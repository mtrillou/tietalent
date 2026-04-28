"use client";

import { useEffect, useState } from "react";
import { useSession } from "next-auth/react";
import { useLocale } from "next-intl";
import { useRouter } from "next/navigation";
import { Navbar } from "@/components/Navbar";

const B = { red: "#E8303A", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

interface Scan {
  id: string;
  type: "candidate_intelligence" | "role_fit";
  input_label: string;
  created_at: string;
}

const TYPE_META = {
  candidate_intelligence: { label: "Candidate Intelligence", icon: "🧠", color: "#7C3AED", bg: "#F5F3FF" },
  role_fit:               { label: "Role Fit",               icon: "🎯", color: "#059669", bg: "#ECFDF5" },
};

export default function HistoryPage() {
  const { status } = useSession();
  const locale = useLocale();
  const router = useRouter();
  const [scans, setScans] = useState<Scan[]>([]);
  const [loading, setLoading] = useState(true);
  const [deleting, setDeleting] = useState<string | null>(null);

  useEffect(() => {
    if (status === "unauthenticated") { router.push(`/${locale}`); return; }
    if (status !== "authenticated") return;
    fetch("/api/history")
      .then(r => r.json())
      .then(d => { setScans(d.scans || []); setLoading(false); })
      .catch(() => setLoading(false));
  }, [status, locale, router]);

  const handleDelete = async (scanId: string) => {
    setDeleting(scanId);
    await fetch("/api/history", { method: "DELETE", headers: { "Content-Type": "application/json" }, body: JSON.stringify({ scanId }) });
    setScans(prev => prev.filter(s => s.id !== scanId));
    setDeleting(null);
  };

  const handleView = async (scan: Scan) => {
    const res = await fetch(`/api/history/${scan.id}`);
    const { scan: full } = await res.json();
    if (!full) return;
    const key = scan.type === "role_fit" ? "tt_fit_report" : "tt_report";
    sessionStorage.setItem(key, JSON.stringify(full.result));
    router.push(`/${locale}/${scan.type === "role_fit" ? "fit" : "report"}`);
  };

  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
      <Navbar />
      <main style={{ maxWidth: "800px", margin: "0 auto", padding: "48px 24px" }}>
        <div style={{ marginBottom: "32px" }}>
          <h1 style={{ fontWeight: 700, fontSize: "28px", color: B.navy, marginBottom: "6px" }}>My analyses</h1>
          <p style={{ fontSize: "14px", color: B.gray }}>Your previous candidate and role fit analyses.</p>
        </div>

        {loading ? (
          <div style={{ display: "flex", justifyContent: "center", padding: "48px" }}>
            <div style={{ width: "32px", height: "32px", border: "3px solid #E5E7EB", borderTopColor: B.red, borderRadius: "50%", animation: "spin 0.9s linear infinite" }} />
            <style>{`@keyframes spin { to { transform: rotate(360deg); } }`}</style>
          </div>
        ) : scans.length === 0 ? (
          <div style={{ textAlign: "center", padding: "64px 24px", backgroundColor: B.white, borderRadius: "12px", border: `1px solid ${B.border}` }}>
            <p style={{ fontSize: "40px", marginBottom: "12px" }}>📋</p>
            <p style={{ fontWeight: 600, color: B.navy, marginBottom: "6px" }}>No analyses yet</p>
            <p style={{ fontSize: "14px", color: B.gray, marginBottom: "20px" }}>Run your first candidate intelligence or role fit analysis.</p>
            <button onClick={() => router.push(`/${locale}`)}
              style={{ padding: "10px 20px", backgroundColor: B.red, color: B.white, border: "none", borderRadius: "8px", cursor: "pointer", fontSize: "14px", fontWeight: 600 }}>
              Start analysing
            </button>
          </div>
        ) : (
          <div style={{ display: "flex", flexDirection: "column", gap: "10px" }}>
            {scans.map(scan => {
              const meta = TYPE_META[scan.type];
              const date = new Date(scan.created_at);
              return (
                <div key={scan.id} style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "10px", padding: "16px 20px", display: "flex", alignItems: "center", gap: "16px", boxShadow: "0 1px 3px rgba(0,0,0,0.04)" }}>
                  <span style={{ fontSize: "24px", flexShrink: 0 }}>{meta.icon}</span>
                  <div style={{ flex: 1, minWidth: 0 }}>
                    <p style={{ fontWeight: 600, fontSize: "14px", color: B.navy, marginBottom: "3px", overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap" }}>
                      {scan.input_label}
                    </p>
                    <div style={{ display: "flex", alignItems: "center", gap: "8px" }}>
                      <span style={{ fontSize: "11px", fontWeight: 600, color: meta.color, backgroundColor: meta.bg, padding: "2px 8px", borderRadius: "20px" }}>
                        {meta.label}
                      </span>
                      <span style={{ fontSize: "12px", color: "#9CA3AF" }}>
                        {date.toLocaleDateString()} · {date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })}
                      </span>
                    </div>
                  </div>
                  <div style={{ display: "flex", gap: "8px", flexShrink: 0 }}>
                    <button onClick={() => handleView(scan)}
                      style={{ padding: "7px 14px", fontSize: "12px", fontWeight: 600, color: B.navy, backgroundColor: B.surface, border: `1px solid ${B.border}`, borderRadius: "7px", cursor: "pointer" }}>
                      View
                    </button>
                    <button onClick={() => handleDelete(scan.id)} disabled={deleting === scan.id}
                      style={{ padding: "7px 14px", fontSize: "12px", fontWeight: 600, color: B.red, backgroundColor: "#FEF2F2", border: "1px solid #FECACA", borderRadius: "7px", cursor: "pointer", opacity: deleting === scan.id ? 0.5 : 1 }}>
                      {deleting === scan.id ? "…" : "Delete"}
                    </button>
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </main>
    </div>
  );
}
