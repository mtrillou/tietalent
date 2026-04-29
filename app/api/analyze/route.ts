import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { checkAndDeductCredit, saveScan, getUserCredits } from "@/lib/credits";
import { analyzeCV } from "@/lib/claude";
import { enforceRateLimit, sanitizeCvText, validateCvInput } from "@/lib/security";

export const runtime = "nodejs";
export const maxDuration = 120;

// ── Identity extraction ──────────────────────────────────────────────────────

interface Identity {
  full_name: string | null;
  current_company: string | null;
  is_founder: boolean;
  confidence: number;
  past_companies?: string[];
  location?: string;
}

interface EnrichedResult { title: string; snippet: string; link: string; }

async function extractIdentity(cv_text: string): Promise<Identity | null> {
  const Anthropic = (await import("@anthropic-ai/sdk")).default;
  const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });
  try {
    const msg = await client.messages.create({
      model: "claude-haiku-4-5-20251001",
      max_tokens: 300,
      system: "Extract structured data from CVs. Return only JSON, no other text.",
      messages: [{
        role: "user",
        content: `Extract: full_name, current_company, is_founder (boolean), confidence (0-1), past_companies (array of up to 3 previous companies), location (city/country if visible).
Return ONLY JSON: {"full_name":"...","current_company":"...","is_founder":false,"confidence":0.9,"past_companies":[],"location":""}
CV: ${cv_text.slice(0, 3000)}`,
      }],
    });
    const block = msg.content.find((b) => b.type === "text");
    if (!block || block.type !== "text") return null;
    const match = block.text.match(/\{[\s\S]*\}/);
    if (!match) return null;
    return JSON.parse(match[0]);
  } catch { return null; }
}

// ── Deep search engine ───────────────────────────────────────────────────────

async function runSearch(query: string, num = 5): Promise<EnrichedResult[]> {
  const apiKey = process.env.SERPER_API_KEY;
  if (!apiKey) return [];
  try {
    const res = await fetch("https://google.serper.dev/search", {
      method: "POST",
      headers: { "X-API-KEY": apiKey, "Content-Type": "application/json" },
      body: JSON.stringify({ q: query, num }),
      signal: AbortSignal.timeout(8000),
    });
    if (!res.ok) return [];
    const data = await res.json();
    return (data.organic || []).slice(0, num).map(
      (item: { title?: string; snippet?: string; link?: string }) => ({
        title: item.title || "", snippet: item.snippet || "", link: item.link || "",
      })
    );
  } catch { return []; }
}

