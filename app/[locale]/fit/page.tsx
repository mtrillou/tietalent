"use client";

import { useState } from "react";
import { useLocale, useTranslations } from "next-intl";
import { Navbar } from "@/components/Navbar";
import { FileUpload } from "@/components/FileUpload";
import { FitReport } from "@/components/FitReport";
import type { FitReport as FitReportData } from "@/lib/fitAnalysis";
import { useSession } from "next-auth/react";
import { LoginModal } from "@/components/auth/LoginModal";
import { NoCreditsModal } from "@/components/auth/NoCreditsModal";

const B = { red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

type JDMode = "paste" | "url";

export default function FitPage() {
  const t = useTranslations("fit");
  const tErr = useTranslations("errors");
  const { data: session, status } = useSession();
  const locale = useLocale();
  const [cvText, setCvText] = useState(() => {
    if (typeof window !== "undefined") return sessionStorage.getItem("tt_pending_cv") || "";
    return "";
  });
  const [jdText, setJdText] = useState(() => {
    if (typeof window !== "undefined") return sessionStorage.getItem("tt_pending_jd") || "";
    return "";
  });
  const [jdUrl, setJdUrl] = useState("");
  const [jdMode, setJdMode] = useState<JDMode>("paste");
  const [loading, setLoading] = useState(false);
  const [stepIndex, setStepIndex] = useState(0);
  const [report, setReport] = useState<FitReportData | null>(() => {
    if (typeof window !== "undefined") {
      const stored = sessionStorage.getItem("tt_fit_report");
      if (stored) { sessionStorage.removeItem("tt_fit_report"); return JSON.parse(stored); }
    }
    return null;
  });
  const [error, setError] = useState<string | null>(null);
  const [jdBlocked, setJdBlocked] = useState(false);
  const [showLogin, setShowLogin] = useState(false);
  const [showNoCredits, setShowNoCredits] = useState(false);
  const [jdFileText, setJdFileText] = useState("");

  const loadingSteps: string[] = [
    t("loading.steps.0"), t("loading.steps.1"), t("loading.steps.2"),
    t("loading.steps.3"), t("loading.steps.4"), t("loading.steps.5"),
  ];

  const handleAnalyse = async () => {
    if (!cvText || cvText.trim().length < 50) { setError(tErr("uploadCv")); return; }
    // Client-side auth gate
    if (status !== "authenticated" || !session?.user) {
      if (cvText) sessionStorage.setItem("tt_pending_cv", cvText);
      if (jdText) sessionStorage.setItem("tt_pending_jd", jdText);
      setShowLogin(true);
      return;
    }
    const resolvedJdText = jdFileText || jdText;
    if (jdMode === "paste" && (!resolvedJdText || resolvedJdText.trim().length < 50)) { setError(tErr("pasteJd")); return; }
    if (jdMode === "url" && !jdUrl.trim()) { setError(tErr("enterUrl")); return; }
    setError(null); setReport(null); setLoading(true); setStepIndex(0);
    const timer = setInterval(() => setStepIndex(p => p < loadingSteps.length - 1 ? p + 1 : p), 8000);
    try {
      const body: Record<string, string> = { cv_text: cvText };
      if (jdMode === "paste") body.jd_text = jdFileText || jdText; else body.jd_url = jdUrl;
      const res = await fetch("/api/fit", { method: "POST", headers: { "Content-Type": "application/json" }, body: JSON.stringify(body) });
      clearInterval(timer);
      if (!res.ok) {
        const d = await res.json().catch(() => ({}));
        if (d.error === "JD_FETCH_BLOCKED") { setJdMode("paste"); setJdBlocked(true); setLoading(false); return; }
        if (d.error === "UNAUTHENTICATED") { setShowLogin(true); setLoading(false); return; }
        if (d.error === "NO_CREDITS") { setShowNoCredits(true); setLoading(false); return; }
        throw new Error(d.error || tErr("analysisError"));
      }
      const { report: data } = await res.json() as { report: FitReportData };
      sessionStorage.removeItem("tt_pending_cv");
      sessionStorage.removeItem("tt_pending_jd");
      setReport(data);
    } catch (err) { setError(err instanceof Error ? err.message : tErr("generic")); }
    finally { clearInterval(timer); setLoading(false); }
  };

  // ── Loading ──
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
            <h2 style={{ fontWeight: 600, fontSize: "20px", color: B.navy, marginBottom: "8px" }}>{t("loading.title")}</h2>
            <p style={{ fontSize: "14px", color: B.gray, marginBottom: "28px" }}>{t("loading.subtitle")}</p>
            <div style={{ height: "4px", backgroundColor: B.border, borderRadius: "2px", overflow: "hidden", marginBottom: "8px" }}>
              <div style={{ height: "100%", backgroundColor: B.red, borderRadius: "2px", width: `${((stepIndex + 1) / loadingSteps.length) * 100}%`, transition: "width 1s ease" }} />
            </div>
            <p style={{ fontSize: "12px", color: "#9CA3AF", textAlign: "left" }}>{loadingSteps[stepIndex]}</p>
          </div>
        </div>
      </div>
    );
  }

  // ── Report ──
  if (report) {
    return (
      <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
        <Navbar />
        <main style={{ maxWidth: "1100px", margin: "0 auto", padding: "32px 24px" }}>
          <div style={{ marginBottom: "20px", display: "flex", alignItems: "center", justifyContent: "space-between" }}>
            <button onClick={() => setReport(null)} style={{ display: "flex", alignItems: "center", gap: "6px", fontSize: "13px", color: B.gray, background: "none", border: "none", cursor: "pointer" }}>
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7"/></svg>
              {t("report.newAnalysis")}
            </button>
            <span style={{ fontSize: "12px", color: "#9CA3AF" }}>{t("report.label")}</span>
          </div>
          <FitReport data={report} locale={locale} />
        </main>
      </div>
    );
  }

  // ── Input form ──
  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.white, display: "flex", flexDirection: "column" }}>
      <Navbar />

      {/* ── HERO — text only, no inputs ── */}
      <div style={{ backgroundColor: B.navy }}>
        <div style={{ maxWidth: "900px", margin: "0 auto", padding: "56px 24px 48px", textAlign: "center" }}>
          <div style={{ display: "inline-flex", alignItems: "center", gap: "6px", padding: "4px 12px", borderRadius: "20px", marginBottom: "16px", backgroundColor: "rgba(232,48,58,0.15)", border: "1px solid rgba(232,48,58,0.35)" }}>
            <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: B.red }} />
            <span style={{ fontSize: "11px", fontWeight: 700, color: "#FCA5A5", letterSpacing: "0.8px", textTransform: "uppercase" }}>Role Match Intelligence</span>
          </div>
          <h1 style={{ fontWeight: 700, fontSize: "40px", color: "#FFFFFF", lineHeight: 1.1, marginBottom: "16px", letterSpacing: "-0.6px" }}>
            Know If This Candidate<br />Is Worth the Interview
          </h1>
          <p style={{ fontSize: "17px", color: "#94A3B8", lineHeight: 1.65, maxWidth: "520px", margin: "0 auto 32px" }}>
            Instantly assess how well a profile matches your role — with deep analysis of alignment, gaps, and external signals that impact hiring decisions.
          </p>
          {/* Value pills — horizontal row */}
          <div style={{ display: "flex", justifyContent: "center", flexWrap: "wrap", gap: "8px" }}>
            {[
              { icon: "🎯", label: "Real match score" },
              { icon: "⚖️", label: "Alignment vs gaps" },
              { icon: "⚠️", label: "Hidden risks" },
              { icon: "🌐", label: "External validation" },
              { icon: "🧠", label: "Critical unknowns" },
            ].map(item => (
              <span key={item.label} style={{ display: "inline-flex", alignItems: "center", gap: "6px", padding: "5px 12px", borderRadius: "20px", backgroundColor: "rgba(255,255,255,0.07)", border: "1px solid rgba(255,255,255,0.1)", fontSize: "12px", color: "#CBD5E1" }}>
                {item.icon} {item.label}
              </span>
            ))}
          </div>
        </div>
      </div>

      {/* ── INPUT PANEL — side by side ── */}
      <div style={{ backgroundColor: B.surface, borderBottom: `1px solid ${B.border}` }}>
        <div style={{ maxWidth: "1100px", margin: "0 auto", padding: "40px 24px" }}>

          {/* Two columns */}
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "20px", marginBottom: "20px" }}>

            {/* ── Left: CV ── */}
            <div style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "12px", padding: "24px", boxShadow: "0 1px 4px rgba(0,0,0,0.04)" }}>
              <div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "16px", paddingBottom: "14px", borderBottom: `1px solid ${B.border}` }}>
                <div style={{ width: "32px", height: "32px", borderRadius: "8px", backgroundColor: "#FEF2F2", display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>
                  <span style={{ fontSize: "16px" }}>📄</span>
                </div>
                <div>
                  <p style={{ fontWeight: 700, fontSize: "14px", color: B.navy }}>Candidate CV</p>
                  <p style={{ fontSize: "11px", color: B.gray }}>{t("cvSubtitle")}</p>
                </div>
              </div>
              <FileUpload onExtracted={setCvText} isLoading={loading} />
            </div>

            {/* ── Right: JD ── */}
            <div style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "12px", padding: "24px", boxShadow: "0 1px 4px rgba(0,0,0,0.04)" }}>
              <div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "16px", paddingBottom: "14px", borderBottom: `1px solid ${B.border}` }}>
                <div style={{ width: "32px", height: "32px", borderRadius: "8px", backgroundColor: "#F0FDF4", display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>
                  <span style={{ fontSize: "16px" }}>📋</span>
                </div>
                <div>
                  <p style={{ fontWeight: 700, fontSize: "14px", color: B.navy }}>Job Description</p>
                  <p style={{ fontSize: "11px", color: B.gray }}>{t("jdSubtitle")}</p>
                </div>
              </div>

              {/* File upload */}
              <FileUpload onExtracted={setJdFileText} isLoading={loading} hidePaste />

              {/* Divider */}
              <div style={{ display: "flex", alignItems: "center", gap: "10px", margin: "16px 0" }}>
                <div style={{ flex: 1, height: "1px", backgroundColor: B.border }} />
                <span style={{ fontSize: "11px", color: "#9CA3AF", fontWeight: 500, whiteSpace: "nowrap" }}>or paste text / add URL</span>
                <div style={{ flex: 1, height: "1px", backgroundColor: B.border }} />
              </div>

              {/* Mode tabs */}
              <div style={{ display: "flex", gap: "4px", marginBottom: "10px", backgroundColor: B.surface, padding: "3px", borderRadius: "8px", border: `1px solid ${B.border}` }}>
                {(["paste", "url"] as JDMode[]).map(mode => (
                  <button key={mode} onClick={() => { setJdMode(mode); setJdBlocked(false); }}
                    style={{ flex: 1, padding: "6px", borderRadius: "6px", border: "none", cursor: "pointer", fontSize: "12px", fontWeight: 500, transition: "all 0.15s", backgroundColor: jdMode === mode ? B.white : "transparent", color: jdMode === mode ? B.navy : B.gray, boxShadow: jdMode === mode ? "0 1px 2px rgba(0,0,0,0.06)" : "none" }}>
                    {mode === "paste" ? t("pasteText") : t("jobUrl")}
                  </button>
                ))}
              </div>

              {jdMode === "paste" ? (
                <>
                  <textarea value={jdText} onChange={e => setJdText(e.target.value)}
                    placeholder={t("jdPlaceholder")}
                    style={{ width: "100%", minHeight: "240px", padding: "12px 14px", fontSize: "13px", color: B.navy, lineHeight: 1.6, border: `1px solid ${B.border}`, borderRadius: "10px", resize: "vertical", outline: "none", fontFamily: "Inter, sans-serif", backgroundColor: B.white }}
                    onFocus={e => e.target.style.borderColor = B.red}
                    onBlur={e => e.target.style.borderColor = B.border}
                  />
                  {jdBlocked && (
                    <div style={{ marginTop: "10px", padding: "12px 14px", backgroundColor: "#FEF2F2", border: "1px solid #FECACA", borderRadius: "8px" }}>
                      <p style={{ fontSize: "13px", fontWeight: 600, color: "#B91C1C", marginBottom: "3px" }}>{t("blockedTitle")}</p>
                      <p style={{ fontSize: "12px", color: "#DC2626", lineHeight: 1.5 }}>{t("blockedMessage")}</p>
                    </div>
                  )}
                </>
              ) : (
                <>
                  <input type="url" value={jdUrl} onChange={e => setJdUrl(e.target.value)}
                    placeholder={t("urlPlaceholder")}
                    style={{ width: "100%", padding: "11px 14px", fontSize: "13px", color: B.navy, border: `1px solid ${B.border}`, borderRadius: "10px", outline: "none", fontFamily: "Inter, sans-serif", backgroundColor: B.white, marginBottom: "8px" }}
                    onFocus={e => e.target.style.borderColor = B.red}
                    onBlur={e => e.target.style.borderColor = B.border}
                  />
                  {jdBlocked ? (
                    <div style={{ padding: "12px 14px", backgroundColor: "#FEF2F2", border: "1px solid #FECACA", borderRadius: "8px" }}>
                      <p style={{ fontSize: "13px", fontWeight: 600, color: "#B91C1C", marginBottom: "3px" }}>{t("blockedTitle")}</p>
                      <p style={{ fontSize: "12px", color: "#DC2626", lineHeight: 1.5 }}>{t("blockedMessage")}</p>
                    </div>
                  ) : (
                    <div style={{ padding: "10px 12px", backgroundColor: "#FFFBEB", borderRadius: "8px", border: "1px solid #FDE68A" }}>
                      <p style={{ fontSize: "11px", color: "#92400E" }}>{t("urlWarning")}</p>
                    </div>
                  )}
                </>
              )}
            </div>
          </div>

          {/* Error */}
          {error && (
            <div style={{ padding: "12px 16px", backgroundColor: "#FEF2F2", border: "1px solid #FECACA", borderRadius: "10px", marginBottom: "16px", fontSize: "13px", color: "#DC2626" }}>
              {error}
            </div>
          )}

          {/* CTA */}
          <button onClick={handleAnalyse}
            style={{ width: "100%", padding: "15px", backgroundColor: B.red, color: B.white, border: "none", borderRadius: "10px", cursor: "pointer", fontSize: "15px", fontWeight: 700, letterSpacing: "0.4px", textTransform: "uppercase", boxShadow: "0 2px 10px rgba(232,48,58,0.3)", transition: "background-color 0.15s" }}
            onMouseOver={e => (e.currentTarget.style.backgroundColor = B.redH)}
            onMouseOut={e => (e.currentTarget.style.backgroundColor = B.red)}
          >
            {t("analyseButton")}
          </button>

          <div style={{ marginTop: "12px", display: "flex", alignItems: "center", justifyContent: "center", gap: "6px" }}>
            <svg width="11" height="11" viewBox="0 0 12 12" fill="none"><rect x="2" y="5" width="8" height="6" rx="1" stroke="#9CA3AF" strokeWidth="1"/><path d="M4 5V4a2 2 0 014 0v1" stroke="#9CA3AF" strokeWidth="1"/></svg>
            <p style={{ fontSize: "11px", color: "#9CA3AF" }}>{t("gdpr")}</p>
          </div>
        </div>
      </div>

      {/* ── WHAT YOU'LL HAVE ── */}
      <div style={{ maxWidth: "1100px", margin: "0 auto", padding: "48px 24px" }}>
        <p style={{ fontSize: "11px", fontWeight: 700, color: "#9CA3AF", textTransform: "uppercase", letterSpacing: "1.5px", marginBottom: "20px" }}>After using this tool, you will</p>
        <div style={{ display: "grid", gridTemplateColumns: "repeat(5, 1fr)", gap: "14px", marginBottom: "40px" }}>
          {[
            { icon: "✅", text: "Know if it's a strong fit, partial fit, or mismatch" },
            { icon: "📍", text: "Understand the real gaps vs your expectations" },
            { icon: "🚫", text: "Identify deal-breakers early" },
            { icon: "💬", text: "Focus interviews on what actually matters" },
            { icon: "🚀", text: "Make faster go / no-go decisions" },
          ].map(item => (
            <div key={item.text} style={{ padding: "16px", backgroundColor: B.white, borderRadius: "10px", border: `1px solid ${B.border}`, boxShadow: "0 1px 3px rgba(0,0,0,0.04)" }}>
              <p style={{ fontSize: "20px", marginBottom: "8px" }}>{item.icon}</p>
              <p style={{ fontSize: "12px", color: B.navy, lineHeight: 1.55, fontWeight: 500 }}>{item.text}</p>
            </div>
          ))}
        </div>
        <p style={{ fontSize: "14px", color: B.gray, lineHeight: 1.7, maxWidth: "560px", fontStyle: "italic" }}>
          &ldquo;Stop guessing. Start screening with precision.&rdquo;
        </p>
      </div>
      {showLogin && <LoginModal onClose={() => setShowLogin(false)} />}
      {showNoCredits && <NoCreditsModal onClose={() => setShowNoCredits(false)} />}
    </div>
  );
}
