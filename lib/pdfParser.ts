"use client";

export async function extractTextFromPDF(file: File): Promise<string> {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = async (e) => {
      try {
        const arrayBuffer = e.target?.result as ArrayBuffer;
        const bytes = new Uint8Array(arrayBuffer);

        const pdfjsLib = await import("pdfjs-dist");
        pdfjsLib.GlobalWorkerOptions.workerSrc = `https://cdnjs.cloudflare.com/ajax/libs/pdf.js/${pdfjsLib.version}/pdf.worker.min.mjs`;

        const pdf = await pdfjsLib.getDocument({ data: bytes }).promise;
        const parts: string[] = [];

        for (let i = 1; i <= pdf.numPages; i++) {
          const page = await pdf.getPage(i);
          const content = await page.getTextContent();
          const pageText = content.items
	   .map((item) => ("str" in item ? item.str || "" : ""))
            .join(" ");
          parts.push(pageText);
        }

        const result = parts.join("\n\n").replace(/\s{3,}/g, " ").trim();
        console.log("[pdfParser] Extracted", result.length, "chars");
        if (result.length > 50) {
          resolve(result);
        } else {
          reject(new Error("Could not extract enough text. Try pasting directly."));
        }
      } catch (err) {
        console.error("[pdfParser] Error:", err);
        reject(new Error("Failed to parse PDF. Try pasting the CV text directly."));
      }
    };
    reader.onerror = () => reject(new Error("Failed to read file"));
    reader.readAsArrayBuffer(file);
  });
}
