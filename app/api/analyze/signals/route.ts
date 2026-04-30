import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { sanitizeCvText, validateCvInput } from "@/lib/security";

export const runtime = "nodejs";
export const maxDuration = 20;

export async function POST(request: NextRequest) {
  try {
    const session = await getServerSession(authOptions) as { user?: { id?: string } } | null;
    if (!session?.user?.id) return NextResponse.json({ signals: [] }, { status: 401 });

    const body = await request.json().catch(() => null);
    const validation = validateCvInput(body?.cv_text);
    if (!validation.valid) return NextResponse.json({ signals: [] });

    const { safe: cv_text } = sanitizeCvText(body.cv_text);
    const Anthropic = (await import("@anthropic-ai/sdk")).default;
    const client = new Anthropic({ apiKey: process.env.ANTHROPIC_API_KEY });

    const msg = await client.messages.create({
      model: "claude-haiku-4-5-20251001",
      max_tokens: 400,
      messages: [{
        role: "user",
        content: `You are an external intelligence scanner for hiring.
TODAY: ${new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" })}.

Analyze this CV and produce 3 to 5 intelligence signals about this candidate.

RULES:
- Signals must be based on EXTERNAL or INFERRED intelligence — not CV parsing
- DO NOT mention dates, tenures, role overlaps, or formatting
- Each signal must feel like a real discovery, not a summary
- Stop early if you run out of genuine insights — do not pad

GOOD signals:
- "Distinctive name — identity attribution likely straightforward across platforms"
- "Claims seniority level typically associated with strong public presence — verification will be telling"
- "Profile type frequently underrepresented in external data despite real expertise"
- "Positioning mixes technical and commercial signals — may create perception ambiguity"

BAD signals (forbidden):
- Anything about date math or tenure
- Generic statements like "experienced professional"
- CV formatting observations

Output ONLY a JSON array, no markdown:
[{"content":"...","confidence":"High|Medium|Low"}]

CV:
${cv_text.slice(0, 3000)}`,
      }],
    });

    const block = msg.content.find(b => b.type === "text");
    if (!block || block.type !== "text") return NextResponse.json({ signals: [] });
    const match = block.text.match(/\[[\s\S]*\]/);
    if (!match) return NextResponse.json({ signals: [] });
    const signals = JSON.parse(match[0]);
    return NextResponse.json({ signals: Array.isArray(signals) ? signals.slice(0, 4) : [] });
  } catch {
    return NextResponse.json({ signals: [] });
  }
}
