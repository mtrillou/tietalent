import Anthropic from "@anthropic-ai/sdk";

const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

// ─────────────────────────────────────────────
// TYPES
// ─────────────────────────────────────────────

export interface FitReport {
  fit_summary: {
    overall_match_score: number;
    match_level: "Strong Fit" | "Good Fit" | "Partial Fit" | "Weak Fit" | "Unclear";
    short_explanation: string;
  };
  alignment_analysis: {
    strong_matches: string[];
    partial_matches: string[];
    mismatches: string[];
  };
  seniority_fit: {
    candidate_level: string;
    role_level: string;
    gap_analysis: string;
  };
  experience_relevance: {
    relevant_experience: string[];
    missing_critical_experience: string[];
    transferable_skills: string[];
  };
  risk_flags: string[];
  hidden_strengths_for_role: string[];
  unknowns_and_validation_points: string[];
  external_validation: {
    verified_insights: string[];
    no_data_flags: string[];
    impact_on_fit: string;
  };
  interview_focus_for_this_role: string[];
  final_recommendation: {
    decision: "Strong Yes" | "Yes" | "Yes with caution" | "No";
    reasoning: string;
  };
}

// ─────────────────────────────────────────────
// PROMPT
// ─────────────────────────────────────────────

const SYSTEM_PROMPT = `You are a senior recruitment strategist evaluating candidate-role fit for tech companies.
Your output helps recruiters answer: "Should I interview this person for this specific role?"
You think in terms of seniority, scope, domain depth, and execution patterns — not keywords.`;

export function buildFitPrompt(
  cv_text: string,
  jd_text: string,
  enriched_data: string
): string {
  return `CANDIDATE CV:
${cv_text}

JOB DESCRIPTION:
${jd_text}

EXTERNAL ENRICHMENT DATA (public web — may be partial or noisy):
${enriched_data}

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
ANALYSIS INSTRUCTIONS
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

You are performing a deep candidate ↔ role fit analysis.
Your job is NOT keyword matching. Your job is strategic evaluation.

THINKING FRAMEWORK:
1. What does this role actually require? (seniority, scope, execution style, domain)
2. What does this candidate actually bring? (depth, trajectory, environment)
3. Where do they genuinely align, partially align, or diverge?
4. What would make a recruiter hesitate — and what might they miss?

ANALYSIS RULES:

A. NO KEYWORD MATCHING
- Never flag a match just because a word appears in both documents
- Evaluate depth, context, and relevance of each claimed skill or experience
- A junior who used Kubernetes is NOT the same as a senior who architected on it

B. SENIORITY IS CRITICAL
- Assess real seniority from CV evidence (scope, team size, ownership, impact)
- Compare to real seniority implied by JD (not just the title)
- Flag both overqualification and underqualification

C. DOMAIN RELEVANCE
- Distinguish between industry domain and technical domain
- A fintech engineer moving to healthtech: different risk than B2B → B2C
- Be specific about what transfers and what doesn't

D. SCORING (0-100)
- 85-100: Strong Fit — nearly all requirements met, seniority aligned
- 70-84:  Good Fit — most requirements met, minor gaps
- 50-69:  Partial Fit — meaningful alignment but notable gaps
- 30-49:  Weak Fit — significant mismatches, major risk
- 0-29:   Unclear — insufficient information or fundamental mismatch

E. EXTERNAL DATA
- Use enriched data to validate CV claims (company credibility, scale, press)
- If enriched data conflicts with CV: flag it
- If no useful external data: populate no_data_flags explicitly, do NOT invent

F. TONE
- Professional, factual, recruiter-facing
- Frame risks as "worth validating" not "disqualifying"
- Be direct — recruiters need clear signals, not vague observations

G. QUALITY BAR
- Every insight must be specific to THIS candidate + THIS role
- No generic statements ("strong communication skills")
- No repetition across sections
- Each section must add new information

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
OUTPUT — return ONLY this JSON, no preamble, no markdown fences:
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

{
  "fit_summary": {
    "overall_match_score": number (0-100),
    "match_level": "Strong Fit | Good Fit | Partial Fit | Weak Fit | Unclear",
    "short_explanation": string (2-3 sentences, sharp and recruiter-facing)
  },
  "alignment_analysis": {
    "strong_matches": [string],
    "partial_matches": [string],
    "mismatches": [string]
  },
  "seniority_fit": {
    "candidate_level": string,
    "role_level": string,
    "gap_analysis": string
  },
  "experience_relevance": {
    "relevant_experience": [string],
    "missing_critical_experience": [string],
    "transferable_skills": [string]
  },
  "risk_flags": [string],
  "hidden_strengths_for_role": [string],
  "unknowns_and_validation_points": [string],
  "external_validation": {
    "verified_insights": [string],
    "no_data_flags": [string],
    "impact_on_fit": string
  },
  "interview_focus_for_this_role": [string],
  "final_recommendation": {
    "decision": "Strong Yes | Yes | Yes with caution | No",
    "reasoning": string
  }
}

SECTION CONSTRAINTS:
- fit_summary.short_explanation: 2-3 sentences max, specific to this pairing
- alignment_analysis: 3-5 items per sub-array, no duplicates across them
- seniority_fit.gap_analysis: one paragraph, evidence-based
- experience_relevance: distinguish between "nice to have" and "critical" gaps
- risk_flags: 2-5 items, orange flags not red — framed as things to validate
- hidden_strengths_for_role: non-obvious reasons this candidate could excel
- unknowns_and_validation_points: specific questions the recruiter cannot answer from CV alone
- interview_focus_for_this_role: 5-7 questions specific to THIS role + THIS candidate pairing
- final_recommendation.reasoning: 2-3 sentences, decisive and grounded in evidence`;
}

// ─────────────────────────────────────────────
// CLAUDE CALL
// ─────────────────────────────────────────────

export async function analyzeFit(
  cv_text: string,
  jd_text: string,
  enriched_data: string,
  parseJSON: <T>(raw: string) => T
): Promise<FitReport> {
  const message = await client.messages.create({
    model: "claude-sonnet-4-5",
    max_tokens: 8192,
    system: SYSTEM_PROMPT,
    messages: [{
      role: "user",
      content: buildFitPrompt(cv_text, jd_text, enriched_data),
    }],
  });

  const textBlock = message.content.find((b) => b.type === "text");
  if (!textBlock || textBlock.type !== "text") throw new Error("No text response from Claude");
  return parseJSON<FitReport>(textBlock.text);
}
