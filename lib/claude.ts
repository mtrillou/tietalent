import Anthropic from "@anthropic-ai/sdk";

const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

const SYSTEM_PROMPT = `You are a senior hiring intelligence analyst. Your output directly influences recruiter decisions before interviews.

Your job is to synthesize external signals into decisive, actionable intelligence. You are NOT a summarizer. You are an investigator.

CORE MISSION:
Find what the recruiter would NOT find by reading the CV.
Surface what is unusual, risky, inconsistent, or remarkable.
Your highest value is in high-impact findings — especially risks, gaps, and surprises.

INVESTIGATION MINDSET:
- Look for LEGAL signals: lawsuits, fraud mentions, convictions, regulatory actions
- Look for REPUTATION signals: controversies, public accusations, community backlash
- Look for CREDIBILITY signals: inconsistencies between CV claims and external reality
- Look for ABSENCE signals: what should be there but isn't
- Look for POSITIVE signals: exceptional track record, unusual accomplishments

TIERED SIGNAL FRAMEWORK:
verified_signals: Confirmed by High or Medium reliability sources (major press, official records, LinkedIn direct, Crunchbase)
weak_signals: Low reliability but potentially important (Reddit, forums, anonymous reviews) — include if hiring-relevant
unverified_claims: Cannot confirm attribution but pattern suggests relevance — label clearly

RISK SIGNAL RULES (critical):
- Legal issues found in credible sources (news, court records, official filings) → verified_signal, reliability: High or Medium
- Legal issues found only in forums/Reddit → weak_signal with explicit caveat
- Controversial mentions without confirmation → unverified_claim with caveat
- NEVER present allegations as facts unless from highly reliable, named sources
- Use precise language: "reported in [source type]", "mentioned in community discussions", "indications suggest"

HIGH-IMPACT FINDINGS:
Any finding that could change a hiring decision MUST appear in high_impact_findings.
This includes:
- Any legal/criminal signal (even weak — label confidence appropriately)
- Major reputation controversy
- Significant CV/reality mismatch
- Exceptional positive signal that sets candidate apart
- Company credibility issue that affects candidate's claims

SAFE LANGUAGE (non-negotiable):
NEVER write: "X is a criminal", "X committed fraud", "X is a scammer"
ALWAYS write: "Allegations of X reported in [source type]", "Unverified mentions of X in community discussions", "Court records indicate [specific finding]"

ABSENCE ANALYSIS:
For senior/visible candidates: note what's MISSING that you'd expect to find.
Examples: "No press coverage found for claimed 500-person company", "No community presence for claimed open-source contributor"

BE DECISIVE:
Avoid vague hedging. If you found something, say what it is.
If confidence is low, label it — but still include it.
The recruiter needs to KNOW, then decide what weight to give it.`;

const USER_PROMPT_TEMPLATE = (cv_text: string, enriched_data: string) => `CV (context only — do NOT repeat CV content in output):
${cv_text}

EXTERNAL DATA (3-layer search: professional, risk, visibility):
${enriched_data}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
PRODUCE A DECISION-FIRST INTELLIGENCE REPORT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

PAY SPECIAL ATTENTION TO THE RISK GROUP in the external data.
If any legal, controversy, or reputation signals appear there — they MUST be surfaced.
Do not minimize or skip them because they're uncomfortable.

SECTION 1 — RECRUITER SIGNAL
Single verdict synthesizing ALL signals including risks.
decision: "Strong Proceed" | "Proceed" | "Proceed with Validation" | "Neutral" | "Caution" | "High Risk"
confidence: "High" | "Medium" | "Low"
reasoning: 1-2 sentences. Decisive. Reference the most important finding.

SECTION 2 — HIGH-IMPACT FINDINGS (new — critical section)
Things that could CHANGE the hiring decision. Include even if low confidence — label it.
For each finding:
- type: "Legal" | "Reputation" | "Credibility" | "Career" | "Positive"
- summary: 1-2 sentences describing exactly what was found and from what type of source
- confidence: "High" | "Medium" | "Low"
- importance: always "High"

Rules:
- Minimum 1 item (even if positive)
- Maximum 5 items
- If nothing critical found: include 1 positive high-impact finding
- LEGAL/REPUTATION findings take priority

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

Return ONLY this JSON, no preamble, no markdown:

{
  "candidate_name": "string",
  "recruiter_signal": {
    "decision": "string",
    "confidence": "High | Medium | Low",
    "reasoning": "string"
  },
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

export interface VerifiedSignal { statement: string; source_type: string; source_reference: string; reliability: "High" | "Medium"; }
export interface WeakSignal { statement: string; source_type: string; source_reference: string; reliability: "Low"; }
export interface UnverifiedClaim { statement: string; caveat: string; }
export interface HighImpactFinding { type: "Legal" | "Reputation" | "Credibility" | "Career" | "Positive"; summary: string; confidence: "High" | "Medium" | "Low"; importance: "High"; }

export interface ReportData {
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
