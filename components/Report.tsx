"use client";

import { useRef, useState } from "react";
import { useTranslations } from "next-intl";
import type { ReportData, VerifiedSignal, WeakSignal, UnverifiedClaim, HighImpactFinding, IdentityRisk } from "@/lib/claude";

// TieTalent brand colors
const B = {
  red: "#E8303A", navy: "#1A1A2E", dark: "#1A1A1A",
  gray: "#6B7280", grayL: "#9CA3AF",
  border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF",
  green: "#059669", greenL: "#ECFDF5", greenB: "#A7F3D0",
  amber: "#D97706", amberL: "#FFFBEB", amberB: "#FDE68A",
  orange: "#EA580C", orangeL: "#FFF7ED", orangeB: "#FED7AA",
  purple: "#7C3AED", purpleL: "#F5F3FF", purpleB: "#DDD6FE",
  blue: "#2563EB", blueL: "#EFF6FF", blueB: "#BFDBFE",
  teal: "#0891B2", tealL: "#ECFEFF", tealB: "#A5F3FC",
};

const DECISION_CFG: Record<string, { color: string; bg: string; border: string; dot: string }> = {
  "Strong Proceed": { color: "#059669", bg: "#ECFDF5", border: "#A7F3D0", dot: "#059669" },
  "Proceed":        { color: "#059669", bg: "#ECFDF5", border: "#A7F3D0", dot: "#059669" },
  "Proceed with Validation": { color: "#D97706", bg: "#FFFBEB", border: "#FDE68A", dot: "#D97706" },
  "Neutral":        { color: "#1A1A2E", bg: "#EFF6FF", border: "#BFDBFE", dot: "#1A1A2E" },
  "Caution":        { color: "#EA580C", bg: "#FFF7ED", border: "#FED7AA", dot: "#EA580C" },
  "High Risk":      { color: "#DC2626", bg: "#FEF2F2", border: "#FECACA", dot: "#DC2626" },
};

const CONF: Record<string, { color: string; bg: string; border: string }> = {
  High:   { color: B.green,  bg: B.greenL,  border: B.greenB  },
  Medium: { color: B.amber,  bg: B.amberL,  border: B.amberB  },
  Low:    { color: B.orange, bg: B.orangeL, border: B.orangeB },
};

const ALERT: Record<string, { color: string; bg: string; border: string }> = {
  Green:  { color: "#059669", bg: "#ECFDF5", border: "#A7F3D0" },
  Yellow: { color: "#D97706", bg: "#FFFBEB", border: "#FDE68A" },
  Orange: { color: "#EA580C", bg: "#FFF7ED", border: "#FED7AA" },
  Red:    { color: "#E8303A", bg: "#FEF2F2", border: "#FECACA" },
};


const HIF_CFG: Record<string, { color: string; bg: string; border: string; icon: string }> = {
  "Legal":       { color: "#DC2626", bg: "#FEF2F2", border: "#FECACA", icon: "⚖" },
  "Reputation":  { color: "#EA580C", bg: "#FFF7ED", border: "#FED7AA", icon: "⚠" },
  "Credibility": { color: "#D97706", bg: "#FFFBEB", border: "#FDE68A", icon: "◉" },
  "Career":      { color: "#2563EB", bg: "#EFF6FF", border: "#BFDBFE", icon: "→" },
  "Positive":    { color: "#059669", bg: "#ECFDF5", border: "#A7F3D0", icon: "✓" },
};

function HIF({ f }: { f: HighImpactFinding }) {
  const cfg = HIF_CFG[f.type] || HIF_CFG["Career"];
  const confColor = f.confidence === "High" ? "#059669" : f.confidence === "Medium" ? "#D97706" : "#EA580C";
  return (
    <div style={{ padding: "12px 14px", borderRadius: "8px", marginBottom: "8px", backgroundColor: cfg.bg, border: `1px solid ${cfg.border}` }}>
      <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", gap: "10px", marginBottom: "5px" }}>
        <div style={{ display: "flex", alignItems: "center", gap: "7px" }}>
          <span style={{ fontSize: "13px", flexShrink: 0 }}>{cfg.icon}</span>
          <span style={{ fontSize: "10px", fontWeight: 700, color: cfg.color, textTransform: "uppercase" as const, letterSpacing: "0.5px" }}>{f.type}</span>
        </div>
        <span style={{ fontSize: "10px", fontWeight: 600, color: confColor, backgroundColor: "rgba(255,255,255,0.8)", padding: "1px 7px", borderRadius: "20px", whiteSpace: "nowrap" as const }}>{f.confidence} confidence</span>
      </div>
      <p style={{ fontSize: "13px", color: "#111827", lineHeight: 1.65, paddingLeft: "20px" }}>{f.summary}</p>
    </div>
  );
}

