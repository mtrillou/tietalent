import Anthropic from "@anthropic-ai/sdk";

const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

const SYSTEM_PROMPT = `You are a senior hiring intelligence analyst. Your output directly influences recruiter decisions before interviews.

Your job is NOT to summarize information. It is to synthesize external signals into a decisive hiring recommendation.

CORE PRINCIPLES:
1. Be decisive — avoid "may", "could", "possibly". Use "indicates", "suggests", "likely"
2. No repetition — each section must add new value, never restate what another section says
3. Source-backed only — never present unverified claims as facts
4. Safe language — no accusations, no definitive negative statements without strong sourcing
5. High signal density — short sentences, no filler, no generic AI language

IDENTITY VERIFICATION:
Assess whether external data clearly matches this specific person (name + company + timeline).
High: distinctive name AND company/context matches. Medium: partial match. Low: common name or unclear.

SOURCE RELIABILITY:
High: Major press, LinkedIn direct, Crunchbase, official company sites
Medium: Industry blogs, podcasts, Product Hunt, Hacker News, secondary press  
Low: Reddit, forums, anonymous reviews, unverified social

SAFE LANGUAGE (NON-NEGOTIABLE):
Never write: "This person is a scammer/fraudster/criminal"
Always write: "Allegations found in [source type] (Low reliability — not independently verified)"`;

const USER_PROMPT_TEMPLATE = (cv_text: string, enriched_data: string) => `CV (understand context only — do NOT repeat CV content in output):
${cv_text}

EXTERNAL DATA (structured search results):
${enriched_data}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRODUCE A DECISION-FIRST INTELLIGENCE REPORT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

SECTION 1 — RECRUITER SIGNAL (most important)
Synthesize everything into a single hiring recommendation.
decision options: "Strong Proceed" | "Proceed" | "Proceed with Validation" | "Neutral" | "Caution" | "High Risk"
confidence: "High" | "Medium" | "Low"
reasoning: 1–2 sentences max. Decisive. No hedging.

SECTION 2 — TOP 3 DECISION DRIVERS
Exactly 3 items. The 3 highest-impact facts a recruiter must know.
Mix strengths and risks. Each item = 1 punchy sentence. No overlap with other sections.

SECTION 3 — WHAT STANDS OUT
What is unusual or notable about this profile vs. peers at same level?
Examples: "Unusually high public visibility for a seed-stage founder", "Rare domain specialization in X"
Only include if genuinely distinctive. 1–3 items max.

SECTION 4 — EXPECTATION GAP ANALYSIS
Compare what SHOULD be visible externally at this seniority/role vs what IS actually visible.
expected_signals_for_profile: what you'd typically expect to find
missing_or_weaker_than_expected: what's absent or thinner than expected
overall_assessment: 1 sentence verdict on alignment

SECTION 5 — RECOMMENDED NEXT STEP
action options: "Proceed to interview" | "Proceed with targeted validation" | "Deprioritize" | "Requires further screening"
focus_areas: 2–3 specific things to probe in interview or reference check
reasoning: 1 sentence explaining the priority

SECTION 6 — IDENTITY & EXTERNAL PROFILE
external_profile_summary: 2–3 sentences on the external picture. No CV content.
identity_confidence + identity_confidence_reason

SECTION 7 — SIGNALS (source-backed)
verified_signals: max 4, High/Medium reliability only
weak_signals: max 3, Low reliability, hedged language
unverified_claims: max 2, hiring-relevant only
no_significant_external_data: true if nothing meaningful found

SECTION 8 — HIRING IMPACT
summary: 1–2 sentences
risk_level: "Low" | "Medium" | "High"
implications: 2–3 specific hiring implications (NOT repeating signals or drivers)

SECTION 9 — WHAT TO VALIDATE
2–3 specific interview or reference check questions. Not repeated from focus_areas.

SECTION 10 — METADATA
alert_level: "Green" | "Yellow" | "Orange" | "Red"
confidence_in_external_data: "High" | "Medium" | "Low"

Return ONLY this JSON, no preamble, no markdown:

{
  "candidate_name": "string",
  "recruiter_signal": {
    "decision": "string",
    "confidence": "High | Medium | Low",
    "reasoning": "string"
  },
  "top_decision_drivers": ["string", "string", "string"],
  "what_stands_out": ["string"],
  "expectation_gap_analysis": {
    "expected_signals_for_profile": ["string"],
    "missing_or_weaker_than_expected": ["string"],
    "overall_assessment": "string"
  },
  "recommended_next_step": {
    "action": "string",
    "focus_areas": ["string"],
    "reasoning": "string"
  },
  "external_profile_summary": "string",
  "identity_confidence": "High | Medium | Low",
  "identity_confidence_reason": "string",
  "signals": {
    "verified_signals": [{"statement": "string", "source_type": "string", "source_reference": "string", "reliability": "High | Medium"}],
    "weak_signals": [{"statement": "string", "source_type": "string", "source_reference": "string", "reliability": "Low"}],
    "unverified_claims": [{"statement": "string", "caveat": "string"}],
    "no_significant_external_data": false
  },
  "hiring_impact": {
    "summary": "string",
    "risk_level": "Low | Medium | High",
    "implications": ["string"]
  },
  "what_to_validate": ["string"],
  "alert_level": "Green | Yellow | Orange | Red",
  "confidence_in_external_data": "High | Medium | Low"
}`;

export interface VerifiedSignal { statement: string; source_type: string; source_reference: string; reliability: "High" | "Medium"; }
export interface WeakSignal { statement: string; source_type: string; source_reference: string; reliability: "Low"; }
export interface UnverifiedClaim { statement: string; caveat: string; }

export interface ReportData {
  candidate_name: string;
  recruiter_signal: { decision: string; confidence: "High" | "Medium" | "Low"; reasoning: string; };
  top_decision_drivers: string[];
  what_stands_out: string[];
  expectation_gap_analysis: { expected_signals_for_profile: string[]; missing_or_weaker_than_expected: string[]; overall_assessment: string; };
  recommended_next_step: { action: string; focus_areas: string[]; reasoning: string; };
  external_profile_summary: string;
  identity_confidence: "High" | "Medium" | "Low";
  identity_confidence_reason: string;
  signals: { verified_signals: VerifiedSignal[]; weak_signals: WeakSignal[]; unverified_claims: UnverifiedClaim[]; no_significant_external_data: boolean; };
  hiring_impact: { summary: string; risk_level: "Low" | "Medium" | "High"; implications: string[]; };
  what_to_validate: string[];
  alert_level: "Green" | "Yellow" | "Orange" | "Red";
  confidence_in_external_data: "High" | "Medium" | "Low";
}

export async function analyzeCV(cv_text: string, enriched_data: string, parseJSON: <T>(raw: string) => T): Promise<ReportData> {
  const message = await client.messages.create({
    model: "claude-sonnet-4-5",
    max_tokens: 8192,
    system: SYSTEM_PROMPT,
    messages: [{ role: "user", content: USER_PROMPT_TEMPLATE(cv_text, enriched_data) }],
  });
  const textBlock = message.content.find((b) => b.type === "text");
  if (!textBlock || textBlock.type !== "text") throw new Error("No text response from Claude");
  return parseJSON<ReportData>(textBlock.text);
}
