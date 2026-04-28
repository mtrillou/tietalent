"use client";

import Link from "next/link";
import Image from "next/image";
import { useLocale, useTranslations } from "next-intl";
import { useSession } from "next-auth/react";
import { useRouter } from "next/navigation";
import { LanguageSwitcher } from "@/components/LanguageSwitcher";
import { CreditsBadge } from "@/components/CreditsBadge";
import { UserMenu } from "@/components/UserMenu";

export function Navbar() {
  const t = useTranslations("nav");
  const locale = useLocale();
  const { status } = useSession();
  const router = useRouter();

  const handleHistory = (e: React.MouseEvent) => {
    e.preventDefault();
    if (status !== "authenticated") {
      router.push(`/${locale}/auth/signin?callbackUrl=/${locale}/history`);
    } else {
      router.push(`/${locale}/history`);
    }
  };

  return (
    <header style={{ backgroundColor: "#FFFFFF", borderBottom: "1px solid #E5E7EB" }} className="sticky top-0 z-20">
      <div className="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <Link href={`/${locale}`} className="flex items-center gap-2" style={{ textDecoration: "none" }}>
          <Image
            src="https://www.eu-startups.com/wp-content/uploads/2024/09/Square-TT-Logo-Large-3.png"
            alt="TieTalent"
            width={44}
            height={44}
            style={{ borderRadius: "10px" }}
            unoptimized
          />
          <span style={{ fontSize: "11px", fontWeight: 600, color: "#E8303A", backgroundColor: "#FEF2F2", border: "1px solid #FECACA", padding: "2px 8px", borderRadius: "20px", marginLeft: "4px" }}>
            CV Insights
          </span>
        </Link>

        <nav className="flex items-center gap-1">
          <Link href={`/${locale}`}
            style={{ color: "#6B7280", fontSize: "13px", padding: "6px 11px", borderRadius: "7px", textDecoration: "none" }}
            className="hover:bg-gray-50 transition-colors">
            {t("candidateInsights")}
          </Link>
          <Link href={`/${locale}/fit`}
            style={{ color: "#6B7280", fontSize: "13px", padding: "6px 11px", borderRadius: "7px", textDecoration: "none" }}
            className="hover:bg-gray-50 transition-colors">
            {t("fitAnalysis")}
          </Link>
          <a href={`/${locale}/history`} onClick={handleHistory}
            style={{ color: "#6B7280", fontSize: "13px", padding: "6px 11px", borderRadius: "7px", textDecoration: "none", cursor: "pointer" }}
            className="hover:bg-gray-50 transition-colors">
            {t("history")}
          </a>
          <LanguageSwitcher />
          <CreditsBadge />
          <UserMenu />
        </nav>
      </div>
    </header>
  );
}
