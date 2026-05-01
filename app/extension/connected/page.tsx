"use client";

import { useEffect, useState } from "react";
import { useSearchParams } from "next/navigation";
import { Suspense } from "react";

function ConnectedContent() {
  const params = useSearchParams();
  const apiKey = params.get("key") || "";
  const email = params.get("email") || "";
  const credits = params.get("credits") || "0";
  const [sent, setSent] = useState(false);
  const [error, setError] = useState(false);

  useEffect(() => {
    if (!apiKey) return;
    // Post the API key to the extension via window.postMessage
    // The extension background listens for this message from the web app origin
    try {
      window.postMessage({ type: "TT_EXT_CONNECT", api_key: apiKey }, "*");
      setTimeout(() => setSent(true), 500);
    } catch {
      setError(true);
    }
  }, [apiKey]);

  return (
    <div style={{ minHeight: "100vh", display: "flex", alignItems: "center", justifyContent: "center", backgroundColor: "#F9FAFB", fontFamily: "'DM Sans', sans-serif, -apple-system" }}>
      <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
      <div style={{ maxWidth: "480px", width: "100%", margin: "24px", backgroundColor: "#fff", borderRadius: "16px", border: "1px solid #E5E7EB", overflow: "hidden", boxShadow: "0 8px 32px rgba(0,18,107,0.08)" }}>

        {/* Header */}
        <div style={{ backgroundColor: "#00126B", padding: "28px 32px", textAlign: "center" }}>
          <div style={{ width: "52px", height: "52px", borderRadius: "12px", backgroundColor: "rgba(255,255,255,0.1)", border: "1px solid rgba(255,255,255,0.2)", display: "flex", alignItems: "center", justifyContent: "center", margin: "0 auto 14px" }}>
            <span style={{ fontSize: "24px" }}>✓</span>
          </div>
          <p style={{ fontFamily: "inherit", fontWeight: 800, fontSize: "22px", color: "#fff", letterSpacing: "-0.3px", marginBottom: "6px" }}>
            <span style={{ color: "#FF1F48" }}>tie</span>talent<span style={{ color: "#FF1F48" }}>.</span> connected
          </p>
          <p style={{ fontSize: "13px", color: "rgba(255,255,255,0.6)" }}>Your extension is ready to use</p>
        </div>

        {/* Body */}
        <div style={{ padding: "28px 32px" }}>
          {/* Success state */}
          <div style={{ padding: "14px 16px", backgroundColor: "#ECFDF5", border: "1px solid #A7F3D0", borderRadius: "8px", marginBottom: "20px", display: "flex", gap: "12px", alignItems: "flex-start" }}>
            <span style={{ fontSize: "18px", flexShrink: 0 }}>🔑</span>
            <div>
              <p style={{ fontSize: "13px", fontWeight: 700, color: "#059669", marginBottom: "3px" }}>API key added to extension</p>
              <p style={{ fontSize: "12px", color: "#374151" }}>Signed in as <strong>{email}</strong></p>
            </div>
          </div>

          {/* Credits */}
          <div style={{ padding: "14px 16px", backgroundColor: "#EFF6FF", border: "1px solid #BFDBFE", borderRadius: "8px", marginBottom: "20px", display: "flex", gap: "12px", alignItems: "center" }}>
            <span style={{ fontSize: "18px", flexShrink: 0 }}>⚡</span>
            <div style={{ flex: 1 }}>
              <p style={{ fontSize: "13px", fontWeight: 700, color: "#00126B", marginBottom: "3px" }}>2 free analyses per day</p>
              <p style={{ fontSize: "12px", color: "#374151" }}>Resets every day at midnight UTC{parseInt(credits) > 0 ? ` · ${credits} paid credits in your balance` : ""}</p>
            </div>
          </div>

          {/* Instructions */}
          <div style={{ marginBottom: "24px" }}>
            <p style={{ fontSize: "13px", fontWeight: 700, color: "#00126B", marginBottom: "12px" }}>You're all set. What's next:</p>
            {[
              "Open any LinkedIn profile",
              'Click "Intelligence" next to the candidate\'s name',
              "Get insights in under 30 seconds",
            ].map((step, i) => (
              <div key={i} style={{ display: "flex", gap: "10px", alignItems: "flex-start", marginBottom: "8px" }}>
                <div style={{ width: "20px", height: "20px", borderRadius: "50%", backgroundColor: "#FF1F48", color: "white", fontSize: "11px", fontWeight: 800, display: "flex", alignItems: "center", justifyContent: "center", flexShrink: 0 }}>{i + 1}</div>
                <p style={{ fontSize: "13px", color: "#374151", lineHeight: 1.5, paddingTop: "1px" }}>{step}</p>
              </div>
            ))}
          </div>

          {/* CTAs */}
          <a href="https://www.linkedin.com" target="_blank" style={{ display: "block", width: "100%", padding: "12px", backgroundColor: "#FF1F48", color: "white", borderRadius: "4px", fontSize: "13px", fontWeight: 700, letterSpacing: "0.5px", textTransform: "uppercase", textAlign: "center", textDecoration: "none", marginBottom: "10px" }}>
            Try it now on LinkedIn →
          </a>
          <a href="/en/pricing" target="_blank" style={{ display: "block", width: "100%", padding: "11px", backgroundColor: "transparent", color: "#00126B", border: "1.5px solid #00126B", borderRadius: "4px", fontSize: "12px", fontWeight: 700, letterSpacing: "0.5px", textTransform: "uppercase", textAlign: "center", textDecoration: "none" }}>
            Buy more credits
          </a>

          {/* Close note */}
          <p style={{ fontSize: "11px", color: "#9CA3AF", textAlign: "center", marginTop: "16px" }}>
            You can close this tab. The extension is ready.
          </p>
        </div>
      </div>
    </div>
  );
}

export default function ExtensionConnectedPage() {
  return (
    <Suspense fallback={<div style={{ minHeight: "100vh", display: "flex", alignItems: "center", justifyContent: "center" }}>Loading…</div>}>
      <ConnectedContent />
    </Suspense>
  );
}
