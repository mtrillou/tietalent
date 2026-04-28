"use client";

import { useRef, useState } from "react";
import { useTranslations } from "next-intl";
import type { FitReport as FitReportData } from "@/lib/fitAnalysis";

interface Props { data: FitReportData; locale?: string; }

const B = {
  red: "#E8303A", navy: "#1A1A2E", dark: "#111827",
  gray: "#6B7280", grayL: "#9CA3AF",
  border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF",
  green: "#059669", greenL: "#ECFDF5", greenB: "#A7F3D0",
  amber: "#D97706", amberL: "#FFFBEB", amberB: "#FDE68A",
  orange: "#EA580C", orangeL: "#FFF7ED", orangeB: "#FED7AA",
  blue: "#2563EB", blueL: "#EFF6FF", blueB: "#BFDBFE",
  violet: "#7C3AED", violetL: "#F5F3FF", violetB: "#DDD6FE",
};

const MATCH_CONFIG = {
  "Strong Fit":   { score: B.green,  badge: B.greenL,  badgeBorder: B.greenB,  badgeText: B.green,  bar: B.green  },
  "Good Fit":     { score: B.green,  badge: B.greenL,  badgeBorder: B.greenB,  badgeText: B.green,  bar: B.green  },
  "Partial Fit":  { score: B.amber,  badge: B.amberL,  badgeBorder: B.amberB,  badgeText: B.amber,  bar: B.amber  },
  "Weak Fit":     { score: B.orange, badge: B.orangeL, badgeBorder: B.orangeB, badgeText: B.orange, bar: B.orange },
  "Unclear":      { score: B.gray,   badge: B.surface, badgeBorder: B.border,  badgeText: B.gray,   bar: B.gray   },
};

const DECISION_CONFIG = {
  "Strong Yes":       { color: B.green,  bg: B.greenL,  border: B.greenB  },
  "Yes":              { color: B.green,  bg: B.greenL,  border: B.greenB  },
  "Yes with caution": { color: B.amber,  bg: B.amberL,  border: B.amberB  },
  "No":               { color: B.orange, bg: B.orangeL, border: B.orangeB },
};

function Card({ children }: { children: React.ReactNode }) {
  return (
    <div style={{ backgroundColor: B.white, borderRadius: "10px", border: `1px solid ${B.border}`, boxShadow: "0 1px 3px rgba(0,0,0,0.05)", overflow: "hidden" }}>
      {children}
    </div>
  );
}

function CardHead({ label, icon, accent }: { label: string; icon: React.ReactNode; accent?: string }) {
  return (
    <div style={{ display: "flex", alignItems: "center", gap: "10px", padding: "13px 20px", borderBottom: `1px solid ${B.border}`, backgroundColor: accent ? `${accent}10` : B.surface }}>
      {icon}
      <span style={{ fontWeight: 600, fontSize: "12px", color: B.navy, textTransform: "uppercase", letterSpacing: "0.4px" }}>{label}</span>
    </div>
  );
}

function Row({ text, dot }: { text: string; dot: string }) {
  return (
    <div style={{ display: "flex", alignItems: "flex-start", gap: "10px", padding: "10px 0", borderBottom: `1px solid ${B.border}` }} className="last:border-0">
      <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: dot, flexShrink: 0, marginTop: "7px" }} />
      <span style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{text}</span>
    </div>
  );
}

function QRow({ text, index }: { text: string; index: number }) {
  return (
    <div style={{ display: "flex", alignItems: "flex-start", gap: "12px", padding: "11px 0", borderBottom: `1px solid ${B.border}` }} className="last:border-0">
      <span style={{ width: "22px", height: "22px", borderRadius: "50%", backgroundColor: B.navy, color: B.white, fontSize: "11px", fontWeight: 600, display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>
        {index + 1}
      </span>
      <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6, paddingTop: "2px" }}>{text}</p>
    </div>
  );
}

