import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { checkAndDeductCredit, saveScan, getUserCredits } from "@/lib/credits";
import { analyzeCV } from "@/lib/claude";
import { enforceRateLimit, sanitizeCvText, validateCvInput, safeError } from "@/lib/security";

export const runtime = "nodejs";
export const maxDuration = 120;

// ── Identity extraction ──────────────────────────────────────────────────────

interface Identity {
  full_name: string | null;
  current_company: string | null;
  is_founder: boolean;
  confidence: number;
}

interface EnrichedResult { title: string; snippet: string; link: string; }

async function extractIdentity(cv_text: string): Promise<Identity | null> {
  const Anthropic = (await import("@anthropic-ai/sdk")).default;
  const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });
  try {
    const msg = await client.messages.create({
      model: "claude-haiku-4-5-20251001",
      max_tokens: 200,
      system: "Extract structured data from CVs. Return only JSON, no other text.",
      messages: [{
        role: "user",
        content: `Extract: full_name, current_company, is_founder (boolean), confidence (0-1).
Return ONLY JSON: {"full_name":"...","current_company":"...","is_founder":false,"confidence":0.9}
CV: ${cv_text.slice(0, 2000)}`,
      }],
    });
    const block = msg.content.find((b) => b.type === "text");
    if (!block || block.type !== "text") return null;
    const match = block.text.match(/\{[\s\S]*\}/);
    if (!match) return null;
    return JSON.parse(match[0]);
  } catch { return null; }
}

// ── Web enrichment ───────────────────────────────────────────────────────────

async function runSearch(query: string): Promise<EnrichedResult[]> {
  const apiKey = process.env.SERPER_API_KEY;
  if (!apiKey) return [];
  try {
    const res = await fetch("https://google.serper.dev/search", {
      method: "POST",
      headers: { "X-API-KEY": apiKey, "Content-Type": "application/json" },
      body: JSON.stringify({ q: query, num: 5 }),
      signal: AbortSignal.timeout(8000),
    });
    if (!res.ok) return [];
    const data = await res.json();
    return (data.organic || []).slice(0, 5).map(
      (item: { title?: string; snippet?: string; link?: string }) => ({
        title: item.title || "", snippet: item.snippet || "", link: item.link || "",
      })
    );
  } catch { return []; }
}

async function enrichCandidate(identity: Identity): Promise<string> {
  const name = identity.full_name!;
  const company = identity.current_company;
  const queries = [
    { label: "core",             query: company ? `"${name}" "${company}"` : `"${name}"` },
    { label: "name_search",      query: `"${name}" site:linkedin.com OR site:twitter.com OR site:x.com` },
    { label: "twitter_x",        query: `"${name}" site:twitter.com OR site:x.com` },
    { label: "linkedin",         query: `"${name}" site:linkedin.com` },
    { label: "github",           query: `"${name}" site:github.com OR site:gitlab.com` },
    { label: "reddit_company",   query: company ? `"${company}" site:reddit.com` : `"${name}" site:reddit.com` },
    { label: "reddit_person",    query: `"${name}" site:reddit.com` },
    { label: "press",            query: `"${name}" interview OR profile OR "talked to" OR "spoke with" -job -hiring` },
    { label: "company_press",    query: company ? `"${company}" TechCrunch OR Forbes OR Wired OR "Business Insider" OR Bloomberg OR Reuters` : "" },
    { label: "funding",          query: company ? `"${company}" site:crunchbase.com OR site:pitchbook.com OR funding OR raised OR investors OR "seed round" OR "series A"` : "" },
    { label: "company_info",     query: company ? `"${company}" employees OR team OR "founded" OR revenue OR customers OR growth` : "" },
    { label: "thought_leadership", query: `"${name}" speaker OR keynote OR podcast OR blog OR "wrote" OR "author" OR "published"` },
    { label: "community",        query: `"${name}" "Product Hunt" OR "Hacker News" OR "Indie Hackers" OR medium.com OR substack.com` },
    { label: "reputation",       query: company ? `"${company}" site:glassdoor.com OR site:trustpilot.com OR reviews OR culture` : "" },
  ].filter(q => q.query.trim().length > 0);

  const BATCH_SIZE = 6;
  const allResults: { label: string; results: EnrichedResult[] }[] = [];

  for (let i = 0; i < queries.length; i += BATCH_SIZE) {
    const batch = queries.slice(i, i + BATCH_SIZE);
    await Promise.all(
      batch.map(async ({ label, query }) => {
        const results = await runSearch(query);
        if (results.length > 0) allResults.push({ label, results });
      })
    );
  }

  if (allResults.length === 0) return "No external data found.";

  const labelGroups: Record<string, string> = {
    core: "DIRECT MENTIONS", name_search: "SOCIAL PROFILES", twitter_x: "TWITTER/X",
    linkedin: "LINKEDIN", github: "GITHUB", reddit_person: "REDDIT (PERSON)",
    reddit_company: "REDDIT (COMPANY)", press: "PRESS & INTERVIEWS",
    company_press: "COMPANY COVERAGE", funding: "FUNDING DATA",
    company_info: "COMPANY INTELLIGENCE", thought_leadership: "THOUGHT LEADERSHIP",
    community: "COMMUNITY", reputation: "REVIEWS & REPUTATION",
  };

  const sections: string[] = [];
  for (const { label, results } of allResults) {
    sections.push(`\n── ${labelGroups[label] || label.toUpperCase()} ──`);
    for (const r of results) {
      sections.push(`• ${r.title}`);
      sections.push(`  ${r.snippet}`);
      sections.push(`  → ${r.link}`);
    }
  }
  return sections.join("\n");
}

