<?php
$root      = '../';
$pageTitle = 'Projekte – Jason Holweg';
$pageDesc  = 'Ausgewählte Web-Projekte von Jason Holweg – moderne Webseiten, Online-Shops und Webanwendungen.';
include '../includes/header.php';

/* ── Project data ─────────────────────────────────────────── */
$projects = [
  [
    'emoji'   => '🚗',
    'bg'      => 'linear-gradient(135deg,rgba(59,130,246,0.3),rgba(107,114,128,0.35))',
    'tags'    => ['Autohaus', 'Demo-Website', 'Admin-Panel'],
    'title'   => 'Autohaus Demo',
    'desc'    => 'Demo-Webseite fuer Autohaeuser inklusive Admin-Panel zur Pflege von Inhalten und Fahrzeugen.',
    'actions' => [
      [
        'label' => 'Webseite ansehen',
        'url'   => 'https://jasonholweg.de/demo/autohaus',
      ],
      [
        'label' => 'Admin-Panel ansehen',
        'url'   => 'https://jasonholweg.de/demo/autohaus/admin',
      ],
    ],
    'credentials' => [
      'E-Mail/User: admin@autohaus.de',
      'Passwort: Admin1234!',
    ],
    'image'   => 'Autohaus.png',
    'color'   => 'var(--c2)',
  ],
  [
    'emoji'   => '🌿',
    'bg'      => 'linear-gradient(135deg,rgba(16,185,129,0.3),rgba(78,205,196,0.3))',
    'tags'    => ['PHP', 'CMS', 'Business-Website'],
    'title'   => 'Garten2000 Handewitt',
    'desc'    => 'Webseite für ein Gartencenter mit modernem Auftritt und klarer Struktur für Leistungen, Angebote und Kontakt.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://jasonholweg.de/demo/garten2000',
      ],
    ],
    'image'   => 'garten2000-handewitt.de.png',
    'color'   => 'var(--c5)',
  ],
  [
    'emoji'   => '📍',
    'bg'      => 'linear-gradient(135deg,rgba(251,191,36,0.3),rgba(249,115,22,0.3))',
    'tags'    => ['360°', 'Webplattform', 'Partnerprojekt'],
    'title'   => 'Visitfy',
    'desc'    => 'Webseite für 360-Grad-Rundgänge – umgesetzt als Partnerprojekt mit Fokus auf Präsentation und Nutzerführung.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://visitfy.de',
      ],
    ],
    'image'   => 'visitfy.de.png',
    'color'   => 'var(--c4)',
  ],
  [
    'emoji'   => '🍨',
    'bg'      => 'linear-gradient(135deg,rgba(59,130,246,0.3),rgba(14,165,233,0.3))',
    'tags'    => ['Admin-Panel', 'Event-Anmeldung', 'Konfigurator'],
    'title'   => 'Flora Kaffee & Eisbar',
    'desc'    => 'Webseite für meine Eiscafés mit Veranstaltungen inkl. Anmeldung, Eistorten-Konfigurator und Speisekarte mit Highlights – komplett im Admin-Panel bearbeitbar.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://flora-fl.de/index.php',
      ],
    ],
    'image'   => 'flora-fl.de.png',
    'color'   => 'var(--c6)',
  ],
  [
    'emoji'   => '🌸',
    'bg'      => 'linear-gradient(135deg,rgba(244,114,182,0.3),rgba(168,85,247,0.3))',
    'tags'    => ['Gastronomie', 'Speisekarte', 'Reservierungssystem'],
    'title'   => 'Garten Café Magnolia',
    'desc'    => 'Webseite für das Garten Café Magnolia in Handewitt mit digitaler Speisekarte und integriertem Reservierungssystem.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://jasonholweg.de/demo/magnolia',
      ],
    ],
    'image'   => 'magnolia-cafe.de.png',
    'color'   => 'var(--c7)',
  ],
  [
    'emoji'   => '✂️',
    'bg'      => 'linear-gradient(135deg,rgba(255,107,107,0.3),rgba(255,0,128,0.3))',
    'tags'    => ['CMS', 'Preisliste', 'Service-Website'],
    'title'   => 'Lyvs Haarstudio',
    'desc'    => 'Schöne Friseur-Webseite mit Preisliste und vollständig bearbeitbaren Inhalten über ein Admin-Panel.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://lyvs-haarstudio.de',
      ],
    ],
    'image'   => 'lyvs-haarstudio.de.png',
    'color'   => 'var(--c1)',
  ],
  [
    'emoji'   => '🇫🇷',
    'bg'      => 'linear-gradient(135deg,rgba(168,85,247,0.3),rgba(59,130,246,0.3))',
    'tags'    => ['Branding', 'Gastro', 'Webdesign'],
    'title'   => 'Glacelia',
    'desc'    => 'Webseite für eine Eisdiele mit französischem Eis – "Eis wie aus Paris" als zentraler Markenbotschaft.',
    'actions' => [
      [
        'label' => 'Projekt ansehen',
        'url'   => 'https://jasonholweg.de/demo/glacelia',
      ],
    ],
    'image'   => 'glacelia.de.png',
    'color'   => 'var(--c3)',
  ],
];
?>

