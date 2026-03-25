<?php
/**
 * Shared header / navigation
 * Usage: <?php $root = ''; include 'includes/header.php'; ?> (from root)
 *        <?php $root = '../'; include '../includes/header.php'; ?> (from /pages/)
 */
if (!isset($root)) $root = '';
if (!isset($pageTitle)) $pageTitle = 'Jason Holweg – Webseiten für Firmen mit Stil';
if (!isset($pageDesc)) $pageDesc  = 'Professionelle Webentwicklung mit modernem Design. Ich erstelle individuelle Webseiten für Firmen und Selbstständige.';
if (!isset($bodyClass)) $bodyClass = '';
if (!isset($navClass)) $navClass = '';
$stylePath = __DIR__ . '/../assets/css/style.css';
$styleVersion = file_exists($stylePath) ? filemtime($stylePath) : time();
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDesc) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDesc) ?>">
  <meta property="og:type" content="website">
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <!-- Favicon -->
  <link rel="icon" href="<?= $root ?>assets/img/favicon.svg" type="image/svg+xml">

  <!-- Stylesheet -->
  <link rel="stylesheet" href="<?= $root ?>assets/css/style.css?v=<?= $styleVersion ?>">

  <!-- Preconnect for Google Fonts (loaded in CSS @import) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>
<body<?= $bodyClass !== '' ? ' class="' . htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8') . '"' : '' ?>>

<!-- ── Navigation ────────────────────────────────────────── -->
<nav class="site-nav<?= $navClass !== '' ? ' ' . htmlspecialchars($navClass, ENT_QUOTES, 'UTF-8') : '' ?>" role="navigation" aria-label="Hauptnavigation">
  <a href="<?= $root ?>index.php" class="nav-brand" aria-label="Jason Holweg – Startseite">
    <span class="nav-brand__mark" aria-hidden="true">JH</span>
    <span class="nav-brand__text">Jason Holweg</span>
  </a>

  <ul class="nav-links" role="list">
    <li><a href="<?= $root ?>index.php">Start</a></li>
    <li><a href="<?= $root ?>index.php#services">Leistungen</a></li>
    <li><a href="<?= $root ?>pages/aboutme.php">Über mich</a></li>
    <li><a href="<?= $root ?>pages/projects.php">Projekte</a></li>
    <li><a href="<?= $root ?>pages/Kontakt.php">Kontakt</a></li>
    <li><a href="<?= $root ?>pages/kalkulator.php">Kalkulator</a></li>
  </ul>

  <a href="<?= $root ?>pages/Kontakt.php" class="nav-cta">Projekt starten</a>

  <button class="nav-toggle" id="nav-toggle" aria-label="Menü öffnen" aria-expanded="false" aria-controls="nav-mobile">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

<!-- Mobile nav -->
<nav class="nav-mobile" id="nav-mobile" role="navigation" aria-label="Mobilnavigation">
  <a href="<?= $root ?>index.php">Start</a>
  <a href="<?= $root ?>index.php#services">Leistungen</a>
  <a href="<?= $root ?>pages/aboutme.php">Über mich</a>
  <a href="<?= $root ?>pages/projects.php">Projekte</a>
  <a href="<?= $root ?>pages/Kontakt.php">Kontakt</a>
  <a href="<?= $root ?>pages/kalkulator.php">Kalkulator</a>
</nav>
