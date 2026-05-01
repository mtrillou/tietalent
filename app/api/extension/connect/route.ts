import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { prisma } from "@/lib/db/prisma";

function generateApiKey(): string {
  const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  let key = "tt_";
  for (let i = 0; i < 32; i++) key += chars[Math.floor(Math.random() * chars.length)];
  return key;
}

export async function GET(request: NextRequest) {
  const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;

  if (!session?.user?.id) {
    const callbackUrl = encodeURIComponent("/api/extension/connect");
    return NextResponse.redirect(new URL(`/en/auth/signin?callbackUrl=${callbackUrl}`, request.url));
  }

  let user = await prisma.user.findUnique({
    where: { id: session.user.id },
    select: { api_key: true, credits_balance: true },
  });
  if (!user) return NextResponse.redirect(new URL("/en/auth/signin", request.url));

  let apiKey = user.api_key;
  if (!apiKey) {
    apiKey = generateApiKey();
    await prisma.user.update({ where: { id: session.user.id }, data: { api_key: apiKey } });
  }

  const params = new URLSearchParams({
    key: apiKey,
    email: session.user.email || "",
    credits: String(user.credits_balance),
  });

  return NextResponse.redirect(new URL(`/extension/connected?${params}`, request.url));
}