export function FitReport({ data }: Props) {
  const t = useTranslations("fit.report");
  const ref = useRef<HTMLDivElement>(null);
  const [exporting, setExporting] = useState(false);

  const level = data.fit_summary.match_level;
  const mc = MATCH_CONFIG[level] || MATCH_CONFIG["Unclear"];
  const score = data.fit_summary.overall_match_score;
  const decision = data.final_recommendation.decision;
  const dc = DECISION_CONFIG[decision] || DECISION_CONFIG["Yes with caution"];

  const handlePDF = async () => {
    if (!ref.current) return;
    setExporting(true);
    try {
      const h2c = (await import("html2canvas")).default;
      const jsPDF = (await import("jspdf")).default;
      const canvas = await h2c(ref.current, { scale: 2, useCORS: true, logging: false, backgroundColor: B.surface });
      const img = canvas.toDataURL("image/png");
      const pdf = new jsPDF({ orientation: "portrait", unit: "mm", format: "a4" });
      const pw = pdf.internal.pageSize.getWidth();
      const ph = pdf.internal.pageSize.getHeight();
      const ih = (canvas.height * pw) / canvas.width;
      let left = ih; let pos = 0;
      pdf.addImage(img, "PNG", 0, pos, pw, ih); left -= ph;
      while (left > 0) { pos = left - ih; pdf.addPage(); pdf.addImage(img, "PNG", 0, pos, pw, ih); left -= ph; }
      pdf.save("tietalent_fit_report.pdf");
    } catch (e) { console.error(e); }
    finally { setExporting(false); }
  };

  return (
    <div style={{ maxWidth: "860px", margin: "0 auto" }}>

      {/* Toolbar */}
      <div className="no-print" style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: "20px" }}>
        <div style={{ display: "flex", alignItems: "center", gap: "8px" }}>
          <span style={{ width: "8px", height: "8px", borderRadius: "50%", backgroundColor: B.green }} />
          <span style={{ fontSize: "13px", color: B.gray }}>{t("ready")}</span>
        </div>
        <button onClick={handlePDF} disabled={exporting} style={{
          display: "flex", alignItems: "center", gap: "6px", padding: "8px 16px", borderRadius: "7px",
          backgroundColor: B.navy, color: B.white, border: "none", fontSize: "13px", fontWeight: 600,
          cursor: "pointer", opacity: exporting ? 0.6 : 1, textTransform: "uppercase", letterSpacing: "0.3px",
        }}>
          {exporting ? <span style={{ width: "14px", height: "14px", border: "2px solid rgba(255,255,255,0.3)", borderTopColor: "#fff", borderRadius: "50%", animation: "spin 0.8s linear infinite" }} />
            : <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>}
          {exporting ? "Exporting…" : "Download PDF"}
        </button>
      </div>

      <div ref={ref} style={{ display: "flex", flexDirection: "column", gap: "12px" }}>

        {/* ── HERO — MATCH SCORE ── */}
        <Card>
          <div style={{ padding: "28px", background: `linear-gradient(135deg, ${B.navy} 0%, #2D2D4E 100%)` }}>
            <p style={{ fontSize: "10px", fontWeight: 700, color: B.red, textTransform: "uppercase", letterSpacing: "1.5px", marginBottom: "20px" }}>
              Candidate ↔ Role Fit Analysis
            </p>
            <div style={{ display: "flex", alignItems: "center", gap: "32px" }}>

              {/* Score ring */}
              <div style={{ position: "relative", flexShrink: 0 }}>
                <svg width="110" height="110" viewBox="0 0 110 110">
                  <circle cx="55" cy="55" r="46" fill="none" stroke="rgba(255,255,255,0.1)" strokeWidth="8"/>
                  <circle cx="55" cy="55" r="46" fill="none" stroke={mc.bar} strokeWidth="8"
                    strokeDasharray={`${2 * Math.PI * 46}`}
                    strokeDashoffset={`${2 * Math.PI * 46 * (1 - score / 100)}`}
                    strokeLinecap="round"
                    style={{ transformOrigin: "55px 55px", transform: "rotate(-90deg)" }}
                  />
                  <text x="55" y="55" textAnchor="middle" fill="white" fontSize="28" fontWeight="700" fontFamily="Inter">{score}</text>
                  <text x="55" y="68" textAnchor="middle" fill="rgba(255,255,255,0.5)" fontSize="10" fontFamily="Inter">/100</text>
                </svg>
              </div>

              <div style={{ flex: 1 }}>
                <div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "10px" }}>
                  <span style={{ fontSize: "22px", fontWeight: 700, color: B.white }}>{level}</span>
                  <span style={{ fontSize: "11px", fontWeight: 700, color: mc.badgeText, backgroundColor: mc.badge, border: `1px solid ${mc.badgeBorder}`, padding: "3px 10px", borderRadius: "20px", textTransform: "uppercase", letterSpacing: "0.5px" }}>
                    {score >= 70 ? t("recommend") : score >= 50 ? t("review") : t("caution")}
                  </span>
                </div>
                <p style={{ fontSize: "11px", color: "#475569", marginBottom: "10px", fontStyle: "italic" }}>
                  Based on experience, seniority, and external signals — not keywords
                </p>
                <p style={{ fontSize: "14px", color: "#CBD5E1", lineHeight: 1.65, maxWidth: "480px" }}>
                  {data.fit_summary.short_explanation}
                </p>
              </div>

              {/* Decision */}
              <div style={{ flexShrink: 0, padding: "16px 20px", borderRadius: "12px", backgroundColor: dc.bg, border: `1px solid ${dc.border}`, textAlign: "center" }}>
                <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.8px", marginBottom: "6px" }}>{t("decision")}</p>
                <p style={{ fontSize: "15px", fontWeight: 700, color: dc.color }}>{decision}</p>
              </div>
            </div>
          </div>

          {/* Reasoning */}
          <div style={{ padding: "16px 24px", borderTop: `1px solid ${B.border}` }}>
            <p style={{ fontSize: "13px", color: B.gray, lineHeight: 1.7 }}>{data.final_recommendation.reasoning}</p>
          </div>
        </Card>

        {/* ── ALIGNMENT ANALYSIS ── */}
        <Card>
          <CardHead label="Alignment analysis" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><path d="M2 7h10M7 2v10" stroke={B.blue} strokeWidth="1.2" strokeLinecap="round"/></svg>} accent={B.blue} />
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr 1fr", gap: "0" }}>
            {[
              { label: "Strong matches", items: data.alignment_analysis.strong_matches, dot: B.green, bg: B.greenL },
              { label: "Partial matches", items: data.alignment_analysis.partial_matches, dot: B.amber, bg: B.amberL },
              { label: "Mismatches", items: data.alignment_analysis.mismatches, dot: B.orange, bg: B.orangeL },
            ].map((col, i) => (
              <div key={col.label} style={{ padding: "16px", borderRight: i < 2 ? `1px solid ${B.border}` : "none" }}>
                <div style={{ display: "flex", alignItems: "center", gap: "6px", marginBottom: "12px" }}>
                  <span style={{ width: "8px", height: "8px", borderRadius: "50%", backgroundColor: col.dot }} />
                  <p style={{ fontSize: "11px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px" }}>{col.label}</p>
                </div>
                {col.items.map((item, j) => (
                  <div key={j} style={{ fontSize: "12px", color: B.dark, lineHeight: 1.55, padding: "7px 10px", borderRadius: "6px", backgroundColor: col.bg, marginBottom: "6px" }}>
                    {item}
                  </div>
                ))}
              </div>
            ))}
          </div>
        </Card>

        {/* ── SENIORITY FIT ── */}
        <Card>
          <CardHead label="Seniority fit" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><path d="M7 1L1 5v8h4V9h4v4h4V5L7 1z" stroke={B.violet} strokeWidth="1.2" strokeLinejoin="round"/></svg>} accent={B.violet} />
          <div style={{ padding: "20px" }}>
            <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "12px", marginBottom: "14px" }}>
              {[
                { label: "Candidate level", value: data.seniority_fit.candidate_level },
                { label: "Role requires",   value: data.seniority_fit.role_level },
              ].map(row => (
                <div key={row.label} style={{ padding: "12px 14px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}` }}>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "4px" }}>{row.label}</p>
                  <p style={{ fontSize: "14px", fontWeight: 600, color: B.navy }}>{row.value}</p>
                </div>
              ))}
            </div>
            <div style={{ padding: "14px", backgroundColor: B.violetL, borderRadius: "8px", border: `1px solid ${B.violetB}` }}>
              <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.65 }}>{data.seniority_fit.gap_analysis}</p>
            </div>
          </div>
        </Card>

        {/* ── EXPERIENCE RELEVANCE ── */}
        <Card>
          <CardHead label="Experience relevance" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><circle cx="7" cy="7" r="5.5" stroke={B.green} strokeWidth="1.2"/><path d="M4.5 7l2 2 3-3" stroke={B.green} strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/></svg>} accent={B.green} />
          <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr 1fr" }}>
            {[
              { label: "Relevant experience",          items: data.experience_relevance.relevant_experience,         dot: B.green  },
              { label: "Missing critical experience",  items: data.experience_relevance.missing_critical_experience, dot: B.orange },
              { label: "Transferable skills",          items: data.experience_relevance.transferable_skills,         dot: B.amber  },
            ].map((col, i) => (
              <div key={col.label} style={{ padding: "16px", borderRight: i < 2 ? `1px solid ${B.border}` : "none" }}>
                <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "10px" }}>{col.label}</p>
                {col.items.map((item, j) => (
                  <div key={j} style={{ display: "flex", alignItems: "flex-start", gap: "8px", marginBottom: "8px" }}>
                    <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: col.dot, flexShrink: 0, marginTop: "7px" }} />
                    <span style={{ fontSize: "12px", color: B.dark, lineHeight: 1.55 }}>{item}</span>
                  </div>
                ))}
              </div>
            ))}
          </div>
        </Card>

        {/* ── RISKS + HIDDEN STRENGTHS (2-col) ── */}
        <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "12px" }}>
          <Card>
            <CardHead label="Risk flags" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><path d="M7 1.5L1 12h12L7 1.5zm0 4v3m0 2v.5" stroke={B.orange} strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/></svg>} accent={B.orange} />
            <div style={{ padding: "4px 16px 8px" }}>
              {data.risk_flags.map((r, i) => <Row key={i} text={r} dot={B.orange} />)}
            </div>
          </Card>
          <Card>
            <CardHead label="Hidden strengths for this role" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><path d="M7 1l1.5 3 3 .5-2.2 2.2.5 3-2.8-1.5-2.8 1.5.5-3L2.5 4.5l3-.5L7 1z" stroke={B.green} strokeWidth="1.2" strokeLinejoin="round"/></svg>} accent={B.green} />
            <div style={{ padding: "4px 16px 8px" }}>
              {data.hidden_strengths_for_role.map((s, i) => <Row key={i} text={s} dot={B.green} />)}
            </div>
          </Card>
        </div>

        {/* ── UNKNOWNS ── */}
        <Card>
          <CardHead label="Unknowns & validation points" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><circle cx="7" cy="7" r="5.5" stroke={B.amber} strokeWidth="1.2"/><path d="M7 8.5V8c.9 0 1.7-.8 1.7-1.7S7.9 4.6 7 4.6s-1.7.8-1.7 1.7M7 10v.5" stroke={B.amber} strokeWidth="1.2" strokeLinecap="round"/></svg>} accent={B.amber} />
          <div style={{ padding: "4px 16px 8px" }}>
            {data.unknowns_and_validation_points.map((u, i) => <Row key={i} text={u} dot={B.amber} />)}
          </div>
        </Card>

        {/* ── EXTERNAL VALIDATION ── */}
        {(data.external_validation.verified_insights.length > 0 || data.external_validation.no_data_flags.length > 0) && (
          <Card>
            <CardHead label="External validation" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><circle cx="7" cy="7" r="5.5" stroke={B.blue} strokeWidth="1.2"/><path d="M4.5 7h5m-2-2l2 2-2 2" stroke={B.blue} strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/></svg>} accent={B.blue} />
            <div style={{ padding: "16px 20px", display: "flex", flexDirection: "column", gap: "12px" }}>
              {data.external_validation.verified_insights.length > 0 && (
                <div>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>{t("sections.verified")}</p>
                  {data.external_validation.verified_insights.map((v, i) => (
                    <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "8px", marginBottom: "6px" }}>
                      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style={{ flexShrink: 0, marginTop: "2px" }}>
                        <circle cx="7" cy="7" r="6" fill={B.greenL} stroke={B.greenB}/>
                        <path d="M4 7l2 2 4-4" stroke={B.green} strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/>
                      </svg>
                      <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{v}</p>
                    </div>
                  ))}
                </div>
              )}
              {data.external_validation.no_data_flags.length > 0 && (
                <div>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>{t("sections.couldNotVerify")}</p>
                  {data.external_validation.no_data_flags.map((f, i) => (
                    <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "8px", marginBottom: "6px" }}>
                      <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: B.gray, flexShrink: 0, marginTop: "7px" }} />
                      <p style={{ fontSize: "13px", color: B.gray, lineHeight: 1.6 }}>{f}</p>
                    </div>
                  ))}
                </div>
              )}
              {data.external_validation.impact_on_fit && (
                <div style={{ padding: "11px 14px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}` }}>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "4px" }}>{t("sections.impactOnFit")}</p>
                  <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{data.external_validation.impact_on_fit}</p>
                </div>
              )}
            </div>
          </Card>
        )}

        {/* ── INTERVIEW FOCUS ── */}
        <Card>
          <CardHead label="Interview questions for this role" icon={<svg width="14" height="14" fill="none" viewBox="0 0 14 14"><path d="M2.5 4h9M2.5 7h6M2.5 10h4" stroke={B.navy} strokeWidth="1.2" strokeLinecap="round"/></svg>} />
          <div style={{ padding: "4px 16px 8px" }}>
            {data.interview_focus_for_this_role.map((q, i) => <QRow key={i} text={q} index={i} />)}
          </div>
        </Card>

        {/* GDPR */}
        <div style={{ display: "flex", alignItems: "flex-start", gap: "8px", padding: "12px 4px", fontSize: "11px", color: B.grayL }}>
          <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: B.green, flexShrink: 0, marginTop: "3px" }} />
          No data stored. Processed in-memory only. GDPR compliant.
        </div>

      </div>
    </div>
  );
}
