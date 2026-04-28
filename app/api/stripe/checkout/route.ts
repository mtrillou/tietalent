import { NextRequest, NextResponse } from "next/server";
import { getServerSession } from "next-auth";
import { authOptions } from "@/lib/auth";
import { prisma } from "@/lib/db/prisma";

const PACKS: Record<string, { credits: number; price_chf: number; label: string }> = {
  pack_5:  { credits: 5,  price_chf: 2500, label: "5 credits"  },
  pack_10: { credits: 10, price_chf: 4500, label: "10 credits" },
  pack_20: { credits: 20, price_chf: 8000, label: "20 credits" },
};

export async function POST(request: NextRequest) {
  const session = await getServerSession(authOptions) as { user?: { id?: string; email?: string } } | null;
  if (!session?.user) return NextResponse.json({ error: "Unauthorized" }, { status: 401 });

  const userId = (session.user as { id?: string }).id!;
  const { packId, locale } = await request.json() as { packId: string; locale: string };

  const pack = PACKS[packId];
  if (!pack) return NextResponse.json({ error: "Invalid pack" }, { status: 400 });

  // Check Stripe key is real
  const stripeKey = process.env.STRIPE_SECRET_KEY;
  if (!stripeKey || stripeKey === "sk_test_placeholder") {
    return NextResponse.json({ error: "Stripe not configured" }, { status: 503 });
  }

  const { default: Stripe } = await import("stripe");
  const stripe = new Stripe(stripeKey, { apiVersion: "2026-04-22.dahlia" });

  // Get or create Stripe customer
  const user = await prisma.user.findUnique({ where: { id: userId }, select: { stripeCustomerId: true, email: true } });
  let customerId = user?.stripeCustomerId;

  if (!customerId) {
    const customer = await stripe.customers.create({ email: user?.email ?? undefined, metadata: { userId } });
    customerId = customer.id;
    await prisma.user.update({ where: { id: userId }, data: { stripeCustomerId: customerId } });
  }

  const origin = request.headers.get("origin") || "http://localhost:3000";

  const checkoutSession = await stripe.checkout.sessions.create({
    customer: customerId,
    mode: "payment",
    line_items: [{
      price_data: {
        currency: "chf",
        product_data: {
          name: `TieTalent — ${pack.label}`,
          description: `${pack.credits} analysis credits · 1 credit = 1 analysis`,
        },
        unit_amount: pack.price_chf,
      },
      quantity: 1,
    }],
    success_url: `${origin}/${locale}/pricing?success=1&session_id={CHECKOUT_SESSION_ID}`,
    cancel_url: `${origin}/${locale}/pricing?cancelled=1`,
    metadata: { userId, packId, credits: String(pack.credits) },
  });

  return NextResponse.json({ url: checkoutSession.url });
}
