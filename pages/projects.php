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
    'tags'    => ['PHP', 'CSS', 'JavaScript'],
    'title'   => 'Florist-Website',
    'desc'    => 'Elegante Webseite für ein lokales Florist-Studio mit Liquid-Glass-Design, Online-Buchung und Galerie.',
    'color'   => 'var(--c5)',
  ],
  [
    'emoji'   => '🍕',
    'bg'      => 'linear-gradient(135deg,rgba(251,191,36,0.3),rgba(249,115,22,0.3))',
    'tags'    => ['PHP', 'MySQL', 'CSS'],
    'title'   => 'Restaurant-Auftritt',
    'desc'    => 'Modernes Online-Menü und Reservierungssystem für ein Stadtrestaurant – mit mehrsprachiger Unterstützung.',
    'color'   => 'var(--c4)',
  ],
  [
    'emoji'   => '💼',
    'bg'      => 'linear-gradient(135deg,rgba(59,130,246,0.3),rgba(14,165,233,0.3))',
    'tags'    => ['JavaScript', 'CSS', 'Responsive'],
    'title'   => 'Business-Portfolio',
    'desc'    => 'Professionelles Portfolio für einen Unternehmensberater – minimalistisch, wirkungsvoll und mobiloptimiert.',
    'color'   => 'var(--c6)',
  ],
  [
    'emoji'   => '🛍️',
    'bg'      => 'linear-gradient(135deg,rgba(244,114,182,0.3),rgba(168,85,247,0.3))',
    'tags'    => ['E-Commerce', 'PHP', 'CSS'],
    'title'   => 'Fashion-Shop',
    'desc'    => 'Online-Shop für ein Boutique-Label mit individuellem Produktkonfigurator und klarem Checkout-Prozess.',
    'color'   => 'var(--c7)',
  ],
  [
    'emoji'   => '🏋️',
    'bg'      => 'linear-gradient(135deg,rgba(255,107,107,0.3),rgba(255,0,128,0.3))',
    'tags'    => ['PHP', 'JavaScript', 'Animation'],
    'title'   => 'Fitness-Studio-Website',
    'desc'    => 'Dynamische Webseite mit Kursplan, Online-Anmeldung und motivierenden Micro-Animationen.',
    'color'   => 'var(--c1)',
  ],
  [
    'emoji'   => '📸',
    'bg'      => 'linear-gradient(135deg,rgba(168,85,247,0.3),rgba(59,130,246,0.3))',
    'tags'    => ['Galerie', 'CSS', 'Lightbox'],
    'title'   => 'Fotografen-Portfolio',
    'desc'    => 'Bildgewaltiges Portfolio mit Fullscreen-Galerie, flüssigen Übergängen und elegantem Glassmorphism-Design.',
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
            <a href="Kontakt.php" class="project-link" style="color:<?= htmlspecialchars($p['color']) ?>">
              Ähnliches Projekt anfragen <span aria-hidden="true">→</span>
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
