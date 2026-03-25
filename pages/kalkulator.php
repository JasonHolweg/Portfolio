<?php
$root      = '../';
$pageTitle = 'Projekt-Kalkulator – Jason Holweg';
$pageDesc  = 'Berechne die Investition in dein Webprojekt – transparent, fair und auf Ergebnisse ausgerichtet.';
$bodyClass = 'page-calculator';
$navClass  = 'scrolled';
include '../includes/header.php';
?>

<header class="page-hero" role="banner">
  <div class="orb" style="width:450px;height:450px;top:-60px;right:-80px;background:radial-gradient(circle,rgba(255,107,107,0.22),transparent 70%)"></div>
  <div class="orb" style="width:350px;height:350px;bottom:-40px;left:-60px;background:radial-gradient(circle,rgba(78,205,196,0.18),transparent 70%)"></div>
  <div class="container" style="position:relative;z-index:1">
    <p class="section-label">Projekt-Kalkulator</p>
    <h1 class="fade-up"><span class="grad-text">Was ist deine Webseite wirklich wert?</span></h1>
    <p class="fade-up fade-up-d1">
      Konfiguriere dein Projekt und sieh sofort, was deine Investition bringt – volle Transparenz, keine versteckten Kosten.
    </p>
  </div>
</header>

<main>
  <section class="section calc-section" id="calculator-section" aria-labelledby="calc-heading">
    <div class="container">

      <div class="calc-header fade-up">
        <p class="section-label">Deine Investition</p>
        <h2 class="section-title" id="calc-heading">Webseite, die Kunden bringt – nicht nur gut aussieht</h2>
        <p class="calc-header__sub">Jedes Paket beinhaltet Design + Entwicklung aus einer Hand. Keine halben Sachen.</p>
      </div>

      <div class="calc-grid fade-up fade-up-d1">

        <!-- LEFT: Calculator Form -->
        <div class="calc-form">

          <!-- 1) Project Scope -->
          <div class="calc-block">
            <h3>Welches Paket passt zu deinem Ziel?</h3>
            <div class="calc-tiers" role="radiogroup" aria-label="Projektumfang">

              <label class="calc-tier">
                <input type="radio" name="projectTier" value="starter">
                <div class="calc-tier__inner">
                  <div class="calc-tier__header">
                    <span class="calc-tier__name">Starter</span>
                    <span class="calc-tier__base">ab 1.900&thinsp;€</span>
                  </div>
                  <p class="calc-tier__desc">Professioneller Online-Auftritt mit klarem Design, responsivem Layout und schneller Ladezeit – ideal für den ersten Eindruck, der überzeugt.</p>
                  <ul class="calc-tier__features">
                    <li>Bis zu 5 Seiten</li>
                    <li>Responsive Design</li>
                    <li>Kontaktformular</li>
                    <li>Google-optimierte Grundstruktur</li>
                  </ul>
                </div>
              </label>

              <label class="calc-tier calc-tier--popular">
                <input type="radio" name="projectTier" value="business" checked>
                <div class="calc-tier__inner">
                  <span class="calc-tier__badge">Beliebteste Wahl</span>
                  <div class="calc-tier__header">
                    <span class="calc-tier__name">Business</span>
                    <span class="calc-tier__base">ab 4.000&thinsp;€</span>
                  </div>
                  <p class="calc-tier__desc">Conversion-optimierte Webseite mit strategischem Aufbau, die aus Besuchern zahlende Kunden macht – mit CMS, Blog und Lead-Generierung.</p>
                  <ul class="calc-tier__features">
                    <li>Bis zu 10 Seiten</li>
                    <li>CMS-Integration</li>
                    <li>Blog / News-Bereich</li>
                    <li>SEO-Grundoptimierung</li>
                    <li>Conversion-optimierter Aufbau</li>
                  </ul>
                </div>
              </label>

              <label class="calc-tier">
                <input type="radio" name="projectTier" value="performance">
                <div class="calc-tier__inner">
                  <div class="calc-tier__header">
                    <span class="calc-tier__name">High-Performance</span>
                    <span class="calc-tier__base">ab 6.500&thinsp;€</span>
                  </div>
                  <p class="calc-tier__desc">Maximale Wirkung durch Animationen, Storytelling und volle SEO-Power – für Unternehmen, die online dominieren wollen.</p>
                  <ul class="calc-tier__features">
                    <li>Unbegrenzte Seiten</li>
                    <li>Premium-Animationen & Effekte</li>
                    <li>Volle SEO-Optimierung</li>
                    <li>Performance-Tuning (90+ Lighthouse)</li>
                    <li>Analytics & Tracking Setup</li>
                  </ul>
                </div>
              </label>

              <label class="calc-tier">
                <input type="radio" name="projectTier" value="enterprise">
                <div class="calc-tier__inner">
                  <div class="calc-tier__header">
                    <span class="calc-tier__name">Enterprise</span>
                    <span class="calc-tier__base">ab 10.000&thinsp;€</span>
                  </div>
                  <p class="calc-tier__desc">Maßgeschneiderte Web-Lösung mit komplexer Logik, API-Anbindungen, Benutzerportal oder E-Commerce – ohne Kompromisse.</p>
                  <ul class="calc-tier__features">
                    <li>Web-App / Portal / Shop</li>
                    <li>API-Anbindungen & Automatisierung</li>
                    <li>Individuelle Geschäftslogik</li>
                    <li>Alle High-Performance Features</li>
                    <li>Persönlicher Projektmanager</li>
                  </ul>
                </div>
              </label>

            </div>
          </div>

          <!-- 2) Add-ons -->
          <div class="calc-block">
            <h3>Zusätzlich mehr rausholen?</h3>
            <div class="calc-checks">
              <label class="calc-check">
                <input type="checkbox" id="needContent">
                <span class="calc-check__box"></span>
                <span class="calc-check__label">Professionelle Texte & Inhalte
                  <span class="calc-tooltip" aria-label="Verkaufsstarke Texte, Headlines und Call-to-Actions, die deine Zielgruppe ansprechen und zur Handlung bewegen." tabindex="0">?</span>
                </span>
                <span class="calc-check__price">+10 %</span>
              </label>
              <label class="calc-check">
                <input type="checkbox" id="needSEO">
                <span class="calc-check__box"></span>
                <span class="calc-check__label">Erweiterte SEO-Strategie
                  <span class="calc-tooltip" aria-label="Keyword-Recherche, technisches SEO, Ladezeit-Optimierung und strukturierte Daten – damit du bei Google auf Seite 1 landest." tabindex="0">?</span>
                </span>
                <span class="calc-check__price">+8 %</span>
              </label>
              <label class="calc-check">
                <input type="checkbox" id="needMaintenance">
                <span class="calc-check__box"></span>
                <span class="calc-check__label">Wartung & Support (12 Monate)
                  <span class="calc-tooltip" aria-label="Monatliche Updates, Sicherheits-Checks, Performance-Monitoring und schneller Support – damit deine Webseite dauerhaft Top-Leistung bringt." tabindex="0">?</span>
                </span>
                <span class="calc-check__price">+15 %</span>
              </label>
            </div>
          </div>

          <!-- 3) Timeline -->
          <div class="calc-block">
            <h3>Wann soll deine Webseite live gehen?</h3>
            <div class="calc-radios" role="radiogroup" aria-label="Zeitrahmen">
              <label class="calc-radio calc-radio--timeline">
                <input type="radio" name="timeline" value="rush">
                <span class="calc-radio__circle"></span>
                <span>Express – innerhalb von 7 Tagen</span>
                <span class="calc-radio__price">+25 %</span>
              </label>
              <label class="calc-radio calc-radio--timeline">
                <input type="radio" name="timeline" value="fast">
                <span class="calc-radio__circle"></span>
                <span>Schnell – innerhalb von 14 Tagen</span>
                <span class="calc-radio__price">+10 %</span>
              </label>
              <label class="calc-radio calc-radio--timeline">
                <input type="radio" name="timeline" value="regular" checked>
                <span class="calc-radio__circle"></span>
                <span>Standard – nach Absprache</span>
              </label>
            </div>
          </div>

        </div>

        <!-- RIGHT: Cost Estimation -->
        <div class="calc-result">
          <h3>Deine Investition</h3>
          <p class="calc-result__desc">Transparente Preise basierend auf deiner Auswahl – keine versteckten Kosten, kein Kleingedrucktes.</p>

          <!-- Agency comparison -->
          <div class="calc-card calc-card--muted">
            <span class="calc-card__label">Das zahlt man bei einer Agentur</span>
            <span class="calc-card__price" id="agencyPrice">12.000&thinsp;€</span>
            <span class="calc-card__sub">Lange Wartezeiten, aufgeblähte Teams, versteckte Kosten</span>
          </div>

          <!-- Your price -->
          <div class="calc-card calc-card--highlight">
            <span class="calc-card__label">Deine Investition mit Jason Holweg</span>
            <span class="calc-card__price" id="myPrice">4.000&thinsp;€</span>
            <span class="calc-card__range" id="myPriceRange">4.000 – 5.500&thinsp;€</span>
            <span class="calc-card__sub">Direkter Draht, schnelle Umsetzung, messbare Ergebnisse</span>
          </div>

          <!-- Value props -->
          <div class="calc-value-props">
            <div class="calc-value-prop">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Design + Entwicklung aus einer Hand</span>
            </div>
            <div class="calc-value-prop">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              <span>Conversion-optimiert von Anfang an</span>
            </div>
            <div class="calc-value-prop">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              <span>100 % responsive & blitzschnell</span>
            </div>
          </div>

          <a href="Kontakt.php" class="calc-cta">
            Projekt starten
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
          <p class="calc-cta-note">Unverbindliches Erstgespräch – kostenlos & ohne Verpflichtung</p>
        </div>

      </div>
    </div>
  </section>