async function enrichCandidate(identity: Identity): Promise<string> {
  const name = identity.full_name!;
  const company = identity.current_company;
  const pastCos = identity.past_companies || [];

  // ── LAYER 1: Professional signals ──────────────────────────────────────────
  const professionalQueries = [
    { label: "CORE_IDENTITY",        query: company ? `"${name}" "${company}"` : `"${name}"` },
    { label: "LINKEDIN_PROFILE",     query: `"${name}" site:linkedin.com` },
    { label: "PROFESSIONAL_PRESS",   query: `"${name}" interview OR "spoke to" OR profile OR founder OR CEO` },
    { label: "COMPANY_CREDIBILITY",  query: company ? `"${company}" funding OR revenue OR customers OR employees OR "series"` : "" },
    { label: "COMPANY_PRESS",        query: company ? `"${company}" TechCrunch OR Forbes OR Bloomberg OR Reuters OR "Business Insider"` : "" },
    { label: "PAST_COMPANY_1",       query: pastCos[0] ? `"${name}" "${pastCos[0]}"` : "" },
    { label: "PAST_COMPANY_2",       query: pastCos[1] ? `"${name}" "${pastCos[1]}"` : "" },
  ].filter(q => q.query.trim().length > 0);

  // ── LAYER 2: Risk & reputation signals ─────────────────────────────────────
  const riskQueries = [
    { label: "LEGAL_RISK",           query: `"${name}" lawsuit OR litigation OR fraud OR convicted OR arrested OR indicted OR "legal action"` },
    { label: "CONTROVERSY",          query: `"${name}" controversy OR scandal OR accused OR misconduct OR investigation` },
    { label: "COMPANY_LEGAL",        query: company ? `"${company}" lawsuit OR fraud OR "regulatory action" OR scam OR controversy OR "shut down"` : "" },
    { label: "REDDIT_REPUTATION",    query: `"${name}" site:reddit.com` },
    { label: "REDDIT_COMPANY",       query: company ? `"${company}" site:reddit.com` : "" },
    { label: "GLASSDOOR_REPUTATION", query: company ? `"${company}" site:glassdoor.com OR trustpilot.com` : "" },
    { label: "NEWS_NEGATIVE",        query: `"${name}" fired OR "laid off" OR resign OR controversy OR "stepping down"` },
  ].filter(q => q.query.trim().length > 0);

  // ── LAYER 3: Public visibility & community ─────────────────────────────────
  const visibilityQueries = [
    { label: "THOUGHT_LEADERSHIP",   query: `"${name}" podcast OR keynote OR speaker OR "wrote" OR author OR blog` },
    { label: "COMMUNITY_SIGNALS",    query: `"${name}" "Product Hunt" OR "Hacker News" OR "Y Combinator" OR "Indie Hackers"` },
    { label: "GITHUB_CODE",          query: `"${name}" site:github.com OR site:gitlab.com` },
    { label: "FUNDING_TRACK",        query: company ? `"${company}" site:crunchbase.com OR site:pitchbook.com OR raised OR investors` : "" },
    { label: "SUBSTACK_MEDIUM",      query: `"${name}" site:substack.com OR site:medium.com` },
    { label: "TWITTER_X",            query: `"${name}" site:twitter.com OR site:x.com` },
  ].filter(q => q.query.trim().length > 0);

  // ── Run all batches in parallel ─────────────────────────────────────────────
  const allQueryGroups = [
    { group: "PROFESSIONAL", queries: professionalQueries },
    { group: "RISK",         queries: riskQueries },
    { group: "VISIBILITY",   queries: visibilityQueries },
  ];

  const allResults: { group: string; label: string; results: EnrichedResult[] }[] = [];

  await Promise.all(
    allQueryGroups.map(async ({ group, queries }) => {
      await Promise.all(
        queries.map(async ({ label, query }) => {
          const results = await runSearch(query, 5);
          if (results.length > 0) {
            allResults.push({ group, label, results });
          }
        })
      );
    })
  );

  if (allResults.length === 0) return "No external data found.";

  // Structure output for Claude with clear group separation
  const sections: string[] = [];

  const groupOrder = ["PROFESSIONAL", "RISK", "VISIBILITY"];
  for (const group of groupOrder) {
    const groupResults = allResults.filter(r => r.group === group);
    if (groupResults.length === 0) continue;

    sections.push(`\n${"═".repeat(50)}`);
    sections.push(`GROUP: ${group} SIGNALS`);
    sections.push("═".repeat(50));

    for (const { label, results } of groupResults) {
      sections.push(`\n[${label}]`);
      for (const r of results) {
        sections.push(`• ${r.title}`);
        sections.push(`  ${r.snippet}`);
        sections.push(`  → ${r.link}`);
      }
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
    const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
    if (!session?.user?.id) return NextResponse.json({ error: "UNAUTHENTICATED" }, { status: 401 });
    const userId = session.user.id;

    const rateLimitResult = enforceRateLimit(request, userId, "paid");
    if (rateLimitResult) return rateLimitResult;

    const { totalAvailable } = await getUserCredits(userId);
    if (totalAvailable < 1) return NextResponse.json({ error: "NO_CREDITS" }, { status: 402 });

    const body = await request.json().catch(() => null);
    const validation = validateCvInput(body?.cv_text);
    if (!validation.valid) return NextResponse.json({ error: validation.error }, { status: 400 });

    const { safe: cv_text, injectionDetected } = sanitizeCvText(body.cv_text);
    if (injectionDetected) console.warn(`[security] Injection attempt from user ${userId}`);

    const deduction = await checkAndDeductCredit(userId);
    if (!deduction.ok) return NextResponse.json({ error: "NO_CREDITS" }, { status: 402 });

    const identity = await extractIdentity(cv_text);
    let enrichedData = "No external data found.";
    if (identity?.full_name) {
      console.log(`[enrichment] Analyzing: ${identity.full_name} @ ${identity.current_company}`);
      enrichedData = await enrichCandidate(identity);
    }

    const report = await analyzeCV(cv_text, enrichedData, safeParseJSON);

    const label = identity?.full_name || "Unknown candidate";
    await saveScan({ userId, type: "candidate_intelligence", input_label: label, result: report as object });

    return NextResponse.json({ report });

  } catch (err) {
    console.error("[/api/analyze] Error:", err instanceof Error ? err.message : "unknown");
    return NextResponse.json({ error: "Analysis failed. Please try again." }, { status: 500 });
  }
}
