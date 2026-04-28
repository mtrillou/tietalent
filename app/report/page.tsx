"use client";

import { useEffect, useState } from "react";
import { useRouter } from "next/navigation";
import { Navbar } from "@/components/Navbar";
import { Report } from "@/components/Report";
import type { ReportData } from "@/lib/claude";

export default function ReportPage() {
  const router = useRouter();
  const [report, setReport] = useState<ReportData | null>(null);
  const [error, setError] = useState(false);
  const [checked, setChecked] = useState(false);

  useEffect(() => {
    const timer = setTimeout(() => {
      try {
        const raw = sessionStorage.getItem("tt_report");
        if (!raw) {
          setError(true);
          setChecked(true);
          return;
        }
        const parsed: ReportData = JSON.parse(raw);
        setReport(parsed);
        setChecked(true);
        setTimeout(() => sessionStorage.removeItem("tt_report"), 3000);
      } catch {
        setError(true);
        setChecked(true);
      }
    }, 100);
    return () => clearTimeout(timer);
  }, []);

  if (!checked) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="w-8 h-8 border-2 border-gray-900 border-t-transparent rounded-full animate-spin" />
      </div>
    );
  }

  if (error || !report) {
    return (
      <div className="min-h-screen bg-gray-50">
        <Navbar />
        <div className="max-w-xl mx-auto px-6 py-24 text-center space-y-4">
          <p className="text-gray-500 text-sm">No report found. Please analyse a CV first.</p>
          <button
            onClick={() => router.push("/")}
            className="px-6 py-2.5 text-sm font-medium text-white rounded-xl"
            style={{ backgroundColor: "#0f1b35" }}
          >
            Back to upload
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50">
      <Navbar />
      <main className="max-w-5xl mx-auto px-6 py-10">
        <div className="mb-6 no-print">
          <button
            onClick={() => router.push("/")}
            className="text-sm text-gray-400 hover:text-gray-700 transition-colors flex items-center gap-1.5"
          >
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
            New analysis
          </button>
        </div>
        <Report data={report} />
      </main>
    </div>
  );
}
