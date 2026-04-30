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
        content: `TODAY: ${new Date().toLocaleDateString("en-GB", { day: "numeric", month: "long", year: "numeric" })}.

You are an external intelligence scanner for hiring. Your job is to surface identity and presence signals — NOT to analyze CVs.

OUTPUT: A JSON array of 3 to 4 signals. No markdown, no preamble.
Format: [{"content":"...","confidence":"High|Medium|Low"}]

════════════════════════════════════
WHAT YOU ARE ALLOWED TO SIGNAL:
════════════════════════════════════

1. IDENTITY CLARITY
- Is this a distinctive, easily identifiable person?
- Or a common name with likely ambiguity across profiles?
Examples:
✓ "Distinctive name — identity attribution across platforms should be straightforward"
✓ "Common name — multiple individuals likely share this identity online"

2. EXTERNAL PRESENCE EXPECTATION
- Given their claimed seniority and sector, what external footprint would you expect?
- Is it likely strong, moderate, or limited?
Examples:
✓ "Profile type typically generates strong external signals — verification will be informative"
✓ "Sector and role combination often produces limited public digital footprint"

3. POSITIONING COHERENCE (high-level only)
- Does the overall professional positioning feel clear and consistent?
- Is there a coherent narrative, or does it feel fragmented?
Examples:
✓ "Clear and focused professional positioning across stated roles"
✓ "Mixed signals between technical and commercial positioning — may affect perception"

════════════════════════════════════
ABSOLUTE PROHIBITIONS — NEVER OUTPUT:
════════════════════════════════════
✗ Anything involving dates, years, months, or durations
✗ Tenure calculations of any kind ("X years", "since 2017", "9 months")
✗ Timeline inconsistencies or "present" role analysis
✗ Overlapping roles or simultaneous positions
✗ Future-dated or backdated role detection
✗ CV formatting observations
✗ Any claim requiring only CV reading (no external signal)

If you catch yourself about to write any of the above — STOP and generate a different signal.
If you cannot find 3 valid external signals — output fewer. Do not pad with weak or forbidden content.

════════════════════════════════════
SELF-CHECK BEFORE OUTPUTTING:
════════════════════════════════════
For each signal ask: "Is this based on external intelligence or inferred market knowledge — NOT on reading the CV?"
If NO → discard it.

CV (for context only — do not analyze its internal consistency):
${cv_text.slice(0, 2000)}`,
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
