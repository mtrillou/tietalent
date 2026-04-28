import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { prisma } from "@/lib/db/prisma";

export async function GET(_req: NextRequest, { params }: { params: { id: string } }) {
  const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
  if (!session?.user) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });
  const userId = (session.user as { id?: string }).id!;
  const scan = await prisma.scan.findFirst({ where: { id: params.id, userId } });
  if (!scan) return NextResponse.json({ error: "Not found" }, { status: 404 });
  return NextResponse.json({ scan });
}
