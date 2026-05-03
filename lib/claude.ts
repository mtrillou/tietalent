import Anthropic from "@anthropic-ai/sdk";

const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

// ── Types ─────────────────────────────────────────────────────────────────────

export interface IdentityRisk { level: "Low" | "Medium" | "High"; reason: string; }
export interface HiringVerdict { decision: "Strong yes" | "Yes with validation" | "High risk"; reason: string; }
export interface QuickSignal { quick_signal: "Green" | "Orange" | "Red"; quick_reason: string; }
export interface HighImpactFinding {
  type: "Legal" | "Reputation" | "Credibility" | "Career" | "Positive";
  summary: string;
  confidence: "High" | "Medium" | "Low";
  importance: "High";
}
export interface SensitiveSignal {
  signal: string;
  context: string;
  attribution_status: "Unconfirmed" | "Weak match" | "Possible match";
  source: { type: string; reference: string };
  confidence: "Low";
}
export interface VerifiedSignal { statement: string; source_type: string; source_reference: string; reliability: "High" | "Medium"; }
export interface WeakSignal { statement: string; source_type: string; source_reference: string; reliability: "Low"; }
export interface UnverifiedClaim { statement: string; caveat: string; }

export interface ReportData {
  candidate_name: string;
  identity_status: "Confirmed" | "Likely" | "Ambiguous" | "Unknown";
  identity_confidence: "High" | "Medium" | "Low";
  identity_confidence_reason: string;
  identity_risk: IdentityRisk;
  hiring_recommendation: {
    decision: "Strong GO" | "GO" | "GO with validation" | "Caution" | "No-go";
    confidence: "High" | "Medium" | "Low";
    reason: string;
    why: string[];
  };
  hiring_verdict: HiringVerdict;
  surprising_insight: string;
  summary: string;
  strengths: string[];
  high_impact_findings: HighImpactFinding[];
  top_decision_drivers: string[];
  recommended_next_step: { action: string; focus_areas: string[]; reasoning: string; };
  what_stands_out: string[];
  expectation_gap_analysis: {
    expected_signals_for_profile: string[];
    missing_or_weaker_than_expected: string[];
    overall_assessment: string;
  };
  external_profile_summary: string;
  signals: {
    verified_signals: VerifiedSignal[];
    weak_signals: WeakSignal[];
    unverified_claims: UnverifiedClaim[];
    no_significant_external_data: boolean;
  };
  hiring_impact: { summary: string; risk_level: "Low" | "Medium" | "High"; implications: string[]; };
  what_to_validate: string[];
  alert_level: "Green" | "Yellow" | "Orange" | "Red";
  confidence_in_external_data: "High" | "Medium" | "Low";
  sensitive_signals_unverified?: SensitiveSignal[];
}

// ── System prompt ─────────────────────────────────────────────────────────────

const SYSTEM_PROMPT = `You are a senior hiring intelligence analyst producing structured reports for recruiters.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
CORE PRINCIPLES
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

TRUST THROUGH EXPLANATION:
Every key output must be explainable. If you cannot explain why you concluded something, do not include it.
For every risk, verdict, or signal: include the specific evidence that led to that conclusion.

BALANCED BY DEFAULT:
Start neutral. Surface strengths before risks. One risk = show once, not amplified across sections.
✗ "No footprint is concerning"
✓ "Limited public footprint — may reflect private network or non-public work"

STABILITY OVER CREATIVITY:
Produce the same output for the same input. Be precise, not inventive. No paraphrasing the same signal differently.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
IDENTITY ATTRIBUTION
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

ENTITY RESOLUTION RULES:
Only attribute a signal to this candidate if you have:
- name + location match, OR
- name + company match, OR
- multiple independent consistent signals

NEVER conclude absence prematurely:
✗ "No LinkedIn profile found"
✓ "No LinkedIn profile confidently identified for this name/location combination"

identity_status values:
- "Confirmed": name + 2+ context factors align
- "Likely": name + 1 context factor aligns
- "Ambiguous": common name, multiple plausible matches
- "Unknown": insufficient data

SUPPRESSION RULE:
If identity_status = "Ambiguous" or "Unknown" AND signal severity = HIGH:
→ Do NOT surface the allegation. Flag identity risk instead.
→ Geography mismatch alone justifies suppression.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DEDUPLICATION (STRICT)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Each unique signal appears EXACTLY ONCE across the entire report.
If a source or finding is used in one section → do NOT reference it again elsewhere.
If only 1 negative signal exists → it appears in 1 section only, never amplified.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SOURCE ATTRIBUTION (MANDATORY)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Every external signal MUST include:
- source_type: e.g. "LinkedIn", "Crunchbase", "Reddit", "News article", "GitHub"
- source_reference: URL or identifiable reference
- confidence: "High" | "Medium" | "Low"

If no clear source → do NOT include the signal.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TONE & LANGUAGE
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

FORBIDDEN: "concerning", "red flag", "serious issue", "alarming", "suspicious"
PREFERRED: "requires validation", "worth clarifying", "limited visibility", "would benefit from verification"

SAFE ATTRIBUTION:
✗ "X committed fraud"
✓ "Allegations reported in [source type] — unverified, requires explicit confirmation"`;

