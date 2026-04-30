import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { enforceRateLimit, sanitizeCvText, validateCvInput } from "@/lib/security";

export const runtime = "nodejs";
export const maxDuration = 15;

export async function POST(request: NextRequest) {
  try {
    const session = await getServerSession(authOptions) as { user?: { id?: string } } | null;
    if (!session?.user?.id) return NextResponse.json({ error: "UNAUTHENTICATED" }, { status: 401 });

    const rateLimitResult = enforceRateLimit(request, session.user.id, "paid");
    if (rateLimitResult) return rateLimitResult;

    const body = await request.json().catch(() => null);
    const validation = validateCvInput(body?.cv_text);
    if (!validation.valid) return NextResponse.json({ error: validation.error }, { status: 400 });

    const { safe: cv_text } = sanitizeCvText(body.cv_text);

    const Anthropic = (await import("@anthropic-ai/sdk")).default;
    const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

    const msg = await client.messages.create({
      model: "claude-haiku-4-5-20251001",
      max_tokens: 150,
      messages: [{
        role: "user",
        content: `TODAY'S DATE: ${new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" })}.

You are an external intelligence assessor for hiring. Your only job is to output a single JSON object.

Evaluate the CV below based ONLY on these 3 signals:
1. IDENTITY CLARITY: Is this a unique, identifiable person or a common/ambiguous name?
2. EXTERNAL PRESENCE: Based on their role/seniority claims, would you expect a strong digital footprint?
3. PROFILE COHERENCE: Does the overall positioning feel consistent and credible at a high level?

STRICT RULES:
- DO NOT analyze dates, tenures, or role overlaps
- DO NOT comment on CV formatting or internal consistency
- DO NOT mention specific companies or dates
- Base your signal on identity and expected external presence only

Output ONLY this JSON (no markdown, no explanation):
{"quick_signal":"Green|Orange|Red","quick_reason":"one sentence, high-level, no technical detail"}

Green examples: "Strong and consistent professional identity detected" | "Clear, distinctive profile with expected external presence"
Orange examples: "Limited external signals expected for this profile type" | "Common name may create identity ambiguity during verification"
Red examples: "Significant identity ambiguity detected — multiple profiles likely share this name" | "Profile positioning appears inconsistent with claimed seniority"

CV:
${cv_text.slice(0, 2000)}`,
      }],
    });

    const block = msg.content.find(b => b.type === "text");
    if (!block || block.type !== "text") throw new Error("No response");
    const match = block.text.match(/\{[\s\S]*\}/);
    if (!match) throw new Error("No JSON");
    return NextResponse.json(JSON.parse(match[0]));
  } catch {
    return NextResponse.json({ quick_signal: "Orange", quick_reason: "Analysis in progress…" });
  }
}
