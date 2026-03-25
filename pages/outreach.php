<?php
$root = '../';
$pageTitle = 'Outreach – Jason Holweg';
$pageDesc  = 'Internes Tool zum Versenden von Outreach-E-Mails.';
$bodyClass = 'page-outreach';
$navClass  = 'scrolled';
include '../includes/header.php';
?>

<!-- ── Access Gate ─────────────────────────────────────── -->
<section class="outreach-gate" id="outreach-gate">
  <div class="container">
    <div class="outreach-gate__card glass">
      <div class="outreach-gate__icon" aria-hidden="true">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
      </div>
      <h1>Zugang erforderlich</h1>
      <p>Bitte gib den Zugangscode ein, um fortzufahren.</p>
      <div class="outreach-gate__input-wrap">
        <input type="password" id="gate-code" class="outreach-input" placeholder="Code eingeben" maxlength="10" autocomplete="off">
        <button class="outreach-btn outreach-btn--primary" id="gate-submit">Freischalten</button>
      </div>
      <p class="outreach-gate__error" id="gate-error" hidden>Falscher Code. Bitte versuche es erneut.</p>
    </div>
  </div>
</section>

<!-- ── Outreach Dashboard ──────────────────────────────── -->
<section class="outreach-dashboard" id="outreach-dashboard" hidden>
  <div class="container">

    <div class="outreach-header">
      <h1>Outreach E-Mail senden</h1>
      <p class="text-muted">Versende eine personalisierte Akquise-E-Mail mit Demo-Screenshots und Links.</p>
      <a class="outreach-btn outreach-btn--ghost" href="outreach_dashboard.php">Zum Dashboard</a>
    </div>

    <form class="outreach-form" id="outreach-form" novalidate>

      <!-- Empfänger -->
      <div class="outreach-form__group">
        <label for="recipient-email">Empfänger E-Mail <span class="required">*</span></label>
        <input type="email" id="recipient-email" name="recipient_email" class="outreach-input" placeholder="info@beispiel-firma.de" required>
      </div>

      <!-- Firmenname -->
      <div class="outreach-form__group">
        <label for="company-name">Firmenname <span class="required">*</span></label>
        <input type="text" id="company-name" name="company_name" class="outreach-input" placeholder="Mustermann GmbH" required>
      </div>

      <!-- Demo-Link -->
      <div class="outreach-form__group">
        <label for="demo-url">Link zur Demo-Webseite <span class="required">*</span></label>
        <input type="url" id="demo-url" name="demo_url" class="outreach-input" placeholder="https://demo.jasonholweg.de/firma" required>
      </div>

      <!-- Screenshots -->
      <div class="outreach-form__group">
        <label>Screenshots der Demo <span class="text-muted">(max. 3 Bilder, je max. 2 MB)</span></label>
        <div class="outreach-upload" id="upload-zone">
          <input type="file" id="screenshot-input" accept="image/*" multiple hidden>
          <div class="outreach-upload__trigger" id="upload-trigger">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
              <circle cx="8.5" cy="8.5" r="1.5"/>
              <polyline points="21 15 16 10 5 21"/>
            </svg>
            <span>Bilder hierher ziehen oder <strong>klicken</strong></span>
          </div>
          <div class="outreach-upload__preview" id="upload-preview"></div>
        </div>
      </div>

      <!-- Persönliche Nachricht -->
      <div class="outreach-form__group">
        <label for="personal-message">Persönliche Nachricht <span class="text-muted">(optional)</span></label>
        <textarea id="personal-message" name="personal_message" class="outreach-input outreach-textarea" rows="4" placeholder="z.B. Mir ist aufgefallen, dass Ihre aktuelle Webseite auf Mobilgeräten nicht optimal dargestellt wird..."></textarea>
      </div>

      <!-- Status & Submit -->
      <div class="outreach-form__actions">
        <button type="submit" class="outreach-btn outreach-btn--send" id="send-btn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"/>
            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
          </svg>
          E-Mail senden
        </button>
      </div>

      <div class="outreach-status" id="outreach-status" hidden></div>
    </form>
  </div>
</section>