// ── JSON parser ──────────────────────────────────────────────────────────────

export function safeParseJSON<T>(raw: string): T {
  let s = raw.replace(/^```json\s*/i, "").replace(/\s*```$/i, "").trim();
  const start = s.indexOf("{");
  if (start !== -1) s = s.slice(start);
  try { return JSON.parse(s) as T; } catch { /* fall through */ }
  function repairJSON(input: string): string {
    let result = ""; let inString = false; let escaped = false;
    for (let i = 0; i < input.length; i++) {
      const ch = input[i];
      if (escaped) { result += ch; escaped = false; continue; }
      if (ch === "\\") { result += ch; escaped = true; continue; }
      if (ch === '"') {
        if (!inString) { inString = true; result += ch; continue; }
        let j = i + 1;
        while (j < input.length && /\s/.test(input[j])) j++;
        const next = input[j];
        if (next === ":" || next === "," || next === "]" || next === "}" || j >= input.length) {
          inString = false; result += ch;
        } else { result += '\\"'; }
        continue;
      }
      result += ch;
    }
    return result;
  }
  const repaired = repairJSON(s);
  try { return JSON.parse(repaired) as T; } catch (e) {
    for (let end = repaired.length - 1; end > 0; end--) {
      if (repaired[end] === "}") {
        try { return JSON.parse(repaired.slice(0, end + 1)) as T; } catch { continue; }
      }
    }
    throw new Error("JSON parse failed");
  }
}

// ── Main route ───────────────────────────────────────────────────────────────

export async function POST(request: NextRequest) {
  try {
    // 1. Auth
    const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
    if (!session?.user?.id) {
      return NextResponse.json({ error: "UNAUTHENTICATED" }, { status: 401 });
    }
    const userId = session.user.id;

    // 2. Rate limiting (server-side, per user)
    const rateLimitResult = enforceRateLimit(request, userId, "paid");
    if (rateLimitResult) return rateLimitResult;

    // 3. Credit check (server-side, before work)
    const { totalAvailable } = await getUserCredits(userId);
    if (totalAvailable < 1) {
      return NextResponse.json({ error: "NO_CREDITS" }, { status: 402 });
    }

    // 4. Parse & validate input
    const body = await request.json().catch(() => null);
    const validation = validateCvInput(body?.cv_text);
    if (!validation.valid) {
      return NextResponse.json({ error: validation.error }, { status: 400 });
    }

    // 5. Sanitize against prompt injection
    const { safe: cv_text, injectionDetected } = sanitizeCvText(body.cv_text);
    if (injectionDetected) {
      // Log suspicious activity server-side only — never expose to client
      console.warn(`[security] Prompt injection attempt from user ${userId}`);
    }

    // 6. Atomic credit deduction
    const deduction = await checkAndDeductCredit(userId);
    if (!deduction.ok) {
      return NextResponse.json({ error: "NO_CREDITS" }, { status: 402 });
    }

    // 7. Enrich & analyze
    const identity = await extractIdentity(cv_text);
    let enrichedData = "No external data found.";
    if (identity?.full_name) {
      enrichedData = await enrichCandidate(identity);
    }

    const report = await analyzeCV(cv_text, enrichedData, safeParseJSON);

    // 8. Save (no CV stored — only label and structured result)
    const label = identity?.full_name || "Unknown candidate";
    await saveScan({ userId, type: "candidate_intelligence", input_label: label, result: report as object });

    // 9. Return (never include internal data, prompts, or CV text)
    return NextResponse.json({ report });

  } catch (err) {
    // Never expose stack traces or internal errors
    console.error("[/api/analyze] Error:", err instanceof Error ? err.message : "unknown");
    return NextResponse.json({ error: "Analysis failed. Please try again." }, { status: 500 });
  }
}
