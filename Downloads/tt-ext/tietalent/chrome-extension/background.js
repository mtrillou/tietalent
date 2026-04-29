// TieTalent Chrome Extension — Background Service Worker
// Handles API calls and stores state

const API_BASE = "https://tietalent.vercel.app"; 

chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
  if (message.type === "ANALYZE_CANDIDATE") {
    handleAnalyze(message.payload).then(sendResponse).catch(err => {
      sendResponse({ error: err.message });
    });
    return true; // Keep channel open for async
  }

  if (message.type === "GET_API_KEY") {
    chrome.storage.local.get("tt_api_key", (data) => {
      sendResponse({ api_key: data.tt_api_key || null });
    });
    return true;
  }

  if (message.type === "SAVE_API_KEY") {
    chrome.storage.local.set({ tt_api_key: message.key }, () => {
      sendResponse({ ok: true });
    });
    return true;
  }

  if (message.type === "CLEAR_API_KEY") {
    chrome.storage.local.remove("tt_api_key", () => {
      sendResponse({ ok: true });
    });
    return true;
  }
});

async function handleAnalyze(payload) {
  const { cv_text, linkedin_url } = payload;

  // Get stored API key
  const stored = await chrome.storage.local.get("tt_api_key");
  const apiKey = stored.tt_api_key;

  if (!apiKey) {
    throw new Error("NO_API_KEY");
  }

  const response = await fetch(`${API_BASE}/api/v1/analyze/candidate`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-API-Key": apiKey,
    },
    body: JSON.stringify({ cv_text, linkedin_url }),
  });

  const data = await response.json();

  if (!response.ok) {
    if (response.status === 402) throw new Error("NO_CREDITS");
    if (response.status === 401) throw new Error("INVALID_KEY");
    throw new Error(data.error || "Analysis failed");
  }

  return data;
}