function Card({ children, style }: { children: React.ReactNode; style?: React.CSSProperties }) {
  return (
    <div style={{ backgroundColor: B.white, borderRadius: "12px", border: `1px solid ${B.border}`, boxShadow: "0 1px 4px rgba(0,0,0,0.04)", overflow: "hidden", ...style }}>
      {children}
    </div>
  );
}

function SHead({ label, sub, accent }: { label: string; sub?: string; accent?: string }) {
  return (
    <div style={{ padding: "13px 20px", borderBottom: `1px solid ${B.border}`, backgroundColor: accent ? `${accent}08` : B.surface }}>
      <p style={{ fontWeight: 700, fontSize: "11px", color: B.navy, textTransform: "uppercase", letterSpacing: "0.6px" }}>{label}</p>
      {sub && <p style={{ fontSize: "11px", color: B.grayL, marginTop: "2px" }}>{sub}</p>}
    </div>
  );
}

function RBadge({ level }: { level: string }) {
  const col = level === "High" ? { c: B.green, bg: B.greenL } : level === "Medium" ? { c: B.amber, bg: B.amberL } : { c: B.orange, bg: B.orangeL };
  return <span style={{ fontSize: "10px", fontWeight: 700, color: col.c, backgroundColor: col.bg, padding: "2px 7px", borderRadius: "20px", textTransform: "uppercase" as const, letterSpacing: "0.4px", whiteSpace: "nowrap" as const }}>{level}</span>;
}

function VI({ s }: { s: VerifiedSignal }) {
  return (
    <div style={{ padding: "10px 12px", borderRadius: "8px", marginBottom: "7px", backgroundColor: B.greenL, border: `1px solid ${B.greenB}` }}>
      <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", gap: "8px", marginBottom: "4px" }}>
        <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6, flex: 1 }}>{s.statement}</p>
        <RBadge level={s.reliability} />
      </div>
      <div style={{ display: "flex", gap: "6px", marginTop: "4px" }}>
        <span style={{ fontSize: "10px", color: B.grayL, backgroundColor: B.white, border: `1px solid ${B.border}`, padding: "1px 6px", borderRadius: "4px" }}>{s.source_type}</span>
        {s.source_reference && <span style={{ fontSize: "10px", color: B.grayL, overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap" as const, maxWidth: "200px" }}>{s.source_reference}</span>}
      </div>
    </div>
  );
}

function WI({ s }: { s: WeakSignal }) {
  return (
    <div style={{ padding: "10px 12px", borderRadius: "8px", marginBottom: "7px", backgroundColor: B.amberL, border: `1px solid ${B.amberB}` }}>
      <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", gap: "8px", marginBottom: "4px" }}>
        <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6, flex: 1 }}>{s.statement}</p>
        <RBadge level="Low" />
      </div>
      <span style={{ fontSize: "10px", color: B.grayL, backgroundColor: B.white, border: `1px solid ${B.border}`, padding: "1px 6px", borderRadius: "4px" }}>{s.source_type}</span>
    </div>
  );
}

function UI({ c }: { c: UnverifiedClaim }) {
  return (
    <div style={{ padding: "10px 12px", borderRadius: "8px", marginBottom: "7px", backgroundColor: B.orangeL, border: `1px solid ${B.orangeB}` }}>
      <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6, marginBottom: "5px" }}>{c.statement}</p>
      <p style={{ fontSize: "11px", color: B.orange, fontStyle: "italic" }}>{c.caveat}</p>
    </div>
  );
}

