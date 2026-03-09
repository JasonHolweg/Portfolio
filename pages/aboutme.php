<?php
$root      = '../';
$pageTitle = 'Über mich – Jason Holweg';
$pageDesc  = 'Ich bin Jason Holweg, Webentwickler und Designer aus Deutschland. Ich erstelle moderne Webseiten für Firmen und Selbstständige.';
include '../includes/header.php';
?>

<!-- Page Hero -->
<header class="page-hero premium-effects-section" role="banner">
  <!-- Premium Antigravity Effect Background - MUST be behind content -->
  <div class="premium-antigravity-wrapper" aria-hidden="true" style="position:absolute;top:0;left:0;right:0;bottom:0;z-index:0;pointer-events:none;">
    <canvas id="premium-antigravity-canvas" class="premium-antigravity-canvas" style="position:absolute;top:0;left:0;width:100%;height:100%;"></canvas>
  </div>

  <!-- Background orbs -->
  <div class="orb" style="position:absolute;width:500px;height:500px;top:-80px;right:-100px;background:radial-gradient(circle,rgba(78,205,196,0.2),transparent 70%);z-index:1;"></div>
  <div class="orb" style="position:absolute;width:350px;height:350px;bottom:0;left:-80px;background:radial-gradient(circle,rgba(168,85,247,0.18),transparent 70%);z-index:1;"></div>
  
  <!-- Hero Content - MUST be in front of effects -->
  <div class="container" style="position:relative;z-index:10;">
    <p class="section-label">Wer steckt dahinter?</p>
    <h1 class="fade-up"><span class="grad-text">Über mich</span></h1>
    <p class="fade-up fade-up-d1">Leidenschaftlicher Entwickler – mit einem Sinn für Ästhetik und Funktion.</p>
  </div>
</header>

<!-- About Section -->
<main>
  <section class="section" aria-labelledby="about-heading">
    <div class="container">
      <div class="about-layout">

        <!-- Avatar -->
        <div class="fade-up">
          <div class="about-avatar" aria-hidden="true">
            <span style="font-size:5rem;filter:drop-shadow(0 0 30px rgba(78,205,196,0.4))">👨‍💻</span>
          </div>
        </div>

        <!-- Text -->
        <div>
          <h2 class="section-title fade-up" id="about-heading">
            Hi, ich bin<br><span>Jason Holweg</span>
          </h2>
          <p class="fade-up fade-up-d1" style="color:var(--text-muted);line-height:1.8;margin-bottom:20px">
            Ich bin ein leidenschaftlicher Webentwickler und Designer aus Deutschland. Meine Arbeit verbindet technische Präzision mit einem starken Sinn für Ästhetik – das Ergebnis sind Webseiten, die nicht nur funktionieren, sondern auch begeistern.
          </p>
          <p class="fade-up fade-up-d2" style="color:var(--text-muted);line-height:1.8;margin-bottom:32px">
            Neben der Webentwicklung bin ich auch Unternehmer: mit Flora Kaffee &amp; Eisbar (2 Standorte in Flensburg) und dem Gartencafé Magnolia GbR im Gartencenter (aktuell im Bau, Eröffnung voraussichtlich Ende 2026 / Anfang 2027).
          </p>
          <p class="fade-up fade-up-d2" style="color:var(--text-muted);line-height:1.8;margin-bottom:32px">
            Deshalb weiß ich aus der Praxis, was Firmen für gute Kunden- und Gästebindung brauchen – und genau das bringe ich in meine Webseiten mit ein.
          </p>

          <div class="skills-list fade-up fade-up-d3">
            <span class="skill-chip">HTML5</span>
            <span class="skill-chip">CSS3</span>
            <span class="skill-chip">JavaScript</span>
            <span class="skill-chip">PHP</span>
            <span class="skill-chip">MySQL</span>
            <span class="skill-chip">Responsive Design</span>
            <span class="skill-chip">Figma</span>
            <span class="skill-chip">Git</span>
            <span class="skill-chip">SEO</span>
            <span class="skill-chip">WordPress</span>
            <span class="skill-chip">Performance-Optimierung</span>
            <span class="skill-chip">UI / UX</span>
          </div>

          <div style="margin-top:36px" class="fade-up fade-up-d4">
            <a href="Kontakt.php" class="btn btn-primary">Projekt anfragen →</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Values / What I believe in -->
  <section class="section" aria-labelledby="values-heading">
    <div class="container">
      <p class="section-label fade-up">Meine Werte</p>
      <h2 class="section-title fade-up fade-up-d1" id="values-heading">
        Was mich antreibt
      </h2>

      <div class="services-grid" style="margin-top:48px">

        <article class="service-card glass fade-up fade-up-d1"
                 style="--accent-grad:linear-gradient(90deg,var(--c2),var(--c5));--icon-bg:rgba(78,205,196,0.12);--icon-border:rgba(78,205,196,0.25)">
          <div class="service-icon">✨</div>
          <h3>Qualität über Quantität</h3>
          <p>Ich nehme mir die Zeit, die jedes Projekt verdient – lieber weniger Projekte mit höchster Qualität als viele halbfertige Lösungen.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d2"
                 style="--accent-grad:linear-gradient(90deg,var(--c3),var(--c7));--icon-bg:rgba(168,85,247,0.12);--icon-border:rgba(168,85,247,0.25)">
          <div class="service-icon">🤝</div>
          <h3>Partnerschaftliche Zusammenarbeit</h3>
          <p>Du bist nicht nur Auftraggeber – du bist Partner. Ich kommuniziere offen, halte Deadlines ein und liefere, was ich verspreche.</p>
        </article>

        <article class="service-card glass fade-up fade-up-d3"
                 style="--accent-grad:linear-gradient(90deg,var(--c4),var(--c1));--icon-bg:rgba(251,191,36,0.12);--icon-border:rgba(251,191,36,0.25)">
          <div class="service-icon">🚀</div>
          <h3>Immer am Puls der Zeit</h3>
          <p>Web-Technologien entwickeln sich rasant. Ich bilde mich ständig weiter, damit dein Projekt vom aktuellen Stand der Technik profitiert.</p>
        </article>

      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="orb" style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%);background:radial-gradient(circle,rgba(78,205,196,0.15),transparent 70%)"></div>
    <div class="container" style="position:relative;z-index:1">
      <h2 class="fade-up">Lass uns <span class="grad-text">zusammenarbeiten</span></h2>
      <p class="fade-up fade-up-d1">Ich freue mich darauf, dein nächstes Projekt zu hören.</p>
      <a href="Kontakt.php" class="btn btn-primary fade-up fade-up-d2">Kontakt aufnehmen →</a>
    </div>
  </section>
</main>

<?php include '../includes/footer.php'; ?>

<!-- Premium visual effects -->
<script src="<?= $root ?>assets/js/premium-effects.js"></script>
