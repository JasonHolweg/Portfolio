<?php if (!isset($root)) $root = ''; ?>
<!-- ── Footer ────────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-inner">

      <div class="footer-brand">
        <a href="<?= $root ?>index.php" class="nav-logo">JH</a>
        <p>Webseiten für Firmen mit Stil –<br>modern, schnell und wirkungsvoll.</p>
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

<script src="<?= $root ?>assets/js/main.js"></script>
</body>
</html>
