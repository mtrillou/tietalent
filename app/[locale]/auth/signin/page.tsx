"use client";

import { signIn } from "next-auth/react";
import { useState } from "react";
import { useSearchParams } from "next/navigation";
import { Navbar } from "@/components/Navbar";

const B = { red: "#E8303A", redH: "#C9242D", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", white: "#FFFFFF", surface: "#F9FAFB" };

export default function SignInPage() {
  const [email, setEmail] = useState("");
  const [sent, setSent] = useState(false);
  const [loading, setLoading] = useState(false);
  const params = useSearchParams();
  const callbackUrl = params.get("callbackUrl") || "/en";

  const handleEmail = async () => {
    if (!email.includes("@")) return;
    setLoading(true);
    await signIn("email", { email, callbackUrl, redirect: false });
    setSent(true);
    setLoading(false);
  };

  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
      <Navbar />
      <div style={{ display: "flex", alignItems: "center", justifyContent: "center", padding: "60px 24px" }}>
        <div style={{ backgroundColor: B.white, borderRadius: "16px", padding: "40px 36px", maxWidth: "400px", width: "100%", boxShadow: "0 8px 32px rgba(0,0,0,0.08)" }}>
          <div style={{ textAlign: "center", marginBottom: "28px" }}>
            <div style={{ display: "inline-flex", alignItems: "center", gap: "6px", padding: "4px 12px", borderRadius: "20px", marginBottom: "14px", backgroundColor: "#FEF2F2", border: "1px solid #FECACA" }}>
              <span style={{ fontSize: "11px", fontWeight: 700, color: B.red }}>⚡ 2 free analyses per day</span>
            </div>
            <h1 style={{ fontWeight: 700, fontSize: "22px", color: B.navy, marginBottom: "8px" }}>Sign in to TieTalent</h1>
            <p style={{ fontSize: "13px", color: B.gray }}>No credit card required.</p>
          </div>

          {sent ? (
            <div style={{ textAlign: "center", padding: "24px", backgroundColor: B.surface, borderRadius: "12px" }}>
              <p style={{ fontSize: "28px", marginBottom: "10px" }}>📬</p>
              <p style={{ fontWeight: 600, color: B.navy, marginBottom: "6px" }}>Check your email</p>
              <p style={{ fontSize: "13px", color: B.gray }}>Magic link sent to <strong>{email}</strong></p>
            </div>
          ) : (
            <>
              <button onClick={() => signIn("google", { callbackUrl })}
                style={{ width: "100%", display: "flex", alignItems: "center", justifyContent: "center", gap: "10px", padding: "13px", borderRadius: "10px", border: `1.5px solid ${B.border}`, backgroundColor: B.white, cursor: "pointer", fontSize: "14px", fontWeight: 600, color: B.navy, marginBottom: "14px" }}
                onMouseOver={e => e.currentTarget.style.borderColor = B.navy}
                onMouseOut={e => e.currentTarget.style.borderColor = B.border}>
                <svg width="18" height="18" viewBox="0 0 18 18"><path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/><path d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 009 18z" fill="#34A853"/><path d="M3.964 10.71A5.41 5.41 0 013.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 000 9c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/><path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 00.957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/></svg>
                Continue with Google
              </button>

              <div style={{ display: "flex", alignItems: "center", gap: "12px", marginBottom: "14px" }}>
                <div style={{ flex: 1, height: "1px", backgroundColor: B.border }} />
                <span style={{ fontSize: "12px", color: "#9CA3AF" }}>or</span>
                <div style={{ flex: 1, height: "1px", backgroundColor: B.border }} />
              </div>

              <input type="email" value={email} onChange={e => setEmail(e.target.value)}
                placeholder="your@email.com"
                onKeyDown={e => e.key === "Enter" && handleEmail()}
                style={{ width: "100%", padding: "12px 14px", fontSize: "14px", border: `1.5px solid ${B.border}`, borderRadius: "10px", outline: "none", fontFamily: "Inter, sans-serif", marginBottom: "10px", boxSizing: "border-box" }}
                onFocus={e => e.target.style.borderColor = B.red}
                onBlur={e => e.target.style.borderColor = B.border}
              />
              <button onClick={handleEmail} disabled={loading || !email.includes("@")}
                style={{ width: "100%", padding: "13px", backgroundColor: B.red, color: B.white, border: "none", borderRadius: "10px", cursor: "pointer", fontSize: "14px", fontWeight: 600, opacity: loading || !email.includes("@") ? 0.55 : 1 }}
                onMouseOver={e => { if (!loading) e.currentTarget.style.backgroundColor = B.redH; }}
                onMouseOut={e => { e.currentTarget.style.backgroundColor = B.red; }}>
                {loading ? "Sending…" : "Continue with Email"}
              </button>
            </>
          )}

          <p style={{ textAlign: "center", fontSize: "11px", color: "#9CA3AF", marginTop: "20px" }}>
            No credit card required · 2 free analyses/day
          </p>
        </div>
      </div>
    </div>
  );
}
