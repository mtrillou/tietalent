"use client";

import { useEffect, useState } from "react";
import { useSession } from "next-auth/react";
import { useLocale } from "next-intl";
import { useRouter } from "next/navigation";
import { Navbar } from "@/components/Navbar";

const B = { red: "#E8303A", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

export default function SettingsPage() {
  const { status } = useSession();
  const locale = useLocale();
  const router = useRouter();
  const [apiKey, setApiKey] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);
  const [generating, setGenerating] = useState(false);
  const [copied, setCopied] = useState(false);

  useEffect(() => {
    if (status === "unauthenticated") { router.push(`/${locale}`); return; }
    if (status !== "authenticated") return;
    fetch("/api/v1/keys")
      .then(r => r.json())
      .then(d => { setApiKey(d.api_key); setLoading(false); })
      .catch(() => setLoading(false));
  }, [status, locale, router]);

  const generateKey = async () => {
    setGenerating(true);
    const res = await fetch("/api/v1/keys", { method: "POST" });
    const data = await res.json();
    setApiKey(data.api_key);
    setGenerating(false);
  };

  const copyKey = () => {
    if (!apiKey) return;
    navigator.clipboard.writeText(apiKey);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
      <Navbar />
      <main style={{ maxWidth: "680px", margin: "0 auto", padding: "48px 24px" }}>
        <h1 style={{ fontWeight: 700, fontSize: "26px", color: B.navy, marginBottom: "6px" }}>Settings</h1>
        <p style={{ fontSize: "14px", color: B.gray, marginBottom: "32px" }}>Manage your API key and integrations.</p>

        <div style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "12px", overflow: "hidden", marginBottom: "24px" }}>
          <div style={{ padding: "16px 20px", borderBottom: `1px solid ${B.border}`, backgroundColor: B.surface }}>
            <p style={{ fontWeight: 700, fontSize: "13px", color: B.navy }}>🔑 API Key</p>
            <p style={{ fontSize: "12px", color: B.gray, marginTop: "2px" }}>Use this key to call the TieTalent API from the Chrome extension or your own tools.</p>
          </div>
          <div style={{ padding: "20px" }}>
            {loading ? (
              <p style={{ fontSize: "13px", color: B.gray }}>Loading…</p>
            ) : apiKey ? (
              <>
                <div style={{ display: "flex", alignItems: "center", gap: "8px", marginBottom: "12px" }}>
                  <code style={{ flex: 1, padding: "10px 12px", backgroundColor: B.surface, border: `1px solid ${B.border}`, borderRadius: "8px", fontSize: "12px", fontFamily: "monospace", color: B.navy, overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap" as const }}>
                    {apiKey}
                  </code>
                  <button onClick={copyKey} style={{ padding: "10px 16px", backgroundColor: copied ? "#059669" : B.navy, color: B.white, border: "none", borderRadius: "8px", fontSize: "12px", fontWeight: 600, cursor: "pointer", flexShrink: 0, transition: "background 0.15s" }}>
                    {copied ? "✓ Copied" : "Copy"}
                  </button>
                </div>
                <p style={{ fontSize: "11px", color: B.gray, marginBottom: "14px" }}>Keep this key secret. It grants access to your credits.</p>
                <button onClick={generateKey} disabled={generating} style={{ padding: "9px 16px", backgroundColor: B.surface, color: B.gray, border: `1px solid ${B.border}`, borderRadius: "8px", fontSize: "12px", cursor: "pointer" }}>
                  {generating ? "Generating…" : "🔄 Generate new key"}
                </button>
              </>
            ) : (
              <>
                <p style={{ fontSize: "13px", color: B.gray, marginBottom: "14px" }}>You do not have an API key yet.</p>
                <button onClick={generateKey} disabled={generating} style={{ padding: "11px 20px", backgroundColor: B.red, color: B.white, border: "none", borderRadius: "8px", fontSize: "13px", fontWeight: 700, cursor: "pointer" }}>
                  {generating ? "Generating…" : "Generate API Key"}
                </button>
              </>
            )}
          </div>
        </div>

        <div style={{ backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "12px", overflow: "hidden" }}>
          <div style={{ padding: "16px 20px", borderBottom: `1px solid ${B.border}`, backgroundColor: B.surface }}>
            <p style={{ fontWeight: 700, fontSize: "13px", color: B.navy }}>📡 API Reference</p>
          </div>
          <div style={{ padding: "20px" }}>
            {[
              { method: "POST", path: "/api/v1/analyze/candidate", desc: "Candidate intelligence report" },
              { method: "POST", path: "/api/v1/analyze/role-fit", desc: "CV vs job description fit analysis" },
            ].map(ep => (
              <div key={ep.path} style={{ marginBottom: "14px", padding: "12px", backgroundColor: B.surface, borderRadius: "8px", border: `1px solid ${B.border}` }}>
                <div style={{ display: "flex", alignItems: "center", gap: "8px", marginBottom: "4px" }}>
                  <span style={{ fontSize: "10px", fontWeight: 700, color: "#059669", backgroundColor: "#ECFDF5", padding: "2px 7px", borderRadius: "4px" }}>{ep.method}</span>
                  <code style={{ fontSize: "12px", color: B.navy, fontFamily: "monospace" }}>{ep.path}</code>
                </div>
                <p style={{ fontSize: "12px", color: B.gray }}>{ep.desc}</p>
              </div>
            ))}
            <p style={{ fontSize: "12px", color: B.gray, marginTop: "8px" }}>
              Pass your key as <code style={{ backgroundColor: B.surface, padding: "1px 5px", borderRadius: "4px" }}>X-API-Key: tt_xxx</code> header. 1 credit per call.
            </p>
          </div>
        </div>
      </main>
    </div>
  );
}
