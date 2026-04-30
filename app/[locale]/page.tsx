"use client";
import { TT } from "@/lib/designTokens";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { useLocale, useTranslations } from "next-intl";
import { useSession } from "next-auth/react";
import { FileUpload } from "@/components/FileUpload";
import { Navbar } from "@/components/Navbar";
import { LoginModal } from "@/components/auth/LoginModal";
import { NoCreditsModal } from "@/components/auth/NoCreditsModal";
import type { ReportData } from "@/lib/claude";

// TieTalent design tokens
const B = { 
  red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", 
  gray: "#6B7280", grayL: "#9CA3AF",
  border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF",
  dark: "#1A1A1A"
};

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
  const [quickSignal, setQuickSignal] = useState<{quick_signal: string; quick_reason: string} | null>(null);
  const [liveSignals, setLiveSignals] = useState<{content: string; confidence: string}[]>([]);
  const [visibleSignals, setVisibleSignals] = useState<{content: string; confidence: string}[]>([]);
  const [showAllSignals, setShowAllSignals] = useState(false);
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  const [_report, setReport]        = useState<ReportData | null>(null);

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
    setError(null); setReport(null); setLoading(true); setStepIndex(0); setQuickSignal(null); setLiveSignals([]); setVisibleSignals([]);
    const timer = setInterval(() => setStepIndex(p => p < steps.length - 1 ? p + 1 : p), 5000);
    // Fire quick signal in parallel — best effort, <3s
    fetch("/api/analyze/quick", {
      method: "POST", headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ cv_text: cvText }),
    }).then(r => r.json()).then(q => setQuickSignal(q)).catch(() => {});
    // Fire signal stream in parallel — drip results progressively
    fetch("/api/analyze/signals", {
      method: "POST", headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ cv_text: cvText }),
    }).then(r => r.json()).then(({ signals }) => {
      if (!signals || signals.length === 0) return;
      setLiveSignals(signals);
      // Drip one signal every 7s starting at 5s
      signals.forEach((_: unknown, i: number) => {
        setTimeout(() => {
          setVisibleSignals(prev => [...prev, signals[i]]);
        }, 5000 + i * 7000);
      });
    }).catch(() => {});
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
            <p style={{ fontSize: "14px", color: B.gray, marginBottom: quickSignal ? "16px" : "28px" }}>{tLoad("subtitle")}</p>

            {/* Quick signal badge — appears within ~3s */}
            {quickSignal && (
              <div style={{
                marginBottom: "24px",
                padding: "12px 16px",
                borderRadius: "8px",
                border: `1px solid ${quickSignal.quick_signal === "Green" ? "#A7F3D0" : quickSignal.quick_signal === "Red" ? "#FECACA" : "#FDE68A"}`,
                backgroundColor: quickSignal.quick_signal === "Green" ? "#ECFDF5" : quickSignal.quick_signal === "Red" ? "#FEF2F2" : "#FFFBEB",
                display: "flex", alignItems: "center", gap: "10px",
                animation: "fadeIn 0.4s ease",
              }}>
                <span style={{ fontSize: "18px", flexShrink: 0 }}>
                  {quickSignal.quick_signal === "Green" ? "🟢" : quickSignal.quick_signal === "Red" ? "🔴" : "🟡"}
                </span>
                <div style={{ textAlign: "left" }}>
                  <p style={{ fontSize: "11px", fontWeight: 700, color: quickSignal.quick_signal === "Green" ? "#059669" : quickSignal.quick_signal === "Red" ? "#DC2626" : "#D97706", textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "2px" }}>
                    Preliminary signal
                  </p>
                  <p style={{ fontSize: "13px", color: "#111827" }}>{quickSignal.quick_reason}</p>
                </div>
              </div>
            )}
            <style>{`@keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }`}</style>
            <div style={{ height: "4px", backgroundColor: B.border, borderRadius: "2px", overflow: "hidden", marginBottom: "8px" }}>
              <div style={{ height: "100%", backgroundColor: B.red, borderRadius: "2px", width: `${((stepIndex + 1) / steps.length) * 100}%`, transition: "width 1.2s cubic-bezier(0.4, 0, 0.2, 1)" }} />
            </div>
            <p style={{ fontSize: "12px", color: "#9CA3AF", textAlign: "left", marginBottom: "20px" }}>{steps[stepIndex]}</p>

            {/* Live signal feed — latest visible, rest toggleable */}
            {visibleSignals.length === 0 ? (
              <div style={{ textAlign: "left", padding: "12px 0" }}>
                <p style={{ fontSize: "12px", color: "#9CA3AF", fontStyle: "italic" }}>Analyzing external signals…</p>
              </div>
            ) : (
              <div style={{ textAlign: "left" }}>
                {/* Latest signal — always shown */}
                {(() => {
                  const sig = visibleSignals[visibleSignals.length - 1];
                  return (
                    <div style={{
                      padding: "10px 14px", borderRadius: "6px", marginBottom: "8px",
                      border: `1px solid ${sig.confidence === "High" ? "#A7F3D0" : sig.confidence === "Low" ? "#E5E7EB" : "#FDE68A"}`,
                      backgroundColor: sig.confidence === "High" ? "#F0FDF4" : sig.confidence === "Low" ? "#F9FAFB" : "#FEFCE8",
                      animation: "fadeIn 0.5s ease",
                      display: "flex", gap: "10px", alignItems: "flex-start",
                    }}>
                      <span style={{ fontSize: "11px", flexShrink: 0, marginTop: "1px" }}>
                        {sig.confidence === "High" ? "●" : sig.confidence === "Low" ? "○" : "◐"}
                      </span>
                      <p style={{ fontSize: "12px", color: "#111827", lineHeight: 1.55 }}>{sig.content}</p>
                    </div>
                  );
                })()}

                {/* Toggle for previous signals */}
                {visibleSignals.length > 1 && (
                  <div>
                    <button
                      onClick={() => setShowAllSignals(p => !p)}
                      style={{
                        background: "none", border: "none", cursor: "pointer",
                        fontSize: "11px", color: B.red, fontWeight: 600,
                        padding: "0 0 8px", display: "flex", alignItems: "center", gap: "4px",
                      }}
                    >
                      {showAllSignals ? "▲ Hide previous signals" : `▼ ${visibleSignals.length - 1} earlier signal${visibleSignals.length > 2 ? "s" : ""}`}
                    </button>
                    {showAllSignals && (
                      <div style={{ display: "flex", flexDirection: "column", gap: "6px" }}>
                        {visibleSignals.slice(0, -1).reverse().map((sig, i) => (
                          <div key={i} style={{
                            padding: "9px 13px", borderRadius: "6px",
                            border: "1px solid #E5E7EB", backgroundColor: "#F9FAFB",
                            display: "flex", gap: "10px", alignItems: "flex-start",
                          }}>
                            <span style={{ fontSize: "11px", color: "#9CA3AF", flexShrink: 0, marginTop: "1px" }}>
                              {sig.confidence === "High" ? "●" : sig.confidence === "Low" ? "○" : "◐"}
                            </span>
                            <p style={{ fontSize: "12px", color: "#6B7280", lineHeight: 1.55 }}>{sig.content}</p>
                          </div>
                        ))}
                      </div>
                    )}
                  </div>
                )}

                {visibleSignals.length < liveSignals.length && (
                  <p style={{ fontSize: "11px", color: "#9CA3AF", fontStyle: "italic", marginTop: "6px" }}>
                    New insight found…
                  </p>
                )}
              </div>
            )}
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