<main>
  <div class="projects-page-flow premium-effects-section">
    <div class="premium-ribbon-wrapper" aria-hidden="true">
      <canvas id="premium-ribbon-canvas" class="premium-ribbon-canvas"></canvas>
    </div>
    <div class="premium-vignette" aria-hidden="true"></div>
    <div class="orb" style="position:absolute;width:520px;height:520px;top:-120px;left:-140px;background:radial-gradient(circle,rgba(168,85,247,0.12),transparent 72%);z-index:0;"></div>
    <div class="orb" style="position:absolute;width:440px;height:440px;bottom:18%;right:-100px;background:radial-gradient(circle,rgba(78,205,196,0.1),transparent 72%);z-index:0;"></div>

    <header class="page-hero premium-effects-section projects-page-hero" role="banner">
      <div class="premium-antigravity-wrapper" aria-hidden="true" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:0;pointer-events:none;">
        <canvas id="premium-antigravity-canvas" class="premium-antigravity-canvas" style="position:absolute;top:0;left:0;width:100%;height:100%;"></canvas>
      </div>
      <div class="orb" style="position:absolute;width:500px;height:500px;top:-80px;left:-100px;background:radial-gradient(circle,rgba(168,85,247,0.2),transparent 70%);z-index:1;"></div>
      <div class="orb" style="position:absolute;width:350px;height:350px;bottom:0;right:-80px;background:radial-gradient(circle,rgba(59,130,246,0.18),transparent 70%);z-index:1;"></div>
      <div class="container" style="position:relative;z-index:1">
        <p class="section-label">Ausgewählte Arbeiten</p>
        <h1 class="fade-up"><span class="grad-text">Meine Projekte</span></h1>
        <p class="fade-up fade-up-d1">Einblicke in Webseiten und Webanwendungen, die ich mit Liebe zum Detail gebaut habe.</p>
      </div>
    </header>

    <section class="section projects-showcase-section projects-section" aria-labelledby="projects-heading">
    <div class="container">
      <h2 class="sr-only" id="projects-heading">Alle Projekte</h2>

      <div class="projects-grid projects-page-grid">
        <?php foreach ($projects as $i => $p): ?>
        <article class="project-card project-page-reveal glass fade-up"
                 style="--project-accent:<?= htmlspecialchars($p['color']) ?>;--project-delay:<?= htmlspecialchars(number_format(($i % 4) * 0.12 + floor($i / 4) * 0.04, 2, '.', '')) ?>s;">
          <div class="project-img">
            <div class="project-img-bg" style="--proj-bg:<?= htmlspecialchars($p['bg']) ?>">
              <?php
              $imageUrl = null;
              if (!empty($p['image'])) {
                $imagePath = __DIR__ . '/../assets/img/projekte/' . $p['image'];
                if (is_file($imagePath)) {
                  $imageUrl = $root . 'assets/img/projekte/' . rawurlencode($p['image']);
                }
              }
              ?>
              <?php if ($imageUrl): ?>
              <img
                src="<?= htmlspecialchars($imageUrl) ?>"
                alt="Vorschau von <?= htmlspecialchars($p['title']) ?>"
                class="project-preview"
                loading="lazy"
                decoding="async"
              >
              <?php else: ?>
              <span class="project-emoji" style="filter:drop-shadow(0 0 20px <?= htmlspecialchars($p['color']) ?>)"><?= $p['emoji'] ?></span>
              <?php endif; ?>
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
            <?php if (!empty($p['credentials'])): ?>
            <div class="project-credentials" aria-label="Demo-Zugangsdaten">
              <?php foreach ($p['credentials'] as $credential): ?>
              <span><?= htmlspecialchars($credential) ?></span>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="project-links">
              <?php foreach ($p['actions'] as $action): ?>
              <a href="<?= htmlspecialchars($action['url']) ?>" class="project-link" style="color:<?= htmlspecialchars($p['color']) ?>" target="_blank" rel="noopener noreferrer">
                <?= htmlspecialchars($action['label']) ?> <span aria-hidden="true">↗</span>
              </a>
              <?php endforeach; ?>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </div>
    </section>
  </div>

  <!-- CTA -->
  <section class="cta-section" aria-labelledby="cta-heading">
    <div class="cta-section__ambient cta-section__ambient--violet" aria-hidden="true"></div>
    <div class="cta-section__ambient cta-section__ambient--cyan" aria-hidden="true"></div>
    <div class="cta-section__grid" aria-hidden="true"></div>

    <div class="container">
      <div class="cta-panel glass">
        <div class="cta-panel__noise" aria-hidden="true"></div>
        <div class="cta-panel__border-glow" aria-hidden="true"></div>

        <div class="cta-copy">
          <p class="cta-kicker fade-up">Bereit fuer den naechsten Schritt</p>
          <h2 class="fade-up" id="cta-heading">
            Lass uns deine neue<br>
            <span class="grad-text">Webseite planen.</span>
          </h2>
          <p class="cta-lead fade-up fade-up-d1">
            Gemeinsam etwas Grossartiges bauen. Schreib mir fuer ein unverbindliches Erstgespraech und wir entwickeln einen Auftritt, der hochwertig wirkt, Vertrauen aufbaut und Anfragen erzeugt.
          </p>
          <div class="cta-actions fade-up fade-up-d2">
            <a href="Kontakt.php" class="btn btn-primary cta-primary cta-primary--hero">Kostenloses Erstgespraech buchen <span aria-hidden="true">→</span></a>
          </div>
          <div class="cta-signals fade-up fade-up-d3" aria-label="Vorteile">
            <span class="cta-signal">Antwort innerhalb von 48h</span>
            <span class="cta-signal">Strategisch, modern, performant</span>
            <span class="cta-signal">Klarer Prozess ohne Chaos</span>
          </div>
        </div>

        <aside class="cta-side fade-up fade-up-d2" aria-label="Warum jetzt anfragen">
          <div class="cta-side__card">
            <span class="cta-side__label">Finaler Conversion-Moment</span>
            <p class="cta-side__title">Von der Idee zum starken digitalen Auftritt.</p>
            <p class="cta-side__text">Design, Entwicklung und Conversion-Fokus in einem klar gefuehrten Prozess, damit aus einer Anfrage ein sauber umgesetztes Ergebnis wird.</p>
          </div>
        </aside>
      </div>
    </div>
  </section>
</main>

<script src="<?= $root ?>assets/js/premium-effects.js"></script>
<?php include '../includes/footer.php'; ?>
