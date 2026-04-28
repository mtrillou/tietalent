"use client";

import { useLocale, useTranslations } from "next-intl";

const B = { red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

interface NoCreditsModalProps { onClose: () => void; }

export function NoCreditsModal({ onClose }: NoCreditsModalProps) {
  const t = useTranslations("noCredits");
  const locale = useLocale();

  return (
    <div style={{ position: "fixed", inset: 0, zIndex: 100, display: "flex", alignItems: "center", justifyContent: "center", backgroundColor: "rgba(0,0,0,0.55)", backdropFilter: "blur(4px)" }}
      onClick={e => e.target === e.currentTarget && onClose()}>
      <div style={{ backgroundColor: B.white, borderRadius: "16px", padding: "40px 36px 32px", maxWidth: "400px", width: "90%", textAlign: "center", boxShadow: "0 24px 64px rgba(0,0,0,0.2)", position: "relative" }}>
        <button onClick={onClose} style={{ position: "absolute", top: "16px", right: "18px", background: "none", border: "none", cursor: "pointer", color: "#9CA3AF", fontSize: "22px", lineHeight: 1 }}>×</button>
        <p style={{ fontSize: "44px", marginBottom: "14px" }}>⚡</p>
        <h2 style={{ fontWeight: 700, fontSize: "20px", color: B.navy, marginBottom: "10px" }}>{t("title")}</h2>
        <p style={{ fontSize: "14px", color: B.gray, lineHeight: 1.65, marginBottom: "6px" }}>{t("desc1")}</p>
        <p style={{ fontSize: "14px", color: B.gray, lineHeight: 1.65, marginBottom: "28px" }}>{t("desc2")}</p>
        <div style={{ display: "flex", flexDirection: "column", gap: "10px" }}>
          <a href={`/${locale}/pricing`}
            style={{ display: "block", padding: "13px", backgroundColor: B.red, color: B.white, borderRadius: "10px", fontSize: "14px", fontWeight: 700, textDecoration: "none", textTransform: "uppercase", letterSpacing: "0.4px" }}
            onMouseOver={e => (e.currentTarget.style.backgroundColor = B.redH)}
            onMouseOut={e => (e.currentTarget.style.backgroundColor = B.red)}>
            {t("buyButton")}
          </a>
          <button onClick={onClose}
            style={{ padding: "12px", backgroundColor: B.surface, color: B.gray, border: `1px solid ${B.border}`, borderRadius: "10px", cursor: "pointer", fontSize: "14px", fontWeight: 500 }}>
            {t("tomorrowButton")}
          </button>
        </div>
        <p style={{ fontSize: "11px", color: "#9CA3AF", marginTop: "16px" }}>{t("note")}</p>
      </div>
    </div>
  );
}
