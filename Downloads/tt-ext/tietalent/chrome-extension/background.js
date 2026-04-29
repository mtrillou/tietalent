// TieTalent Scout — Background Service Worker
// Handles API calls and persists state across popup sessions

const API_BASE = "https://tietalent.vercel.app";
const STATE_EXPIRY_MS = 30 * 60 * 1000; // 30 minutes

// ── State helpers ─────────────────────────────────────────────────────────────

function setState(patch) {
  return new Promise(resolve => {
    chrome.storage.local.get("tt_state", (data) => {
      const current = data.tt_state || { status: "idle" };
      const next = { ...current, ...patch };
      chrome.storage.local.set({ tt_state: next }, resolve);
    });
  });
}

function getState() {
  return new Promise(resolve => {
    chrome.storage.local.get("tt_state", (data) => {
      const state = data.tt_state || { status: "idle" };
      // Auto-expire stale loading states (popup crashed mid-analysis)
      if (state.status === "loading" && state.startedAt) {
        if (Date.now() - state.startedAt > STATE_EXPIRY_MS) {
          const expired = { status: "idle" };
          chrome.storage.local.set({ tt_state: expired });
          resolve(expired);
          return;
        }
      }
      // Auto-expire completed results
      if (state.status === "completed" && state.finishedAt) {
        if (Date.now() - state.finishedAt > STATE_EXPIRY_MS) {
          const expired = { status: "idle" };
          chrome.storage.local.set({ tt_state: expired });
          resolve(expired);
          return;
        }
      }
      resolve(state);
    });
  });
}

// ── Message handler ───────────────────────────────────────────────────────────

chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {

  if (message.type === "GET_STATE") {
    getState().then(sendResponse);
    return true;
  }

  if (message.type === "RESET_STATE") {
    chrome.storage.local.set({ tt_state: { status: "idle" } }, () => sendResponse({ ok: true }));
    return true;
  }

  if (message.type === "GET_API_KEY") {
    chrome.storage.local.get("tt_api_key", (d) => sendResponse({ api_key: d.tt_api_key || null }));
    return true;
  }

  if (message.type === "SAVE_API_KEY") {
    chrome.storage.local.set({ tt_api_key: message.key }, () => sendResponse({ ok: true }));
    return true;
  }

  if (message.type === "CLEAR_API_KEY") {
    chrome.storage.local.remove("tt_api_key", () => sendResponse({ ok: true }));
    return true;
  }

  if (message.type === "ANALYZE_CANDIDATE") {
    // Start analysis — runs entirely in background, survives popup close
    handleAnalysis(message.payload).then(sendResponse).catch(err => {
      sendResponse({ error: err.message });
    });
    return true; // keep channel open for async
  }
});

// ── Core analysis handler ─────────────────────────────────────────────────────

async function handleAnalysis(payload) {
  const { cv_text, linkedin_url, input_name } = payload;

  // Save loading state immediately
  await setState({
    status: "loading",
    input: input_name || "",
    startedAt: Date.now(),
    result: null,
    error: null,
  });

  // Get API key
  const stored = await new Promise(r => chrome.storage.local.get("tt_api_key", d => r(d)));
  const apiKey = stored.tt_api_key;

  if (!apiKey) {
    await setState({ status: "error", error: "NO_API_KEY" });
    throw new Error("NO_API_KEY");
  }

  try {
    const response = await fetch(`${API_BASE}/api/v1/analyze/candidate`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-API-Key": apiKey,
      },
      body: JSON.stringify({ cv_text, linkedin_url }),
      signal: AbortSignal.timeout(120000), // 2 min timeout
    });

    const data = await response.json();

    if (!response.ok) {
      const errCode = response.status === 402 ? "NO_CREDITS"
        : response.status === 401 ? "INVALID_KEY"
        : data.error || "ANALYSIS_FAILED";
      await setState({ status: "error", error: errCode, finishedAt: Date.now() });
      throw new Error(errCode);
    }

    // Save completed state
    await setState({
      status: "completed",
      result: data.report,
      meta: data.meta,
      finishedAt: Date.now(),
    });

    return data;

  } catch (err) {
    if (err.message !== "NO_CREDITS" && err.message !== "INVALID_KEY" && err.message !== "NO_API_KEY") {
      await setState({ status: "error", error: "ANALYSIS_FAILED", finishedAt: Date.now() });
    }
    throw err;
  }
}