<script>
(function() {
  'use strict';

  const GATE_CODE = '2705';
  const MAX_IMAGES = 3;
  const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

  /* ── Gate ──────────────────────────────────────────── */
  const gate = document.getElementById('outreach-gate');
  const dashboard = document.getElementById('outreach-dashboard');
  const gateInput = document.getElementById('gate-code');
  const gateSubmit = document.getElementById('gate-submit');
  const gateError = document.getElementById('gate-error');

  if (sessionStorage.getItem('outreach_unlocked') === '1') {
    gate.hidden = true;
    dashboard.hidden = false;
  }

  function tryUnlock() {
    if (gateInput.value.trim() === GATE_CODE) {
      sessionStorage.setItem('outreach_unlocked', '1');
      gate.hidden = true;
      dashboard.hidden = false;
    } else {
      gateError.hidden = false;
      gateInput.classList.add('shake');
      setTimeout(() => gateInput.classList.remove('shake'), 500);
    }
  }

  gateSubmit.addEventListener('click', tryUnlock);
  gateInput.addEventListener('keydown', e => { if (e.key === 'Enter') tryUnlock(); });

  /* ── Image Upload ─────────────────────────────────── */
  const fileInput = document.getElementById('screenshot-input');
  const uploadTrigger = document.getElementById('upload-trigger');
  const uploadPreview = document.getElementById('upload-preview');
  const uploadZone = document.getElementById('upload-zone');
  let selectedFiles = [];

  uploadTrigger.addEventListener('click', () => fileInput.click());

  uploadZone.addEventListener('dragover', e => {
    e.preventDefault();
    uploadZone.classList.add('drag-over');
  });
  uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('drag-over'));
  uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('drag-over');
    handleFiles(e.dataTransfer.files);
  });

  fileInput.addEventListener('change', () => handleFiles(fileInput.files));

  function handleFiles(files) {
    for (const file of files) {
      if (selectedFiles.length >= MAX_IMAGES) break;
      if (!file.type.startsWith('image/')) continue;
      if (file.size > MAX_FILE_SIZE) {
        alert(file.name + ' ist zu groß (max. 2 MB).');
        continue;
      }
      selectedFiles.push(file);
      addPreview(file, selectedFiles.length - 1);
    }
    fileInput.value = '';
  }

  function addPreview(file, index) {
    const reader = new FileReader();
    reader.onload = e => {
      const div = document.createElement('div');
      div.className = 'outreach-upload__item';
      div.dataset.index = index;
      div.innerHTML = '<img src="' + e.target.result + '" alt="Screenshot"><button type="button" class="outreach-upload__remove" title="Entfernen">&times;</button>';
      div.querySelector('.outreach-upload__remove').addEventListener('click', () => {
        selectedFiles[index] = null;
        div.remove();
      });
      uploadPreview.appendChild(div);
    };
    reader.readAsDataURL(file);
  }

  /* ── Form Submit ──────────────────────────────────── */
  const form = document.getElementById('outreach-form');
  const status = document.getElementById('outreach-status');
  const sendBtn = document.getElementById('send-btn');

  form.addEventListener('submit', async e => {
    e.preventDefault();

    const email = document.getElementById('recipient-email').value.trim();
    const company = document.getElementById('company-name').value.trim();
    const demoUrl = document.getElementById('demo-url').value.trim();
    const message = document.getElementById('personal-message').value.trim();

    if (!email || !company || !demoUrl) {
      showStatus('Bitte fülle alle Pflichtfelder aus.', 'error');
      return;
    }

    sendBtn.disabled = true;
    sendBtn.textContent = 'Wird gesendet...';
    status.hidden = true;

    const formData = new FormData();
    formData.append('recipient_email', email);
    formData.append('company_name', company);
    formData.append('demo_url', demoUrl);
    formData.append('personal_message', message);
    formData.append('access_code', GATE_CODE);

    const activeFiles = selectedFiles.filter(f => f !== null);
    activeFiles.forEach((file, i) => formData.append('screenshots[]', file));

    try {
      const res = await fetch('../send_outreach.php', {
        method: 'POST',
        body: formData,
      });
      const json = await res.json();

      if (json.ok) {
        showStatus('E-Mail erfolgreich gesendet!', 'success');
        form.reset();
        selectedFiles = [];
        uploadPreview.innerHTML = '';
      } else {
        showStatus(json.error || 'Fehler beim Senden.', 'error');
      }
    } catch (err) {
      showStatus('Netzwerkfehler. Bitte versuche es erneut.', 'error');
    }

    sendBtn.disabled = false;
    sendBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> E-Mail senden';
  });

  function showStatus(msg, type) {
    status.hidden = false;
    status.textContent = msg;
    status.className = 'outreach-status outreach-status--' + type;
  }
})();
</script>

<?php include '../includes/footer.php'; ?>
