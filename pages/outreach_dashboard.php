<?php
$root = '../';
$pageTitle = 'Outreach Dashboard – Jason Holweg';
$pageDesc  = 'Internes Dashboard mit Versandhistorie der Outreach-E-Mails.';
$bodyClass = 'page-outreach';
$navClass  = 'scrolled';
include '../includes/header.php';
?>

<section class="outreach-gate" id="outreach-gate">
  <div class="container">
    <div class="outreach-gate__card glass">
      <div class="outreach-gate__icon" aria-hidden="true">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </div>
      <h1>Dashboard geschützt</h1>
      <p>Bitte gib den Zugangscode ein, um die Versandhistorie zu sehen.</p>
      <div class="outreach-gate__input-wrap">
        <input type="password" id="gate-code" class="outreach-input" placeholder="Code eingeben" maxlength="10" autocomplete="off">
        <button class="outreach-btn outreach-btn--primary" id="gate-submit">Freischalten</button>
      </div>
      <p class="outreach-gate__error" id="gate-error" hidden>Falscher Code. Bitte versuche es erneut.</p>
    </div>
  </div>
</section>

<section class="outreach-dashboard" id="outreach-dashboard" hidden>
  <div class="container">
    <div class="outreach-history" id="outreach-history" aria-live="polite">
      <div class="outreach-history__top">
        <div>
          <h1>Outreach Dashboard</h1>
          <p class="text-muted">Übersicht über bereits verschickte Outreach-E-Mails.</p>
        </div>
        <div class="outreach-history__actions">
          <a class="outreach-btn outreach-btn--ghost" href="outreach.php">Neue E-Mail senden</a>
          <button type="button" class="outreach-btn" id="history-refresh-btn">Aktualisieren</button>
        </div>
      </div>

      <div class="outreach-history__stats">
        <span class="outreach-history__chip" id="history-total">Gesamt: 0</span>
        <span class="outreach-history__chip" id="history-with-attachments">Mit Screenshots: 0</span>
      </div>

      <div class="outreach-status" id="history-status" hidden></div>

      <div class="outreach-history__table-wrap">
        <table>
          <thead>
            <tr>
              <th>Gesendet</th>
              <th>Firma</th>
              <th>Empfänger</th>
              <th>Demo-Link</th>
              <th>Screenshots</th>
            </tr>
          </thead>
          <tbody id="history-tbody">
            <tr>
              <td colspan="5" class="text-muted">Noch keine Einträge.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<script>
(function() {
  'use strict';

  const GATE_CODE = '2705';

  const gate = document.getElementById('outreach-gate');
  const dashboard = document.getElementById('outreach-dashboard');
  const gateInput = document.getElementById('gate-code');
  const gateSubmit = document.getElementById('gate-submit');
  const gateError = document.getElementById('gate-error');

  const historyStatus = document.getElementById('history-status');
  const historyBody = document.getElementById('history-tbody');
  const historyTotal = document.getElementById('history-total');
  const historyWithAttachments = document.getElementById('history-with-attachments');
  const historyRefreshBtn = document.getElementById('history-refresh-btn');

  function unlockDashboard() {
    sessionStorage.setItem('outreach_unlocked', '1');
    gate.hidden = true;
    dashboard.hidden = false;
    fetchHistory(true);
  }

  function tryUnlock() {
    if (gateInput.value.trim() === GATE_CODE) {
      unlockDashboard();
    } else {
      gateError.hidden = false;
      gateInput.classList.add('shake');
      setTimeout(() => gateInput.classList.remove('shake'), 500);
    }
  }

  if (sessionStorage.getItem('outreach_unlocked') === '1') {
    unlockDashboard();
  }

  gateSubmit.addEventListener('click', tryUnlock);
  gateInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      tryUnlock();
    }
  });

  if (historyRefreshBtn) {
    historyRefreshBtn.addEventListener('click', () => fetchHistory(true));
  }

  async function fetchHistory(showToast) {
    if (!historyBody) return;

    if (showToast) {
      historyStatus.hidden = false;
      historyStatus.textContent = 'Lade Versandhistorie...';
      historyStatus.className = 'outreach-status';
    }

    try {
      const res = await fetch('../get_outreach_log.php?access_code=' + encodeURIComponent(GATE_CODE) + '&limit=100', {
        method: 'GET',
      });
      const json = await res.json();

      if (!json.ok || !Array.isArray(json.items)) {
        throw new Error('Invalid history response');
      }

      renderHistory(json.items);

      if (showToast) {
        historyStatus.hidden = false;
        historyStatus.textContent = 'Historie aktualisiert.';
        historyStatus.className = 'outreach-status outreach-status--success';
      }
    } catch (err) {
      if (showToast) {
        historyStatus.hidden = false;
        historyStatus.textContent = 'Historie konnte nicht geladen werden.';
        historyStatus.className = 'outreach-status outreach-status--error';
      }
    }
  }

  function renderHistory(items) {
    historyBody.innerHTML = '';

    historyTotal.textContent = 'Gesamt: ' + items.length;
    historyWithAttachments.textContent = 'Mit Screenshots: ' + items.filter(i => Number(i.attachments_count) > 0).length;

    if (items.length === 0) {
      historyBody.innerHTML = '<tr><td colspan="5" class="text-muted">Noch keine Einträge.</td></tr>';
      return;
    }

    items.forEach(item => {
      const tr = document.createElement('tr');
      const sentAt = formatDate(item.sent_at);
      const company = escapeHtml(item.company_name || '-');
      const recipient = escapeHtml(item.recipient_email || '-');
      const demoUrl = item.demo_url || '';
      const shots = Number(item.attachments_count || 0);

      const safeUrl = escapeHtml(demoUrl);
      const demoCell = safeUrl
        ? '<a href="' + safeUrl + '" target="_blank" rel="noopener noreferrer">Öffnen</a>'
        : '-';

      tr.innerHTML =
        '<td>' + sentAt + '</td>' +
        '<td>' + company + '</td>' +
        '<td>' + recipient + '</td>' +
        '<td>' + demoCell + '</td>' +
        '<td>' + shots + '</td>';

      historyBody.appendChild(tr);
    });
  }

  function formatDate(isoDate) {
    if (!isoDate) return '-';
    const d = new Date(isoDate);
    if (Number.isNaN(d.getTime())) return '-';
    return d.toLocaleString('de-DE', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  }

  function escapeHtml(value) {
    return String(value)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
})();
</script>

<?php include '../includes/footer.php'; ?>
