"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { useLocale, useTranslations } from "next-intl";
import { useSession } from "next-auth/react";
import { FileUpload } from "@/components/FileUpload";
import { Navbar } from "@/components/Navbar";
import { LoginModal } from "@/components/auth/LoginModal";
import { NoCreditsModal } from "@/components/auth/NoCreditsModal";
import type { ReportData } from "@/lib/claude";

const B = { red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

export default function Home() {
  const tLoad = useTranslations("loading");
  const tErr  = useTranslations("errors");
  const t     = useTranslations("home");
  const locale = useLocale();
  const router = useRouter();
  const { data: session, status } = useSession();

  const [cvText, setCvText] = useState(() => {
    if (typeof window !== "undefined") return sessionStorage.getItem("tt_pending_cv") || "";
    return "";
  });
  const [loading, setLoading]       = useState(false);
  const [stepIndex, setStepIndex]   = useState(0);
  const [error, setError]           = useState<string | null>(null);
  const [showLogin, setShowLogin]   = useState(false);
  const [showNoCredits, setShowNoCredits] = useState(false);

  const steps: string[] = [
    tLoad("steps.0"), tLoad("steps.1"), tLoad("steps.2"), tLoad("steps.3"), tLoad("steps.4"),
  ];

  // Auto-run after login if pending CV in sessionStorage
  const autoTriggered = typeof window !== "undefined" && !!sessionStorage.getItem("tt_pending_cv");
  useEffect(() => {
    if (status !== "authenticated" || !session?.user) return;
    if (!autoTriggered) return;
    const pending = sessionStorage.getItem("tt_pending_cv");
    if (!pending || pending.trim().length < 50) return;
    sessionStorage.removeItem("tt_pending_cv"); // clear immediately to prevent double-run
    setError(null);
    setLoading(true);
    setStepIndex(0);
    const steps = [tLoad("steps.0"), tLoad("steps.1"), tLoad("steps.2"), tLoad("steps.3"), tLoad("steps.4")];
    const timer = setInterval(() => setStepIndex(p => p < steps.length - 1 ? p + 1 : p), 5000);
    fetch("/api/analyze", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ cv_text: pending }),
    }).then(async res => {
      clearInterval(timer);
      if (!res.ok) {
        const d = await res.json().catch(() => ({}));
        if (d.error === "NO_CREDITS") { setShowNoCredits(true); setLoading(false); return; }
        setError(d.error || tErr("analysisError")); setLoading(false); return;
      }
      const { report } = await res.json();
      sessionStorage.setItem("tt_report", JSON.stringify(report));
      router.push(`/${locale}/report`);
    }).catch(() => { clearInterval(timer); setError(tErr("generic")); setLoading(false); });
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [status, session]);

  const handleGenerate = async () => {
    if (!cvText || cvText.trim().length < 50) { setError(tErr("uploadCv")); return; }
    if (status !== "authenticated" || !session?.user) {
      if (cvText) sessionStorage.setItem("tt_pending_cv", cvText);
      setShowLogin(true);
      return;
    }
    setError(null); setLoading(true); setStepIndex(0);
    const timer = setInterval(() => setStepIndex(p => p < steps.length - 1 ? p + 1 : p), 5000);
    try {
      const res = await fetch("/api/analyze", {
        method: "POST", headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cv_text: cvText }),
      });
      clearInterval(timer);
      if (!res.ok) {
        const d = await res.json().catch(() => ({}));
        if (d.error === "UNAUTHENTICATED") { setShowLogin(true); setLoading(false); return; }
        if (d.error === "NO_CREDITS") { setShowNoCredits(true); setLoading(false); return; }
        throw new Error(d.error || tErr("analysisError"));
      }
      const { report } = (await res.json()) as { report: ReportData };
      sessionStorage.setItem("tt_report", JSON.stringify(report));
      sessionStorage.removeItem("tt_pending_cv");
      router.push(`/${locale}/report`);
    } catch (err) {
      clearInterval(timer);
      setError(err instanceof Error ? err.message : tErr("generic"));
      setLoading(false);
    }
  };

  const valueItems = [
    { icon: "🔍", label: t("valueBlock.items.0.label"), desc: t("valueBlock.items.0.desc") },
    { icon: "⚠️", label: t("valueBlock.items.1.label"), desc: t("valueBlock.items.1.desc") },
    { icon: "🧠", label: t("valueBlock.items.2.label"), desc: t("valueBlock.items.2.desc") },
    { icon: "🌐", label: t("valueBlock.items.3.label"), desc: t("valueBlock.items.3.desc") },
    { icon: "🎯", label: t("valueBlock.items.4.label"), desc: t("valueBlock.items.4.desc") },
  ];

  const outcomeItems = [
    { icon: "✅", text: t("outcomes.items.0.text") },
    { icon: "📍", text: t("outcomes.items.1.text") },
    { icon: "⚡", text: t("outcomes.items.2.text") },
    { icon: "💬", text: t("outcomes.items.3.text") },
    { icon: "🚀", text: t("outcomes.items.4.text") },
  ];

  if (loading) {
    return (
      <div style={{ minHeight: "100vh", backgroundColor: B.white, display: "flex", flexDirection: "column" }}>
        <Navbar />
        <div style={{ flex: 1, display: "flex", alignItems: "center", justifyContent: "center", padding: "24px" }}>
          <div style={{ maxWidth: "380px", width: "100%", textAlign: "center" }}>
            <div style={{ position: "relative", width: "56px", height: "56px", margin: "0 auto 28px" }}>
              <div style={{ position: "absolute", inset: 0, border: "3px solid #FECACA", borderTopColor: B.red, borderRadius: "50%", animation: "spin 0.9s linear infinite" }} />
            </div>
            <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
            <h2 style={{ fontWeight: 600, fontSize: "20px", color: B.navy, marginBottom: "8px" }}>{tLoad("title")}</h2>
            <p style={{ fontSize: "14px", color: B.gray, marginBottom: "28px" }}>{tLoad("subtitle")}</p>
            <div style={{ height: "4px", backgroundColor: B.border, borderRadius: "2px", overflow: "hidden", marginBottom: "8px" }}>
              <div style={{ height: "100%", backgroundColor: B.red, borderRadius: "2px", width: `${((stepIndex + 1) / steps.length) * 100}%`, transition: "width 1.2s cubic-bezier(0.4, 0, 0.2, 1)" }} />
            </div>
            <p style={{ fontSize: "12px", color: "#9CA3AF", textAlign: "left", marginBottom: "20px" }}>{steps[stepIndex]}</p>
            <div style={{ textAlign: "left", display: "flex", flexDirection: "column", gap: "8px" }}>
              {steps.map((step, i) => (
                <div key={i} style={{ display: "flex", alignItems: "center", gap: "10px", fontSize: "13px", color: i < stepIndex ? B.red : i === stepIndex ? B.navy : "#D1D5DB", fontWeight: i === stepIndex ? 500 : 400 }}>
                  <span style={{ width: "18px", height: "18px", borderRadius: "50%", flexShrink: 0, display: "flex", alignItems: "center", justifyContent: "center", backgroundColor: i < stepIndex ? "#FEF2F2" : "transparent", border: i < stepIndex ? "none" : i === stepIndex ? `2px solid ${B.red}` : "2px solid #E5E7EB" }}>
                    {i < stepIndex && <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke={B.red} strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/></svg>}
                  </span>
                  {step}
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.white, display: "flex", flexDirection: "column" }}>
      <Navbar />

      {/* ── HERO ── */}
      <div style={{ background: `linear-gradient(135deg, ${B.navy} 0%, #2D2D4E 100%)` }}>
        <div style={{ maxWidth: "1152px", margin: "0 auto", padding: "72px 24px 64px", display: "flex", alignItems: "center", gap: "72px", flexWrap: "wrap" }}>

          {/* Left */}
          <div style={{ flex: 1, minWidth: "300px" }}>
            <div style={{ display: "inline-flex", alignItems: "center", gap: "6px", padding: "5px 14px", borderRadius: "20px", marginBottom: "22px", backgroundColor: "rgba(232,48,58,0.15)", border: "1px solid rgba(232,48,58,0.35)" }}>
              <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: B.red }} />
              <span style={{ fontSize: "11px", fontWeight: 700, color: "#FCA5A5", letterSpacing: "0.8px", textTransform: "uppercase" }}>{t("badge")}</span>
            </div>
            <h1 style={{ fontWeight: 700, fontSize: "42px", color: "#FFFFFF", lineHeight: 1.1, marginBottom: "20px", letterSpacing: "-0.8px", maxWidth: "480px", whiteSpace: "pre-line" }}>
              {t("title")}
            </h1>
            <p style={{ fontSize: "17px", color: "#94A3B8", lineHeight: 1.7, maxWidth: "440px", marginBottom: "36px" }}>
              {t("subtitle")}
            </p>

            <div style={{ display: "flex", flexDirection: "column", gap: "11px", marginBottom: "32px" }}>
              {valueItems.map(item => (
                <div key={item.label} style={{ display: "flex", alignItems: "center", gap: "12px" }}>
                  <span style={{ fontSize: "16px", flexShrink: 0 }}>{item.icon}</span>
                  <div>
                    <span style={{ fontSize: "13px", fontWeight: 600, color: "#E2E8F0" }}>{item.label}</span>
                    <span style={{ fontSize: "12px", color: "#64748B", marginLeft: "8px" }}>{item.desc}</span>
                  </div>
                </div>
              ))}
            </div>

            <p style={{ fontSize: "13px", color: "#475569", fontStyle: "italic" }}>{t("tagline")}</p>
          </div>

          {/* Right — upload card */}
          <div style={{ width: "420px", flexShrink: 0, backgroundColor: B.white, borderRadius: "16px", padding: "28px", boxShadow: "0 24px 64px rgba(0,0,0,0.35)" }}>
            <div style={{ marginBottom: "18px" }}>
              <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: "4px" }}>
                <h2 style={{ fontWeight: 700, fontSize: "15px", color: B.navy }}>{t("uploadTitle")}</h2>
                <span style={{ fontSize: "11px", fontWeight: 600, color: B.red, backgroundColor: "#FEF2F2", border: "1px solid #FECACA", padding: "2px 8px", borderRadius: "20px" }}>{t("freeBadge")}</span>
              </div>
              <p style={{ fontSize: "12px", color: B.gray }}>{t("uploadSubtitle")}</p>
            </div>

            {cvText && cvText.trim().length > 50 && (
                <div style={{ marginBottom: "10px", padding: "10px 12px", backgroundColor: "#ECFDF5", border: "1px solid #A7F3D0", borderRadius: "8px", display: "flex", alignItems: "center", gap: "8px" }}>
                  <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="6" fill="#059669"/><path d="M4 7l2 2 4-4" stroke="white" strokeWidth="1.3" strokeLinecap="round" strokeLinejoin="round"/></svg>
                  <span style={{ fontSize: "12px", fontWeight: 600, color: "#059669" }}>CV ready — launching analysis…</span>
                </div>
              )}
              <FileUpload onExtracted={setCvText} isLoading={loading} />

            {error && (
              <div style={{ marginTop: "14px", padding: "10px 14px", backgroundColor: "#FEF2F2", border: "1px solid #FECACA", borderRadius: "8px", fontSize: "13px", color: "#DC2626" }}>{error}</div>
            )}

            <button onClick={handleGenerate}
              style={{ marginTop: "16px", width: "100%", padding: "13px", backgroundColor: B.red, color: B.white, border: "none", borderRadius: "10px", cursor: "pointer", fontSize: "14px", fontWeight: 700, letterSpacing: "0.4px", textTransform: "uppercase", boxShadow: "0 2px 8px rgba(232,48,58,0.3)", transition: "background-color 0.15s" }}
              onMouseOver={e => (e.currentTarget.style.backgroundColor = B.redH)}
              onMouseOut={e => (e.currentTarget.style.backgroundColor = B.red)}
            >{t("generateButton")}</button>

            <div style={{ marginTop: "12px", display: "flex", alignItems: "center", justifyContent: "center", gap: "6px" }}>
              <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><rect x="2" y="5" width="8" height="6" rx="1" stroke="#9CA3AF" strokeWidth="1"/><path d="M4 5V4a2 2 0 014 0v1" stroke="#9CA3AF" strokeWidth="1"/></svg>
              <p style={{ fontSize: "11px", color: "#9CA3AF" }}>{t("gdpr")}</p>
            </div>
          </div>
        </div>
      </div>

      {/* ── OUTCOMES ── */}
      <div style={{ backgroundColor: B.surface, borderBottom: `1px solid ${B.border}` }}>
        <div style={{ maxWidth: "1152px", margin: "0 auto", padding: "52px 24px" }}>
          <p style={{ fontSize: "11px", fontWeight: 700, color: "#9CA3AF", textTransform: "uppercase", letterSpacing: "1.5px", marginBottom: "24px" }}>{t("outcomes.title")}</p>
          <div style={{ display: "grid", gridTemplateColumns: "repeat(5, 1fr)", gap: "14px" }}>
            {outcomeItems.map(item => (
              <div key={item.text} style={{ padding: "18px 16px", backgroundColor: B.white, borderRadius: "10px", border: `1px solid ${B.border}`, boxShadow: "0 1px 3px rgba(0,0,0,0.04)" }}>
                <p style={{ fontSize: "22px", marginBottom: "10px" }}>{item.icon}</p>
                <p style={{ fontSize: "12px", color: B.navy, lineHeight: 1.55, fontWeight: 500 }}>{item.text}</p>
              </div>
            ))}
          </div>
        </div>
      </div>

      {/* ── HOW IT WORKS ── */}
      <div style={{ maxWidth: "1152px", margin: "0 auto", padding: "52px 24px" }}>
        <p style={{ fontSize: "11px", fontWeight: 700, color: "#9CA3AF", textTransform: "uppercase", letterSpacing: "1.5px", marginBottom: "28px" }}>{t("howItWorks")}</p>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(3, 1fr)", gap: "36px" }}>
          {[
            { n: "01", title: t("steps.step1Title"), desc: t("steps.step1Desc") },
            { n: "02", title: t("steps.step2Title"), desc: t("steps.step2Desc") },
            { n: "03", title: t("steps.step3Title"), desc: t("steps.step3Desc") },
          ].map(step => (
            <div key={step.n} style={{ display: "flex", gap: "16px" }}>
              <span style={{ fontWeight: 700, fontSize: "22px", color: B.red, flexShrink: 0, fontFamily: "Inter" }}>{step.n}</span>
              <div>
                <p style={{ fontWeight: 600, fontSize: "14px", color: B.navy, marginBottom: "6px" }}>{step.title}</p>
                <p style={{ fontSize: "13px", color: B.gray, lineHeight: 1.65 }}>{step.desc}</p>
              </div>
            </div>
          ))}
        </div>

      </div>

      {showLogin && <LoginModal onClose={() => setShowLogin(false)} />}
      {showNoCredits && <NoCreditsModal onClose={() => setShowNoCredits(false)} />}
    </div>
  );
}
