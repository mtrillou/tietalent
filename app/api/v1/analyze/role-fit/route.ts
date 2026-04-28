import { NextRequest, NextResponse } from "next/server";
import { validateApiKey, checkAndDeductApiCredit } from "@/lib/apiAuth";
import { analyzeFit } from "@/lib/fitAnalysis";
import { saveScan } from "@/lib/credits";
import { safeParseJSON } from "@/app/api/analyze/route";

export const runtime = "nodejs";
export const maxDuration = 120;

export async function POST(request: NextRequest) {
  // 1. Auth
  const auth = await validateApiKey(request);
  if (!auth.ok) return auth.response;
  const { user } = auth;

  // 2. Parse body
  const body = await request.json().catch(() => null);
  if (!body) return NextResponse.json({ error: "Invalid JSON body" }, { status: 400 });

  const { cv_text, job_description } = body as { cv_text: string; job_description: string };

  if (!cv_text || typeof cv_text !== "string" || cv_text.trim().length < 50) {
    return NextResponse.json({ error: "cv_text is required (min 50 characters)" }, { status: 400 });
  }
  if (!job_description || typeof job_description !== "string" || job_description.trim().length < 50) {
    return NextResponse.json({ error: "job_description is required (min 50 characters)" }, { status: 400 });
  }

  // 3. Credit check
  const credit = await checkAndDeductApiCredit(user.id);
  if (!credit.ok) return credit.response;

  // 4. Run analysis (no web enrichment for role fit via API — faster)
  const report = await analyzeFit(cv_text, job_description, "No external enrichment via API.", safeParseJSON);

  // 5. Save
  await saveScan({ userId: user.id, type: "role_fit", input_label: "API Role Fit", result: report as object });

  return NextResponse.json({
    success: true,
    report,
    meta: {
      credits_used: 1,
      remaining_credits: credit.remaining,
    },
  });
}
