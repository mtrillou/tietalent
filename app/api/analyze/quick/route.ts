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
        content: `TODAY'S DATE: ${new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" })}. Use this for tenure calculations.

You are a hiring signal detector. Read this CV and output ONLY JSON.

CV: ${cv_text.slice(0, 3000)}

Output exactly: {"quick_signal":"Green|Orange|Red","quick_reason":"one sentence"}

Green = clean consistent profile. Orange = ambiguity or gaps. Red = risk signals detected.`,
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
