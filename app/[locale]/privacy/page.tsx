import { Navbar } from "@/components/Navbar";

export default function PrivacyPage() {
  const B = { navy: "#1A1A2E", dark: "#111827", gray: "#6B7280", border: "#E5E7EB", surface: "#F9FAFB" };
  return (
    <div style={{ minHeight: "100vh", backgroundColor: B.surface }}>
      <Navbar />
      <main style={{ maxWidth: "720px", margin: "0 auto", padding: "48px 24px" }}>
        <div style={{ backgroundColor: "#fff", borderRadius: "12px", border: `1px solid ${B.border}`, padding: "40px 48px" }}>
          <h1 style={{ fontWeight: 800, fontSize: "28px", color: B.navy, marginBottom: "6px", letterSpacing: "-0.4px" }}>Privacy Policy</h1>
          <p style={{ fontSize: "13px", color: B.gray, marginBottom: "36px" }}>Last updated: April 28, 2026</p>

          {[
            {
              title: "1. Who we are",
              content: "TieTalent CV Insights is operated by TieTalent. This policy explains how we collect, use, and protect your data when you use our platform at tietalent.vercel.app and our Chrome extension (TieTalent Scout)."
            },
            {
              title: "2. What data we collect",
              content: null,
              list: [
                "Email address — for authentication via Google OAuth",
                "Credit balance and usage — to manage your analysis quota",
                "Structured analysis results — the output of candidate intelligence reports (never raw CV text)",
                "Stripe customer ID — for payment processing only",
                "API key — generated on request, stored securely in our database"
              ]
            },
            {
              title: "3. What we do NOT store",
              content: null,
              list: [
                "Raw CV text — it is processed in memory and immediately discarded",
                "Personal data of analyzed candidates",
                "Browsing history or page content from the Chrome extension",
                "Payment card details (handled entirely by Stripe)"
              ]
            },
            {
              title: "4. Chrome extension (TieTalent Scout)",
              content: "The extension stores only your TieTalent API key, locally in Chrome's secure storage (chrome.storage.local). It is never transmitted to any server other than tietalent.vercel.app. The extension only activates on candidate profile pages (LinkedIn /in/, job board profiles, etc.) and only when you explicitly click the Intelligence button. No background data collection occurs."
            },
            {
              title: "5. How we use your data",
              content: null,
              list: [
                "To authenticate your account and maintain your session",
                "To track credit usage and process payments",
                "To store analysis history for your personal reference",
                "To improve the service (aggregate, anonymized usage only)"
              ]
            },
            {
              title: "6. Third-party services",
              content: null,
              list: [
                "Anthropic — AI analysis engine (CV text sent for processing, not stored by Anthropic beyond the request)",
                "Google OAuth — authentication only",
                "Stripe — payment processing (governed by Stripe's privacy policy)",
                "Serper.dev — web search enrichment (queries sent, no personal data)",
                "Neon — database hosting (data stored in EU region)"
              ]
            },
            {
              title: "7. Data retention",
              content: "Analysis results are stored until you delete them from your history. You can delete your account and all associated data at any time by contacting us."
            },
            {
              title: "8. Your rights (GDPR)",
              content: "If you are located in the EU, you have the right to access, correct, delete, or export your personal data. To exercise any of these rights, contact us at the email below."
            },
            {
              title: "9. Security",
              content: "All data is transmitted over HTTPS. API keys are stored hashed. We apply rate limiting and input sanitization to protect against abuse. CV text is never logged or persisted."
            },
            {
              title: "10. Contact",
              content: "For any privacy-related questions or data requests, contact us at: marc.trillou@tietalent.com"
            }
          ].map((section) => (
            <div key={section.title} style={{ marginBottom: "28px" }}>
              <h2 style={{ fontWeight: 700, fontSize: "15px", color: B.navy, marginBottom: "10px" }}>{section.title}</h2>
              {section.content && <p style={{ fontSize: "14px", color: B.dark, lineHeight: 1.75 }}>{section.content}</p>}
              {section.list && (
                <ul style={{ paddingLeft: "20px", margin: 0 }}>
                  {section.list.map((item, i) => (
                    <li key={i} style={{ fontSize: "14px", color: B.dark, lineHeight: 1.75, marginBottom: "4px" }}>{item}</li>
                  ))}
                </ul>
              )}
            </div>
          ))}
        </div>
      </main>
    </div>
  );
}
