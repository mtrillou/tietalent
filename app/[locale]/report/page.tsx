"use client";

import { useEffect, useState, useCallback } from "react";
import { useRouter, useSearchParams } from "next/navigation";
import { useLocale, useTranslations } from "next-intl";
import { Navbar } from "@/components/Navbar";
import { Report } from "@/components/Report";
import type { ReportData } from "@/lib/claude";
import { Suspense } from "react";

function ReportContent() {
  const router = useRouter();
  const locale = useLocale();
  const t = useTranslations("report");
  const searchParams = useSearchParams();
  const scanId = searchParams.get("id");

  const [report, setReport] = useState<ReportData | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(false);

  const loadReport = useCallback(async () => {
    setLoading(true);
    setError(false);

    // 1. Try URL param → fetch from DB (extension flow + history links)
    if (scanId) {
      try {
        const res = await fetch(`/api/history/${scanId}`);
        if (res.ok) {
          const { scan } = await res.json();
          if (scan?.result) {
            setReport(scan.result as ReportData);
            setLoading(false);
            return;
          }
        }
      } catch { /* fall through */ }
    }

    // 2. Try sessionStorage (web app flow)
    try {
      const raw = sessionStorage.getItem("tt_report");
      if (raw) {
        const parsed: ReportData = JSON.parse(raw);
        setReport(parsed);
        setLoading(false);
        setTimeout(() => sessionStorage.removeItem("tt_report"), 5000);
        return;
      }
    } catch { /* fall through */ }

    // 3. Try chrome.storage.local (extension fallback)
    if (typeof window !== "undefined" && (window as unknown as { chrome?: { storage?: { local?: { get: (k: string, cb: (d: Record<string, string>) => void) => void } } } }).chrome?.storage?.local) {
      const chromeStorage = (window as unknown as { chrome: { storage: { local: { get: (k: string, cb: (d: Record<string, string>) => void) => void } } } }).chrome.storage.local;
      chromeStorage.get("tt_last_report", (data: Record<string, string>) => {
        if (data.tt_last_report) {
          try {
            setReport(JSON.parse(data.tt_last_report) as ReportData);
            setLoading(false);
            return;
          } catch { /* fall through */ }
        }
        setError(true);
        setLoading(false);
      });
      return;
    }

    setError(true);
    setLoading(false);
  }, [scanId]);

  useEffect(() => { loadReport(); }, [loadReport]);

  // Loading state — never show empty, always show spinner
  if (loading) {
    return (
      <div style={{ minHeight: "100vh", backgroundColor: "#F9FAFB" }}>
        <Navbar />
        <div style={{ display: "flex", flexDirection: "column", alignItems: "center", justifyContent: "center", minHeight: "60vh", gap: "16px" }}>
          <div style={{ width: "36px", height: "36px", border: "3px solid #FFCCD6", borderTopColor: "#FF1F48", borderRadius: "50%", animation: "spin 0.85s linear infinite" }} />
          <p style={{ fontSize: "14px", color: "#6B7280", fontWeight: 500 }}>Loading intelligence report…</p>
          <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
        </div>
      </div>
    );
  }

  // Error — with clear action, no dead end
  if (error || !report) {
    return (
      <div style={{ minHeight: "100vh", backgroundColor: "#F9FAFB" }}>
        <Navbar />
        <div style={{ maxWidth: "480px", margin: "0 auto", padding: "80px 24px", textAlign: "center" }}>
          <p style={{ fontSize: "14px", color: "#6B7280", marginBottom: "20px" }}>
            Report not found. It may have expired or been generated in a different session.
          </p>
          <button
            onClick={() => router.push(`/${locale}`)}
            style={{ padding: "10px 24px", backgroundColor: "#FF1F48", color: "#fff", border: "none", borderRadius: "4px", fontSize: "13px", fontWeight: 700, letterSpacing: "0.5px", textTransform: "uppercase", cursor: "pointer" }}
          >
            Analyse a new profile
          </button>
        </div>
      </div>
    );
  }

  return (
    <div style={{ minHeight: "100vh", backgroundColor: "#F9FAFB" }}>
      <Navbar />
      <main style={{ maxWidth: "1100px", margin: "0 auto", padding: "32px 24px" }}>
        <div style={{ marginBottom: "20px" }}>
          <button
            onClick={() => router.push(`/${locale}`)}
            style={{ display: "flex", alignItems: "center", gap: "6px", fontSize: "13px", color: "#6B7280", background: "none", border: "none", cursor: "pointer" }}
          >
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7"/>
            </svg>
            New analysis
          </button>
        </div>
        <Report data={report} />
      </main>
    </div>
  );
}

export default function ReportPage() {
  return (
    <Suspense fallback={
      <div style={{ minHeight: "100vh", display: "flex", alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: "32px", height: "32px", border: "3px solid #FFCCD6", borderTopColor: "#FF1F48", borderRadius: "50%", animation: "spin 0.85s linear infinite" }} />
        <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
      </div>
    }>
      <ReportContent />
    </Suspense>
  );
}
