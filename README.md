# TieTalent CV Insights

AI-powered CV analysis tool. Upload a CV, get a structured talent report in <30 seconds.

## Setup

### 1. Install dependencies

```bash
npm install
```

### 2. Configure environment

```bash
cp .env.local.example .env.local
```

Edit `.env.local`:

```
ANTHROPIC_API_KEY=sk-ant-api03-your-key-here
```

Get your key at: https://console.anthropic.com

### 3. Run locally

```bash
npm run dev
```

Open http://localhost:3000

### 4. Build for production

```bash
npm run build
npm start
```

## Deploy to Vercel

### Option A — Vercel CLI

```bash
npm i -g vercel
vercel
```

Follow prompts. When asked for environment variables, add `ANTHROPIC_API_KEY`.

### Option B — Vercel Dashboard

1. Push this repo to GitHub
2. Go to https://vercel.com/new
3. Import your repo
4. Add environment variable: `ANTHROPIC_API_KEY` = your key
5. Click Deploy

## Architecture

```
Browser
├── PDF parsed client-side (pdfjs-dist) — raw file never uploaded
├── Extracted text sent to POST /api/analyze
└── Report stored in sessionStorage (cleared after read)

API Route /api/analyze
├── Receives: { cv_text: string }
├── Calls: Claude claude-sonnet-4-20250514
├── Returns: structured JSON report
└── No DB writes, no file storage, no CV text logging
```

## GDPR

- No database
- No file storage  
- CV text is not logged (only text length)
- sessionStorage cleared immediately after report is read
- All processing is stateless and in-memory

## Tech stack

- Next.js 14 (App Router)
- TypeScript
- Tailwind CSS
- pdfjs-dist (client-side PDF parsing)
- Anthropic Claude API
- jsPDF + html2canvas (PDF export)
- Deployed on Vercel
