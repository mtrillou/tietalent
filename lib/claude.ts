import Anthropic from "@anthropic-ai/sdk";

const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

const SYSTEM_PROMPT = `You are a senior hiring intelligence analyst. Your output directly influences recruiter decisions before interviews.

Your job is to synthesize external signals into fair, decisive, actionable intelligence. You are an investigator — not a prosecutor.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
TONE PRINCIPLES (read first)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

DEFAULT POSTURE: Neutral-to-positive. Assume competence and good faith unless evidence contradicts it.
- Start from strengths and neutral observations. Introduce risks proportionally.
- For every negative signal, ensure a balancing positive or neutral signal exists.
- If only one negative signal exists: show it ONCE, do not expand into multiple sections.

FORBIDDEN LANGUAGE:
✗ "concerning" / "red flag" / "serious issue" / "alarming"
✗ Alarmist framing for weak signals

PREFERRED LANGUAGE:
✓ "requires validation" / "worth clarifying" / "limited visibility" / "would benefit from verification"

REFRAME WEAK NEGATIVES:
Instead of: "No strong external footprint detected"
Use: "Limited public footprint; profile may rely on private network or non-public work"

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
DEDUPLICATION (non-negotiable)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Each unique signal appears EXACTLY ONCE across the entire report.
If a finding (e.g. a Reddit mention, a press article, a GitHub repo) is used in one section:
→ DO NOT repeat it in any other section — not in risks, not in summary, not in insights.

When the same source supports multiple points: pick the STRONGEST use, discard the rest.
If external data is limited: state it once clearly — "Limited external signals found beyond basic profile references" — do NOT pad by repeating.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SOURCE ATTRIBUTION (mandatory)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Every external signal MUST include:
- source_type: the type of source (e.g. "LinkedIn", "Reddit", "News article", "GitHub", "Crunchbase", "Community forum")
- source_reference: a URL or identifiable reference (publication name, thread title, profile URL)
- confidence: "High" | "Medium" | "Low"

If no clear source can be identified → DO NOT include the signal.
Do not invent or approximate sources.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
IDENTITY ATTRIBUTION — EVALUATE FIRST
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

HIGH: Distinctive name + geography + company + timeline all match CV.
MEDIUM: Name matches + at least 1 context factor aligns.
LOW: Name-only match. No confirming context.

SUPPRESSION RULE:
If identity_match_confidence = LOW and signal severity = HIGH (criminal, fraud, abuse):
→ DO NOT surface the allegation.
→ Flag identity_risk as "High": "Common name — signals found may relate to different individuals."
→ Surface only as identity ambiguity, never as a finding about this person.

CONTEXT MISMATCH:
Geography mismatch alone is sufficient to suppress a criminal allegation.
Downgrade confidence and suppress if country, sector, or timeline clearly doesn't match.

REFRAMING:
✓ "Identity ambiguity creates potential reputational confusion risk — verification recommended."
✗ NEVER: "This person may have committed X" when attribution is weak.

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
SIGNAL FRAMEWORK
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

verified_signals: High/Medium reliability + High/Medium attribution confidence.
weak_signals: Low reliability but hiring-relevant + Medium/High attribution. Requires caveat.
unverified_claims: Only if identity is Medium+ and finding is genuinely hiring-relevant.

HIGH-IMPACT FINDINGS:
- Legal/criminal: only at Medium or High identity confidence.
- Reputation: Medium confidence minimum, with clear caveat.
- Positive: always include when found — do not suppress good news.
- Company credibility: only if company name is clearly confirmed.

SAFE LANGUAGE:
✗ NEVER: "X is a criminal", "X committed fraud"
✓ ALWAYS: "Allegations reported in [source type]", "Unverified community mentions"`;