export function Report({ data }: { data: ReportData }) {
  const t = useTranslations("report");
  const ref = useRef<HTMLDivElement>(null);
  const [exporting, setExporting] = useState(false);

  const decision = DECISION_CFG[data.recruiter_signal?.decision] || DECISION_CFG["Neutral"];
  const confCfg  = CONF[data.recruiter_signal?.confidence] || CONF.Medium;
  const idConf   = CONF[data.identity_confidence] || CONF.Medium;
  const dataConf = CONF[data.confidence_in_external_data] || CONF.Low;
  const alertCfg = ALERT[data.alert_level] || ALERT.Yellow;
  const riskColor = { Low: B.green, Medium: B.amber, High: B.red }[data.hiring_impact?.risk_level] || B.gray;
  const initials = data.candidate_name ? data.candidate_name.split(" ").map((n: string) => n[0]).join("").slice(0, 2).toUpperCase() : "?";

  const hasV = (data.signals?.verified_signals?.length ?? 0) > 0;
  const hasW = (data.signals?.weak_signals?.length ?? 0) > 0;
  const hasU = (data.signals?.unverified_claims?.length ?? 0) > 0;
  const noData = data.signals?.no_significant_external_data;

  const handlePDF = async () => {
    if (!ref.current) return;
    setExporting(true);
    try {
      const h2c = (await import("html2canvas")).default;
      const jsPDF = (await import("jspdf")).default;
      const canvas = await h2c(ref.current, { scale: 2, useCORS: true, logging: false, backgroundColor: B.surface });
      const img = canvas.toDataURL("image/png");
      const pdf = new jsPDF({ orientation: "portrait", unit: "mm", format: "a4" });
      const pw = pdf.internal.pageSize.getWidth(), ph = pdf.internal.pageSize.getHeight();
      const ih = (canvas.height * pw) / canvas.width;
      let left = ih, pos = 0;
      pdf.addImage(img, "PNG", 0, pos, pw, ih); left -= ph;
      while (left > 0) { pos = left - ih; pdf.addPage(); pdf.addImage(img, "PNG", 0, pos, pw, ih); left -= ph; }
      pdf.save("tietalent_intelligence.pdf");
    } catch (e) { console.error(e); } finally { setExporting(false); }
  };

  return (
    <div style={{ maxWidth: "820px", margin: "0 auto" }}>
      <style>{`@keyframes spin{to{transform:rotate(360deg)}}`}</style>

      {/* Toolbar */}
      <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", marginBottom: "20px" }}>
        <div style={{ display: "flex", alignItems: "center", gap: "8px" }}>
          <span style={{ width: "8px", height: "8px", borderRadius: "50%", backgroundColor: B.green, display: "inline-block" }} />
          <span style={{ fontSize: "13px", color: B.gray }}>{t("ready")}</span>
        </div>
        <button onClick={handlePDF} disabled={exporting} style={{ display: "flex", alignItems: "center", gap: "6px", padding: "8px 16px", borderRadius: "7px", backgroundColor: B.red, color: B.white, border: "none", fontSize: "13px", fontWeight: 700, letterSpacing: "0.5px", textTransform: "uppercase", cursor: "pointer", opacity: exporting ? 0.6 : 1 }}>
          {exporting && <span style={{ width: "13px", height: "13px", border: "2px solid rgba(255,255,255,0.3)", borderTopColor: "#fff", borderRadius: "50%", animation: "spin 0.8s linear infinite", display: "inline-block" }} />}
          {exporting ? t("exporting") : t("downloadPdf")}
        </button>
      </div>

      <div ref={ref} style={{ display: "flex", flexDirection: "column", gap: "12px" }}>

        {/* ── HEADER: Name + Alert ── */}
        <Card>
          <div style={{ padding: "20px 24px 18px", background: `linear-gradient(135deg, ${B.navy} 0%, #2D2D4E 100%)` }}>
            <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", gap: "16px" }}>
              <div style={{ display: "flex", alignItems: "center", gap: "12px" }}>
                <div style={{ width: "42px", height: "42px", borderRadius: "50%", backgroundColor: "rgba(232,48,58,0.2)", border: "1px solid rgba(232,48,58,0.4)", display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>
                  <span style={{ fontSize: "15px", fontWeight: 700, color: B.red }}>{initials}</span>
                </div>
                <div>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.red, textTransform: "uppercase", letterSpacing: "1px", marginBottom: "3px" }}>Candidate Intelligence</p>
                  <h1 style={{ fontWeight: 700, fontSize: "20px", color: B.white, letterSpacing: "-0.3px", margin: 0 }}>{data.candidate_name}</h1>
                </div>
              </div>
              <div style={{ padding: "6px 12px", borderRadius: "4px", backgroundColor: alertCfg.bg, border: `1px solid ${alertCfg.border}`, textAlign: "center", flexShrink: 0 }}>
                <p style={{ fontSize: "9px", fontWeight: 700, color: alertCfg.color, textTransform: "uppercase", letterSpacing: "0.8px", marginBottom: "3px" }}>Alert</p>
                <p style={{ fontSize: "13px", fontWeight: 700, color: alertCfg.color }}>{data.alert_level}</p>
              </div>
            </div>
          </div>
        </Card>

        {/* ── 0. HIRING RECOMMENDATION — first thing user sees ── */}
        {(() => {
          const rec = data.hiring_recommendation || (data.hiring_verdict ? {
            decision: data.hiring_verdict.decision === "Strong yes" ? "Strong GO" : data.hiring_verdict.decision === "High risk" ? "No-go" : "GO with validation",
            confidence: "Medium" as const,
            reason: data.hiring_verdict.reason,
            why: [],
          } : null);
          if (!rec) return null;
          const goColors: Record<string, { bg: string; border: string; color: string; icon: string }> = {
            "Strong GO":        { bg: "#ECFDF5", border: "#A7F3D0", color: "#059669", icon: "✓" },
            "GO":               { bg: "#ECFDF5", border: "#A7F3D0", color: "#059669", icon: "✓" },
            "GO with validation":{ bg: "#FFFBEB", border: "#FDE68A", color: "#D97706", icon: "⚠" },
            "Caution":          { bg: "#FFF7ED", border: "#FED7AA", color: "#EA580C", icon: "⚠" },
            "No-go":            { bg: "#FEF2F2", border: "#FECACA", color: "#DC2626", icon: "✗" },
          };
          const cfg = goColors[rec.decision] || goColors["GO with validation"];
          return (
            <Card style={{ border: `2px solid ${cfg.border}`, backgroundColor: cfg.bg }}>
              <div style={{ padding: "18px 20px" }}>
                <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", gap: "12px", marginBottom: "8px" }}>
                  <p style={{ fontSize: "9px", fontWeight: 700, color: B.gray, textTransform: "uppercase", letterSpacing: "0.8px" }}>Hiring Recommendation</p>
                  <span style={{ fontSize: "10px", fontWeight: 600, color: cfg.color, backgroundColor: "rgba(255,255,255,0.7)", padding: "2px 8px", borderRadius: "20px" }}>{rec.confidence} confidence</span>
                </div>
                <p style={{ fontSize: "26px", fontWeight: 800, letterSpacing: "-0.5px", marginBottom: "8px", color: cfg.color }}>
                  {cfg.icon} {rec.decision}
                </p>
                <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.65, marginBottom: rec.why?.length ? "14px" : 0 }}>{rec.reason}</p>
                {(rec.why?.length ?? 0) > 0 && (
                  <div style={{ borderTop: `1px solid ${cfg.border}`, paddingTop: "12px" }}>
                    <p style={{ fontSize: "9px", fontWeight: 700, color: cfg.color, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>Why this decision</p>
                    {rec.why.map((w: string, i: number) => (
                      <div key={i} style={{ display: "flex", gap: "8px", marginBottom: "6px" }}>
                        <span style={{ color: cfg.color, fontWeight: 700, fontSize: "12px", flexShrink: 0 }}>→</span>
                        <p style={{ fontSize: "12px", color: B.dark, lineHeight: 1.55 }}>{w}</p>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            </Card>
          );
        })()}

        {/* ── SURPRISING INSIGHT ── */}
        {data.surprising_insight && data.surprising_insight !== "No surprising signals found beyond what the CV states." && (
          <Card style={{ border: `1px solid #C7D2FE`, backgroundColor: "#EEF2FF" }}>
            <div style={{ padding: "14px 20px", display: "flex", gap: "12px", alignItems: "flex-start" }}>
              <span style={{ fontSize: "18px", flexShrink: 0 }}>💡</span>
              <div>
                <p style={{ fontSize: "9px", fontWeight: 700, color: "#4338CA", textTransform: "uppercase", letterSpacing: "0.8px", marginBottom: "5px" }}>Surprising insight</p>
                <p style={{ fontSize: "13px", color: "#1E1B4B", lineHeight: 1.65, fontStyle: "italic" }}>{data.surprising_insight}</p>
              </div>
            </div>
          </Card>
        )}

        {/* ── IDENTITY CONFIDENCE ── */}
        {(data.identity_status || data.identity_risk) && (
          <div style={{ padding: "10px 14px", borderRadius: "8px", backgroundColor: "#F9FAFB", border: "1px solid #E5E7EB", display: "flex", alignItems: "flex-start", gap: "10px" }}>
            <span style={{ fontSize: "13px", flexShrink: 0 }}>🔍</span>
            <div>
              <p style={{ fontSize: "10px", fontWeight: 700, color: B.gray, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "3px" }}>
                Identity confidence — how certain we are that the data matches this person
              </p>
              <p style={{ fontSize: "12px", color: B.dark, lineHeight: 1.55 }}>
                <strong>{data.identity_status || data.identity_confidence}</strong>
                {data.identity_confidence_reason ? ` — ${data.identity_confidence_reason}` : ""}
              </p>
            </div>
          </div>
        )}

        {/* ── STRENGTHS ── */}
        {(data.strengths?.length ?? 0) > 0 && (
          <Card>
            <SHead label="Strengths" sub="Evidence-based positive signals" accent="#059669" />
            <div style={{ padding: "14px 20px" }}>
              {data.strengths.map((s: string, i: number) => (
                <div key={i} style={{ display: "flex", gap: "10px", padding: "8px 12px", borderRadius: "7px", marginBottom: "7px", backgroundColor: "#ECFDF5", border: "1px solid #A7F3D0" }}>
                  <span style={{ color: "#059669", fontWeight: 700, flexShrink: 0 }}>✓</span>
                  <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{s}</p>
                </div>
              ))}
            </div>
          </Card>
        )}

        {/* ── 1. RECRUITER SIGNAL — primary output ── */}
        <Card style={{ border: `2px solid ${decision.border}` }}>
          <div style={{ padding: "18px 22px", backgroundColor: decision.bg }}>
            <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", gap: "16px", marginBottom: "12px" }}>
              <div>
                <p style={{ fontSize: "10px", fontWeight: 700, color: decision.color, textTransform: "uppercase", letterSpacing: "0.8px", marginBottom: "6px" }}>Recruiter Signal</p>
                <p style={{ fontSize: "22px", fontWeight: 800, color: decision.color, letterSpacing: "-0.4px", lineHeight: 1 }}>{data.recruiter_signal?.decision}</p>
              </div>
              <div style={{ padding: "7px 13px", borderRadius: "8px", backgroundColor: confCfg.bg, border: `1px solid ${confCfg.border}`, textAlign: "center", flexShrink: 0 }}>
                <p style={{ fontSize: "9px", fontWeight: 700, color: confCfg.color, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "2px" }}>Confidence</p>
                <p style={{ fontSize: "12px", fontWeight: 700, color: confCfg.color }}>{data.recruiter_signal?.confidence}</p>
              </div>
            </div>
            <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.65, fontStyle: "italic" }}>{data.recruiter_signal?.reasoning}</p>
          </div>
        </Card>



        {/* ── IDENTITY RISK BANNER (only when Medium or High) ── */}
        {data.identity_risk && data.identity_risk.level !== "Low" && (
          <div style={{
            padding: "10px 16px",
            backgroundColor: data.identity_risk.level === "High" ? "#FFF7ED" : "#FFFBEB",
            border: `1px solid ${data.identity_risk.level === "High" ? "#FED7AA" : "#FDE68A"}`,
            borderRadius: "8px",
            display: "flex", alignItems: "flex-start", gap: "10px",
          }}>
            <span style={{ fontSize: "14px", flexShrink: 0 }}>⚠</span>
            <div>
              <p style={{ fontSize: "11px", fontWeight: 700, color: data.identity_risk.level === "High" ? "#EA580C" : "#D97706", textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "3px" }}>
                Identity Risk: {data.identity_risk.level}
              </p>
              <p style={{ fontSize: "12px", color: "#374151", lineHeight: 1.6 }}>{data.identity_risk.reason}</p>
            </div>
          </div>
        )}
        {/* ── HIGH IMPACT FINDINGS ── */}
        {(data.high_impact_findings?.length ?? 0) > 0 && (
          <Card style={{ border: `1px solid ${
            data.high_impact_findings.some(f => f.type === "Legal" || f.type === "Reputation")
              ? "#FECACA"
              : B.border
          }` }}>
            <SHead
              label="High-Impact Findings"
              sub="Signals that could change this hiring decision"
              accent={data.high_impact_findings.some(f => f.type === "Legal" || f.type === "Reputation") ? "#DC2626" : "#D97706"}
            />
            <div style={{ padding: "14px 20px" }}>
              {[...data.high_impact_findings].sort((a, b) => {
                const order = { High: 0, Medium: 1, Low: 2 };
                return (order[a.confidence] ?? 1) - (order[b.confidence] ?? 1);
              }).map((f, i) => <HIF key={i} f={f} />)}
            </div>
          </Card>
        )}
        {/* ── 2. TOP 3 DECISION DRIVERS ── */}
        {data.top_decision_drivers?.length > 0 && (
          <Card>
            <SHead label="Top 3 Decision Drivers" sub="The highest-impact facts about this candidate" accent={B.navy} />
            <div style={{ padding: "14px 20px", display: "flex", flexDirection: "column", gap: "8px" }}>
              {data.top_decision_drivers.map((d, i) => (
                <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "10px", padding: "10px 14px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}` }}>
                  <span style={{ fontSize: "14px", fontWeight: 800, color: B.navy, flexShrink: 0, lineHeight: 1.4 }}>{i + 1}</span>
                  <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{d}</p>
                </div>
              ))}
            </div>
          </Card>
        )}

        {/* ── 3. RECOMMENDED NEXT STEP ── */}
        {data.recommended_next_step && (
          <Card>
            <SHead label="Recommended Next Step" accent={B.green} />
            <div style={{ padding: "16px 20px" }}>
              <div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "12px" }}>
                <span style={{ fontSize: "13px", fontWeight: 700, color: B.green, backgroundColor: B.greenL, border: `1px solid ${B.greenB}`, padding: "5px 14px", borderRadius: "20px" }}>
                  {data.recommended_next_step.action}
                </span>
              </div>
              <p style={{ fontSize: "12px", color: B.gray, lineHeight: 1.6, marginBottom: "12px", fontStyle: "italic" }}>{data.recommended_next_step.reasoning}</p>
              {(data.recommended_next_step.focus_areas || []).length > 0 && (
                <div>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.grayL, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "7px" }}>Focus areas</p>
                  <div style={{ display: "flex", flexDirection: "column", gap: "6px" }}>
                    {data.recommended_next_step.focus_areas.map((f, i) => (
                      <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "8px", fontSize: "13px", color: B.dark }}>
                        <span style={{ color: B.green, fontWeight: 700, flexShrink: 0 }}>→</span>{f}
                      </div>
                    ))}
                  </div>
                </div>
              )}
            </div>
          </Card>
        )}

        {/* ── 4. WHAT STANDS OUT ── */}
        {(data.what_stands_out?.length ?? 0) > 0 && (
          <Card>
            <SHead label="What Stands Out" sub="Unusual or notable signals vs. peers at same level" accent={B.purple} />
            <div style={{ padding: "14px 20px", display: "flex", flexDirection: "column", gap: "8px" }}>
              {data.what_stands_out.map((w, i) => (
                <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "10px", padding: "10px 14px", backgroundColor: B.purpleL, borderRadius: "8px", border: `1px solid ${B.purpleB}` }}>
                  <span style={{ fontSize: "14px", flexShrink: 0 }}>✦</span>
                  <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{w}</p>
                </div>
              ))}
            </div>
          </Card>
        )}

        {/* ── 5. EXPECTATION GAP ── */}
        {data.expectation_gap_analysis && (
          <Card>
            <SHead label="Expectation vs Reality" sub="What signals are typical at this level — and what's missing" accent={B.teal} />
            <div style={{ padding: "16px 20px" }}>
              <div style={{ display: "grid", gridTemplateColumns: "1fr 1fr", gap: "12px", marginBottom: "12px" }}>
                <div style={{ padding: "12px", backgroundColor: B.tealL, borderRadius: "8px", border: `1px solid ${B.tealB}` }}>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.teal, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "8px" }}>Expected</p>
                  {(data.expectation_gap_analysis.expected_signals_for_profile || []).map((e, i) => (
                    <div key={i} style={{ display: "flex", gap: "6px", fontSize: "12px", color: B.dark, lineHeight: 1.55, marginBottom: "5px" }}>
                      <span style={{ color: B.teal, flexShrink: 0 }}>✓</span>{e}
                    </div>
                  ))}
                </div>
                <div style={{ padding: "12px", backgroundColor: B.amberL, borderRadius: "8px", border: `1px solid ${B.amberB}` }}>
                  <p style={{ fontSize: "10px", fontWeight: 700, color: B.amber, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "8px" }}>Missing / Weaker</p>
                  {(data.expectation_gap_analysis.missing_or_weaker_than_expected || []).map((m, i) => (
                    <div key={i} style={{ display: "flex", gap: "6px", fontSize: "12px", color: B.dark, lineHeight: 1.55, marginBottom: "5px" }}>
                      <span style={{ color: B.amber, flexShrink: 0 }}>△</span>{m}
                    </div>
                  ))}
                </div>
              </div>
              <div style={{ padding: "10px 14px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}` }}>
                <p style={{ fontSize: "12px", color: B.dark, fontStyle: "italic", lineHeight: 1.6 }}>{data.expectation_gap_analysis.overall_assessment}</p>
              </div>
            </div>
          </Card>
        )}

        {/* ── 6. EXTERNAL SIGNALS ── */}
        <Card>
          <SHead label="External Signals" sub="Source-backed findings from public data" accent={B.green} />
          <div style={{ padding: "14px 20px" }}>
            {noData && (
              <div style={{ padding: "14px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}`, textAlign: "center" }}>
                <p style={{ fontSize: "13px", color: B.grayL, fontStyle: "italic" }}>No reliable external signals found beyond the CV.</p>
              </div>
            )}
            {hasV && (
              <div style={{ marginBottom: "14px" }}>
                <p style={{ fontSize: "10px", fontWeight: 700, color: B.green, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>Verified ({data.signals.verified_signals.length})</p>
                {data.signals.verified_signals.map((s, i) => <VI key={i} s={s} />)}
              </div>
            )}
            {hasW && (
              <div style={{ marginBottom: "14px" }}>
                <p style={{ fontSize: "10px", fontWeight: 700, color: B.amber, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>Weak signals ({data.signals.weak_signals.length})</p>
                {data.signals.weak_signals.map((s, i) => <WI key={i} s={s} />)}
              </div>
            )}
            {hasU && (
              <div>
                <p style={{ fontSize: "10px", fontWeight: 700, color: B.orange, textTransform: "uppercase", letterSpacing: "0.6px", marginBottom: "8px" }}>Unverified ({data.signals.unverified_claims.length})</p>
                {data.signals.unverified_claims.map((c, i) => <UI key={i} c={c} />)}
              </div>
            )}
            {!hasV && !hasW && !hasU && !noData && <p style={{ fontSize: "13px", color: B.grayL, fontStyle: "italic" }}>No signals identified.</p>}
          </div>
        </Card>

        {/* ── 7. HIRING IMPACT ── */}
        <Card>
          <SHead label="Hiring Impact" sub="What this means for your decision" accent={B.blue} />
          <div style={{ padding: "16px 20px" }}>
            <div style={{ display: "flex", alignItems: "center", gap: "10px", marginBottom: "12px" }}>
              <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.7, flex: 1 }}>{data.hiring_impact?.summary}</p>
              <span style={{ fontSize: "11px", fontWeight: 700, color: riskColor, backgroundColor: `${riskColor}15`, padding: "4px 10px", borderRadius: "20px", flexShrink: 0 }}>{data.hiring_impact?.risk_level} risk</span>
            </div>
            <div style={{ display: "flex", flexDirection: "column", gap: "7px" }}>
              {(data.hiring_impact?.implications || []).map((imp, i) => (
                <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "8px", padding: "9px 12px", backgroundColor: B.blueL, borderRadius: "8px", border: `1px solid ${B.blueB}` }}>
                  <span style={{ color: B.blue, fontWeight: 700, flexShrink: 0, marginTop: "1px" }}>→</span>
                  <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.55 }}>{imp}</p>
                </div>
              ))}
            </div>
          </div>
        </Card>

        {/* ── 8. WHAT TO VALIDATE ── */}
        <Card>
          <SHead label="What to Validate" sub="Specific questions for interview or reference checks" accent={B.purple} />
          <div style={{ padding: "14px 20px" }}>
            {(data.what_to_validate || []).map((q, i) => (
              <div key={i} style={{ display: "flex", alignItems: "flex-start", gap: "10px", padding: "10px 12px", borderRadius: "8px", marginBottom: "8px", backgroundColor: B.purpleL, border: `1px solid ${B.purpleB}` }}>
                <span style={{ fontSize: "11px", fontWeight: 700, color: B.purple, backgroundColor: B.white, border: `1px solid ${B.purpleB}`, borderRadius: "4px", padding: "1px 6px", flexShrink: 0 }}>{i + 1}</span>
                <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.6 }}>{q}</p>
              </div>
            ))}
          </div>
        </Card>

        {/* ── SENSITIVE SIGNALS (UNVERIFIED) — shown only when present ── */}
        {(data.sensitive_signals_unverified?.length ?? 0) > 0 && (
          <Card style={{ border: "1px solid #FED7AA" }}>
            <div style={{ padding: "14px 20px 4px" }}>
              <div style={{ display: "flex", alignItems: "center", gap: "8px", marginBottom: "4px" }}>
                <span style={{ fontSize: "14px" }}>⚠</span>
                <p style={{ fontSize: "10px", fontWeight: 700, color: "#EA580C", textTransform: "uppercase", letterSpacing: "0.8px" }}>
                  Sensitive Signals — Verification Required
                </p>
              </div>
              <p style={{ fontSize: "11px", color: "#9CA3AF", lineHeight: 1.5, marginBottom: "14px" }}>
                These signals are not verified and may relate to other individuals with similar names. Do not treat as confirmed facts.
              </p>
              {(data.sensitive_signals_unverified || []).map((s, i) => (
                <div key={i} style={{ padding: "12px 14px", borderRadius: "8px", marginBottom: "10px", backgroundColor: "#FFF7ED", border: "1px solid #FED7AA" }}>
                  <div style={{ display: "flex", alignItems: "center", justifyContent: "space-between", gap: "10px", marginBottom: "6px" }}>
                    <span style={{ fontSize: "10px", fontWeight: 700, color: "#EA580C", textTransform: "uppercase", letterSpacing: "0.5px" }}>
                      {s.attribution_status}
                    </span>
                    <span style={{ fontSize: "10px", color: "#9CA3AF", backgroundColor: "#F3F4F6", padding: "1px 7px", borderRadius: "20px" }}>
                      Low confidence
                    </span>
                  </div>
                  <p style={{ fontSize: "13px", color: "#111827", lineHeight: 1.65, marginBottom: "6px" }}>{s.signal}</p>
                  <p style={{ fontSize: "12px", color: "#6B7280", lineHeight: 1.55, marginBottom: "8px", fontStyle: "italic" }}>{s.context}</p>
                  {s.source?.reference && (
                    <p style={{ fontSize: "10px", color: "#9CA3AF" }}>
                      Source: {s.source.type}{s.source.reference !== s.source.type ? ` — ${s.source.reference}` : ""}
                    </p>
                  )}
                </div>
              ))}
              <div style={{ padding: "10px 14px", borderRadius: "6px", backgroundColor: "#F0F4FF", border: "1px solid #C7D2FE", marginBottom: "14px" }}>
                <p style={{ fontSize: "11px", fontWeight: 600, color: "#4338CA", marginBottom: "5px" }}>Suggested validation questions</p>
                <p style={{ fontSize: "12px", color: "#374151", lineHeight: 1.6 }}>
                  "Can you confirm any past legal or compliance matters?"<br />
                  "Have you ever been involved in disputes or regulatory proceedings?"
                </p>
              </div>
            </div>
          </Card>
        )}

        {/* ── 9. EXTERNAL SUMMARY + IDENTITY META ── */}
        <Card>
          <SHead label="External Profile" />
          <div style={{ padding: "16px 20px" }}>
            <p style={{ fontSize: "13px", color: B.dark, lineHeight: 1.75, marginBottom: "14px" }}>{data.external_profile_summary}</p>
            <div style={{ display: "flex", gap: "10px", flexWrap: "wrap" }}>
              {[
                { label: "Identity match", val: data.identity_confidence, conf: idConf },
                { label: "Data confidence", val: data.confidence_in_external_data, conf: dataConf },
              ].map(item => (
                <div key={item.label} style={{ padding: "6px 12px", borderRadius: "8px", backgroundColor: item.conf.bg, border: `1px solid ${item.conf.border}` }}>
                  <p style={{ fontSize: "9px", fontWeight: 700, color: item.conf.color, textTransform: "uppercase", letterSpacing: "0.5px", marginBottom: "2px" }}>{item.label}</p>
                  <p style={{ fontSize: "11px", fontWeight: 600, color: item.conf.color }}>{item.val}</p>
                </div>
              ))}
            </div>
            {data.identity_confidence_reason && (
              <p style={{ fontSize: "11px", color: B.grayL, marginTop: "10px", fontStyle: "italic" }}>ⓘ {data.identity_confidence_reason}</p>
            )}
          </div>
        </Card>

        <div style={{ display: "flex", alignItems: "flex-start", gap: "8px", padding: "10px 4px", fontSize: "11px", color: B.grayL }}>
          <span style={{ width: "6px", height: "6px", borderRadius: "50%", backgroundColor: B.green, flexShrink: 0, marginTop: "3px", display: "inline-block" }} />
          {t("gdpr")}
        </div>
      </div>
    </div>
  );
}
