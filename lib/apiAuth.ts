import { NextRequest, NextResponse } from "next/server";
import { prisma } from "@/lib/db/prisma";
import { getUserCredits, checkAndDeductCredit } from "@/lib/credits";

export interface ApiUser { id: string; email: string | null; }

export async function validateApiKey(request: NextRequest): Promise<
  | { ok: true; user: ApiUser }
  | { ok: false; response: NextResponse }
> {
  const authHeader = request.headers.get("authorization");
  const apiKeyHeader = request.headers.get("x-api-key");
  const rawKey = apiKeyHeader || authHeader?.replace("Bearer ", "").trim();

  if (!rawKey) {
    return { ok: false, response: NextResponse.json({ error: "API key required" }, { status: 401 }) };
  }

  // Validate key format before DB lookup (prevents timing attacks on malformed keys)
  if (!rawKey.startsWith("tt_") || rawKey.length < 20) {
    return { ok: false, response: NextResponse.json({ error: "Invalid API key format" }, { status: 401 }) };
  }

  const user = await prisma.user.findUnique({
    where: { api_key: rawKey },
    select: { id: true, email: true },
  });

  if (!user) {
    // Constant-time response to prevent timing-based key enumeration
    await new Promise(r => setTimeout(r, 50 + Math.random() * 50));
    return { ok: false, response: NextResponse.json({ error: "Invalid API key" }, { status: 401 }) };
  }

  return { ok: true, user };
}

export async function checkAndDeductApiCredit(userId: string): Promise<
  | { ok: true; remaining: number }
  | { ok: false; response: NextResponse }
> {
  const { totalAvailable } = await getUserCredits(userId);

  if (totalAvailable < 1) {
    return {
      ok: false,
      response: NextResponse.json({
        error: "Insufficient credits",
        message: "Purchase more credits at https://tietalent.com/en/pricing",
      }, { status: 402 }),
    };
  }

  const result = await checkAndDeductCredit(userId);
  if (!result.ok) {
    return { ok: false, response: NextResponse.json({ error: "Failed to process credits" }, { status: 500 }) };
  }

  const { totalAvailable: remaining } = await getUserCredits(userId);
  return { ok: true, remaining };
}
