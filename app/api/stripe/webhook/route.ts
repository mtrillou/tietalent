import { NextRequest, NextResponse } from "next/server";
import { prisma } from "@/lib/db/prisma";

export const runtime = "nodejs";

export async function POST(request: NextRequest) {
  const stripeKey = process.env.STRIPE_SECRET_KEY;
  if (!stripeKey || stripeKey === "sk_test_placeholder") {
    return NextResponse.json({ error: "Stripe not configured" }, { status: 503 });
  }

  const { default: Stripe } = await import("stripe");
  const stripe = new Stripe(stripeKey, { apiVersion: "2026-04-22.dahlia" });

  const body = await request.text();
  const sig = request.headers.get("stripe-signature")!;

  let event;
  try {
    event = stripe.webhooks.constructEvent(body, sig, process.env.STRIPE_WEBHOOK_SECRET!);
  } catch (err) {
    return NextResponse.json({ error: "Invalid signature" }, { status: 400 });
  }

  if (event.type === "checkout.session.completed") {
    const session = event.data.object;
    const { userId, credits } = session.metadata ?? {};
    if (!userId || !credits) return NextResponse.json({ error: "Missing metadata" }, { status: 400 });

    const existing = await prisma.creditPurchase.findUnique({ where: { stripe_session: session.id } });
    if (existing) return NextResponse.json({ ok: true });

    await prisma.$transaction([
      prisma.user.update({ where: { id: userId }, data: { credits_balance: { increment: parseInt(credits) } } }),
      prisma.creditPurchase.create({ data: { userId, credits: parseInt(credits), amount_chf: session.amount_total ?? 0, stripe_session: session.id } }),
    ]);
  }

  return NextResponse.json({ ok: true });
}
