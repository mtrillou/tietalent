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
        content: `TODAY: ${new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" })}.

You are an external intelligence assessor for hiring. Output ONLY a single JSON object — no markdown, no explanation.

Evaluate based ONLY on:
1. IDENTITY CLARITY — Is this a unique, identifiable person or a common/ambiguous name?
2. EXTERNAL PRESENCE — Given their seniority claims, would you expect a strong digital footprint?
3. POSITIONING — Does the overall professional identity feel clear and coherent?

ABSOLUTE PROHIBITIONS — NEVER mention:
✗ Dates, years, months, durations, tenures
✗ Timeline inconsistencies or "present" role analysis  
✗ Overlapping roles or simultaneous positions
✗ CV formatting or internal CV consistency
✗ Anything requiring only CV reading

Output exactly: {"quick_signal":"Green|Orange|Red","quick_reason":"one sentence, no dates, no tenure, external/identity focus only"}

Green: clear identity + expected external presence
Orange: ambiguity in identity or limited expected footprint
Red: significant identity confusion or positioning inconsistency

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
