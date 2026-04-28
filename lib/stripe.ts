import Stripe from "stripe";

export const stripe = new Stripe(process.env.STRIPE_SECRET_KEY!, {
  apiVersion: "2026-04-22.dahlia",
});

export const CREDIT_PACKS = [
  { id: "pack_5",  credits: 5,  price_chf: 2500, label: "5 credits",  popular: false },
  { id: "pack_10", credits: 10, price_chf: 4500, label: "10 credits", popular: true  },
  { id: "pack_20", credits: 20, price_chf: 8000, label: "20 credits", popular: false },
] as const;

export type PackId = typeof CREDIT_PACKS[number]["id"];
