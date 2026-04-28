"use client";
import { useEffect } from "react";
export function DevErrorSuppressor() {
  useEffect(() => {
    if (process.env.NODE_ENV !== "development") return;
    const orig = console.error;
    console.error = (...args: unknown[]) => {
      if (typeof args[0] === "string" && args[0].includes("string refs")) return;
      orig(...args);
    };
  }, []);
  return null;
}
