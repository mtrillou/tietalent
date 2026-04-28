"use client";

import { useLocale } from "next-intl";
import { useRouter, usePathname } from "next/navigation";
import { useState } from "react";
import { locales, localeNames, localeLabels, type Locale } from "@/i18n.config";

const B = { navy: "#1A1A2E", border: "#E5E7EB", surface: "#F9FAFB", white: "#FFFFFF", red: "#E8303A" };

export function LanguageSwitcher() {
  const locale = useLocale() as Locale;
  const router = useRouter();
  const pathname = usePathname();
  const [open, setOpen] = useState(false);

  const switchLocale = (next: Locale) => {
    // Replace the current locale segment in the path
    const segments = pathname.split("/");
    segments[1] = next;
    router.push(segments.join("/") || "/");
    setOpen(false);
  };

  return (
    <div style={{ position: "relative" }}>
      <button
        onClick={() => setOpen(!open)}
        style={{
          display: "flex", alignItems: "center", gap: "4px",
          padding: "6px 10px", borderRadius: "6px",
          border: `1px solid ${B.border}`, backgroundColor: B.white,
          fontSize: "13px", fontWeight: 600, color: B.navy,
          cursor: "pointer", transition: "border-color 0.15s",
        }}
        onMouseOver={e => (e.currentTarget.style.borderColor = B.red)}
        onMouseOut={e => (e.currentTarget.style.borderColor = B.border)}
      >
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <circle cx="7" cy="7" r="6" stroke={B.navy} strokeWidth="1.2"/>
          <ellipse cx="7" cy="7" rx="2.5" ry="6" stroke={B.navy} strokeWidth="1.2"/>
          <path d="M1.5 5h11M1.5 9h11" stroke={B.navy} strokeWidth="1.2"/>
        </svg>
        {localeNames[locale]}
        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" style={{ opacity: 0.5, transform: open ? "rotate(180deg)" : "none", transition: "transform 0.15s" }}>
          <path d="M2 4l3 3 3-3" stroke={B.navy} strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/>
        </svg>
      </button>

      {open && (
        <>
          {/* Backdrop */}
          <div style={{ position: "fixed", inset: 0, zIndex: 10 }} onClick={() => setOpen(false)} />
          {/* Dropdown */}
          <div style={{
            position: "absolute", right: 0, top: "calc(100% + 6px)", zIndex: 20,
            backgroundColor: B.white, border: `1px solid ${B.border}`,
            borderRadius: "8px", boxShadow: "0 4px 16px rgba(0,0,0,0.1)",
            minWidth: "130px", overflow: "hidden",
          }}>
            {locales.map((l) => (
              <button key={l} onClick={() => switchLocale(l)} style={{
                display: "flex", alignItems: "center", justifyContent: "space-between",
                width: "100%", padding: "9px 14px", border: "none",
                backgroundColor: l === locale ? B.surface : B.white,
                fontSize: "13px", fontWeight: l === locale ? 600 : 400,
                color: l === locale ? B.red : B.navy,
                cursor: "pointer", textAlign: "left",
                borderBottom: `1px solid ${B.border}`,
                transition: "background-color 0.1s",
              }}
                onMouseOver={e => { if (l !== locale) e.currentTarget.style.backgroundColor = B.surface; }}
                onMouseOut={e => { if (l !== locale) e.currentTarget.style.backgroundColor = B.white; }}
              >
                <span>{localeLabels[l]}</span>
                <span style={{ fontSize: "11px", fontWeight: 700, color: B.navy, opacity: 0.5 }}>{localeNames[l]}</span>
              </button>
            ))}
          </div>
        </>
      )}
    </div>
  );
}
