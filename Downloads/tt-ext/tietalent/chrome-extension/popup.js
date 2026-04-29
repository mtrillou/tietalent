// TieTalent Chrome Extension — Popup Script

const API_BASE = "https://tietalent.vercel.app"; 

const noKeySection     = document.getElementById("no-key-section");
const connectedSection = document.getElementById("connected-section");
const keyInput         = document.getElementById("key-input");
const keyError         = document.getElementById("key-error");
const saveKeyBtn       = document.getElementById("save-key-btn");
const removeKeyBtn     = document.getElementById("remove-key-btn");
const generateKeyBtn   = document.getElementById("generate-key-btn");
const creditsCount     = document.getElementById("credits-count");
const creditsSub       = document.getElementById("credits-sub");
const keyDisplay       = document.getElementById("key-display");

// ── Init ─────────────────────────────────────────────────────────────────────
chrome.storage.local.get("tt_api_key", (data) => {
  if (data.tt_api_key) {
    showConnected(data.tt_api_key);
  } else {
    noKeySection.style.display = "block";
  }
});

// ── Save key ─────────────────────────────────────────────────────────────────
saveKeyBtn.addEventListener("click", () => {
  const key = keyInput.value.trim();
  if (!key.startsWith("tt_") || key.length < 10) {
    keyError.textContent = "Invalid key format — must start with tt_";
    keyError.style.display = "block";
    return;
  }
  keyError.style.display = "none";
  chrome.storage.local.set({ tt_api_key: key }, () => {
    showConnected(key);
  });
});

// ── Remove key ───────────────────────────────────────────────────────────────
removeKeyBtn.addEventListener("click", () => {
  chrome.storage.local.remove("tt_api_key", () => {
    connectedSection.style.display = "none";
    noKeySection.style.display = "block";
    keyInput.value = "";
  });
});

// ── Generate new key (opens TieTalent settings) ───────────────────────────────
generateKeyBtn.addEventListener("click", () => {
  chrome.tabs.create({ url: `${API_BASE}/en/settings` });
});

// ── Show connected state ──────────────────────────────────────────────────────
async function showConnected(key) {
  noKeySection.style.display = "none";
  connectedSection.style.display = "block";

  // Mask key for display: tt_xxxx...xxxx
  const masked = key.slice(0, 7) + "•".repeat(8) + key.slice(-4);
  keyDisplay.textContent = masked;

  // Fetch credits
  try {
    const res = await fetch(`${API_BASE}/api/credits`, {
      headers: { "X-API-Key": key },
    });
    if (res.ok) {
      const data = await res.json();
      const total = data.totalAvailable ?? 0;
      const free = data.freeRemaining ?? 0;
      const paid = data.paidBalance ?? 0;
      creditsCount.textContent = total;
      creditsCount.style.color = total === 0 ? "#DC2626" : total <= 2 ? "#D97706" : "#059669";
      if (free > 0 && paid > 0) {
        creditsSub.textContent = `${free} free today + ${paid} paid`;
      } else if (free > 0) {
        creditsSub.textContent = `${free} free resets daily`;
      } else if (paid > 0) {
        creditsSub.textContent = `${paid} paid credits`;
      } else {
        creditsSub.textContent = "No credits — buy more to continue";
        creditsSub.style.color = "#DC2626";
      }
    } else {
      creditsCount.textContent = "—";
      creditsSub.textContent = "Could not load credits";
    }
  } catch {
    creditsCount.textContent = "—";
    creditsSub.textContent = "Offline";
  }
}
