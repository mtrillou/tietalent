import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { prisma } from "@/lib/db/prisma";

export async function GET() {
  const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
  if (!session?.user) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const userId = (session.user as { id?: string }).id!;

  const scans = await prisma.scan.findMany({
    where: { userId },
    orderBy: { created_at: "desc" },
    take: 50,
    select: { id: true, type: true, input_label: true, created_at: true },
  });

  return NextResponse.json({ scans });
}

export async function DELETE(request: NextRequest) {
  const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
  if (!session?.user) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const userId = (session.user as { id?: string }).id!;
  const { scanId } = await request.json() as { scanId: string };
  await prisma.scan.deleteMany({ where: { id: scanId, userId } });
  return NextResponse.json({ ok: true });
}
