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
  <section class="hero section premium-effects-section" aria-labelledby="hero-heading">
    <!-- Premium Ribbon Effect Background - MUST be behind content -->
    <div class="premium-ribbon-wrapper" aria-hidden="true" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:0;pointer-events:none;">
      <canvas id="premium-ribbon-canvas" class="premium-ribbon-canvas" style="position:absolute;top:0;left:0;width:100%;height:100%;"></canvas>
    </div>

    <!-- Premium Vignette Overlay -->
    <div class="premium-vignette" aria-hidden="true" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:1;pointer-events:none;"></div>

    <!-- Background orbs -->
    <div class="orb" style="position:absolute;width:500px;height:500px;top:-100px;left:-150px;background:radial-gradient(circle,rgba(168,85,247,0.15),transparent 70%);z-index:1;"></div>
    <div class="orb" style="position:absolute;width:400px;height:400px;bottom:50px;right:-80px;background:radial-gradient(circle,rgba(78,205,196,0.12),transparent 70%);z-index:1;"></div>
    <div class="orb" style="position:absolute;width:300px;height:300px;top:40%;left:55%;background:radial-gradient(circle,rgba(59,130,246,0.10),transparent 70%);z-index:1;"></div>

    <!-- Hero Content - MUST be in front of effects -->
    <div class="container hero-content" style="position:relative;z-index:10;">
      <div class="hero-badge"><span class="dot"></span> Verfügbar für neue Projekte</div>

      <h1 id="hero-heading" class="hero-text">
        <span class="line-1">Jason Holweg</span>
        <span class="line-2">Webseiten mit Stil.
          <br>Und Wirkung.
        </span>
      </h1>

      <p class="hero-sub hero-subheadline">
       Moderne Webseiten für Unternehmen und Selbstständige.
