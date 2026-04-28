import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { checkAndDeductCredit, saveScan, getUserCredits } from "@/lib/credits";
import { NextRequest, NextResponse } from "next/server";
import Anthropic from "@anthropic-ai/sdk";
import { analyzeFit } from "@/lib/fitAnalysis";
import { safeParseJSON } from "@/app/api/analyze/route";

export const runtime = "nodejs";
export const maxDuration = 60;

const anthropic = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

// ─────────────────────────────────────────────
// IDENTITY EXTRACTION (reused from analyze route)
// ─────────────────────────────────────────────

interface Identity {
  full_name: string | null;
  current_company: string | null;
  is_founder: boolean;
  confidence: number;
}

async function extractIdentity(cvText: string): Promise<Identity | null> {
  try {
    const msg = await anthropic.messages.create({
      model: "claude-haiku-4-5-20251001",
      max_tokens: 200,
      system: "You are a CV parser. Extract only the candidate's identity. Return JSON only.",
      messages: [{
        role: "user",
        content: `Extract from this CV (first 1000 chars): ${cvText.slice(0, 1000)}

Return ONLY: {"full_name": "string or null", "current_company": "string or null", "is_founder": false, "confidence": 0.0}`,
      }],
    });
    const block = msg.content.find((b) => b.type === "text");
    if (!block || block.type !== "text") return null;
    const parsed = safeParseJSON<Identity>(block.text);
    return parsed.confidence >= 0.6 ? parsed : null;
  } catch { return null; }
}

// ─────────────────────────────────────────────
// JD URL FETCHER
// ─────────────────────────────────────────────

async function fetchJDFromUrl(url: string): Promise<string> {
  try {
    const res = await fetch(url, {
      headers: { "User-Agent": "Mozilla/5.0 (compatible; TieTalent-CV-Insights/1.0)" },
      signal: AbortSignal.timeout(10000),
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    const html = await res.text();
    // Strip HTML tags, collapse whitespace
    const text = html
      .replace(/<script[\s\S]*?<\/script>/gi, "")
      .replace(/<style[\s\S]*?<\/style>/gi, "")
      .replace(/<[^>]+>/g, " ")
      .replace(/&nbsp;/g, " ")
      .replace(/&amp;/g, "&")
      .replace(/&lt;/g, "<")
      .replace(/&gt;/g, ">")
      .replace(/\s{3,}/g, "\n\n")
      .trim()
      .slice(0, 8000);
    if (text.length < 100) throw new Error("Extracted text too short");
    return text;
  } catch (err) {
    throw new Error(`Could not fetch job description from URL: ${err instanceof Error ? err.message : "unknown error"}`);
  }
}

// ─────────────────────────────────────────────
// SERPER ENRICHMENT (same pattern as analyze)
// ─────────────────────────────────────────────

interface EnrichedResult { title: string; snippet: string; link: string; }

async function runSearch(query: string): Promise<EnrichedResult[]> {
  const apiKey = process.env.SERPER_API_KEY;
  if (!apiKey) return [];
  try {
    const res = await fetch("https://google.serper.dev/search", {
      method: "POST",
      headers: { "X-API-KEY": apiKey, "Content-Type": "application/json" },
      body: JSON.stringify({ q: query, num: 3 }),
      signal: AbortSignal.timeout(6000),
    });
    if (!res.ok) return [];
    const data = await res.json();
    return (data.organic || []).slice(0, 3).map((item: { title?: string; snippet?: string; link?: string }) => ({
      title: item.title || "", snippet: item.snippet || "", link: item.link || "",
    }));
  } catch { return []; }
}

async function enrichForFit(identity: Identity, jdText: string): Promise<string> {
  const queries: string[] = [];
  if (identity.full_name && identity.current_company) {
    queries.push(`"${identity.full_name}" "${identity.current_company}"`);
  }
  if (identity.is_founder && identity.current_company) {
    queries.push(`"${identity.current_company}" funding OR traction OR growth OR team`);
  }

  // Extract hiring company name from JD for credibility check
  const companyMatch = jdText.match(/(?:at|join|about)\s+([A-Z][A-Za-z0-9\s&]{2,30}?)(?:\s*[,.\n]|$)/m);
  if (companyMatch?.[1]) {
    const hiringCo = companyMatch[1].trim().slice(0, 40);
    queries.push(`"${hiringCo}" company size OR funding OR employees OR founded`);
  }

  if (queries.length === 0) return "No external data found.";

  const results: string[] = [];
  await Promise.all(queries.slice(0, 3).map(async (q) => {
    const hits = await runSearch(q);
    if (hits.length > 0) {
      results.push(`[Query: ${q}]`);
      hits.forEach(r => results.push(`- ${r.title} — ${r.snippet} [${r.link}]`));
    }
  }));

  return results.length > 0 ? results.join("\n") : "No external data found.";
}

// ─────────────────────────────────────────────
// MAIN HANDLER
// ─────────────────────────────────────────────

export async function POST(request: NextRequest) {
  try {
    // 1. Auth gate
    const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
    if (!session?.user) {
      return NextResponse.json({ error: "UNAUTHENTICATED" }, { status: 401 });
    }
    const userId = (session.user as { id?: string }).id!;

    // 2. Credit gate
    const { totalAvailable } = await getUserCredits(userId);
    if (totalAvailable < 1) {
      return NextResponse.json({ error: "NO_CREDITS" }, { status: 402 });
    }

    const body = await request.json();
    const { cv_text, jd_text, jd_url } = body as {
      cv_text: string;
      jd_text?: string;
      jd_url?: string;
    };

    if (!cv_text || cv_text.trim().length < 50) {
      return NextResponse.json({ error: "CV text is required (min 50 characters)." }, { status: 400 });
    }

    // Resolve JD
    let resolvedJD = jd_text?.trim() || "";
    if (!resolvedJD && jd_url?.trim()) {
      console.log("[/api/fit] Fetching JD from URL:", jd_url);
      try {
        resolvedJD = await fetchJDFromUrl(jd_url.trim());
      } catch (fetchErr) {
        console.warn("[/api/fit] JD fetch failed:", fetchErr instanceof Error ? fetchErr.message : fetchErr);
        return NextResponse.json({
          error: "JD_FETCH_BLOCKED",
          message: "This job board blocks automated access. Please copy and paste the job description text directly.",
        }, { status: 422 });
      }
    }

    if (!resolvedJD || resolvedJD.length < 50) {
      return NextResponse.json({ error: "Job description is required. Paste text, upload a file, or provide a URL." }, { status: 400 });
    }

console.log("[/api/fit] CV:", cv_text.length, "chars | JD:", resolvedJD.length, "chars");

    // Enrichment
    const identity = await extractIdentity(cv_text);
    let enrichedData = "No external data found.";
    if (identity) {
      enrichedData = await enrichForFit(identity, resolvedJD);
      console.log("[/api/fit] Enrichment complete");
    }

    const report = await analyzeFit(cv_text, resolvedJD, enrichedData, safeParseJSON);

    await checkAndDeductCredit(userId);
    const jdLabel = jd_url ? (() => { try { return new URL(jd_url).hostname; } catch { return "Job URL"; } })() : "Pasted JD";
    await saveScan({ userId, type: "role_fit", input_label: jdLabel, result: report as object });

    return NextResponse.json({ success: true, report });

  } catch (err) {
    console.error("[/api/fit] Error:", err instanceof Error ? err.message : err);
    return NextResponse.json({ error: "Analysis failed. Please try again." }, { status: 500 });
  }
}
