"use client";

import { useState, useRef, DragEvent, ChangeEvent } from "react";
import { useTranslations } from "next-intl";
import { extractTextFromPDF } from "@/lib/pdfParser";

interface FileUploadProps {
  onExtracted: (text: string) => void;
  isLoading: boolean;
  hidePaste?: boolean;
}

export function FileUpload({ onExtracted, isLoading, hidePaste = false }: FileUploadProps) {
  const t = useTranslations("upload");
  const [dragging, setDragging] = useState(false);
  const [fileName, setFileName] = useState<string | null>(null);
  const [pasteText, setPasteText] = useState("");
  const [parsing, setParsing] = useState(false);
  const [parseError, setParseError] = useState<string | null>(null);
  const fileRef = useRef<HTMLInputElement>(null);

  const processFile = async (file: File) => {
    if (file.type !== "application/pdf" && !file.name.endsWith(".pdf")) {
      setParseError("Only PDF files are supported.");
      return;
    }
    if (file.size > 10 * 1024 * 1024) {
      setParseError("File too large. Maximum 10MB.");
      return;
    }
    setParseError(null);
    setParsing(true);
    try {
      const text = await extractTextFromPDF(file);
      if (text.length < 50) {
        setParseError("Could not extract text from PDF. Try pasting the CV text directly.");
        setParsing(false);
        return;
      }
      setFileName(file.name);
      setPasteText("");
      onExtracted(text);
    } catch {
      setParseError("Failed to parse PDF. Try pasting the CV text directly.");
    } finally {
      setParsing(false);
    }
  };

  const handleDrop = (e: DragEvent<HTMLDivElement>) => {
    e.preventDefault();
    setDragging(false);
    const file = e.dataTransfer.files[0];
    if (file) processFile(file);
  };

  const handleFileChange = (e: ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) processFile(file);
  };

  const handlePasteChange = (e: ChangeEvent<HTMLTextAreaElement>) => {
    setPasteText(e.target.value);
    setFileName(null);
    if (e.target.value.trim().length > 50) {
      onExtracted(e.target.value.trim());
    }
  };

  return (
    <div className="space-y-4">
      {/* Drop zone */}
      <div
        onClick={() => !parsing && !isLoading && fileRef.current?.click()}
        onDragOver={(e) => { e.preventDefault(); setDragging(true); }}
        onDragLeave={() => setDragging(false)}
        onDrop={handleDrop}
        className={`relative border-2 border-dashed rounded-xl p-10 text-center cursor-pointer transition-all duration-200
          ${dragging ? "border-red-400 bg-red-50" : "border-gray-200 bg-gray-50 hover:border-gray-300 hover:bg-white"}
          ${parsing || isLoading ? "opacity-60 cursor-not-allowed" : ""}
        `}
      >
        <input
          ref={fileRef}
          type="file"
          accept=".pdf"
          className="hidden"
          onChange={handleFileChange}
          disabled={parsing || isLoading}
        />
        {parsing ? (
          <div className="space-y-2">
            <div className="w-8 h-8 border-2 border-red-400 border-t-transparent rounded-full animate-spin mx-auto" />
            <p className="text-sm text-gray-500">{t("parsing")}</p>
          </div>
        ) : fileName ? (
          <div className="space-y-2">
            <div className="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mx-auto">
              <svg className="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <p className="text-sm font-medium text-gray-700">{fileName}</p>
            <p className="text-xs text-gray-400">{t("replace")}</p>
          </div>
        ) : (
          <div className="space-y-3">
            <div className="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto">
              <svg className="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
            </div>
            <div>
              <p className="text-sm font-medium text-gray-700">{t("dropTitle")}</p>
              <p className="text-xs text-gray-400 mt-1">{t("dropSubtitle")}</p>
            </div>
          </div>
        )}
      </div>

      {parseError && (
        <p className="text-sm text-red-600 bg-red-50 border border-red-100 rounded-lg px-4 py-2.5">{parseError}</p>
      )}

      {!hidePaste && (
        <>
          {/* Divider */}
          <div className="flex items-center gap-3">
            <div className="flex-1 h-px bg-gray-200" />
            <span className="text-xs text-gray-400 font-medium">{t("orPaste")}</span>
            <div className="flex-1 h-px bg-gray-200" />
          </div>

          {/* Text paste */}
          <textarea
            value={pasteText}
            onChange={handlePasteChange}
            disabled={isLoading}
            rows={6}
            placeholder={t("pastePlaceholder")}
            className="w-full px-4 py-3 text-sm text-gray-700 border border-gray-200 rounded-xl resize-none focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all bg-white placeholder-gray-300 disabled:opacity-60"
          />
        </>
      )}
    </div>
  );
}