// ── User prompt ────────────────────────────────────────────────────────────────

const USER_PROMPT_TEMPLATE = (cv_text: string, enriched_data: string) => {
  const today = new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" });
  return `TODAY: ${today}. Use this for all tenure calculations.

CV (for context only — do not repeat CV content verbatim):
${cv_text}

EXTERNAL DATA (3-layer search: professional, risk, visibility):
${enriched_data}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRODUCE A STRUCTURED INTELLIGENCE REPORT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Follow this exact section order. Be concise. No padding.

SECTION 0 — IDENTITY RESOLUTION
Evaluate: does external data clearly map to THIS candidate?
identity_status: "Confirmed" | "Likely" | "Ambiguous" | "Unknown"
identity_confidence: "High" | "Medium" | "Low"
identity_confidence_reason: 1 sentence explaining HOW you assessed this (what matched, what didn't)
identity_risk.level: "Low" | "Medium" | "High"
identity_risk.reason: 1 sentence on ambiguity risk for this specific name/profile

SECTION 1 — HIRING RECOMMENDATION (shown first in UI)
The single most important output. Be decisive.
decision: "Strong GO" | "GO" | "GO with validation" | "Caution" | "No-go"
confidence: "High" | "Medium" | "Low"
reason: 1–2 sentences. Start with the strongest signal.
why: Array of 2–4 specific evidence points that led to this decision.
  - Each must reference a concrete finding, NOT a generic statement
  - ✗ "Limited external data"
  - ✓ "Crunchbase confirms $1.54M funding under their leadership"
  - ✓ "No verifiable press coverage found for claimed 200-person company"

SECTION 1.5 — HIRING VERDICT (legacy field, mirrors recommendation)
decision: "Strong yes" | "Yes with validation" | "High risk"
reason: 1 sentence

SECTION 2 — SURPRISING INSIGHT
One non-obvious finding not visible in the CV.
Must be based on external signals or notable absence.
If nothing genuinely surprising: return "No surprising signals found beyond what the CV states."
Do NOT invent.

SECTION 3 — SUMMARY
2–3 sentences on the overall external picture.
Start from what you FOUND externally, not what they claim.
If data is limited: say so clearly — "Limited external signals found beyond basic profile references."

SECTION 4 — STRENGTHS
2–4 evidence-based positive signals.
Must NOT be generic ("experienced professional").
Must reference a specific external source or finding.
If no positive signals found: return 1 item — "No strong external positive signals identified — this may reflect a private professional network rather than lack of accomplishment."

SECTION 5 — HIGH-IMPACT FINDINGS
Max 4 items. Only findings that could change a hiring decision.
Apply suppression rules from identity section.
Each must have type, summary (with source), confidence, importance.
Priority order: Legal > Reputation > Credibility > Career > Positive.
If nothing critical: include 1 positive finding.

SECTION 6 — TOP 3 DECISION DRIVERS
Exactly 3. Most impactful facts. No overlap with other sections.

SECTION 7 — EXTERNAL SIGNALS
verified_signals: max 4, confirmed by named sources
weak_signals: max 3, unconfirmed but hiring-relevant
unverified_claims: max 2, clearly caveated
no_significant_external_data: true only if genuinely nothing found

SECTION 8 — WHAT TO VALIDATE
2–3 specific interview or reference check questions.
Must be actionable and tied to actual gaps found.

SECTION 9 — RECOMMENDED NEXT STEP
action: concrete next step
focus_areas: 2–3 specific topics
reasoning: 1 sentence

SECTION 10 — METADATA
alert_level: "Green" | "Yellow" | "Orange" | "Red"
confidence_in_external_data: "High" | "Medium" | "Low"

SECTION 10.5 — SENSITIVE SIGNALS (only if applicable)
Include ONLY when: severity HIGH + credible source + identity NOT confirmed + no context mismatch.
Max 2. Frame as "A record associated with this name was found in [source]."
If not applicable: omit entirely.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRE-FLIGHT CHECKLIST (run before outputting)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

0. GLOBAL SIGNAL REGISTRY: Before writing any section, mentally list every unique signal found.
   Assign each signal to EXACTLY ONE section based on: Legal/Reputation → high_impact_findings, Supporting evidence → signals, Summary → synthesis only (no new signals).
   Once a signal is assigned to a section: it CANNOT appear anywhere else — not rephrased, not summarized, not referenced.

1. DEDUPLICATION: Every signal appears exactly once. Remove any repetition.
2. SOURCE AUDIT: Every signal in verified/weak/findings has source_type + source_reference. Remove any without.
3. TONE CHECK: Replace any forbidden words. Add context to every negative signal.
4. WHY CHECK: hiring_recommendation.why contains specific evidence, not generic statements.
5. UNCERTAINTY CHECK: Any conclusion without clear evidence → remove or flag as uncertain.

Only after all 5 checks pass: output the JSON.

Return ONLY this JSON, no preamble, no markdown:

{
  "candidate_name": "string",
  "identity_status": "Confirmed | Likely | Ambiguous | Unknown",
  "identity_confidence": "High | Medium | Low",
  "identity_confidence_reason": "string",
  "identity_risk": { "level": "Low | Medium | High", "reason": "string" },
  "hiring_recommendation": {
    "decision": "Strong GO | GO | GO with validation | Caution | No-go",
    "confidence": "High | Medium | Low",
    "reason": "string",
    "why": ["string", "string", "string"]
  },
  "hiring_verdict": { "decision": "Strong yes | Yes with validation | High risk", "reason": "string" },
  "surprising_insight": "string",
  "summary": "string",
  "strengths": ["string"],
  "high_impact_findings": [
    { "type": "Legal | Reputation | Credibility | Career | Positive", "summary": "string", "confidence": "High | Medium | Low", "importance": "High" }
  ],
  "top_decision_drivers": ["string", "string", "string"],
  "recommended_next_step": { "action": "string", "focus_areas": ["string"], "reasoning": "string" },
  "what_stands_out": ["string"],
  "expectation_gap_analysis": {
    "expected_signals_for_profile": ["string"],
    "missing_or_weaker_than_expected": ["string"],
    "overall_assessment": "string"
  },
  "external_profile_summary": "string",
  "signals": {
    "verified_signals": [{ "statement": "string", "source_type": "string", "source_reference": "string", "reliability": "High | Medium" }],
    "weak_signals": [{ "statement": "string", "source_type": "string", "source_reference": "string", "reliability": "Low" }],
    "unverified_claims": [{ "statement": "string", "caveat": "string" }],
    "no_significant_external_data": false
  },
  "hiring_impact": { "summary": "string", "risk_level": "Low | Medium | High", "implications": ["string"] },
  "what_to_validate": ["string"],
  "alert_level": "Green | Yellow | Orange | Red",
  "confidence_in_external_data": "High | Medium | Low",
  "sensitive_signals_unverified": []
}`;
};

// ── JSON parser ────────────────────────────────────────────────────────────────

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
  try { return JSON.parse(repaired) as T; } catch {
    for (let end = repaired.length - 1; end > 0; end--) {
      if (repaired[end] === "}") {
        try { return JSON.parse(repaired.slice(0, end + 1)) as T; } catch { continue; }
      }
    }
    throw new Error("JSON parse failed");
  }
}

// ── Main analysis function ────────────────────────────────────────────────────

export async function analyzeCV(
  cv_text: string,
  enriched_data: string,
  parseJSON: <T>(raw: string) => T
): Promise<ReportData> {
  const message = await client.messages.create({
    model: "claude-sonnet-4-5",
    max_tokens: 8192,
    temperature: 0.1, // low temperature for consistency
    system: SYSTEM_PROMPT,
    messages: [{ role: "user", content: USER_PROMPT_TEMPLATE(cv_text, enriched_data) }],
  });
  const textBlock = message.content.find((b) => b.type === "text");
  if (!textBlock || textBlock.type !== "text") throw new Error("No text response from Claude");
  return parseJSON<ReportData>(textBlock.text);
}
