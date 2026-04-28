import { NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { prisma } from "@/lib/db/prisma";
import { randomBytes } from "crypto";

export async function GET() {
  const session = await getServerSession(authOptions) as { user?: { id?: string } } | null;
  if (!session?.user?.id) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });

  const user = await prisma.user.findUnique({
    where: { id: session.user.id },
    select: { api_key: true },
  });

  return NextResponse.json({ api_key: user?.api_key || null });
}

export async function POST() {
  const session = await getServerSession(authOptions) as { user?: { id?: string } } | null;
  if (!session?.user?.id) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });

  // Generate a secure API key: tt_ prefix + 32 random hex chars
  const key = "tt_" + randomBytes(16).toString("hex");

  await prisma.user.update({
    where: { id: session.user.id },
    data: { api_key: key },
  });

  return NextResponse.json({ api_key: key, message: "New API key generated. Keep this secret — it won't be shown again." });
}
