"use client";

import { useEffect, useState } from "react";
import { useSession } from "next-auth/react";
import Link from "next/link";
import { useLocale } from "next-intl";

interface Credits { freeRemaining: number; paidBalance: number; totalAvailable: number; }

export function CreditsBadge() {
  const { status } = useSession();
  const locale = useLocale();
  const [credits, setCredits] = useState<Credits | null>(null);

  useEffect(() => {
    if (status !== "authenticated") return;
    fetch("/api/credits").then(r => r.json()).then(setCredits).catch(() => {});
  }, [status]);

  if (status !== "authenticated" || !credits) return null;

  const { freeRemaining, paidBalance, totalAvailable } = credits;

  let label: string;
  let color: string;
  if (totalAvailable === 0) {
    label = "No credits left";
    color = "#E8303A";
  } else if (paidBalance > 0 && freeRemaining > 0) {
    label = `${totalAvailable} credits (${freeRemaining} free + ${paidBalance} paid)`;
    color = "#059669";
  } else if (freeRemaining > 0) {
    label = `${freeRemaining} free credit${freeRemaining !== 1 ? "s" : ""} today`;
    color = "#059669";
  } else {
    label = `${paidBalance} credit${paidBalance !== 1 ? "s" : ""} remaining`;
    color = "#D97706";
  }

  return (
    <Link href={`/${locale}/pricing`} style={{ textDecoration: "none" }}>
      <div style={{ display: "flex", alignItems: "center", gap: "5px", padding: "5px 11px", borderRadius: "20px", border: "1px solid #E5E7EB", backgroundColor: "#F9FAFB", cursor: "pointer" }}>
        <span style={{ fontSize: "12px" }}>⚡</span>
        <span style={{ fontSize: "12px", fontWeight: 600, color }}>{label}</span>
      </div>
    </Link>
  );
}
