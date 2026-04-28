import type { Metadata } from "next";
import { notFound } from "next/navigation";
import { NextIntlClientProvider } from "next-intl";
import { getMessages } from "next-intl/server";
import { locales, type Locale } from "@/i18n.config";
import { SessionProvider } from "@/components/SessionProvider";
import { DevErrorSuppressor } from "@/components/DevErrorSuppressor";
import "../globals.css";

export const dynamic = "force-dynamic";

export const metadata: Metadata = {
  title: "TieTalent CV Insights — Instant Talent Reports",
  description: "Upload a CV and get a structured AI-powered talent insight report in under 30 seconds.",
};

export function generateStaticParams() {
  return locales.map((locale) => ({ locale }));
}

export default async function LocaleLayout({
  children,
  params: { locale },
}: {
  children: React.ReactNode;
  params: { locale: string };
}) {
  if (!locales.includes(locale as Locale)) notFound();
  const messages = await getMessages();

  return (
    <html lang={locale}>
      <body className="bg-gray-50 min-h-screen">
        <DevErrorSuppressor />
        <SessionProvider>
          <NextIntlClientProvider messages={messages}>
            {children}
          </NextIntlClientProvider>
        </SessionProvider>
      </body>
    </html>
  );
}
