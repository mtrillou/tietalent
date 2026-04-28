"use client";

import { Suspense } from "react";
import { useSession, signIn } from "next-auth/react";
import { useLocale, useTranslations } from "next-intl";
import { useSearchParams } from "next/navigation";
import { useEffect, useState } from "react";
import { Navbar } from "@/components/Navbar";

const B = { red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

const PACKS = [
  { id: "pack_5",  credits: 5,  chf: 25, popular: false },
  { id: "pack_10", credits: 10, chf: 45, popular: true  },
  { id: "pack_20", credits: 20, chf: 80, popular: false },
];

function PricingContent() {
  const t = useTranslations("pricing");
  const { data: session, status } = useSession();
  const locale = useLocale();
  const params = useSearchParams();
  const [loading, setLoading] = useState<string | null>(null);
  const [credits, setCredits] = useState<{ freeRemaining: number; paidBalance: number } | null>(null);
  const success = params.get("success");

  useEffect(() => {
    if (status !== "authenticated") return;
    fetch("/api/credits").then(r => r.json()).then(setCredits).catch(() => {});
  }, [status]);

  const handleBuy = async (packId: string) => {
    if (!session) { signIn(); return; }
    setLoading(packId);
    try {
      const res = await fetch("/api/stripe/checkout", {
        method: "POST", headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ packId, locale }),
      });
      const { url } = await res.json();
      if (url) window.location.href = url;
    } catch { setLoading(null); }
  };

  const whyItems = [
    { icon: "⚡", text: t("reason1") },
    { icon: "🔍", text: t("reason2") },
    { icon: "💬", text: t("reason3") },
    { icon: "🚀", text: t("reason4") },
  ];

  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
      <Navbar />

      {/* Header */}
      <div style={{ background: `linear-gradient(135deg, ${B.navy} 0%, #2D2D4E 100%)`, padding: "56px 24px 48px", textAlign: "center" }}>
        <div style={{ display: "inline-flex", alignItems: "center", gap: "6px", padding: "4px 12px", borderRadius: "20px", marginBottom: "16px", backgroundColor: "rgba(232,48,58,0.15)", border: "1px solid rgba(232,48,58,0.35)" }}>
          <span style={{ fontSize: "11px", fontWeight: 700, color: "#FCA5A5", textTransform: "uppercase", letterSpacing: "0.8px" }}>{t("badge")}</span>
        </div>
        <h1 style={{ fontWeight: 700, fontSize: "36px", color: B.white, marginBottom: "12px", letterSpacing: "-0.5px" }}>{t("title")}</h1>
        <p style={{ fontSize: "16px", color: "#94A3B8", maxWidth: "440px", margin: "0 auto 20px", lineHeight: 1.65 }}>{t("subtitle")}</p>
        {credits && (
          <div style={{ display: "inline-flex", alignItems: "center", gap: "8px", padding: "8px 18px", backgroundColor: "rgba(255,255,255,0.08)", borderRadius: "20px", border: "1px solid rgba(255,255,255,0.12)" }}>
            <span>⚡</span>
            <span style={{ fontSize: "13px", color: "#CBD5E1" }}>
              <strong style={{ color: B.white }}>{credits.freeRemaining}</strong> {t("currentBalance").split("·")[0].trim()} · <strong style={{ color: B.white }}>{credits.paidBalance}</strong> {t("currentBalance").split("·")[1].trim()}
            </span>
          </div>
        )}
      </div>

      <main style={{ maxWidth: "820px", margin: "0 auto", padding: "48px 24px" }}>

        {success && (
          <div style={{ padding: "16px 20px", backgroundColor: "#ECFDF5", border: "1px solid #A7F3D0", borderRadius: "10px", marginBottom: "32px", display: "flex", alignItems: "center", gap: "12px" }}>
            <span style={{ fontSize: "20px" }}>✅</span>
            <div>
              <p style={{ fontWeight: 600, color: "#065F46", fontSize: "14px" }}>{t("successTitle")}</p>
              <p style={{ fontSize: "13px", color: "#059669" }}>{t("successDesc")}</p>
            </div>
          </div>
        )}

        {/* Free tier */}
        <div style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "12px", padding: "20px 24px", marginBottom: "24px", display: "flex", alignItems: "center", gap: "16px", boxShadow: "0 1px 4px rgba(0,0,0,0.04)" }}>
          <span style={{ fontSize: "32px", flexShrink: 0 }}>🎁</span>
          <div>
            <p style={{ fontWeight: 700, fontSize: "15px", color: B.navy, marginBottom: "3px" }}>{t("freeTitle")}</p>
            <p style={{ fontSize: "13px", color: B.gray, lineHeight: 1.55 }}>{t("freeDesc")}</p>
          </div>
        </div>

        {/* Packs */}
        <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: "16px", marginBottom: "40px" }}>
          {PACKS.map(pack => (
            <div key={pack.id} style={{ backgroundColor: B.white, border: pack.popular ? `2px solid ${B.red}` : `1px solid ${B.border}`, borderRadius: "14px", padding: "32px 20px", textAlign: "center", position: "relative", boxShadow: pack.popular ? "0 8px 32px rgba(232,48,58,0.12)" : "0 1px 4px rgba(0,0,0,0.04)", transition: "transform 0.15s, box-shadow 0.15s" }}
              onMouseOver={e => { e.currentTarget.style.transform = "translateY(-2px)"; e.currentTarget.style.boxShadow = pack.popular ? "0 12px 40px rgba(232,48,58,0.18)" : "0 4px 16px rgba(0,0,0,0.08)"; }}
              onMouseOut={e => { e.currentTarget.style.transform = "none"; e.currentTarget.style.boxShadow = pack.popular ? "0 8px 32px rgba(232,48,58,0.12)" : "0 1px 4px rgba(0,0,0,0.04)"; }}>
              {pack.popular && (
                <div style={{ position: "absolute", top: "-13px", left: "50%", transform: "translateX(-50%)", backgroundColor: B.red, color: B.white, fontSize: "11px", fontWeight: 700, padding: "4px 14px", borderRadius: "20px", whiteSpace: "nowrap", textTransform: "uppercase", letterSpacing: "0.5px" }}>
                  {t("mostPopular")}
                </div>
              )}
              <p style={{ fontWeight: 800, fontSize: "40px", color: B.navy, marginBottom: "2px", letterSpacing: "-1px" }}>{pack.credits}</p>
              <p style={{ fontSize: "13px", color: B.gray, marginBottom: "20px", textTransform: "uppercase", letterSpacing: "0.5px" }}>{t("credits")}</p>
              <p style={{ fontWeight: 700, fontSize: "28px", color: pack.popular ? B.red : B.navy, marginBottom: "4px" }}>CHF {pack.chf}</p>
              <p style={{ fontSize: "12px", color: "#9CA3AF", marginBottom: "24px" }}>CHF {(pack.chf / pack.credits).toFixed(2)} {t("perCredit")}</p>
              <button onClick={() => handleBuy(pack.id)} disabled={loading === pack.id}
                style={{ width: "100%", padding: "13px", backgroundColor: pack.popular ? B.red : B.white, color: pack.popular ? B.white : B.navy, border: `1.5px solid ${pack.popular ? B.red : B.border}`, borderRadius: "9px", cursor: "pointer", fontSize: "14px", fontWeight: 700, opacity: loading ? 0.7 : 1, transition: "all 0.15s", letterSpacing: "0.3px" }}
                onMouseOver={e => { e.currentTarget.style.backgroundColor = pack.popular ? B.redH : B.surface; }}
                onMouseOut={e => { e.currentTarget.style.backgroundColor = pack.popular ? B.red : B.white; }}>
                {loading === pack.id ? t("redirecting") : t("buyNow")}
              </button>
            </div>
          ))}
        </div>

        {/* Why buy */}
        <div style={{ backgroundColor: B.navy, borderRadius: "14px", padding: "32px", marginBottom: "32px" }}>
          <p style={{ fontSize: "11px", fontWeight: 700, color: "#64748B", textTransform: "uppercase", letterSpacing: "1.5px", marginBottom: "20px" }}>{t("whyCredits")}</p>
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "14px" }}>
            {whyItems.map(item => (
              <div key={item.text} style={{ display: "flex", alignItems: "center", gap: "12px" }}>
                <span style={{ fontSize: "20px", flexShrink: 0 }}>{item.icon}</span>
                <span style={{ fontSize: "13px", color: "#CBD5E1", lineHeight: 1.5 }}>{item.text}</span>
              </div>
            ))}
          </div>
        </div>

        {/* Trust */}
        <div style={{ display: "flex", justifyContent: "center", gap: "32px", fontSize: "13px", color: "#9CA3AF", flexWrap: "wrap" }}>
          <span>{t("trust1")}</span>
          <span>{t("trust2")}</span>
          <span>{t("trust3")}</span>
        </div>
      </main>
    </div>
  );
}

export default function PricingPage() {
  return (
    <Suspense fallback={<div style={{ minHeight: "100vh", backgroundColor: "#F9FAFB" }} />}>
      <PricingContent />
    </Suspense>
  );
}
