// TieTalent Scout — Popup v4 (stateful)

const API_BASE = "https://tietalent.vercel.app";
const LOADING_STEPS = [
  "Analyzing profile…",
  "Detecting signals…",
  "Building intelligence…",
  "Assessing credibility…",
  "Finalizing report…",
];

let currentTab = null;
let stepTimer = null;
let stepIdx = 0;

// ── Screen manager ────────────────────────────────────────────────────────────

function show(id) {
  document.querySelectorAll(".screen").forEach(s => s.classList.remove("active"));
  document.getElementById("screen-" + id).classList.add("active");
}

// ── Init: read persisted state first ─────────────────────────────────────────

chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
  currentTab = tabs[0];

  chrome.storage.local.get("tt_api_key", (keyData) => {
    if (!keyData.tt_api_key) { show("connect"); return; }

    // Restore state
    chrome.runtime.sendMessage({ type: "GET_STATE" }, (state) => {
      if (!state || state.status === "idle") {
        initMain(keyData.tt_api_key);
      } else if (state.status === "loading") {
        restoreLoading(state, keyData.tt_api_key);
      } else if (state.status === "completed") {
        restoreResult(state);
      } else if (state.status === "error") {
        restoreError(state, keyData.tt_api_key);
      } else {
        initMain(keyData.tt_api_key);
      }
    });
  });
});

// ── State restoration ─────────────────────────────────────────────────────────

function restoreLoading(state, apiKey) {
  const elapsed = Date.now() - (state.startedAt || Date.now());
  const elapsedSteps = Math.min(Math.floor(elapsed / 5000), LOADING_STEPS.length - 1);

  document.getElementById("loading-name").textContent =
    state.input ? `Analyzing "${state.input}"…` : "Building intelligence report…";

  stepIdx = elapsedSteps;
  document.getElementById("loading-step").textContent = LOADING_STEPS[stepIdx];
  show("loading");

  // Restore any already-arrived quick signal or live signals
  if (state.quickSignal) renderQuickSignal(state.quickSignal);
  if (state.liveSignals && state.liveSignals.length > 0) {
    renderLiveSignals(state.liveSignals, elapsed);
  }

  // Keep cycling steps
  stepTimer = setInterval(() => {
    stepIdx = Math.min(stepIdx + 1, LOADING_STEPS.length - 1);
    document.getElementById("loading-step").textContent = LOADING_STEPS[stepIdx];
  }, 5000);

  // Poll for completion and new signals
  pollForResult(apiKey);
}

function renderQuickSignal(q) {
  let el = document.getElementById("quick-signal-badge");
  if (!el) {
    el = document.createElement("div");
    el.id = "quick-signal-badge";
    el.style.cssText = "margin:10px 0 6px;padding:9px 12px;border-radius:6px;display:flex;align-items:center;gap:9px;animation:fadeIn 0.4s ease;";
    const loadingWrap = document.querySelector(".loading-wrap");
    if (loadingWrap) loadingWrap.appendChild(el);
  }
  const colors = { Green: { bg:"#ECFDF5", border:"#A7F3D0", color:"#059669" }, Orange: { bg:"#FFFBEB", border:"#FDE68A", color:"#D97706" }, Red: { bg:"#FEF2F2", border:"#FECACA", color:"#DC2626" } };
  const cfg = colors[q.quick_signal] || colors.Orange;
  el.style.background = cfg.bg;
  el.style.border = `1px solid ${cfg.border}`;
  el.innerHTML = `<span style="font-size:14px;flex-shrink:0">${q.quick_signal === "Green" ? "🟢" : q.quick_signal === "Red" ? "🔴" : "🟡"}</span><div><p style="font-size:9px;font-weight:700;color:${cfg.color};text-transform:uppercase;letter-spacing:0.5px;margin-bottom:2px;">Preliminary signal</p><p style="font-size:11px;color:#111827;line-height:1.45;">${q.quick_reason}</p></div>`;
}

