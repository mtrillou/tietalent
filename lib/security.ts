// ─────────────────────────────────────────────────────────────────────────────
// TieTalent Security Layer
// Rate limiting, input sanitization, prompt injection protection
// ─────────────────────────────────────────────────────────────────────────────

import { NextRequest, NextResponse } from "next/server";

// ── In-memory rate limiter (replace with Redis/Upstash for multi-instance) ──

interface RateEntry { count: number; resetAt: number; }
const rateLimitStore = new Map<string, RateEntry>();

export function rateLimit(
  key: string,
  maxRequests: number,
  windowMs: number
): { allowed: boolean; remaining: number; resetIn: number } {
  const now = Date.now();
  const entry = rateLimitStore.get(key);

  if (!entry || now > entry.resetAt) {
    rateLimitStore.set(key, { count: 1, resetAt: now + windowMs });
    return { allowed: true, remaining: maxRequests - 1, resetIn: windowMs };
  }

  if (entry.count >= maxRequests) {
    return { allowed: false, remaining: 0, resetIn: entry.resetAt - now };
  }

  entry.count++;
  return { allowed: true, remaining: maxRequests - entry.count, resetIn: entry.resetAt - now };
}

// Clean up stale entries every 10 minutes
setInterval(() => {
  const now = Date.now();
  for (const [key, entry] of rateLimitStore.entries()) {
    if (now > entry.resetAt) rateLimitStore.delete(key);
  }
}, 10 * 60 * 1000);

// ── Rate limit enforcement ───────────────────────────────────────────────────

export function enforceRateLimit(
  request: NextRequest,
  userId: string | null,
  tier: "free" | "paid" | "api"
): NextResponse | null {
  const ip = request.headers.get("x-forwarded-for")?.split(",")[0].trim()
    || request.headers.get("x-real-ip")
    || "unknown";

  const limits = {
    free: { max: 10, window: 60_000 },    // 10 req/min per IP for free
    paid: { max: 30, window: 60_000 },    // 30 req/min for authenticated
    api:  { max: 20, window: 60_000 },    // 20 req/min for API keys
  };

  const { max, window } = limits[tier];
  const key = userId ? `user:${userId}` : `ip:${ip}`;
  const { allowed, remaining, resetIn } = rateLimit(key, max, window);

  if (!allowed) {
    return NextResponse.json(
      { error: "Too many requests. Please slow down." },
      {
        status: 429,
        headers: {
          "Retry-After": String(Math.ceil(resetIn / 1000)),
          "X-RateLimit-Remaining": "0",
        },
      }
    );
  }
  return null; // allowed
}

// ── Prompt injection sanitization ────────────────────────────────────────────

const INJECTION_PATTERNS = [
  /ignore\s+(all\s+)?(previous|prior|above|earlier)\s+(instructions?|prompts?|context|rules?)/gi,
  /forget\s+(everything|all|your|previous)/gi,
  /you\s+are\s+now\s+(a\s+)?(different|new|another)/gi,
  /act\s+as\s+(if\s+you\s+(are|were)\s+)?(a\s+)?/gi,
  /disregard\s+(your|all|previous|the)/gi,
  /system\s*prompt/gi,
  /reveal\s+(your|the)\s+(instructions?|prompts?|system|rules?)/gi,
  /print\s+(your|the)\s+(instructions?|prompts?|system)/gi,
  /what\s+(are|were)\s+your\s+instructions/gi,
  /repeat\s+(the\s+)?(above|previous|prior|your)/gi,
  /jailbreak/gi,
  /DAN\s+mode/gi,
  /developer\s+mode/gi,
  /\{\{.*\}\}/g,   // template injection
  /<\|.*\|>/g,     // token injection patterns
];

export function sanitizeCvText(input: string): { safe: string; injectionDetected: boolean } {
  let safe = input;
  let injectionDetected = false;

  for (const pattern of INJECTION_PATTERNS) {
    if (pattern.test(safe)) {
      injectionDetected = true;
      safe = safe.replace(pattern, "[content removed]");
    }
  }

  // Limit to reasonable CV length
  safe = safe.slice(0, 50_000);

  return { safe, injectionDetected };
}

// ── Security headers ─────────────────────────────────────────────────────────

export function addSecurityHeaders(response: NextResponse): NextResponse {
  response.headers.set("X-Content-Type-Options", "nosniff");
  response.headers.set("X-Frame-Options", "DENY");
  response.headers.set("X-XSS-Protection", "1; mode=block");
  response.headers.set("Referrer-Policy", "strict-origin-when-cross-origin");
  response.headers.set("Permissions-Policy", "camera=(), microphone=(), geolocation=()");
  return response;
}

// ── CORS enforcement ─────────────────────────────────────────────────────────

const ALLOWED_ORIGINS = [
  "http://localhost:3000",
  "https://tietalent.com",
  "https://www.tietalent.com",
];

export function checkCors(request: NextRequest): { allowed: boolean; origin: string } {
  const origin = request.headers.get("origin") || "";
  // Allow extension requests (no origin) and allowed origins
  if (!origin || ALLOWED_ORIGINS.includes(origin)) {
    return { allowed: true, origin };
  }
  return { allowed: false, origin };
}

// ── Sanitize error messages (never expose internals) ─────────────────────────

export function safeError(err: unknown, fallback = "An error occurred. Please try again."): string {
  if (process.env.NODE_ENV === "development" && err instanceof Error) {
    return err.message; // show in dev
  }
  return fallback;
}

// ── Input validation helpers ─────────────────────────────────────────────────

export function validateCvInput(cv_text: unknown): { valid: boolean; error?: string } {
  if (!cv_text || typeof cv_text !== "string") {
    return { valid: false, error: "cv_text is required" };
  }
  if (cv_text.trim().length < 50) {
    return { valid: false, error: "cv_text must be at least 50 characters" };
  }
  if (cv_text.length > 50_000) {
    return { valid: false, error: "cv_text exceeds maximum length" };
  }
  return { valid: true };
}
