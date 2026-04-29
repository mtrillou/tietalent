// TieTalent Chrome Extension — Content Script v3 (auto-run on open)

(function () {
  if (document.getElementById("tt-ext-root")) return;

  function isProfilePage() {
    const url = window.location.href;
    const h = window.location.hostname;
    if (h.includes("linkedin.com")) return url.includes("/in/") || url.includes("/pub/");
    if (h.includes("indeed.com")) return url.includes("/r/") || url.includes("/resume/");
    if (h.includes("glassdoor.com")) return url.includes("/profile/") || url.includes("/resume/");
    if (h.includes("welcome.io") || h.includes("malt.") || h.includes("toptal.com")) return true;
    return url.includes("/profile/") || url.includes("/candidate/") || url.includes("/talent/") || url.includes("/cv/");
  }
  if (!isProfilePage()) return;

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

  function detectCandidate() {
    const title = document.title || "";
    let name = "", meta = "";
    if (window.location.hostname.includes("linkedin.com")) {
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

  // ── LinkedIn inline button ───────────────────────────────────────────────
  let linkedInBtnInjected = false;
  function injectLinkedInButton() {
    if (linkedInBtnInjected) return;
    const nameEl = document.querySelector("h1.text-heading-xlarge, h1.inline, .pv-top-card--list h1");
    if (!nameEl) return;
    const btn = document.createElement("button");
    btn.id = "tt-li-btn";
    btn.innerHTML = `<svg width="13" height="13" viewBox="0 0 24 24" fill="none" style="flex-shrink:0"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/><path d="M21 21l-4-4" stroke="white" stroke-width="2" stroke-linecap="round"/></svg> Intelligence`;
    btn.style.cssText = `display:inline-flex;align-items:center;gap:5px;padding:5px 12px;margin-left:10px;vertical-align:middle;background:linear-gradient(135deg,#E8303A,#C9242D);color:white;border:none;border-radius:20px;font-size:12px;font-weight:700;font-family:inherit;cursor:pointer;letter-spacing:0.2px;box-shadow:0 2px 8px rgba(232,48,58,0.4);transition:transform 0.15s,box-shadow 0.15s;`;
    btn.addEventListener("mouseenter", () => { btn.style.transform = "translateY(-1px)"; btn.style.boxShadow = "0 4px 14px rgba(232,48,58,0.5)"; });
    btn.addEventListener("mouseleave", () => { btn.style.transform = ""; btn.style.boxShadow = "0 2px 8px rgba(232,48,58,0.4)"; });
    btn.addEventListener("click", (e) => { e.stopPropagation(); openAndRun(); });
    nameEl.parentNode.insertBefore(btn, nameEl.nextSibling);
    linkedInBtnInjected = true;
  }

  // ── Floating fallback button ─────────────────────────────────────────────
  const floatBtn = document.createElement("div");
  floatBtn.id = "tt-ext-trigger";
  floatBtn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" style="flex-shrink:0"><circle cx="11" cy="11" r="8" stroke="white" stroke-width="2.2"/><path d="M21 21l-4-4" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg><span>Intelligence</span>`;
  floatBtn.title = "TieTalent — Run Intelligence Report";
  document.body.appendChild(floatBtn);
  floatBtn.addEventListener("click", () => openAndRun());

  if (window.location.hostname.includes("linkedin.com")) {
    floatBtn.style.display = "none";
    setTimeout(() => { injectLinkedInButton(); if (!linkedInBtnInjected) floatBtn.style.display = "flex"; }, 1500);
    setTimeout(() => { injectLinkedInButton(); if (!linkedInBtnInjected) floatBtn.style.display = "flex"; }, 3000);
  }

  // ── Sidebar HTML ─────────────────────────────────────────────────────────
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
            <div style="font-weight:700;font-size:13px;color:#fff;letter-spacing:-0.2px;">TieTalent Scout</div>
            <div style="font-size:10px;color:#9CA3AF;">Candidate Intelligence</div>
          </div>
        </div>
        <button id="tt-close" title="Close">&#x2715;</button>
      </div>

      <div id="tt-auth-section" style="display:none;">
        <div style="padding:20px 16px;">
          <div style="padding:12px;background:#FFF7ED;border:1px solid #FED7AA;border-radius:8px;margin-bottom:14px;">
            <p style="font-size:12px;color:#92400E;line-height:1.5;">Enter your TieTalent API key to run intelligence reports.</p>
          </div>
          <input id="tt-api-input" type="password" placeholder="tt_xxxxxxxxxxxxxxxx" />
          <button id="tt-save-key" class="tt-btn-primary">Connect &amp; Run</button>
          <a href="https://tietalent.vercel.app/en/settings" target="_blank" style="font-size:11px;color:#E8303A;display:block;margin-top:10px;text-align:center;text-decoration:none;">Get your free API key &rarr;</a>
        </div>
      </div>

      <div id="tt-loading" style="display:none;flex-direction:column;align-items:center;padding:40px 24px;text-align:center;">
        <div class="tt-spinner"></div>
        <p style="font-size:13px;color:#374151;margin-top:16px;font-weight:600;" id="tt-loading-title">Building intelligence report...</p>
        <p style="font-size:11px;color:#9CA3AF;margin-top:5px;" id="tt-loading-step">Analyzing external signals…</p>
      </div>

      <div id="tt-results" style="display:none;flex:1;overflow-y:auto;"></div>
      <div id="tt-error" style="display:none;"></div>

      <div id="tt-footer" style="display:none;padding:8px 16px;border-top:1px solid #E5E7EB;background:#F9FAFB;">
        <div style="display:flex;align-items:center;justify-content:space-between;">
          <span id="tt-credits-text" style="font-size:11px;font-weight:600;color:#059669;">&#x26A1; ...</span>
          <button id="tt-change-key" style="font-size:10px;color:#9CA3AF;background:none;border:none;cursor:pointer;padding:0;">Disconnect</button>
        </div>
      </div>
    </div>
  `;
  document.body.appendChild(root);

  const sidebar      = document.getElementById("tt-sidebar");
  const authSec      = document.getElementById("tt-auth-section");
  const loading      = document.getElementById("tt-loading");
  const loadingStep  = document.getElementById("tt-loading-step");
  const results      = document.getElementById("tt-results");
  const errorDiv     = document.getElementById("tt-error");
  const apiInput     = document.getElementById("tt-api-input");
  const creditsText  = document.getElementById("tt-credits-text");
  const footer       = document.getElementById("tt-footer");

  let isOpen = false, pageText = "", detectedName = "";

  const LOADING_STEPS = [
    "Analyzing external signals…",
    "Cross-validating public data…",
    "Detecting patterns and inconsistencies…",
    "Assessing credibility and risk…",
    "Highlighting signals most recruiters miss…"
  ];

  function showLoading() {
    authSec.style.display = "none";
    results.style.display = "none";
    errorDiv.style.display = "none";
    footer.style.display = "none";
    loading.style.display = "flex";
    // Cycle through steps
    let stepIdx = 0;
    loadingStep.textContent = LOADING_STEPS[0];
    const stepTimer = setInterval(() => {
      stepIdx = Math.min(stepIdx + 1, LOADING_STEPS.length - 1);
      loadingStep.textContent = LOADING_STEPS[stepIdx];
    }, 5000);
    return stepTimer;
  }

  function openAndRun() {
    // Open sidebar
    isOpen = true;
    sidebar.classList.add("tt-open");
    // Detect candidate
    const candidate = detectCandidate();
    detectedName = candidate.name;
    pageText = extractPageText();
    // Check auth then immediately run
    chrome.runtime.sendMessage({ type: "GET_API_KEY" }, (res) => {
      if (res && res.api_key) {
        loadCredits(res.api_key);
        footer.style.display = "block";
        triggerAnalysis();
      } else {
        authSec.style.display = "block";
      }
    });
  }

  function triggerAnalysis() {
    if (!pageText || pageText.length < 100) pageText = extractPageText();
    if (pageText.length < 100) {
      showError("Not enough text on this page. Try on a candidate profile page."); return;
    }
    const stepTimer = showLoading();

    chrome.runtime.sendMessage(
      { type: "ANALYZE_CANDIDATE", payload: { cv_text: pageText, linkedin_url: detectLinkedInUrl() } },
      (response) => {
        clearInterval(stepTimer);
        loading.style.display = "none";
        if (chrome.runtime.lastError || !response || response.error) {
          const err = (response && response.error) || (chrome.runtime.lastError && chrome.runtime.lastError.message) || "Unknown error";
          if (err === "NO_API_KEY") { authSec.style.display = "block"; footer.style.display = "none"; return; }
          if (err === "NO_CREDITS") { showError('No credits remaining. <a href="https://tietalent.vercel.app/en/pricing" target="_blank" style="color:#E8303A;font-weight:600;">Buy credits &rarr;</a>'); return; }
          if (err === "INVALID_KEY") { chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }); showError("Invalid API key."); authSec.style.display = "block"; footer.style.display = "none"; return; }
          showError(err); return;
        }
        if (response.meta) {
          const rem = response.meta.remaining_credits;
          creditsText.textContent = "\u26A1 " + rem + " credit" + (rem !== 1 ? "s" : "") + " remaining";
          creditsText.style.color = rem === 0 ? "#DC2626" : rem <= 3 ? "#D97706" : "#059669";
        }
        footer.style.display = "block";
        renderResults(response.report, response.meta);
      }
    );
  }

  document.getElementById("tt-close").addEventListener("click", () => {
    isOpen = false; sidebar.classList.remove("tt-open");
  });

  document.getElementById("tt-save-key").addEventListener("click", () => {
    const key = apiInput.value.trim();
    if (!key.startsWith("tt_")) { showError("Key must start with tt_"); return; }
    chrome.runtime.sendMessage({ type: "SAVE_API_KEY", key }, () => {
      authSec.style.display = "none";
      footer.style.display = "block";
      loadCredits(key);
      triggerAnalysis();
    });
  });

  document.getElementById("tt-change-key").addEventListener("click", () => {
    chrome.runtime.sendMessage({ type: "CLEAR_API_KEY" }, () => {
      authSec.style.display = "block";
      results.style.display = "none";
      footer.style.display = "none";
      apiInput.value = "";
    });
  });

  function loadCredits(apiKey) {
    fetch("https://tietalent.vercel.app/api/credits", { headers: { "X-API-Key": apiKey } })
      .then(r => r.json()).then(d => {
        const total = d.totalAvailable ?? 0;
        creditsText.textContent = "\u26A1 " + total + " credit" + (total !== 1 ? "s" : "") + " remaining";
        creditsText.style.color = total === 0 ? "#DC2626" : total <= 3 ? "#D97706" : "#059669";
      }).catch(() => { creditsText.textContent = "\u26A1 —"; });
  }

  function renderResults(report, meta) {
    const alertColors = {
      Green:  { bg: "#ECFDF5", color: "#059669", border: "#A7F3D0" },
      Yellow: { bg: "#FFFBEB", color: "#D97706", border: "#FDE68A" },
      Orange: { bg: "#FFF7ED", color: "#EA580C", border: "#FED7AA" },
      Red:    { bg: "#FEF2F2", color: "#DC2626", border: "#FECACA" },
    };
    const decisionColors = {
      "Strong Proceed":          { color: "#059669", bg: "#ECFDF5" },
      "Proceed":                 { color: "#059669", bg: "#ECFDF5" },
      "Proceed with Validation": { color: "#D97706", bg: "#FFFBEB" },
      "Neutral":                 { color: "#6B7280", bg: "#F9FAFB" },
      "Caution":                 { color: "#EA580C", bg: "#FFF7ED" },
      "High Risk":               { color: "#DC2626", bg: "#FEF2F2" },
    };
    const al = alertColors[report.alert_level] || alertColors.Yellow;
    const dc = decisionColors[report.recruiter_signal && report.recruiter_signal.decision] || decisionColors["Neutral"];
    const verified   = (report.signals && report.signals.verified_signals)  || [];
    const weak       = (report.signals && report.signals.weak_signals)       || [];

    var html = "";

    // Recruiter signal — primary
    if (report.recruiter_signal) {
      html += '<div style="padding:14px 16px;background:' + dc.bg + ';border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:9px;font-weight:700;color:' + dc.color + ';text-transform:uppercase;letter-spacing:0.8px;margin-bottom:5px;">Recruiter Signal</div>'
        + '<div style="font-size:18px;font-weight:800;color:' + dc.color + ';letter-spacing:-0.3px;margin-bottom:6px;">' + report.recruiter_signal.decision + '</div>'
        + '<p style="font-size:12px;color:#374151;line-height:1.6;font-style:italic;">' + report.recruiter_signal.reasoning + '</p>'
        + '</div>';
    }

    // Candidate name + alert
    html += '<div style="padding:12px 16px;border-bottom:1px solid #E5E7EB;display:flex;align-items:center;justify-content:space-between;gap:10px;">'
      + '<div><div style="font-weight:700;font-size:14px;color:#1A1A2E;">' + (report.candidate_name || detectedName || "Candidate") + '</div>'
      + '<div style="font-size:11px;color:#9CA3AF;margin-top:2px;">Identity: <strong style="color:#374151;">' + report.identity_confidence + '</strong></div></div>'
      + '<div style="padding:6px 10px;border-radius:7px;background:' + al.bg + ';border:1px solid ' + al.border + ';text-align:center;flex-shrink:0;">'
      + '<div style="font-size:9px;font-weight:700;color:' + al.color + ';text-transform:uppercase;">Alert</div>'
      + '<div style="font-size:12px;font-weight:700;color:' + al.color + ';">' + report.alert_level + '</div></div></div>';

    // Top decision drivers
    if (report.top_decision_drivers && report.top_decision_drivers.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#1A1A2E;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:7px;">Top Decision Drivers</div>'
        + report.top_decision_drivers.map(function(d, i) {
            return '<div style="display:flex;gap:8px;padding:7px 10px;background:#F9FAFB;border:1px solid #E5E7EB;border-radius:7px;margin-bottom:5px;">'
              + '<span style="color:#E8303A;font-weight:800;flex-shrink:0;">' + (i+1) + '</span>'
              + '<p style="font-size:12px;color:#111827;line-height:1.55;margin:0;">' + d + '</p></div>';
          }).join("")
        + '</div>';
    }

    // Recommended next step
    if (report.recommended_next_step) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:7px;">Next Step</div>'
        + '<span style="display:inline-block;font-size:11px;font-weight:700;color:#059669;background:#ECFDF5;border:1px solid #A7F3D0;padding:3px 10px;border-radius:20px;margin-bottom:7px;">' + report.recommended_next_step.action + '</span>'
        + (report.recommended_next_step.focus_areas || []).map(function(f) {
            return '<div style="font-size:12px;color:#374151;padding:3px 0;display:flex;gap:6px;"><span style="color:#059669;flex-shrink:0;">&rarr;</span>' + f + '</div>';
          }).join("")
        + '</div>';
    }

    // Verified signals
    if (verified.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#059669;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:7px;">Verified Signals</div>'
        + verified.map(function(s) {
            return '<div style="padding:8px 10px;background:#ECFDF5;border:1px solid #A7F3D0;border-radius:7px;margin-bottom:5px;">'
              + '<p style="font-size:12px;color:#065F46;line-height:1.55;margin:0 0 4px;">' + s.statement + '</p>'
              + '<span style="font-size:10px;color:#6EE7B7;">' + s.source_type + '</span></div>';
          }).join("")
        + '</div>';
    }

    // Weak signals
    if (weak.length > 0) {
      html += '<div style="padding:10px 16px;border-bottom:1px solid #E5E7EB;">'
        + '<div style="font-size:10px;font-weight:700;color:#D97706;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:7px;">Weak Signals</div>'
        + weak.map(function(s) {
            return '<div style="padding:7px 10px;background:#FFFBEB;border:1px solid #FDE68A;border-radius:7px;margin-bottom:5px;">'
              + '<p style="font-size:12px;color:#92400E;line-height:1.55;margin:0;">' + s.statement + '</p></div>';
          }).join("")
        + '</div>';
    }

    // What to validate
    const validate = report.what_to_validate || [];
    if (validate.length > 0) {
      html += '<div style="padding:10px 16px;">'
        + '<div style="font-size:10px;font-weight:700;color:#7C3AED;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:7px;">What to Validate</div>'
        + validate.map(function(q, i) {
            return '<div style="display:flex;gap:7px;padding:6px 9px;background:#F5F3FF;border:1px solid #DDD6FE;border-radius:7px;margin-bottom:5px;font-size:12px;color:#374151;line-height:1.5;">'
              + '<span style="color:#7C3AED;font-weight:700;flex-shrink:0;">' + (i+1) + '.</span>' + q + '</div>';
          }).join("")
        + '</div>';
    }

    // Re-run button
    html += '<div style="padding:10px 16px;border-top:1px solid #E5E7EB;text-align:right;">'
      + '<button id="tt-rerun" style="font-size:11px;color:#E8303A;background:none;border:none;cursor:pointer;font-weight:700;padding:0;">'
      + 'Run again &rarr;</button></div>';

    results.innerHTML = html;
    results.style.display = "block";

    var rerunBtn = document.getElementById("tt-rerun");
    if (rerunBtn) rerunBtn.addEventListener("click", function() {
      results.style.display = "none";
      pageText = extractPageText();
      triggerAnalysis();
    });
  }

  function showError(msg) {
    errorDiv.innerHTML = '<div style="padding:14px 16px;background:#FEF2F2;border:1px solid #FECACA;border-radius:8px;margin:12px 16px;font-size:12px;color:#DC2626;line-height:1.6;">' + msg + '</div>';
    errorDiv.style.display = "block";
  }
})();