let signalDripTimers = [];
let shownSignalCount = 0;

function renderLiveSignals(signals, elapsedMs = 0) {
  // Clear any pending drip timers
  signalDripTimers.forEach(t => clearTimeout(t));
  signalDripTimers = [];

  let container = document.getElementById("live-signals-container");
  if (!container) {
    container = document.createElement("div");
    container.id = "live-signals-container";
    container.style.cssText = "margin-top:8px;display:flex;flex-direction:column;gap:6px;";
    const loadingWrap = document.querySelector(".loading-wrap");
    if (loadingWrap) loadingWrap.appendChild(container);
  }

  // Figure out how many should already be visible based on elapsed time
  // First signal at 8s, then every 12s
  const alreadyVisible = Math.max(0, Math.floor((elapsedMs - 8000) / 12000) + 1);

  signals.forEach((sig, i) => {
    if (i < alreadyVisible) {
      appendSignalCard(container, sig, false);
    } else {
      const delay = Math.max(0, (8000 + i * 12000) - elapsedMs);
      const t = setTimeout(() => appendSignalCard(container, sig, true), delay);
      signalDripTimers.push(t);
    }
  });
}

function appendSignalCard(container, sig, animate) {
  const card = document.createElement("div");
  card.style.cssText = `padding:8px 11px;border-radius:5px;display:flex;gap:8px;align-items:flex-start;border:1px solid ${sig.confidence === "High" ? "#A7F3D0" : sig.confidence === "Low" ? "#E5E7EB" : "#FDE68A"};background:${sig.confidence === "High" ? "#F0FDF4" : sig.confidence === "Low" ? "#F9FAFB" : "#FEFCE8"};${animate ? "animation:fadeIn 0.5s ease;" : ""}`;
  card.innerHTML = `<span style="font-size:10px;flex-shrink:0;margin-top:2px;color:${sig.confidence === "High" ? "#059669" : sig.confidence === "Low" ? "#9CA3AF" : "#D97706"};">${sig.confidence === "High" ? "●" : sig.confidence === "Low" ? "○" : "◐"}</span><p style="font-size:11px;color:#111827;line-height:1.5;">${sig.content}</p>`;
  container.appendChild(card);
}

function pollForResult(apiKey) {
  const poll = setInterval(() => {
    chrome.runtime.sendMessage({ type: "GET_STATE" }, (state) => {
      if (!state) return;

      // Update quick signal if it just arrived
      if (state.quickSignal) renderQuickSignal(state.quickSignal);

      // Update live signals if new ones arrived
      if (state.liveSignals && state.liveSignals.length > 0) {
        const elapsed = Date.now() - (state.startedAt || Date.now());
        renderLiveSignals(state.liveSignals, elapsed);
      }

      if (state.status === "loading") return; // still running
      clearInterval(poll);
      clearInterval(stepTimer);
      signalDripTimers.forEach(t => clearTimeout(t));
      if (state.status === "completed") {
        restoreResult(state);
      } else if (state.status === "error") {
        restoreError(state, apiKey);
      }
    });
  }, 1500);
}

function restoreResult(state) {
  if (state.result) {
    renderResult(state.result, state.input || "");
    loadCredits(); // refresh credits after analysis
  } else {
    initMain();
  }
}

function restoreError(state, apiKey) {
  clearInterval(stepTimer);
  const err = state.error;
  if (err === "NO_CREDITS") { show("nocredits"); }
  else if (err === "INVALID_KEY") { chrome.storage.local.remove("tt_api_key"); show("connect"); }
  else { initMain(apiKey); } // generic error — back to main
}

// ── Main screen ───────────────────────────────────────────────────────────────

function initMain(apiKey) {
  show("main");
  autoDetectName();
  if (apiKey) loadCredits(apiKey);
  else chrome.storage.local.get("tt_api_key", d => d.tt_api_key && loadCredits(d.tt_api_key));
}

