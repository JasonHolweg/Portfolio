<?php
if (!isset($root)) $root = '';
$mainJsPath = __DIR__ . '/../assets/js/main.js';
$mainJsVersion = file_exists($mainJsPath) ? filemtime($mainJsPath) : time();
?>
<!-- ── Footer ────────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-inner">

      <div class="footer-brand">
        <a href="<?= $root ?>index.php" class="nav-logo">JH</a>
        <p>Webseiten für Firmen mit Stil –<br>modern, schnell und wirkungsvoll.</p>
        <p class="footer-trust">Individuelle Webentwicklung aus Deutschland – ohne Baukasten, ohne Templates.</p>
        <div class="footer-socials" aria-label="Social Media">
          <a class="footer-social-link" href="https://instagram.com/jason.holweg" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
            <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <defs>
                <linearGradient id="footerInstagramGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" style="stop-color: var(--c1);"></stop>
                  <stop offset="50%" style="stop-color: var(--c3);"></stop>
                  <stop offset="100%" style="stop-color: var(--c2);"></stop>
                </linearGradient>
              </defs>
              <path fill="url(#footerInstagramGradient)" d="M7.75 2h8.5A5.76 5.76 0 0 1 22 7.75v8.5A5.76 5.76 0 0 1 16.25 22h-8.5A5.76 5.76 0 0 1 2 16.25v-8.5A5.76 5.76 0 0 1 7.75 2Zm0 1.8A3.95 3.95 0 0 0 3.8 7.75v8.5a3.95 3.95 0 0 0 3.95 3.95h8.5a3.95 3.95 0 0 0 3.95-3.95v-8.5a3.95 3.95 0 0 0-3.95-3.95h-8.5Zm8.95 1.35a1.08 1.08 0 1 1 0 2.16 1.08 1.08 0 0 1 0-2.16ZM12 7.1a4.9 4.9 0 1 1 0 9.8 4.9 4.9 0 0 1 0-9.8Zm0 1.8a3.1 3.1 0 1 0 0 6.2 3.1 3.1 0 0 0 0-6.2Z"></path>
            </svg>
          </a>
          <a class="footer-social-link" href="https://github.com/jasonholweg" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
            <svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <defs>
                <linearGradient id="footerGithubGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" style="stop-color: var(--c1);"></stop>
                  <stop offset="50%" style="stop-color: var(--c3);"></stop>
                  <stop offset="100%" style="stop-color: var(--c2);"></stop>
                </linearGradient>
              </defs>
              <path fill="url(#footerGithubGradient)" d="M12 .8a11.2 11.2 0 0 0-3.55 21.82c.56.1.77-.24.77-.54v-2.1c-3.12.68-3.78-1.5-3.78-1.5-.5-1.28-1.23-1.62-1.23-1.62-1-.68.08-.67.08-.67 1.1.08 1.67 1.13 1.67 1.13.98 1.68 2.56 1.2 3.18.92.1-.72.38-1.2.7-1.47-2.5-.28-5.14-1.25-5.14-5.56 0-1.23.44-2.24 1.15-3.02-.11-.28-.5-1.4.11-2.92 0 0 .94-.3 3.08 1.15a10.69 10.69 0 0 1 5.6 0c2.13-1.45 3.07-1.15 3.07-1.15.61 1.52.23 2.64.12 2.92.71.78 1.15 1.8 1.15 3.02 0 4.32-2.65 5.28-5.17 5.55.4.35.75 1.03.75 2.08v3.08c0 .3.2.65.78.54A11.2 11.2 0 0 0 12 .8Z"></path>
            </svg>
          </a>
        </div>
        <p class="site-footer__signature">Webseite von <a class="jason-gradient-link" href="https://jasonholweg.de" target="_blank" rel="noopener noreferrer">Jason Holweg</a></p>
      </div>

      <div class="footer-links-group">
        <h4>Navigation</h4>
        <a href="<?= $root ?>index.php">Start</a>
        <a href="<?= $root ?>pages/aboutme.php">Über mich</a>
        <a href="<?= $root ?>pages/projects.php">Projekte</a>
        <a href="<?= $root ?>pages/Kontakt.php">Kontakt</a>
      </div>

      <div class="footer-links-group">
        <h4>Rechtliches</h4>
        <a href="<?= $root ?>pages/Impressum.php">Impressum</a>
        <a href="<?= $root ?>pages/Datenschutz.php">Datenschutz</a>
      </div>

      <div class="footer-links-group">
        <h4>Kontakt</h4>
        <a href="mailto:hallo@jasonholweg.de">hallo@jasonholweg.de</a>
        <a href="<?= $root ?>pages/Kontakt.php">Kontaktformular</a>
      </div>

      <div class="footer-links-group">
        <h4>Standort</h4>
        <p>Webdesigner aus Deutschland – spezialisiert auf moderne Webseiten für Unternehmen und Selbstständige.</p>
      </div>

    </div>

    <div class="footer-bottom">
      <span>&copy; <?= date('Y') ?> Jason Holweg. Alle Rechte vorbehalten.</span>
      <span>
        <a href="<?= $root ?>pages/Impressum.php">Impressum</a> ·
        <a href="<?= $root ?>pages/Datenschutz.php">Datenschutz</a>
      </span>
    </div>
  </div>
</footer>

<script src="<?= $root ?>assets/js/main.js?v=<?= $mainJsVersion ?>"></script>
</body>
</html>
