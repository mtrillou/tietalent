"use client";

import { useSession, signIn, signOut } from "next-auth/react";
import { useState } from "react";
import { useLocale } from "next-intl";
import Link from "next/link";

const B = { red: "#E8303A", navy: "#1A1A2E", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF" };

export function UserMenu() {
  const { data: session, status } = useSession();
  const locale = useLocale();
  const [open, setOpen] = useState(false);

  if (status === "loading") return <div style={{ width: "32px", height: "32px", borderRadius: "50%", backgroundColor: B.surface }} />;

  if (!session?.user) {
    return (
      <button onClick={() => signIn()}
        style={{ padding: "6px 14px", border: `1px solid ${B.border}`, borderRadius: "7px", backgroundColor: B.white, cursor: "pointer", fontSize: "13px", fontWeight: 500, color: B.navy }}>
        Sign in
      </button>
    );
  }

  const initial = session.user.name?.[0] || session.user.email?.[0] || "?";

  return (
    <div style={{ position: "relative" }}>
      <button onClick={() => setOpen(!open)}
        style={{ width: "34px", height: "34px", borderRadius: "50%", backgroundColor: B.navy, color: B.white, border: "none", cursor: "pointer", fontSize: "13px", fontWeight: 700, display: "flex", alignItems: "center", justifyContent: "center" }}>
        {initial.toUpperCase()}
      </button>

      {open && (
        <>
          <div style={{ position: "fixed", inset: 0, zIndex: 10 }} onClick={() => setOpen(false)} />
          <div style={{ position: "absolute", right: 0, top: "calc(100% + 8px)", zIndex: 20, backgroundColor: B.white, border: `1px solid ${B.border}`, borderRadius: "10px", boxShadow: "0 8px 24px rgba(0,0,0,0.1)", minWidth: "180px", overflow: "hidden" }}>
            <div style={{ padding: "12px 14px", borderBottom: `1px solid ${B.border}` }}>
              <p style={{ fontSize: "12px", fontWeight: 600, color: B.navy, overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap" }}>{session.user.name || "User"}</p>
              <p style={{ fontSize: "11px", color: B.gray, overflow: "hidden", textOverflow: "ellipsis", whiteSpace: "nowrap" }}>{session.user.email}</p>
            </div>
            {[
              { label: "My analyses", href: `/${locale}/history` },
              { label: "Buy credits", href: `/${locale}/pricing` },
            ].map(item => (
              <Link key={item.href} href={item.href} onClick={() => setOpen(false)}
                style={{ display: "block", padding: "10px 14px", fontSize: "13px", color: B.navy, textDecoration: "none", borderBottom: `1px solid ${B.border}` }}
                onMouseOver={e => (e.currentTarget.style.backgroundColor = B.surface)}
                onMouseOut={e => (e.currentTarget.style.backgroundColor = B.white)}>
                {item.label}
              </Link>
            ))}
            <button onClick={() => signOut()}
              style={{ width: "100%", padding: "10px 14px", fontSize: "13px", color: B.red, textAlign: "left", background: "none", border: "none", cursor: "pointer" }}
              onMouseOver={e => (e.currentTarget.style.backgroundColor = B.surface)}
              onMouseOut={e => (e.currentTarget.style.backgroundColor = "transparent")}>
              Sign out
            </button>
          </div>
        </>
      )}
    </div>
  );
}
