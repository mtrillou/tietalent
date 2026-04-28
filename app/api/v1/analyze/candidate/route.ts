import { NextRequest, NextResponse } from "next/server";
import { validateApiKey, checkAndDeductApiCredit } from "@/lib/apiAuth";
import { analyzeCV } from "@/lib/claude";
import { saveScan } from "@/lib/credits";
import { enforceRateLimit, sanitizeCvText, validateCvInput, safeError } from "@/lib/security";
import { safeParseJSON } from "@/app/api/analyze/route";

export const runtime = "nodejs";
export const maxDuration = 120;

interface Identity { full_name: string | null; current_company: string | null; is_founder: boolean; confidence: number; }
interface EnrichedResult { title: string; snippet: string; link: string; }

async function extractIdentity(cv_text: string): Promise<Identity | null> {
  const Anthropic = (await import("@anthropic-ai/sdk")).default;
  const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });
  try {
    const msg = await client.messages.create({
      model: "claude-haiku-4-5-20251001", max_tokens: 200,
      system: "Extract structured data from CVs. Return only JSON.",
      messages: [{ role: "user", content: `Extract full_name, current_company, is_founder, confidence (0-1). JSON only: {"full_name":"...","current_company":"...","is_founder":false,"confidence":0.9}\nCV: ${cv_text.slice(0, 2000)}` }],
    });
    const block = msg.content.find((b) => b.type === "text");
    if (!block || block.type !== "text") return null;
    const match = block.text.match(/\{[\s\S]*\}/);
    return match ? JSON.parse(match[0]) : null;
  } catch { return null; }
}

async function runSearch(query: string): Promise<EnrichedResult[]> {
  const apiKey = process.env.SERPER_API_KEY;
  if (!apiKey) return [];
  try {
    const res = await fetch("https://google.serper.dev/search", {
      method: "POST", headers: { "X-API-KEY": apiKey, "Content-Type": "application/json" },
      body: JSON.stringify({ q: query, num: 5 }), signal: AbortSignal.timeout(8000),
    });
    if (!res.ok) return [];
    const data = await res.json();
    return (data.organic || []).slice(0, 5).map((item: { title?: string; snippet?: string; link?: string }) => ({ title: item.title || "", snippet: item.snippet || "", link: item.link || "" }));
  } catch { return []; }
}

async function enrichCandidate(identity: Identity): Promise<string> {
  const name = identity.full_name!;
  const company = identity.current_company;
  const queries = [
    { label: "core", query: company ? `"${name}" "${company}"` : `"${name}"` },
    { label: "linkedin", query: `"${name}" site:linkedin.com` },
    { label: "press", query: `"${name}" interview OR profile OR podcast` },
    { label: "reddit", query: company ? `"${company}" site:reddit.com` : `"${name}" site:reddit.com` },
    { label: "funding", query: company ? `"${company}" site:crunchbase.com OR funding OR raised` : "" },
    { label: "community", query: `"${name}" "Product Hunt" OR "Hacker News" OR medium.com` },
  ].filter(q => q.query.trim().length > 0);
  const results: string[] = [];
  await Promise.all(queries.map(async ({ label, query }) => {
    const r = await runSearch(query);
    if (r.length > 0) { results.push(`\n── ${label.toUpperCase()} ──`); r.forEach(x => results.push(`• ${x.title}\n  ${x.snippet}\n  → ${x.link}`)); }
  }));
  return results.join("\n") || "No external data found.";
}

export async function POST(request: NextRequest) {
  try {
    // 1. API key auth
    const auth = await validateApiKey(request);
    if (!auth.ok) return auth.response;
    const { user } = auth;

    // 2. Rate limit per API key
    const rateLimitResult = enforceRateLimit(request, user.id, "api");
    if (rateLimitResult) return rateLimitResult;

    // 3. Parse & validate
    const body = await request.json().catch(() => null);
    const validation = validateCvInput(body?.cv_text);
    if (!validation.valid) return NextResponse.json({ error: validation.error }, { status: 400 });

    // 4. Sanitize prompt injection
    const { safe: cv_text, injectionDetected } = sanitizeCvText(body.cv_text);
    if (injectionDetected) console.warn(`[security] Injection attempt via API key user ${user.id}`);

    // 5. Credit check + deduct (atomic)
    const credit = await checkAndDeductApiCredit(user.id);
    if (!credit.ok) return credit.response;

    // 6. Analyze
    const identity = await extractIdentity(cv_text);
    let enrichedData = "No external data found.";
    if (identity?.full_name) enrichedData = await enrichCandidate(identity);
    const report = await analyzeCV(cv_text, enrichedData, safeParseJSON);

    // 7. Save (no CV stored)
    const label = identity?.full_name || "API Candidate";
    await saveScan({ userId: user.id, type: "candidate_intelligence", input_label: label, result: report as object });

    return NextResponse.json({ success: true, report, meta: { credits_used: 1, remaining_credits: credit.remaining } });
  } catch (err) {
    console.error("[/api/v1/analyze/candidate]", err instanceof Error ? err.message : "unknown");
    return NextResponse.json({ error: "Analysis failed. Please try again." }, { status: 500 });
  }
}
