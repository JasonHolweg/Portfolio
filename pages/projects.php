<?php
$root      = '../';
$pageTitle = 'Projekte – Jason Holweg';
$pageDesc  = 'Ausgewählte Web-Projekte von Jason Holweg – moderne Webseiten, Online-Shops und Webanwendungen.';
include '../includes/header.php';

/* ── Project data ─────────────────────────────────────────── */
$projects = [
  [
    'emoji'   => '🌿',
    'bg'      => 'linear-gradient(135deg,rgba(16,185,129,0.3),rgba(78,205,196,0.3))',
    'tags'    => ['PHP', 'CMS', 'Business-Website'],
    'title'   => 'Garten2000 Handewitt',
    'desc'    => 'Webseite für ein Gartencenter mit modernem Auftritt und klarer Struktur für Leistungen, Angebote und Kontakt.',
    'url'     => 'https://jasonholweg.de/demo/garten2000',
    'color'   => 'var(--c5)',
  ],
  [
    'emoji'   => '📍',
    'bg'      => 'linear-gradient(135deg,rgba(251,191,36,0.3),rgba(249,115,22,0.3))',
    'tags'    => ['360°', 'Webplattform', 'Partnerprojekt'],
    'title'   => 'Visitfy',
    'desc'    => 'Webseite für 360-Grad-Rundgänge – umgesetzt als Partnerprojekt mit Fokus auf Präsentation und Nutzerführung.',
    'url'     => 'https://visitfy.de/',
    'color'   => 'var(--c4)',
  ],
  [
    'emoji'   => '🍨',
    'bg'      => 'linear-gradient(135deg,rgba(59,130,246,0.3),rgba(14,165,233,0.3))',
    'tags'    => ['Admin-Panel', 'Event-Anmeldung', 'Konfigurator'],
    'title'   => 'Flora Kaffee & Eisbar',
    'desc'    => 'Webseite für meine Eiscafés mit Veranstaltungen inkl. Anmeldung, Eistorten-Konfigurator und Speisekarte mit Highlights – komplett im Admin-Panel bearbeitbar.',
    'url'     => 'https://flora-fl.de/index.php',
    'color'   => 'var(--c6)',
  ],
  [
    'emoji'   => '🌸',
    'bg'      => 'linear-gradient(135deg,rgba(244,114,182,0.3),rgba(168,85,247,0.3))',
    'tags'    => ['Gastronomie', 'Speisekarte', 'Reservierungssystem'],
    'title'   => 'Garten Café Magnolia',
    'desc'    => 'Webseite für das Garten Café Magnolia in Handewitt mit digitaler Speisekarte und integriertem Reservierungssystem.',
    'url'     => 'https://magnolia-cafe.de',
    'color'   => 'var(--c7)',
  ],
  [
    'emoji'   => '✂️',
    'bg'      => 'linear-gradient(135deg,rgba(255,107,107,0.3),rgba(255,0,128,0.3))',
    'tags'    => ['CMS', 'Preisliste', 'Service-Website'],
    'title'   => 'Lyvs Haarstudio',
    'desc'    => 'Schöne Friseur-Webseite mit Preisliste und vollständig bearbeitbaren Inhalten über ein Admin-Panel.',
    'url'     => 'https://lyvs-haarstudio.de',
    'color'   => 'var(--c1)',
  ],
  [
    'emoji'   => '🇫🇷',
    'bg'      => 'linear-gradient(135deg,rgba(168,85,247,0.3),rgba(59,130,246,0.3))',
    'tags'    => ['Branding', 'Gastro', 'Webdesign'],
    'title'   => 'Glacelia',
    'desc'    => 'Webseite für eine Eisdiele mit französischem Eis – "Eis wie aus Paris" als zentraler Markenbotschaft.',
    'url'     => 'https://glacelia.de',
    'color'   => 'var(--c3)',
  ],
];
?>

<header class="page-hero" role="banner">
  <div class="orb" style="width:500px;height:500px;top:-80px;left:-100px;background:radial-gradient(circle,rgba(168,85,247,0.2),transparent 70%)"></div>
  <div class="orb" style="width:350px;height:350px;bottom:0;right:-80px;background:radial-gradient(circle,rgba(59,130,246,0.18),transparent 70%)"></div>
  <div class="container" style="position:relative;z-index:1">
    <p class="section-label">Ausgewählte Arbeiten</p>
    <h1 class="fade-up"><span class="grad-text">Meine Projekte</span></h1>
    <p class="fade-up fade-up-d1">Einblicke in Webseiten und Webanwendungen, die ich mit Liebe zum Detail gebaut habe.</p>
  </div>
</header>

<main>
  <section class="section" aria-labelledby="projects-heading">
    <div class="container">
      <h2 class="sr-only" id="projects-heading">Alle Projekte</h2>

      <div class="projects-grid">
        <?php foreach ($projects as $i => $p): ?>
        <article class="project-card glass fade-up<?= $i < 3 ? ' fade-up-d' . ($i + 1) : '' ?>">
          <div class="project-img">
            <div class="project-img-bg" style="--proj-bg:<?= htmlspecialchars($p['bg']) ?>">
              <span style="font-size:3.5rem;filter:drop-shadow(0 0 20px <?= htmlspecialchars($p['color']) ?>)"><?= $p['emoji'] ?></span>
            </div>
          </div>
          <div class="project-body">
            <div class="project-tags">
              <?php foreach ($p['tags'] as $tag): ?>
              <span class="tag"><?= htmlspecialchars($tag) ?></span>
              <?php endforeach; ?>
            </div>
            <h3><?= htmlspecialchars($p['title']) ?></h3>
            <p><?= htmlspecialchars($p['desc']) ?></p>
            <a href="<?= htmlspecialchars($p['url']) ?>" class="project-link" style="color:<?= htmlspecialchars($p['color']) ?>" target="_blank" rel="noopener noreferrer">
              Projekt ansehen <span aria-hidden="true">↗</span>
            </a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="orb" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%);background:radial-gradient(circle,rgba(168,85,247,0.18),transparent 70%)"></div>
    <div class="container" style="position:relative;z-index:1">
      <h2 class="fade-up">Dein Projekt ist das<br><span class="grad-text">nächste auf der Liste</span></h2>
      <p class="fade-up fade-up-d1">Lass uns gemeinsam etwas Einzigartiges schaffen.</p>
      <a href="Kontakt.php" class="btn btn-primary fade-up fade-up-d2">Jetzt anfragen →</a>
    </div>
  </section>
</main>

<?php include '../includes/footer.php'; ?>