Schnell, auffällig und auf neue Kunden optimiert.
      </p>

      <div class="hero-actions hero-buttons">
        <a href="pages/Kontakt.php" class="btn btn-primary cta-primary">Projekt starten</a>
        <a href="pages/projects.php"  class="btn btn-glass cta-secondary">Projekte ansehen</a>
      </div>
      <p class="hero-trust">No spam. Kostenloses Erstgespräch. Antwort innerhalb von 48h.</p>
    </div>

    <div class="hero-scroll scroll-indicator" aria-hidden="true">Scroll</div>
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
                 style="--accent-grad:linear-gradient(90deg,var(--c3),var(--c6));--icon-grad-a:rgba(168,85,247,0.2);--icon-grad-b:rgba(59,130,246,0.26);--icon-glow-a:rgba(168,85,247,0.42);--icon-glow-b:rgba(59,130,246,0.3)">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M12 3a9 9 0 0 0 0 18h1.12a1.88 1.88 0 0 0 1.88-1.88c0-.47-.18-.92-.5-1.26a1.77 1.77 0 0 1-.44-1.14c0-.97.79-1.75 1.75-1.75H17A4 4 0 0 0 21 11a8 8 0 0 0-9-8m-5.5 9A1.5 1.5 0 1 1 8 10.5A1.5 1.5 0 0 1 6.5 12m3-4A1.5 1.5 0 1 1 11 6.5A1.5 1.5 0 0 1 9.5 8m5 0A1.5 1.5 0 1 1 16 6.5A1.5 1.5 0 0 1 14.5 8m3 4a1.5 1.5 0 1 1 1.5-1.5a1.5 1.5 0 0 1-1.5 1.5"/>
            </svg>
          </div>
          <h3>Individuelles Webdesign</h3>
          <p>Modernes Webdesign mit einzigartigem Stil und flüssigen Animationen.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d2"
                 style="--accent-grad:linear-gradient(90deg,var(--c2),var(--c5));--icon-grad-a:rgba(78,205,196,0.2);--icon-grad-b:rgba(16,185,129,0.24);--icon-glow-a:rgba(78,205,196,0.42);--icon-glow-b:rgba(16,185,129,0.28)">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M13 2L4 14h6l-1 8l9-12h-6z"/>
            </svg>
          </div>
          <h3>High-Performance Entwicklung</h3>
          <p>Performanter Code mit PHP, HTML, CSS und JavaScript – schnell, sauber und vollständig responsive.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d3"
                 style="--accent-grad:linear-gradient(90deg,var(--c4),var(--c1));--icon-grad-a:rgba(251,191,36,0.2);--icon-grad-b:rgba(255,107,107,0.24);--icon-glow-a:rgba(251,191,36,0.42);--icon-glow-b:rgba(255,107,107,0.28)">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 25">
              <path d="M11.2498 5.75037C10.8356 5.75037 10.4998 6.08615 10.4998 6.50037C10.4998 6.91458 10.8356 7.25037 11.2498 7.25037C13.874 7.25037 16.0011 9.37718 16.0011 12.0004C16.0011 12.4146 16.3369 12.7504 16.7511 12.7504C17.1653 12.7504 17.5011 12.4146 17.5011 12.0004C17.5011 8.54842 14.7021 5.75037 11.2498 5.75037Z" fill="currentColor"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M2 11.9989C2 6.89126 6.14154 2.75098 11.25 2.75098C16.3585 2.75098 20.5 6.89126 20.5 11.9989C20.5 14.2836 19.6714 16.3747 18.2983 17.9883L21.7791 21.4695C22.072 21.7624 22.072 22.2372 21.7791 22.5301C21.4862 22.823 21.0113 22.823 20.7184 22.5301L17.2372 19.0486C15.6237 20.4197 13.5334 21.2469 11.25 21.2469C6.14154 21.2469 2 17.1066 2 11.9989ZM11.25 4.25098C6.96962 4.25098 3.5 7.72003 3.5 11.9989C3.5 16.2779 6.96962 19.7469 11.25 19.7469C15.5304 19.7469 19 16.2779 19 11.9989C19 7.72003 15.5304 4.25098 11.25 4.25098Z" fill="currentColor"/>
            </svg>
          </div>
          <h3>SEO &amp; Performance</h3>
          <p>Technisches SEO und Performance-Optimierung für bessere Rankings und schnelle Ladezeiten.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d4"
                 style="--accent-grad:linear-gradient(90deg,var(--c7),var(--c3));--icon-grad-a:rgba(244,114,182,0.22);--icon-grad-b:rgba(168,85,247,0.24);--icon-glow-a:rgba(244,114,182,0.42);--icon-glow-b:rgba(168,85,247,0.28)">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M7 18a2 2 0 1 0 2 2a2 2 0 0 0-2-2m10 0a2 2 0 1 0 2 2a2 2 0 0 0-2-2M7.17 14h9.92a2 2 0 0 0 1.91-1.41L21 6H6.21l-.47-2H2v2h2.17z"/>
            </svg>
          </div>
          <h3>Online-Shops</h3>
          <p>Individuelle Online-Shops, die Produkte optimal präsentieren und Besucher in Kunden verwandeln.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d5"
                 style="--accent-grad:linear-gradient(90deg,var(--c6),var(--c2));--icon-grad-a:rgba(59,130,246,0.22);--icon-grad-b:rgba(78,205,196,0.22);--icon-glow-a:rgba(59,130,246,0.42);--icon-glow-b:rgba(78,205,196,0.28)">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M7 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm5 18a1.25 1.25 0 1 1 1.25-1.25A1.25 1.25 0 0 1 12 20m5-4H7V5h10z"/>
            </svg>
          </div>
          <h3>Mobile-First Design</h3>
          <p>Pixel-perfektes Responsive-Design für Smartphone, Tablet und Desktop.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d1"
                 style="    --accent-grad: linear-gradient(90deg, #3f10b9, #cd6c4e);
    --icon-grad-a: rgb(16 22 185 / 22%);
    --icon-grad-b: rgb(205 114 78 / 22%);
    --icon-glow-a: rgb(16 38 185 / 42%);
    --icon-glow-b: rgb(205 121 78 / 28%);">
          <div class="service-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M13.4423 4.0528C13.4423 3.02209 14.2778 2.18652 15.3085 2.18652C16.3393 2.18652 17.1748 3.02208 17.1748 4.0528C17.1748 5.08352 16.3393 5.91908 15.3085 5.91908C14.2778 5.91908 13.4423 5.08352 13.4423 4.0528Z" fill="currentColor"/>
              <path d="M11.856 8.51792C11.856 7.2817 12.8581 6.27955 14.0943 6.27955H16.5226C17.7589 6.27955 18.761 7.2817 18.761 8.51792V9.44815C18.761 9.86237 18.4252 10.1982 18.011 10.1982H12.606C12.1917 10.1982 11.856 9.86237 11.856 9.44815V8.51792Z" fill="currentColor"/>
              <path d="M19.4265 11.0839C20.0838 10.5508 21.0446 10.6311 21.6042 11.2659C22.1113 11.841 22.1316 12.6974 21.6523 13.2959L17.7857 18.1245C17.4103 18.5934 16.8422 18.8663 16.2415 18.8663H10.0683C9.88238 18.8663 9.70304 18.9354 9.56514 19.0601L9.24091 19.3533C9.22557 19.3227 9.20925 19.2925 9.19195 19.2625L6.19328 14.0687C6.11945 13.9408 6.03193 13.8258 5.93363 13.7244L7.38752 12.5621C7.94102 12.1196 8.64045 11.8146 9.41265 11.8112C10.2258 11.8075 11.511 11.8794 12.6743 12.3037H15.6309C16.1953 12.3037 16.6724 12.6779 16.8276 13.1917C16.8623 13.3063 16.8809 13.4278 16.8809 13.5537C16.8809 14.2441 16.3212 14.8037 15.6309 14.8037H13.8345C13.5583 14.8037 13.3345 15.0276 13.3345 15.3037C13.3345 15.5799 13.5583 15.8037 13.8345 15.8037H15.6309C16.8735 15.8037 17.8809 14.7964 17.8809 13.5537C17.8809 13.187 17.7931 12.8408 17.6375 12.5349L19.4265 11.0839Z" fill="currentColor"/>
              <path d="M8.32592 19.7625C8.52709 20.1109 8.41691 20.5537 8.0817 20.7686L6.12367 21.899C5.76495 22.1062 5.30626 21.9832 5.09915 21.6245L2.10048 16.4307C2.00103 16.2584 1.97408 16.0537 2.02556 15.8616C2.07704 15.6694 2.20274 15.5056 2.375 15.4062L4.30273 14.2941C4.65191 14.0925 5.0958 14.2036 5.31019 14.5405C5.31605 14.5497 5.32174 14.5591 5.32725 14.5687L8.32592 19.7625Z" fill="currentColor"/>
            </svg>
          </div>
          <h3>Wartung &amp; Support</h3>
          <p>Updates, Sicherheit und Anpassungen – damit deine Website dauerhaft stabil läuft.</p>
        </article>

      </div>
    </div>
  </section>

  <!-- ── STATS ─────────────────────────────────────────────── -->
  <section class="section" aria-label="Zahlen & Fakten">
    <div class="container">
      <p class="section-label fade-up">Zahlen, die für sich sprechen</p>
      <div class="stats-row">
        <div class="stat-item glass fade-up">
          <div class="stat-number">8+</div>
          <div class="stat-label">Projekte umgesetzt</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d1">
          <div class="stat-number">100%</div>
          <div class="stat-label">zufriedene Kunden</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d2">
          <div class="stat-number">3+</div>
          <div class="stat-label">Jahre Erfahrung</div>
        </div>
        <div class="stat-item glass fade-up fade-up-d3">
          <div class="stat-number">48h</div>
          <div class="stat-label">Ø Antwortzeit</div>
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
        <div class="step-card glass fade-up fade-up-d1" data-step="01">
          <div class="step-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.28-.28.67-.36 1.02-.25c1.12.37 2.32.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02z"/>
            </svg>
          </div>
          <h3>Erstgespräch</h3>
          <p>Wir besprechen deine Ziele, Zielgruppe und Vorstellungen. Kostenlos und unverbindlich.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d2" data-step="02">
          <div class="step-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
              <path fill="currentColor" d="M21.211 6C8.579 6 1 16.133 1 21.2s2.526 8.867 7.579 8.867s7.58 1.266 7.58 5.066c0 5.066 3.789 8.866 8.842 8.866c16.422 0 24-8.866 24-17.732C49 11.067 36.366 6 21.211 6m-3.158 5.067a3.16 3.16 0 0 1 3.158 3.166c0 1.75-1.414 3.167-3.158 3.167s-3.158-1.418-3.158-3.167a3.16 3.16 0 0 1 3.158-3.166m10.104 0a3.16 3.16 0 0 1 3.158 3.166a3.16 3.16 0 0 1-3.158 3.167A3.16 3.16 0 0 1 25 14.233a3.16 3.16 0 0 1 3.157-3.166m10.106 5.066a3.16 3.16 0 0 1 3.159 3.167a3.16 3.16 0 0 1-3.159 3.166a3.16 3.16 0 0 1-3.157-3.166a3.16 3.16 0 0 1 3.157-3.167M9.211 18.667a3.16 3.16 0 0 1 3.157 3.165c0 1.75-1.414 3.167-3.157 3.167s-3.158-1.418-3.158-3.167a3.16 3.16 0 0 1 3.158-3.165M25 31.333c2.093 0 3.789 1.7 3.789 3.801c0 2.098-1.696 3.799-3.789 3.799s-3.789-1.701-3.789-3.799A3.794 3.794 0 0 1 25 31.333"/>
            </svg>
          </div>
          <h3>Konzept &amp; Design</h3>
          <p>Ich erstelle ein Designkonzept, das zu deiner Marke passt – mit Liquid-Glass-Elementen und individuellem Flair.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d3" data-step="03">
          <div class="step-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="m12.89 3l1.96.4L11.11 21l-1.96-.4zm6.7 9L16 8.41V5.58L22.42 12L16 18.41v-2.83zM1.58 12L8 5.58v2.83L4.41 12L8 15.58v2.83z"/>
            </svg>
          </div>
          <h3>Entwicklung</h3>
          <p>Sauberer, strukturierter Code. Ich halte dich mit regelmäßigen Updates auf dem Laufenden.</p>
        </div>
        <div class="step-card glass fade-up fade-up-d4" data-step="04">
          <div class="step-icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path fill="currentColor" d="M5 16c-2 1-2 5-2 5s3 0 5-2zM21 2h-3.69c-2.4 0-4.66.94-6.36 2.64L8.69 6.9a8.4 8.4 0 0 0-6.24 1.27c-.25.17-.41.44-.44.73s.08.59.29.81l12 12c.2.2.45.29.71.29s.51-.1.71-.29c1.9-1.9 1.6-5.08 1.38-6.38l2.28-2.28c1.7-1.7 2.64-3.96 2.64-6.36V3c0-.55-.45-1-1-1Zm-3.59 7.41c-.78.78-2.05.78-2.83 0s-.78-2.05 0-2.83s2.05-.78 2.83 0s.78 2.05 0 2.83"/>
            </svg>
          </div>
          <h3>Launch &amp; Übergabe</h3>
          <p>Test, Optimierung und Go-Live – danach kannst du Inhalte jederzeit einfach selbst über das CMS anpassen.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ── TRUST / TESTIMONIAL ──────────────────────────────── -->
  <section class="section" aria-labelledby="trust-heading">
    <div class="container">
      <p class="section-label fade-up">Für wen ich arbeite</p>
      <h2 class="section-title fade-up fade-up-d1" id="trust-heading">
        Vertrauen entsteht durch<br><span>echte Ergebnisse</span>
      </h2>

      <div class="trust-grid">
        <article class="testimonial-card testimonial glass fade-up fade-up-d2">
          <blockquote class="testimonial-quote">
            "Jason hat unsere Webseite komplett neu aufgebaut. Seitdem bekommen wir deutlich mehr Anfragen."
          </blockquote>
          <p class="testimonial-source testimonial-author">- Visitfy</p>
        </article>
      </div>
    </div>
  </section>

  <!-- ── PROJECT PREVIEW ──────────────────────────────────── -->
  <section class="section" aria-labelledby="project-preview-heading">
    <div class="container">
      <p class="section-label fade-up">Ausgewählte Projekte</p>
      <h2 class="section-title fade-up fade-up-d1" id="project-preview-heading">
        Ein kleiner Einblick in<br><span>aktuelle Arbeiten</span>
      </h2>

      <div class="projects-grid">
        <article class="project-card glass fade-up fade-up-d1">
          <div class="project-img">
            <div class="project-img-bg" style="--proj-bg:linear-gradient(135deg,rgba(16,185,129,0.3),rgba(78,205,196,0.3))">
              <img
                src="<?= $root ?>assets/img/projekte/garten2000-handewitt.de.png"
                alt="Vorschau des Projekts Garten2000 Handewitt"
                class="project-preview"
                loading="lazy"
              >
            </div>
          </div>
          <div class="project-body">
            <h3>Garten2000 Handewitt</h3>
            <p>Moderner Webauftritt für ein Gartencenter mit klarer Nutzerführung und starkem lokalem Auftritt.</p>
            <div class="project-links">
              <a href="pages/projects.php" class="project-link">Projekt ansehen <span aria-hidden="true">→</span></a>
            </div>
          </div>
        </article>

        <article class="project-card glass fade-up fade-up-d2">
          <div class="project-img">
            <div class="project-img-bg" style="--proj-bg:linear-gradient(135deg,rgba(251,191,36,0.3),rgba(249,115,22,0.3))">
              <img
                src="<?= $root ?>assets/img/projekte/visitfy.de.png"
                alt="Vorschau des Projekts Visitfy"
                class="project-preview"
                loading="lazy"
              >
            </div>
          </div>
          <div class="project-body">
            <h3>Visitfy</h3>
            <p>Präsentationsstarke Website für 360-Grad-Rundgänge mit Fokus auf Vertrauen, Klarheit und Anfragen.</p>
            <div class="project-links">
              <a href="pages/projects.php" class="project-link">Projekt ansehen <span aria-hidden="true">→</span></a>
            </div>
          </div>
        </article>

        <article class="project-card glass fade-up fade-up-d3">
          <div class="project-img">
            <div class="project-img-bg" style="--proj-bg:linear-gradient(135deg,rgba(59,130,246,0.3),rgba(14,165,233,0.3))">
              <img
                src="<?= $root ?>assets/img/projekte/flora-fl.de.png"
                alt="Vorschau des Projekts Flora Kaffee & Eisbar"
                class="project-preview"
                loading="lazy"
              >
            </div>
          </div>
          <div class="project-body">
            <h3>Flora Kaffee &amp; Eisbar</h3>
            <p>Website mit Event-Bereich, Speisekarte und CMS-Logik für schnelle inhaltliche Pflege im Alltag.</p>
            <div class="project-links">
              <a href="pages/projects.php" class="project-link">Projekt ansehen <span aria-hidden="true">→</span></a>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- ── CTA ───────────────────────────────────────────────── -->
  <section class="cta-section" aria-labelledby="cta-heading">
    <!-- Background orbs -->
    <div class="orb" style="width:600px;height:600px;top:50%;left:50%;transform:translate(-50%,-50%);background:radial-gradient(circle,rgba(168,85,247,0.18),transparent 70%);opacity:0.7"></div>

    <div class="container" style="position:relative;z-index:1">
      <h2 class="fade-up" id="cta-heading">
        Lass uns deine neue<br>
        <span class="grad-text">Webseite planen.</span>
      </h2>
      <p class="fade-up fade-up-d1">
        Gemeinsam etwas Großartiges bauen. Schreib mir – ich antworte innerhalb von 48 Stunden.
      </p>
      <a href="pages/Kontakt.php" class="btn btn-primary fade-up fade-up-d2">Kostenloses Erstgespräch buchen →</a>
    </div>
  </section>

</div><!-- /#main-content -->

<?php include 'includes/footer.php'; ?>

<!-- Intro animation script -->
<script src="<?= $root ?>assets/js/intro.js"></script>

<!-- Premium visual effects -->
<script src="<?= $root ?>assets/js/premium-effects.js"></script>
