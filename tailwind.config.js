/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Inter", "system-ui", "-apple-system", "sans-serif"],
      },
      colors: {
        tt: {
          red:       "#E8303A",
          "red-h":   "#C9242D",
          "red-l":   "#FEF2F2",
          "red-b":   "#FECACA",
          navy:      "#1A1A2E",
          dark:      "#111827",
          gray:      "#6B7280",
          border:    "#E5E7EB",
          surface:   "#F9FAFB",
        },
      },
    },
  },
  plugins: [],
};
