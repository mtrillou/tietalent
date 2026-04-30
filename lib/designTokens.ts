export const TT = {
  colors: {
    primary:      "#FF1F48",
    primaryHover: "#E5183F",
    primaryLight: "#FFF0F3",
    navy:         "#00126B",
    navyDark:     "#000D4D",
    dark:         "#1A1A1A",
    gray:         "#6B7280",
    grayLight:    "#9CA3AF",
    border:       "#E5E7EB",
    borderLight:  "#F3F4F6",
    surface:      "#F9FAFB",
    white:        "#FFFFFF",
    success:      "#059669",
    successLight: "#ECFDF5",
    warning:      "#D97706",
    warningLight: "#FFFBEB",
    danger:       "#DC2626",
    dangerLight:  "#FEF2F2",
  },
  typography: {
    fontFamily: "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif",
    sizes: { xs: "11px", sm: "12px", base: "14px", md: "15px", lg: "16px", xl: "18px" },
    weights: { normal: 400, medium: 500, semibold: 600, bold: 700, extrabold: 800 },
  },
  spacing: { "1": "4px", "2": "8px", "3": "12px", "4": "16px", "6": "24px", "8": "32px", "12": "48px" },
  layout: { maxWidth: "1200px", contentWidth: "800px", navHeight: "64px", containerPx: "24px" },
  radius: { sm: "4px", md: "8px", lg: "12px", full: "9999px" },
  shadows: { sm: "0 1px 3px rgba(0,0,0,0.06)", md: "0 4px 12px rgba(0,0,0,0.08)" },
  components: {
    btnPrimary: {
      background: "#FF1F48", color: "#FFFFFF", borderRadius: "4px",
      padding: "10px 24px", fontSize: "13px", fontWeight: 700,
      letterSpacing: "0.5px", textTransform: "uppercase" as const,
      border: "none", cursor: "pointer",
    },
    card: {
      background: "#FFFFFF", borderRadius: "8px",
      border: "1px solid #E5E7EB", boxShadow: "0 1px 3px rgba(0,0,0,0.06)",
    },
  },
} as const;

export type DesignTokens = typeof TT;