</main>

<script>
(function() {
  const tierInputs     = document.querySelectorAll('input[name="projectTier"]');
  const needContent    = document.getElementById('needContent');
  const needSEO        = document.getElementById('needSEO');
  const needMaintenance= document.getElementById('needMaintenance');
  const timelineInputs = document.querySelectorAll('input[name="timeline"]');

  const agencyEl     = document.getElementById('agencyPrice');
  const myPriceEl    = document.getElementById('myPrice');
  const myRangeEl    = document.getElementById('myPriceRange');

  /* ── Tier pricing ── */
  const tiers = {
    starter:     { min: 1900,  max: 2400,  agencyMul: 3.5 },
    business:    { min: 4000,  max: 5500,  agencyMul: 3.0 },
    performance: { min: 6500,  max: 9000,  agencyMul: 2.5 },
    enterprise:  { min: 10000, max: 15000, agencyMul: 2.5 }
  };

  function getTier() {
    return document.querySelector('input[name="projectTier"]:checked').value;
  }
  function getTimeline() {
    return document.querySelector('input[name="timeline"]:checked').value;
  }

  function fmt(n) {
    return Math.round(n).toLocaleString('de-DE') + '\u2009€';
  }

  function fmtShort(n) {
    return Math.round(n).toLocaleString('de-DE');
  }

  function getAddOnMultiplier() {
    let mul = 1;
    if (needContent.checked)     mul += 0.10;
    if (needSEO.checked)         mul += 0.08;
    if (needMaintenance.checked) mul += 0.15;
    return mul;
  }

  function getTimelineMultiplier() {
    const tl = getTimeline();
    if (tl === 'rush') return 1.25;
    if (tl === 'fast') return 1.10;
    return 1;
  }

  function update() {
    const tier = tiers[getTier()];
    const addOn = getAddOnMultiplier();
    const timeline = getTimelineMultiplier();

    const totalMin = Math.round(tier.min * addOn * timeline);
    const totalMax = Math.round(tier.max * addOn * timeline);
    const agencyPrice = Math.round(tier.min * tier.agencyMul);

    agencyEl.textContent = fmt(agencyPrice);
    myPriceEl.textContent = fmt(totalMin);
    myRangeEl.textContent = fmtShort(totalMin) + ' – ' + fmtShort(totalMax) + '\u2009€';
  }

  tierInputs.forEach(r => r.addEventListener('change', update));
  needContent.addEventListener('change', update);
  needSEO.addEventListener('change', update);
  needMaintenance.addEventListener('change', update);
  timelineInputs.forEach(r => r.addEventListener('change', update));

  update();
})();
</script>

<?php include '../includes/footer.php'; ?>