// ── Name detection (URL-only, no page title) ──────────────────────────────────

const REJECTED_TERMS = new Set([
  "home","dashboard","welcome","login","signin","signup","register","profile",
  "settings","account","feed","news","explore","trending","search","results",
  "error","404","403","page","loading","untitled",
]);

function looksLikeFullName(str) {
  const words = str.trim().split(/\s+/);
  if (words.length < 2 || words.length > 4) return false;
  return words.every(w => /^[A-ZÀ-ÖØ-Ý][a-zà-öø-ý'\-]{1,}$/.test(w));
}

function looksLikeUsername(str) {
  return /^@?[a-zA-Z0-9][a-zA-Z0-9_\-.]{2,29}$/.test(str);
}

function isRejected(str) {
  return REJECTED_TERMS.has(str.toLowerCase().trim());
}

function autoDetectName() {
  if (!currentTab) return;
  const url = currentTab.url || "";
  const input = document.getElementById("name-input");
  const hint = document.getElementById("name-hint");
  let name = "", source = "";

  if (url.includes("linkedin.com/in/")) {
    const match = url.match(/linkedin\.com\/in\/([^\/\?#]+)/);
    if (match && match[1]) {
      const slug = match[1].replace(/-\d+$/, "");
      const candidate = slug.split("-").map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(" ");
      if (looksLikeFullName(candidate) && !isRejected(candidate)) { name = candidate; source = "LinkedIn"; }
    }
  } else if (url.includes("github.com/")) {
    const match = url.match(/github\.com\/([^\/\?#]+)/);
    const ex = ["login","signup","explore","trending","features","pricing","about","orgs","marketplace"];
    if (match && match[1] && !ex.includes(match[1].toLowerCase())) {
      const h = "@" + match[1];
      if (looksLikeUsername(h)) { name = h; source = "GitHub"; }
    }
  } else if (url.includes("twitter.com/") || url.includes("x.com/")) {
    const match = url.match(/(?:twitter|x)\.com\/([^\/\?#]+)/);
    const ex = ["home","explore","notifications","messages","i","settings","login","signup","intent"];
    if (match && match[1] && !ex.includes(match[1].toLowerCase())) {
      const h = "@" + match[1];
      if (looksLikeUsername(h)) { name = h; source = "Twitter/X"; }
    }
  } else if (url.includes("malt.fr/profile/") || url.includes("malt.com/profile/")) {
    const match = url.match(/\/profile\/([^\/\?#]+)/);
    if (match && match[1]) {
      const candidate = match[1].split("-").map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(" ");
      if (looksLikeFullName(candidate) && !isRejected(candidate)) { name = candidate; source = "Malt"; }
    }
  } else if (url.includes("toptal.com/resume/")) {
    const match = url.match(/\/resume\/([^\/\?#]+)/);
    if (match && match[1]) {
      const candidate = match[1].split("-").map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(" ");
      if (looksLikeFullName(candidate) && !isRejected(candidate)) { name = candidate; source = "Toptal"; }
    }
  }

  if (name && !isRejected(name)) {
    input.value = name;
    input.classList.add("auto-filled");
    hint.textContent = "✓ Detected from " + source + " — edit if needed";
    hint.className = "input-hint detected";
  } else {
    hint.textContent = "Works with any name, @handle, or username";
    hint.className = "input-hint";
  }
}

document.getElementById("name-input").addEventListener("input", function() {
  this.classList.remove("auto-filled");
  document.getElementById("name-hint").className = "input-hint";
  document.getElementById("name-hint").textContent = "";
  document.getElementById("main-error").style.display = "none";
});

// ── Credits ───────────────────────────────────────────────────────────────────

function loadCredits(apiKey) {
  const label = document.getElementById("credits-label");
  const buyLink = document.getElementById("buy-link");
  const analyzeBtn = document.getElementById("analyze-btn");

  fetch(API_BASE + "/api/credits", { credentials: "include", headers: { "X-API-Key": apiKey } })
    .then(r => r.json())
    .then(d => {
      const total = d.totalAvailable ?? 0;
      const free = d.freeRemaining ?? 0;
      const paid = d.paidBalance ?? 0;
      if (total === 0) {
        label.textContent = "No credits remaining";
        label.className = "credits-label empty";
        buyLink.style.display = "inline";
        if (analyzeBtn) analyzeBtn.disabled = true;
      } else if (free > 0 && paid > 0) {
        label.textContent = `${total} credits (${free} free + ${paid} paid)`;
        label.className = "credits-label ok";
      } else if (free > 0) {
        label.textContent = `${free} free credit${free !== 1 ? "s" : ""} today`;
        label.className = free <= 1 ? "credits-label warn" : "credits-label ok";
      } else {
        label.textContent = `${paid} paid credit${paid !== 1 ? "s" : ""}`;
        label.className = "credits-label ok";
      }
    })
    .catch(() => { if (label) { label.textContent = "—"; label.className = "credits-label"; } });
}

document.getElementById("buy-link").addEventListener("click", () => {
  chrome.tabs.create({ url: API_BASE + "/en/pricing" });
});

// ── Analyze ───────────────────────────────────────────────────────────────────

document.getElementById("analyze-btn").addEventListener("click", () => {
  const nameVal = document.getElementById("name-input").value.trim();
  const errEl = document.getElementById("main-error");
  if (nameVal.length < 3) { errEl.style.display = "block"; document.getElementById("name-input").focus(); return; }
  errEl.style.display = "none";

  chrome.storage.local.get("tt_api_key", (d) => {
    if (!d.tt_api_key) { show("connect"); return; }
    startAnalysis(nameVal, d.tt_api_key);
  });
});

function startAnalysis(nameInput, apiKey) {
  // Show loading immediately
  document.getElementById("loading-name").textContent = `Analyzing "${nameInput}"…`;
  stepIdx = 0;
  document.getElementById("loading-step").textContent = LOADING_STEPS[0];
  show("loading");
  clearInterval(stepTimer);
  stepTimer = setInterval(() => {
    stepIdx = Math.min(stepIdx + 1, LOADING_STEPS.length - 1);
    document.getElementById("loading-step").textContent = LOADING_STEPS[stepIdx];
  }, 5000);

  // Build cv_text: get page text if on a profile page, else use name
  const url = currentTab ? currentTab.url : "";
  const isProfile = url && (
    url.includes("linkedin.com/in/") || url.includes("github.com/") ||
    url.includes("twitter.com/") || url.includes("x.com/") ||
    url.includes("malt.") || url.includes("toptal.com")
  );

  function sendToBackground(pageText) {
    const cvText = pageText && pageText.length > 100
      ? pageText
      : `Candidate name/identifier: ${nameInput}\n\nContext URL: ${url}`;

    // Send to background — it will persist and run even if popup closes
    chrome.runtime.sendMessage({
      type: "ANALYZE_CANDIDATE",
      payload: { cv_text: cvText, linkedin_url: url, input_name: nameInput }
    }, (result) => {
      clearInterval(stepTimer);
      if (chrome.runtime.lastError || !result) { initMain(apiKey); return; }
      if (result.error) {
        if (result.error === "NO_CREDITS") { show("nocredits"); return; }
        if (result.error === "INVALID_KEY") { chrome.storage.local.remove("tt_api_key"); show("connect"); return; }
        initMain(apiKey); return;
      }
      renderResult(result.report, nameInput);
      loadCredits(apiKey);
    });
  }

  if (isProfile && currentTab) {
    chrome.tabs.sendMessage(currentTab.id, { type: "GET_PAGE_TEXT" }, (resp) => {
      sendToBackground((resp && resp.text) || "");
    });
  } else {
    sendToBackground("");
  }
}

// ── Render result ─────────────────────────────────────────────────────────────

function renderResult(report, inputName) {
  show("result");
  const decisionColors = {
    "Strong Proceed":          { color: "#059669", bg: "#ECFDF5" },
    "Proceed":                 { color: "#059669", bg: "#ECFDF5" },
    "Proceed with Validation": { color: "#D97706", bg: "#FFFBEB" },
    "Neutral":                 { color: "#6B7280", bg: "#F3F4F6" },
    "Caution":                 { color: "#EA580C", bg: "#FFF7ED" },
    "High Risk":               { color: "#DC2626", bg: "#FEF2F2" },
  };
  const sig = report.recruiter_signal || {};
  const dc = decisionColors[sig.decision] || decisionColors["Neutral"];
  const badge = document.getElementById("result-badge");
  badge.textContent = sig.decision || "Analyzed";
  badge.style.color = dc.color;
  badge.style.background = dc.bg;
  document.getElementById("result-name").textContent = report.candidate_name || inputName;
  document.getElementById("result-summary").textContent = report.external_profile_summary || sig.reasoning || "";
  const drivers = report.top_decision_drivers || [];
  document.getElementById("result-drivers").innerHTML = drivers.slice(0, 3)
    .map((d, i) => `<div class="driver"><span class="driver-num">${i+1}</span>${d}</div>`).join("");
}

document.getElementById("view-btn").addEventListener("click", () => {
  chrome.tabs.create({ url: API_BASE + "/en/report" });
});

document.getElementById("again-btn").addEventListener("click", () => {
  clearInterval(stepTimer);
  chrome.runtime.sendMessage({ type: "RESET_STATE" }, () => {
    document.getElementById("name-input").value = "";
    document.getElementById("name-input").classList.remove("auto-filled");
    document.getElementById("name-hint").textContent = "";
    chrome.storage.local.get("tt_api_key", d => initMain(d.tt_api_key));
  });
});

// ── No credits ────────────────────────────────────────────────────────────────

document.getElementById("buy-btn").addEventListener("click", () => chrome.tabs.create({ url: API_BASE + "/en/pricing" }));
document.getElementById("nocredits-back").addEventListener("click", () => {
  chrome.runtime.sendMessage({ type: "RESET_STATE" }, () => chrome.storage.local.get("tt_api_key", d => initMain(d.tt_api_key)));
});

// ── Connect screen ────────────────────────────────────────────────────────────

document.getElementById("connect-btn").addEventListener("click", () => {
  const key = document.getElementById("key-input").value.trim();
  const err = document.getElementById("key-error");
  if (!key.startsWith("tt_") || key.length < 10) { err.style.display = "block"; return; }
  err.style.display = "none";
  chrome.storage.local.set({ tt_api_key: key }, () => initMain(key));
});

document.getElementById("get-key-btn").addEventListener("click", () => chrome.tabs.create({ url: API_BASE + "/en/settings" }));

// ── Settings ──────────────────────────────────────────────────────────────────

document.getElementById("settings-toggle").addEventListener("click", () => {
  chrome.storage.local.get("tt_api_key", (d) => {
    const key = d.tt_api_key || "";
    document.getElementById("settings-key").textContent = key ? key.slice(0, 7) + "••••••••" + key.slice(-4) : "Not connected";
    show("settings");
  });
});

document.getElementById("settings-back").addEventListener("click", () => {
  chrome.storage.local.get("tt_api_key", d => d.tt_api_key ? initMain(d.tt_api_key) : show("connect"));
});

document.getElementById("open-dashboard").addEventListener("click", () => chrome.tabs.create({ url: API_BASE + "/en/settings" }));
document.getElementById("disconnect-btn").addEventListener("click", () => {
  chrome.storage.local.remove(["tt_api_key", "tt_state"], () => show("connect"));
});