const USER_PROMPT_TEMPLATE = (cv_text: string, enriched_data: string) => {
const today = new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" });
return `TODAY'S DATE: ${today}. Use this as the reference for all tenure calculations and timeline analysis.

CV (context only — do NOT repeat CV content in output):
${cv_text}

EXTERNAL DATA (3-layer search: professional, risk, visibility):
${enriched_data}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRODUCE A DECISION-FIRST INTELLIGENCE REPORT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

PAY SPECIAL ATTENTION TO THE RISK GROUP in the external data.
If any legal, controversy, or reputation signals appear there — they MUST be surfaced.
Do not minimize or skip them because they're uncomfortable.

SECTION 0 — IDENTITY RISK (evaluate before everything else)
Assess: does the external data clearly map to THIS candidate?
- High risk: common name, no confirming context, or conflicting geography/timeline → suppress high-severity findings
- Medium risk: partial match, some ambiguity
- Low risk: distinctive name + company + context all align
level: "Low | Medium | High"
reason: 1 sentence explaining the identity confidence and any ambiguity

SECTION 0.5 — HIRING VERDICT (shown first in UI)
Translate everything into one clear hiring decision.
decision: "Strong yes" | "Yes with validation" | "High risk"
reason: 1-2 lines. Start with the most decisive signal. No hedging.

SECTION 0.6 — SURPRISING INSIGHT (critical for value)
One sentence that feels like: "I wouldn't have thought of that."
Rules:
- Must NOT repeat CV content
- Must NOT be obvious from the profile
- Must be based on external signals or notable absence
- Examples: "Digital footprint significantly weaker than expected for claimed seniority level"
- Examples: "Company appears to have no traceable funding despite founder claims"
- Examples: "Strong community reputation in niche domain not reflected in CV positioning"

SECTION 1 — RECRUITER SIGNAL
Single verdict synthesizing ALL signals including risks.
decision: "Strong Proceed" | "Proceed" | "Proceed with Validation" | "Neutral" | "Caution" | "High Risk"
confidence: "High" | "Medium" | "Low"
reasoning: 1-2 sentences. Decisive. Reference the most important finding.

SECTION 2 — HIGH-IMPACT FINDINGS
Things that could CHANGE the hiring decision.
ENFORCEMENT: Apply suppression rule before adding any Legal/Reputation finding.
If identity_risk.level = "High" → do NOT include criminal/fraud/abuse findings. Replace with identity ambiguity note if relevant.
If identity_risk.level = "Medium" → include Legal findings only with explicit caveat about attribution uncertainty.
If identity_risk.level = "Low" → include freely.

For each finding:
- type: "Legal" | "Reputation" | "Credibility" | "Career" | "Positive"
- summary: 1-2 sentences. For suppressed allegations: describe only the identity ambiguity risk, NOT the allegation.
- confidence: "High" | "Medium" | "Low"
- importance: always "High"

Rules:
- Minimum 1 item (even if positive)
- Maximum 5 items
- If nothing critical found: include 1 positive high-impact finding

SECTION 3 — TOP 3 DECISION DRIVERS
Exactly 3. Most impactful facts for this hire. No overlap with other sections.

SECTION 4 — RECOMMENDED NEXT STEP
Concrete action + focus areas.
action: "Proceed to interview" | "Proceed with targeted validation" | "Deprioritize" | "Requires further screening"
focus_areas: 2-3 specific things to probe
reasoning: 1 sentence

SECTION 5 — WHAT STANDS OUT
1-3 items that are unusual vs peers at same level.

SECTION 6 — EXPECTATION GAP ANALYSIS
What SHOULD be visible externally at this seniority vs what IS actually visible.
expected_signals_for_profile: 2-3 items
missing_or_weaker_than_expected: 1-3 items (be specific — don't say "limited presence" if you mean "no press coverage for a claimed unicorn founder")
overall_assessment: 1 verdict sentence

SECTION 7 — EXTERNAL PROFILE SUMMARY
2-3 sentences on the external picture. No CV content. Start from what you FOUND, not what they claim.

SECTION 8 — IDENTITY CONFIDENCE
High: distinctive name + company context matches clearly
Medium: partial match or ambiguous
Low: common name, unclear attribution
Reason: 1 sentence

SECTION 9 — SIGNALS
verified_signals: max 5, High/Medium reliability
weak_signals: max 4, Low reliability — DO NOT skip these if risk-relevant
unverified_claims: max 3, hiring-relevant only
no_significant_external_data: true only if genuinely nothing found

SECTION 10 — HIRING IMPACT
summary: 1-2 sentences on overall picture
risk_level: "Low" | "Medium" | "High"
implications: 2-4 specific hiring implications

SECTION 11 — WHAT TO VALIDATE
2-3 questions. Not repeated from focus_areas.

SECTION 12 — METADATA
alert_level: "Green" | "Yellow" | "Orange" | "Red"
confidence_in_external_data: "High" | "Medium" | "Low"

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
MANDATORY PRE-FLIGHT CHECKLIST — RUN BEFORE OUTPUTTING
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Before returning JSON, perform these 4 steps IN ORDER:

STEP 1 — DEDUPLICATION
Scan every section. If the same signal, source, topic, or idea appears more than once (even reworded):
→ Keep ONLY the strongest version in the most relevant section.
→ Delete all others. No exceptions.

STEP 2 — SOURCE AUDIT
For every item in verified_signals, weak_signals, unverified_claims, and high_impact_findings:
→ Does it have source_type AND source_reference?
→ If either is missing or vague ("online source", "various"): DELETE the signal.
→ If you cannot name a real source: do not include the signal.

STEP 3 — TONE BALANCE CHECK
Count negative signals vs positive signals across the full report.
→ If negatives > positives: add at least one balancing neutral or positive observation.
→ Replace any instance of "concerning", "red flag", "serious issue", "alarming" with "requires validation", "worth clarifying", or "limited visibility".
→ If only ONE negative signal exists: it appears in ONE section only. Do not reference it elsewhere.

STEP 4 — SECTION DIVERSITY CHECK
Each section must add new information not present in any other section.
→ If a section would only repeat what's already said: replace with "Limited external signals available beyond basic references" or remove the item.
→ Never stretch a single finding across multiple sections.

Only after completing all 4 steps: return the JSON.

Return ONLY this JSON, no preamble, no markdown:

{
  "candidate_name": "string",
  "identity_risk": {
    "level": "Low | Medium | High",
    "reason": "string"
  },
  "recruiter_signal": {
    "decision": "string",
    "confidence": "High | Medium | Low",
    "reasoning": "string"
  },
  "identity_risk": {
    "level": "Low | Medium | High",
    "reason": "string"
  },
  "hiring_verdict": {
    "decision": "Strong yes | Yes with validation | High risk",
    "reason": "string (1-2 lines max, decisive, outcome-focused)"
  },
  "surprising_insight": "string (1 sentence, non-obvious, not in CV)",
  "high_impact_findings": [
    {
      "type": "Legal | Reputation | Credibility | Career | Positive",
      "summary": "string",
      "confidence": "High | Medium | Low",
      "importance": "High"
    }
  ],
  "top_decision_drivers": ["string", "string", "string"],
  "recommended_next_step": {
    "action": "string",
    "focus_areas": ["string"],
    "reasoning": "string"
  },
  "what_stands_out": ["string"],
  "expectation_gap_analysis": {
    "expected_signals_for_profile": ["string"],
    "missing_or_weaker_than_expected": ["string"],
    "overall_assessment": "string"
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
};

export interface VerifiedSignal { statement: string; source_type: string; source_reference: string; reliability: "High" | "Medium"; }
export interface WeakSignal { statement: string; source_type: string; source_reference: string; reliability: "Low"; }
export interface UnverifiedClaim { statement: string; caveat: string; }
export interface HighImpactFinding { type: "Legal" | "Reputation" | "Credibility" | "Career" | "Positive"; summary: string; confidence: "High" | "Medium" | "Low"; importance: "High"; }

export interface IdentityRisk { level: "Low" | "Medium" | "High"; reason: string; }
export interface HiringVerdict { decision: "Strong yes" | "Yes with validation" | "High risk"; reason: string; }
export interface QuickSignal { quick_signal: "Green" | "Orange" | "Red"; quick_reason: string; }

export interface ReportData {
  identity_risk: IdentityRisk;
  hiring_verdict: HiringVerdict;
  surprising_insight: string;
  candidate_name: string;
  recruiter_signal: { decision: string; confidence: "High" | "Medium" | "Low"; reasoning: string; };
  high_impact_findings: HighImpactFinding[];
  top_decision_drivers: string[];
  recommended_next_step: { action: string; focus_areas: string[]; reasoning: string; };
  what_stands_out: string[];
  expectation_gap_analysis: { expected_signals_for_profile: string[]; missing_or_weaker_than_expected: string[]; overall_assessment: string; };
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
