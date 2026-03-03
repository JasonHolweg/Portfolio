<?php
$root      = '';
$pageTitle = 'Jason Holweg – Webseiten für Firmen mit Stil';
$pageDesc  = 'Ich entwickle individuelle, moderne Webseiten und Webanwendungen für Firmen und Selbstständige – mit flüssigem Design, schneller Performance und klarer Botschaft.';
include 'includes/header.php';
?>

<!-- ═══════════════════════════════════════════════════════
     INTRO ANIMATION OVERLAY
═══════════════════════════════════════════════════════ -->
<div id="intro" role="presentation" aria-hidden="true">
  <canvas id="intro-canvas"></canvas>

  <div id="intro-text">
    <h1>Jason Holweg</h1>
    <p>Webseiten für Firmen mit Stil</p>
    <p class="scroll-hint">Klicken zum Fortfahren</p>
  </div>

  <button id="skip-btn" type="button">Überspringen ↓</button>
</div>

<!-- ═══════════════════════════════════════════════════════
     MAIN CONTENT (hidden until intro completes)
═══════════════════════════════════════════════════════ -->
<div id="main-content" style="opacity:0;">

  <!-- ── HERO ─────────────────────────────────────────────── -->
  <section class="hero section" aria-labelledby="hero-heading">
    <!-- Background orbs -->
    <div class="orb" style="width:500px;height:500px;top:-100px;left:-150px;background:radial-gradient(circle,rgba(168,85,247,0.25),transparent 70%)"></div>
    <div class="orb" style="width:400px;height:400px;bottom:50px;right:-80px;background:radial-gradient(circle,rgba(78,205,196,0.2),transparent 70%)"></div>
    <div class="orb" style="width:300px;height:300px;top:40%;left:55%;background:radial-gradient(circle,rgba(59,130,246,0.15),transparent 70%)"></div>

    <div class="container hero-content">
      <div class="hero-badge"><span class="dot"></span> Verfügbar für neue Projekte</div>

      <h1 id="hero-heading">
        <span class="line-1">Jason Holweg</span>
        <span class="line-2">Webseiten mit Stil.</span>
      </h1>

      <p class="hero-sub">
        Ich entwickle moderne, individuelle Webauftritte für Unternehmen und Selbstständige –
        mit auffälligem Design, schneller Performance und klarer Botschaft.
      </p>

      <div class="hero-actions">
        <a href="pages/projects.php" class="btn btn-primary">Meine Projekte ansehen</a>
        <a href="pages/Kontakt.php"  class="btn btn-glass">Projekt anfragen</a>
      </div>
    </div>

    <div class="hero-scroll" aria-hidden="true">Scroll</div>
  </section>

  <!-- ── SERVICES ─────────────────────────────────────────── -->
  <section class="section" id="services" aria-labelledby="services-heading">
    <div class="container">
      <p class="section-label fade-up">Was ich biete</p>
      <h2 class="section-title fade-up fade-up-d1" id="services-heading">
        Leistungen, die dein<br><span>Business voranbringen</span>
      </h2>
      <p class="section-sub fade-up fade-up-d2">
        Von der ersten Idee bis zum fertigen Launch – ich begleite dein Projekt mit Know-how und Leidenschaft.
      </p>

      <div class="services-grid">

        <article class="service-card glass fade-up fade-up-d1"
                 style="--accent-grad:linear-gradient(90deg,var(--c3),var(--c6));--icon-bg:rgba(168,85,247,0.12);--icon-border:rgba(168,85,247,0.25)">
          <div class="service-icon">🎨</div>
          <h3>Web-Design</h3>
          <p>Einzigartiges visuelles Design mit Liquid-Glass-Elementen, flüssigen Animationen und einem unverwechselbaren Stil, der deine Marke stärkt.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d2"
                 style="--accent-grad:linear-gradient(90deg,var(--c2),var(--c5));--icon-bg:rgba(78,205,196,0.12);--icon-border:rgba(78,205,196,0.25)">
          <div class="service-icon">⚡</div>
          <h3>Web-Entwicklung</h3>
          <p>Sauberer, performanter Code mit PHP, HTML, CSS und JavaScript. Responsive für alle Endgeräte, optimiert für schnelle Ladezeiten.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d3"
                 style="--accent-grad:linear-gradient(90deg,var(--c4),var(--c1));--icon-bg:rgba(251,191,36,0.12);--icon-border:rgba(251,191,36,0.25)">
          <div class="service-icon">🔍</div>
          <h3>SEO &amp; Performance</h3>
          <p>Technische Optimierung für Suchmaschinen und blitzschnelle Ladezeiten – damit dein Auftritt gefunden wird und Besucher bleibt.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d4"
                 style="--accent-grad:linear-gradient(90deg,var(--c7),var(--c3));--icon-bg:rgba(244,114,182,0.12);--icon-border:rgba(244,114,182,0.25)">
          <div class="service-icon">🛒</div>
          <h3>Online-Shops</h3>
          <p>Individuelle E-Commerce-Lösungen, die dein Produkt ins beste Licht rücken und Besucher in Kunden verwandeln.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d5"
                 style="--accent-grad:linear-gradient(90deg,var(--c6),var(--c2));--icon-bg:rgba(59,130,246,0.12);--icon-border:rgba(59,130,246,0.25)">
          <div class="service-icon">📱</div>
          <h3>Mobile-First</h3>
          <p>Pixel-perfektes Responsive-Design für Smartphones, Tablets und Desktop – deine Seite sieht überall großartig aus.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d1"
                 style="--accent-grad:linear-gradient(90deg,var(--c5),var(--c2));--icon-bg:rgba(16,185,129,0.12);--icon-border:rgba(16,185,129,0.25)">
          <div class="service-icon">🔧</div>
          <h3>Wartung &amp; Support</h3>
          <p>Nach dem Launch nicht allein gelassen – ich kümmere mich um Updates, Sicherheit und Anpassungen, damit deine Seite immer läuft.</p>
        </article>

      </div>
    </div>
  </section>

  <!-- ── STATS ─────────────────────────────────────────────── -->
  <section class="section" aria-label="Zahlen & Fakten">
    <div class="container">
      <div class="stats-row">
        <div class="stat-item glass fade-up">
          <div class="stat-number">20+</div>
          <div class="stat-label">Projekte umgesetzt</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d1">
          <div class="stat-number">100%</div>
          <div class="stat-label">Kundenzufriedenheit</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d2">
          <div class="stat-number">3+</div>
          <div class="stat-label">Jahre Erfahrung</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d3">
          <div class="stat-number">48h</div>
          <div class="stat-label">Antwortzeit</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ── PROCESS ───────────────────────────────────────────── -->
  <section class="section" aria-labelledby="process-heading">
    <div class="container">
      <p class="section-label fade-up">Mein Ablauf</p>
      <h2 class="section-title fade-up fade-up-d1" id="process-heading">
        So läuft ein Projekt<br><span>bei mir ab</span>
      </h2>

      <div class="process-steps">
        <div class="step-card glass fade-up fade-up-d1">
          <div class="step-num">01</div>
          <h3>Erstgespräch</h3>
          <p>Wir besprechen deine Ziele, Zielgruppe und Vorstellungen. Kostenlos und unverbindlich.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d2">
          <div class="step-num">02</div>
          <h3>Konzept &amp; Design</h3>
          <p>Ich erstelle ein Designkonzept, das zu deiner Marke passt – mit Liquid-Glass-Elementen und individuellem Flair.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d3">
          <div class="step-num">03</div>
          <h3>Entwicklung</h3>
          <p>Sauberer, strukturierter Code. Ich halte dich mit regelmäßigen Updates auf dem Laufenden.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d4">
          <div class="step-num">04</div>
          <h3>Launch &amp; Übergabe</h3>
          <p>Test, Optimierung und Go-Live – du erhältst alle Zugänge und eine persönliche Einweisung.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── CTA ───────────────────────────────────────────────── -->
  <section class="cta-section" aria-labelledby="cta-heading">
    <!-- Background orbs -->
    <div class="orb" style="width:600px;height:600px;top:50%;left:50%;transform:translate(-50%,-50%);background:radial-gradient(circle,rgba(168,85,247,0.18),transparent 70%);opacity:0.7"></div>

    <div class="container" style="position:relative;z-index:1">
      <h2 class="fade-up" id="cta-heading">
        Bereit für deinen<br>
        <span class="grad-text">neuen Webauftritt?</span>
      </h2>
      <p class="fade-up fade-up-d1">
        Lass uns gemeinsam etwas Großartiges bauen. Schreib mir – ich antworte innerhalb von 48 Stunden.
      </p>
      <a href="pages/Kontakt.php" class="btn btn-primary fade-up fade-up-d2">Jetzt Kontakt aufnehmen →</a>
    </div>
  </section>

</div><!-- /#main-content -->

<?php include 'includes/footer.php'; ?>

<!-- Intro animation script -->
<script src="<?= $root ?>assets/js/intro.js"></script>
