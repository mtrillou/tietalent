// TieTalent Chrome Extension — Content Script v2

(function () {
  if (document.getElementById("tt-ext-root")) return;

  // Only activate on profile/candidate pages
  function isProfilePage() {
    const url = window.location.href;
    const hostname = window.location.hostname;
    // LinkedIn profile pages
    if (hostname.includes("linkedin.com")) {
      return url.includes("/in/") || url.includes("/pub/");
    }
    // Indeed, Glassdoor resume pages
    if (hostname.includes("indeed.com")) return url.includes("/r/") || url.includes("/resume/");
    if (hostname.includes("glassdoor.com")) return url.includes("/profile/") || url.includes("/resume/");
    // Welcome3, Malt, other talent platforms
    if (hostname.includes("welcome.io") || hostname.includes("malt.") || hostname.includes("toptal.com")) return true;
    // Generic: if URL has common profile patterns
    return url.includes("/profile/") || url.includes("/candidate/") || url.includes("/talent/") || url.includes("/cv/");
  }

  if (!isProfilePage()) return; // Exit early if not a profile page

  // ── Page text extraction ─────────────────────────────────────────────────
  function extractPageText() {
    const main = document.querySelector(".scaffold-layout__main, main, [role='main']");
    if (main) return main.innerText.replace(/\s{3,}/g, "\n\n").trim().slice(0, 8000);
    const clone = document.body.cloneNode(true);
    clone.querySelectorAll("nav,footer,header,script,style,noscript,[role='navigation'],[role='banner']").forEach(e => e.remove());
    return clone.innerText.replace(/\s{3,}/g, "\n\n").trim().slice(0, 8000);
  }

  function detectLinkedInUrl() {
    return window.location.hostname.includes("linkedin.com") ? window.location.href : undefined;
  }

  function isLinkedIn() {
    return window.location.hostname.includes("linkedin.com");
  }

  // ── Detect candidate name ────────────────────────────────────────────────
  function detectCandidate() {
    const title = document.title || "";
    let name = "", meta = "";

    if (isLinkedIn()) {
      name = title.replace(/\s*[|\u2013\u2014-].*$/, "").trim();
      if (name.toLowerCase() === "linkedin" || name.toLowerCase() === "feed") name = "";
      const headline = document.querySelector(".text-body-medium.break-words, .pv-text-details__left-panel .mt2 .text-body-medium");
      meta = headline ? headline.innerText.trim().slice(0, 80) : "";
    } else {
      const og = document.querySelector("meta[property='og:title']");
      name = og ? (og.getAttribute("content") || "").replace(/\s*[|\u2013-].*$/, "").trim() : "";
      if (!name) { const h1 = document.querySelector("h1"); if (h1) name = h1.innerText.trim().slice(0, 60); }
      meta = window.location.hostname;
    }
    return { name, meta };
  }

  // ── LinkedIn inline button (next to candidate name) ──────────────────────
  let linkedInBtnInjected = false;

  function injectLinkedInButton() {
    if (linkedInBtnInjected) return;
    // Try to find the name heading on a LinkedIn profile
    const nameEl = document.querySelector("h1.text-heading-xlarge, h1.inline, .pv-top-card--list h1");
    if (!nameEl) return;

    const btn = document.createElement("button");
    btn.id = "tt-li-btn";
    btn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="flex-shrink:0"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/><path d="M21 21l-4-4" stroke="white" stroke-width="2" stroke-linecap="round"/></svg> Intelligence`;
    btn.title = "TieTalent — Analyze this candidate";
    btn.style.cssText = `
      display:inline-flex;align-items:center;gap:5px;
      padding:5px 12px;margin-left:10px;vertical-align:middle;
      background:linear-gradient(135deg,#E8303A,#C9242D);
      color:white;border:none;border-radius:20px;
      font-size:12px;font-weight:700;font-family:inherit;
      cursor:pointer;letter-spacing:0.2px;
      box-shadow:0 2px 8px rgba(232,48,58,0.4);
      transition:transform 0.15s,box-shadow 0.15s;
    `;
    btn.addEventListener("mouseenter", () => { btn.style.transform = "translateY(-1px)"; btn.style.boxShadow = "0 4px 14px rgba(232,48,58,0.5)"; });
    btn.addEventListener("mouseleave", () => { btn.style.transform = ""; btn.style.boxShadow = "0 2px 8px rgba(232,48,58,0.4)"; });
    btn.addEventListener("click", (e) => { e.stopPropagation(); openSidebar(); });

    nameEl.parentNode.insertBefore(btn, nameEl.nextSibling);
    linkedInBtnInjected = true;
  }

  // ── Floating fallback button (non-LinkedIn or if inline fails) ───────────
  const floatBtn = document.createElement("div");
  floatBtn.id = "tt-ext-trigger";
  floatBtn.innerHTML = `
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" style="flex-shrink:0">
      <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2.2"/>
      <path d="M21 21l-4-4" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
    </svg>
    <span>Intelligence</span>
  `;
  floatBtn.title = "TieTalent Intelligence — Analyze this candidate";
  document.body.appendChild(floatBtn);
  floatBtn.addEventListener("click", () => openSidebar());

  // On LinkedIn, try to inject inline button and hide the float btn
  if (isLinkedIn()) {
    floatBtn.style.display = "none";
    // Try immediately and also after a delay for SPA navigation
    setTimeout(() => { injectLinkedInButton(); if (!linkedInBtnInjected) floatBtn.style.display = "flex"; }, 1500);
    setTimeout(() => { injectLinkedInButton(); if (!linkedInBtnInjected) floatBtn.style.display = "flex"; }, 3000);
  }

  // ── Sidebar ──────────────────────────────────────────────────────────────
  const root = document.createElement("div");
  root.id = "tt-ext-root";
  root.innerHTML = `
    <div id="tt-sidebar">
      <div id="tt-header">
        <div style="display:flex;align-items:center;gap:9px;">
          <div style="width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#1A1A2E,#2D2D4E);border:1px solid rgba(232,48,58,0.5);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <div style="width:8px;height:8px;border-radius:50%;background:#E8303A;"></div>
          </div>
          <div>
            <div style="font-weight:700;font-size:13px;color:#fff;letter-spacing:-0.2px;">TieTalent Intelligence</div>
            <div style="font-size:10px;color:#9CA3AF;">Candidate Intelligence</div>
          </div>
        </div>
        <button id="tt-close" title="Close">&#x2715;</button>
      </div>

      <div id="tt-auth-section" style="display:none;">
        <div style="padding:20px 16px;">
          <div style="padding:12px;background:#FFF7ED;border:1px solid #FED7AA;border-radius:8px;margin-bottom:14px;">
            <p style="font-size:12px;color:#92400E;line-height:1.5;">Enter your TieTalent API key to unlock candidate intelligence from any page.</p>
          </div>
          <input id="tt-api-input" type="password" placeholder="tt_xxxxxxxxxxxxxxxx" />
          <button id="tt-save-key" class="tt-btn-primary">Connect Account</button>
          <a href="http://localhost:3000/en/settings" target="_blank" style="font-size:11px;color:#E8303A;display:block;margin-top:10px;text-align:center;text-decoration:none;">Get your free API key &rarr;</a>
        </div>
      </div>

      <div id="tt-ready-section" style="display:none;">
        <div id="tt-credits-bar">
          <span id="tt-credits-text">&#x26A1; Loading...</span>
          <button id="tt-change-key" style="font-size:10px;color:#9CA3AF;background:none;border:none;cursor:pointer;padding:0;">Disconnect</button>
        </div>
        <div style="padding:14px 16px 16px;">
          <div id="tt-candidate-preview" style="display:none;padding:11px 13px;background:linear-gradient(135deg,#F9FAFB,#F3F4F6);border:1px solid #E5E7EB;border-radius:9px;margin-bottom:12px;">
            <div style="font-size:9px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.8px;margin-bottom:4px;">Candidate detected</div>
            <div id="tt-candidate-name" style="font-size:14px;font-weight:700;color:#1A1A2E;"></div>
            <div id="tt-candidate-meta" style="font-size:11px;color:#6B7280;margin-top:3px;"></div>
          </div>
          <button id="tt-analyze" class="tt-btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-right:6px"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2.2"/><path d="M21 21l-4-4" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg>
            Run Intelligence
          </button>
          <p style="font-size:10px;color:#9CA3AF;text-align:center;margin-top:7px;">1 credit &middot; ~20 seconds &middot; 14 sources</p>
        </div>
      </div>

      <div id="tt-loading" style="display:none;flex-direction:column;align-items:center;padding:40px 24px;text-align:center;">
        <div class="tt-spinner"></div>
        <p style="font-size:13px;color:#374151;margin-top:16px;font-weight:600;">Building intelligence report...</p>
        <p style="font-size:11px;color:#9CA3AF;margin-top:5px;">This usually takes 20–30 seconds</p>
      </div>

      <div id="tt-results" style="display:none;flex:1;overflow-y:auto;"></div>
      <div id="tt-error" style="display:none;"></div>
    </div>
  `;
  document.body.appendChild(root);

  const sidebar          = document.getElementById("tt-sidebar");
  const authSec          = document.getElementById("tt-auth-section");
  const readySec         = document.getElementById("tt-ready-section");
  const loading          = document.getElementById("tt-loading");
  const results          = document.getElementById("tt-results");
  const errorDiv         = document.getElementById("tt-error");
  const apiInput         = document.getElementById("tt-api-input");
  const creditsText      = document.getElementById("tt-credits-text");
  const candidatePreview = document.getElementById("tt-candidate-preview");
  const candidateName    = document.getElementById("tt-candidate-name");
  const candidateMeta    = document.getElementById("tt-candidate-meta");

  let isOpen = false, pageText = "", detectedName = "";

  function openSidebar() {
    isOpen = true;
    sidebar.classList.add("tt-open");

    const candidate = detectCandidate();
    detectedName = candidate.name;
    pageText = extractPageText();

    if (detectedName) {
      candidateName.textContent = detectedName;
      candidateMeta.textContent = candidate.meta;
      candidatePreview.style.display = "block";
    } else {
      candidatePreview.style.display = "none";
    }

    chrome.runtime.sendMessage({ type: "GET_API_KEY" }, (res) => {
      if (!res || !res.api_key) {
        authSec.style.display = "block";
        readySec.style.display = "none";
        return;
      }

      loadCredits(res.api_key);

      // Check if a prior report exists
      chrome.storage.local.get(["tt_last_report", "tt_report_history"], (stored) => {
        const lastReport = stored.tt_last_report ? JSON.parse(stored.tt_last_report) : null;
        const history = stored.tt_report_history || [];

        if (lastReport) {
          // Show decision screen: run for current profile + links to past reports
          showReadyWithHistory(lastReport, history);
        } else {
          // No prior report — auto-run immediately
          runAnalysis();
        }
      });
    });
  }

  function showReadyWithHistory(lastReport, history) {
    authSec.style.display = "none";
    results.style.display = "none";
    loading.style.display = "none";
    errorDiv.style.display = "none";

    const candidateLabel = detectedName || "this profile";
    const lastName = lastReport.candidate_name || "Previous candidate";
    const API_BASE = "https://tietalent.vercel.app";

    // Build history links (last 5 excluding current if same name)
    const historyItems = history
      .filter(h => h.name !== detectedName)
      .slice(0, 5);

    let historyHtml = "";
    if (historyItems.length > 0) {
      historyHtml = `
        <div style="margin-top:14px;padding-top:12px;border-top:1px solid #F3F4F6;">
          <p style="font-size:9px;font-weight:700;color:#9CA3AF;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">Previous reports</p>
          ${historyItems.map(h => `
            <a href="${API_BASE}/en/history" target="_blank"
               style="display:flex;align-items:center;justify-content:space-between;padding:8px 10px;border-radius:6px;border:1px solid #E5E7EB;background:#F9FAFB;margin-bottom:6px;text-decoration:none;cursor:pointer;">
              <div>
                <p style="font-size:12px;font-weight:600;color:#00126B;">${h.name}</p>
                <p style="font-size:10px;color:#9CA3AF;">${h.date || ""}</p>
              </div>
              <span style="font-size:11px;color:#FF1F48;font-weight:600;">View →</span>
            </a>
          `).join("")}
          <a href="${API_BASE}/en/history" target="_blank"
             style="display:block;text-align:center;font-size:11px;color:#9CA3AF;text-decoration:none;margin-top:4px;">
            See all reports →
          </a>
        </div>`;
    }

    readySec.innerHTML = `
      <div id="tt-credits-bar">
        <span id="tt-credits-text">⚡ Loading...</span>
        <button id="tt-change-key" style="font-size:10px;color:#9CA3AF;background:none;border:none;cursor:pointer;padding:0;">Disconnect</button>
      </div>
      <div style="padding:14px 16px 16px;">
        <button id="tt-analyze" class="tt-btn-primary" style="width:100%;margin-bottom:6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-right:6px"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2.2"/><path d="M21 21l-4-4" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg>
          Run Intelligence${detectedName ? ` for ${detectedName}` : ""}
        </button>
        <p style="font-size:10px;color:#9CA3AF;text-align:center;margin-bottom:0;">1 credit · ~30 seconds</p>
        ${historyHtml}
      </div>`;

    readySec.style.display = "block";

    // Re-bind analyze button
    document.getElementById("tt-analyze").addEventListener("click", () => runAnalysis());

    // Re-bind disconnect
    const changeKeyBtn = document.getElementById("tt-change-key");
    if (changeKeyBtn) {
      changeKeyBtn.addEventListener("click", () => {
        chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }, () => {
          readySec.style.display = "none";
          authSec.style.display = "block";
        });
      });
    }

    // Reload credits on new elements
    chrome.storage.local.get("tt_api_key", (d) => d.tt_api_key && loadCredits(d.tt_api_key));
  }

  function runAnalysis() {
    if (!pageText || pageText.length < 100) pageText = extractPageText();
    if (pageText.length < 100) {
      authSec.style.display = "none";
      readySec.style.display = "none";
      showError("Not enough text on this page. Try on a candidate profile.");
      return;
    }
    readySec.style.display = "none";
    authSec.style.display = "none";
    loading.style.display = "flex";
    results.style.display = "none";
    errorDiv.style.display = "none";

    chrome.runtime.sendMessage(
      { type: "ANALYZE_CANDIDATE", payload: { cv_text: pageText, linkedin_url: detectLinkedInUrl() } },
      (response) => {
        loading.style.display = "none";
        if (chrome.runtime.lastError || !response || response.error) {
          const err = (response && response.error) || (chrome.runtime.lastError && chrome.runtime.lastError.message) || "Unknown error";
          if (err === "NO_API_KEY") { authSec.style.display = "block"; return; }
          if (err === "NO_CREDITS") { showError('No credits remaining. <a href="http://localhost:3000/en/pricing" target="_blank" style="color:#E8303A;font-weight:600;">Buy credits &rarr;</a>'); return; }
          if (err === "INVALID_KEY") { chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }); showError("Invalid API key. Please reconnect."); authSec.style.display = "block"; return; }
          showError(err); readySec.style.display = "block"; return;
        }
        if (response.meta) {
          const rem = response.meta.remaining_credits;
          creditsText.textContent = "⚡ " + rem + " credit" + (rem !== 1 ? "s" : "") + " remaining";
          creditsText.style.color = rem === 0 ? "#DC2626" : rem <= 3 ? "#D97706" : "#059669";
        }
        renderResults(response.report, response.meta);
      }
    );
  }

  document.getElementById("tt-close").addEventListener("click", () => {
    isOpen = false; sidebar.classList.remove("tt-open");
  });

  function checkAuth() {
    chrome.runtime.sendMessage({ type: "GET_API_KEY" }, (res) => {
      if (res && res.api_key) { showReady(); loadCredits(res.api_key); }
      else { authSec.style.display = "block"; readySec.style.display = "none"; }
    });
  }

  function loadCredits(apiKey) {
    fetch("http://localhost:3000/api/credits", { headers: { "X-API-Key": apiKey } })
      .then(r => r.json()).then(d => {
        const total = d.totalAvailable ?? 0;
        creditsText.textContent = "\u26A1 " + total + " credit" + (total !== 1 ? "s" : "") + " remaining";
        creditsText.style.color = total === 0 ? "#DC2626" : total <= 3 ? "#D97706" : "#059669";
      }).catch(() => { creditsText.textContent = "\u26A1 —"; });
  }

  document.getElementById("tt-save-key").addEventListener("click", () => {
    const key = apiInput.value.trim();
    if (!key.startsWith("tt_")) { showError("Key must start with tt_"); return; }
    chrome.runtime.sendMessage({ type: "SAVE_API_KEY", key }, () => { showReady(); loadCredits(key); });
  });

  document.getElementById("tt-change-key").addEventListener("click", () => {
    chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }, () => {
      authSec.style.display = "block"; readySec.style.display = "none"; apiInput.value = "";
    });
  });

  function showReady() {
    authSec.style.display = "none"; readySec.style.display = "block";
    results.style.display = "none"; errorDiv.style.display = "none"; loading.style.display = "none";
  }

  document.getElementById("tt-analyze").addEventListener("click", () => {
    if (!pageText || pageText.length < 100) pageText = extractPageText();
    if (pageText.length < 100) { showError("Not enough text on this page. Try on a candidate profile."); return; }
    readySec.style.display = "none"; loading.style.display = "flex";
    results.style.display = "none"; errorDiv.style.display = "none";

    chrome.runtime.sendMessage(
      { type: "ANALYZE_CANDIDATE", payload: { cv_text: pageText, linkedin_url: detectLinkedInUrl() } },
      (response) => {
        loading.style.display = "none";
        if (chrome.runtime.lastError || !response || response.error) {
          const err = (response && response.error) || (chrome.runtime.lastError && chrome.runtime.lastError.message) || "Unknown error";
          if (err === "NO_API_KEY") { authSec.style.display = "block"; return; }
          if (err === "NO_CREDITS") { showError('No credits remaining. <a href="http://localhost:3000/en/pricing" target="_blank" style="color:#E8303A;font-weight:600;">Buy credits &rarr;</a>'); return; }
          if (err === "INVALID_KEY") { chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }); showError("Invalid API key. Please reconnect."); authSec.style.display = "block"; return; }
          showError(err); readySec.style.display = "block"; return;
        }
        if (response.meta) {
          const rem = response.meta.remaining_credits;
          creditsText.textContent = "\u26A1 " + rem + " credit" + (rem !== 1 ? "s" : "") + " remaining";
          creditsText.style.color = rem === 0 ? "#DC2626" : rem <= 3 ? "#D97706" : "#059669";
        }
        renderResults(response.report, response.meta);
      }
    );
  });

  function renderResults(report, meta) {
    // Save to history
    chrome.storage.local.get("tt_report_history", (stored) => {
      const history = stored.tt_report_history || [];
      const entry = {
        name: report.candidate_name || detectedName || "Unknown",
        date: new Date().toLocaleDateString("en-GB", { day: "numeric", month: "short", year: "numeric" }),
        alert: report.alert_level,
      };
      // Remove duplicate same name, prepend new entry, keep last 10
      const filtered = history.filter(h => h.name !== entry.name);
      chrome.storage.local.set({
        tt_last_report: JSON.stringify(report),
        tt_report_history: [entry, ...filtered].slice(0, 10),
      });
    });
    const alertCfg = {
      Green:  { bg: "#ECFDF5", color: "#059669", border: "#A7F3D0", label: "Clean" },
      Yellow: { bg: "#FFFBEB", color: "#D97706", border: "#FDE68A", label: "Review" },
      Orange: { bg: "#FFF7ED", color: "#EA580C", border: "#FED7AA", label: "Caution" },
      Red:    { bg: "#FEF2F2", color: "#DC2626", border: "#FECACA", label: "Flag" },
    };
    const al = alertCfg[report.alert_level] || alertCfg.Yellow;
    const verified   = (report.signals && report.signals.verified_signals)  || [];
    const weak       = (report.signals && report.signals.weak_signals)       || [];
    const unverified = (report.signals && report.signals.unverified_claims)  || [];
    const noData     = report.signals && report.signals.no_significant_external_data;

    var html =
      '<div style="padding:14px 16px;border-bottom:1px solid #E5E7EB;display:flex;align-items:flex-start;justify-content:space-between;gap:10px;">'
      + '<div style="flex:1;">'
      + '<div style="font-weight:700;font-size:15px;color:#1A1A2E;">' + (report.candidate_name || detectedName || "Candidate") + '</div>'
      + '<div style="font-size:11px;color:#6B7280;margin-top:2px;">Identity confidence: <strong style="color:#374151;">' + report.identity_confidence + '</strong></div>'
      + (report.identity_confidence_reason ? '<div style="font-size:10px;color:#9CA3AF;margin-top:3px;font-style:italic;">' + report.identity_confidence_reason + '</div>' : '')
      + '</div>'
      + '<div style="padding:7px 11px;border-radius:8px;background:' + al.bg + ';border:1px solid ' + al.border + ';text-align:center;flex-shrink:0;">'
      + '<div style="font-size:9px;font-weight:700;color:' + al.color + ';text-transform:uppercase;letter-spacing:0.6px;">' + al.label + '</div>'
      + '<div style="font-size:12px;font-weight:700;color:' + al.color + ';">' + report.alert_level + '</div>'
      + '</div></div>'
      + '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;background:#FAFAFA;">'
      + '<p style="font-size:12px;color:#374151;line-height:1.65;margin:0;">' + report.external_profile_summary + '</p></div>';

    if (noData) {
      html += '<div style="padding:14px 16px;font-size:12px;color:#9CA3AF;font-style:italic;text-align:center;">No significant external signals found.</div>';
    }

    if (verified.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">&#10003; Verified signals (' + verified.length + ')</div>'
        + verified.map(function(s) {
            return '<div style="padding:8px 10px;background:#ECFDF5;border:1px solid #A7F3D0;border-radius:7px;margin-bottom:6px;">'
              + '<div style="font-size:12px;color:#065F46;line-height:1.55;">' + s.statement + '</div>'
              + '<div style="font-size:10px;color:#6EE7B7;margin-top:4px;">' + s.source_type + ' &middot; ' + s.reliability + ' reliability</div></div>';
          }).join("")
        + '</div>';
    }

    if (weak.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#D97706;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">&#9651; Weak signals (' + weak.length + ')</div>'
        + weak.map(function(s) {
            return '<div style="padding:7px 10px;background:#FFFBEB;border:1px solid #FDE68A;border-radius:7px;margin-bottom:6px;">'
              + '<div style="font-size:12px;color:#92400E;line-height:1.55;">' + s.statement + '</div>'
              + '<div style="font-size:10px;color:#F59E0B;margin-top:3px;">' + s.source_type + '</div></div>';
          }).join("")
        + '</div>';
    }

    if (unverified.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#EA580C;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:6px;">Unverified (' + unverified.length + ')</div>'
        + unverified.map(function(c) {
            return '<div style="font-size:12px;color:#374151;padding:5px 0;border-bottom:1px solid #F3F4F6;">' + c.statement
              + '<br><span style="font-size:10px;color:#EA580C;font-style:italic;">' + c.caveat + '</span></div>';
          }).join("")
        + '</div>';
    }

    if (report.hiring_impact) {
      const rc = { Low: "#059669", Medium: "#D97706", High: "#DC2626" }[report.hiring_impact.risk_level] || "#6B7280";
      const rbg = { Low: "#ECFDF5", Medium: "#FFFBEB", High: "#FEF2F2" }[report.hiring_impact.risk_level] || "#F9FAFB";
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">'
        + '<div style="font-size:10px;font-weight:700;color:#2563EB;text-transform:uppercase;letter-spacing:0.6px;">Hiring Impact</div>'
        + '<span style="font-size:10px;font-weight:700;color:' + rc + ';background:' + rbg + ';padding:2px 8px;border-radius:20px;">' + report.hiring_impact.risk_level + ' Risk</span></div>'
        + '<p style="font-size:12px;color:#374151;line-height:1.6;margin-bottom:8px;">' + report.hiring_impact.summary + '</p>'
        + (report.hiring_impact.implications || []).map(function(i) {
            return '<div style="display:flex;gap:7px;padding:4px 0;font-size:11px;color:#374151;line-height:1.5;">'
              + '<span style="color:#2563EB;flex-shrink:0;font-weight:700;">&rarr;</span>' + i + '</div>';
          }).join("")
        + '</div>';
    }

    const validate = report.what_to_validate || [];
    if (validate.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#7C3AED;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:8px;">What to validate</div>'
        + validate.map(function(q, i) {
            return '<div style="display:flex;gap:8px;padding:6px 9px;background:#F5F3FF;border:1px solid #DDD6FE;border-radius:7px;margin-bottom:5px;font-size:12px;color:#374151;line-height:1.5;">'
              + '<span style="color:#7C3AED;font-weight:700;flex-shrink:0;">' + (i+1) + '.</span>' + q + '</div>';
          }).join("")
        + '</div>';
    }

    html += '<div style="padding:12px 16px;display:flex;justify-content:space-between;align-items:center;background:#F9FAFB;">'
      + '<span style="font-size:10px;color:#9CA3AF;">\u26A1 ' + (meta && meta.remaining_credits != null ? meta.remaining_credits : "?") + ' credits left</span>'
      + '<button id="tt-new-analysis" style="font-size:11px;color:#E8303A;background:none;border:none;cursor:pointer;font-weight:700;padding:0;letter-spacing:0.2px;">New analysis &rarr;</button></div>';

    results.innerHTML = html;
    results.style.display = "block";

    var newBtn = document.getElementById("tt-new-analysis");
    if (newBtn) newBtn.addEventListener("click", function() {
      results.style.display = "none";
      var c = detectCandidate(); detectedName = c.name;
      pageText = extractPageText();
      if (c.name) { candidateName.textContent = c.name; candidateMeta.textContent = c.meta; candidatePreview.style.display = "block"; }
      runAnalysis();
    });
  }

  function showError(msg) {
    errorDiv.innerHTML = '<div style="padding:14px 16px;background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;margin:12px 16px;font-size:12px;color:#DC2626;line-height:1.6;">' + msg + '</div>'
      + '<div style="padding:0 16px 12px;"><button id="tt-err-back" class="tt-btn-secondary">&larr; Back</button></div>';
    errorDiv.style.display = "block";
    var b = document.getElementById("tt-err-back");
    if (b) b.addEventListener("click", function() { errorDiv.style.display = "none"; showReady(); });
  }


// ── Listen for popup requests ────────────────────────────────────────────────
chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
  if (message.type === "GET_PAGE_TEXT") {
    sendResponse({ text: extractPageText().slice(0, 8000) });
  }
  return true;
});

})();
