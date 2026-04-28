const createNextIntlPlugin = require("next-intl/plugin");
const withNextIntl = createNextIntlPlugin("./i18n.ts");

/** @type {import('next').NextConfig} */
const nextConfig = {
  reactStrictMode: false,

  images: {
    remotePatterns: [
      { protocol: "https", hostname: "www.eu-startups.com" },
    ],
  },

  webpack: (config) => {
    config.resolve.alias.canvas = false;
    return config;
  },

  // ── Security headers on every response ──────────────────────────────────
  async headers() {
    return [
      {
        source: "/(.*)",
        headers: [
          { key: "X-DNS-Prefetch-Control",  value: "on" },
          { key: "X-Frame-Options",         value: "SAMEORIGIN" },
          { key: "X-Content-Type-Options",  value: "nosniff" },
          { key: "X-XSS-Protection",        value: "1; mode=block" },
          { key: "Referrer-Policy",         value: "strict-origin-when-cross-origin" },
          { key: "Permissions-Policy",      value: "camera=(), microphone=(), geolocation=(), payment=()" },
          {
            key: "Strict-Transport-Security",
            value: "max-age=63072000; includeSubDomains; preload",
          },
          {
            key: "Content-Security-Policy",
            value: [
              "default-src 'self'",
              "script-src 'self' 'unsafe-eval' 'unsafe-inline'", // Next.js needs these
              "style-src 'self' 'unsafe-inline'",
              "img-src 'self' data: https://www.eu-startups.com https://encrypted-tbn0.gstatic.com",
              "font-src 'self'",
              "connect-src 'self' https://api.anthropic.com https://google.serper.dev https://api.stripe.com",
              "frame-ancestors 'none'",
            ].join("; "),
          },
        ],
      },
      // API routes: stricter CORS
      {
        source: "/api/v1/(.*)",
        headers: [
          { key: "Access-Control-Allow-Origin",  value: process.env.NEXT_PUBLIC_SITE_URL || "https://tietalent.com" },
          { key: "Access-Control-Allow-Methods", value: "POST, OPTIONS" },
          { key: "Access-Control-Allow-Headers", value: "Content-Type, X-API-Key, Authorization" },
        ],
      },
    ];
  },

  // ── Suppress verbose logs in production ─────────────────────────────────
  logging: {
    fetches: {
      fullUrl: process.env.NODE_ENV === "development",
    },
  },
};

module.exports = withNextIntl(nextConfig);
