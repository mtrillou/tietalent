"use client";
import { useEffect } from "react";

export function SuppressWarnings() {
  useEffect(() => {
    const orig = console.error.bind(console);
    console.error = (...args: unknown[]) => {
      if (typeof args[0] === "string" && args[0].includes("string refs")) return;
      orig(...args);
    };
    return () => { console.error = orig; };
  }, []);
  return null;
}
