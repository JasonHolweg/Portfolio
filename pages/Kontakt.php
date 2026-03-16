<?php
$root      = '../';
$pageTitle = 'Kontakt – Jason Holweg';
$pageDesc  = 'Nimm Kontakt mit Jason Holweg auf – ich freue mich auf dein Projekt und antworte innerhalb von 48 Stunden.';
$mailConfig = [];
$mailConfigPath = __DIR__ . '/../config.mail.php';
if (is_file($mailConfigPath)) {
  $loadedMailConfig = require $mailConfigPath;
  if (is_array($loadedMailConfig)) {
    $mailConfig = $loadedMailConfig;
  }
}
$turnstileSiteKey = trim((string) ($mailConfig['TURNSTILE_SITE_KEY'] ?? ''));
include '../includes/header.php';
?>

<header class="page-hero" role="banner">
  <div class="orb" style="width:450px;height:450px;top:-60px;right:-80px;background:radial-gradient(circle,rgba(168,85,247,0.22),transparent 70%)"></div>
  <div class="orb" style="width:350px;height:350px;bottom:-40px;left:-60px;background:radial-gradient(circle,rgba(78,205,196,0.18),transparent 70%)"></div>
  <div class="container" style="position:relative;z-index:1">
    <p class="section-label">Projektanfrage</p>
    <h1 class="fade-up"><span class="grad-text">Lass uns über deine neue Website sprechen.</span></h1>
    <p class="fade-up fade-up-d1">
      Ich arbeite mit Unternehmen und Selbstständigen, die einen professionellen Webauftritt ohne Baukasten und ohne Standardlösung wollen. Eine kurze Anfrage reicht aus – ich melde mich persönlich und unkompliziert zurück.
    </p>
  </div>
</header>

<main>
  <section class="section" aria-labelledby="contact-heading">
    <div class="container">
      <div class="contact-page">
        <div class="contact-overview">
          <p class="section-label fade-up">Direkt & persönlich</p>
          <h2 class="section-title fade-up fade-up-d1" id="contact-heading">Der schnellste Weg zu einem klaren nächsten Schritt.</h2>
          <p class="contact-lead fade-up fade-up-d2">
            Wenn du eine individuelle Website, einen Relaunch oder eine performante Landingpage planst, bist du hier richtig. Du musst noch nicht alles perfekt vorbereitet haben – ich helfe dir, Ziel, Umfang und sinnvollen nächsten Schritt klar zu definieren.
          </p>

          <div class="contact-trust-grid" role="list" aria-label="Vertrauenselemente">
            <article class="contact-trust-card glass fade-up" role="listitem">
              <strong>Antwort innerhalb von 48 Stunden</strong>
              <span>Du bekommst schnell eine persönliche Rückmeldung.</span>
            </article>
            <article class="contact-trust-card glass fade-up fade-up-d1" role="listitem">
              <strong>Kostenloses Erstgespräch</strong>
              <span>Unverbindlich, klar strukturiert und ohne Verkaufsdruck.</span>
            </article>
            <article class="contact-trust-card glass fade-up fade-up-d2" role="listitem">
              <strong>Ohne Baukasten &amp; ohne Templates</strong>
              <span>Maßgeschneiderte Webentwicklung statt Standardlösung.</span>
            </article>
            <article class="contact-trust-card glass fade-up fade-up-d3" role="listitem">
              <strong>Direkter Kontakt mit mir</strong>
              <span>Keine Agentur-Weiterleitung, keine Zwischeninstanzen.</span>
            </article>
          </div>

          <div class="contact-direct glass fade-up fade-up-d2">
            <h3>Direkt erreichbar</h3>
            <div class="contact-direct-list" role="list" aria-label="Direkte Kontaktinfos">
              <div class="contact-direct-item" role="listitem">
                <strong>E-Mail</strong>
                <span><a href="mailto:hallo@jasonholweg.de">hallo@jasonholweg.de</a></span>
              </div>
              <div class="contact-direct-item" role="listitem">
                <strong>Standort</strong>
                <span>Deutschland</span>
              </div>
              <div class="contact-direct-item" role="listitem">
                <strong>Arbeitsweise</strong>
                <span>Transparent, strukturiert und mit klarer Kommunikation.</span>
              </div>
            </div>
          </div>

          <div class="contact-steps glass fade-up fade-up-d3" aria-labelledby="contact-steps-heading">
            <h3 id="contact-steps-heading">Was passiert nach deiner Anfrage?</h3>
            <ol class="contact-steps-list">
              <li><strong>1. Anfrage senden</strong><span>Du schickst mir ein paar Eckdaten zu deinem Vorhaben.</span></li>
              <li><strong>2. Persönliche Rückmeldung</strong><span>Ich melde mich direkt bei dir und ordne das Projekt ein.</span></li>
              <li><strong>3. Nächsten Schritt klären</strong><span>Wir besprechen Ziele, Umfang, Timing und den sinnvollsten Start.</span></li>
            </ol>
          </div>
        </div>

        <div class="contact-form-panel glass fade-up fade-up-d1">
          <div class="contact-form-head">
            <p class="section-label">Unverbindliche Anfrage</p>
            <h3>Erzähl mir kurz, worum es geht.</h3>
            <p>Je klarer dein Ziel, desto gezielter kann ich dir antworten. Wenn du noch nicht alles definiert hast, ist das völlig in Ordnung.</p>
          </div>

          <form id="contact-form" novalidate aria-label="Kontaktformular" data-endpoint="../send_mail.php">
            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="f-name">Name *</label>
                <input class="form-control" type="text" id="f-name" name="name"
                       placeholder="Wie darf ich dich ansprechen?" required autocomplete="name">
              </div>
              <div class="form-group">
                <label class="form-label" for="f-email">E-Mail *</label>
                <input class="form-control" type="email" id="f-email" name="email"
                       placeholder="Wohin soll ich dir antworten?" required autocomplete="email">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-subject">Worum geht es? <span class="form-optional">optional</span></label>
              <input class="form-control" type="text" id="f-subject" name="subject"
                     placeholder="z. B. neue Website, Relaunch, Landingpage oder technischer Support">
            </div>

            <div class="form-group">
              <label class="form-label" for="f-message">Projektanfrage *</label>
              <textarea class="form-control" id="f-message" name="message"
                        rows="7" placeholder="Hilfreich sind z. B. ein kurzer Satz zu deinem Unternehmen, das Ziel der Website, gewünschter Umfang und ein grober Zeitrahmen." required></textarea>
            </div>

            <div class="form-honeypot" aria-hidden="true">
              <label for="company-website">Website</label>
              <input type="text" id="company-website" name="company_website" tabindex="-1" autocomplete="off">
            </div>

            <?php if ($turnstileSiteKey !== ''): ?>
              <div class="form-group form-group-turnstile">
                <p class="form-label">Sicherheitsprüfung *</p>
                <div
                  class="turnstile-shell"
                  data-turnstile-container
                  data-sitekey="<?= htmlspecialchars($turnstileSiteKey, ENT_QUOTES, 'UTF-8') ?>">
                  <div
                    class="cf-turnstile"
                    data-sitekey="<?= htmlspecialchars($turnstileSiteKey, ENT_QUOTES, 'UTF-8') ?>"
                    data-theme="dark"
                    data-size="flexible"
                    data-response-field-name="turnstile_token"></div>
                </div>
                <p class="form-note form-note-compact">Diese Prüfung schützt das Formular vor automatisierten Anfragen.</p>
              </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary cta-primary" style="width:100%;justify-content:center">
              Projekt unverbindlich anfragen
            </button>

            <p class="form-note">Deine Anfrage ist unverbindlich. Ich gebe deine Daten nicht weiter und melde mich in der Regel innerhalb von 48 Stunden persönlich bei dir.</p>

            <div id="form-status" class="form-status" role="alert" aria-live="polite"></div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="contact-faq-heading">
    <div class="container">
      <p class="section-label fade-up">Kurze Antworten</p>
      <h2 class="section-title fade-up fade-up-d1" id="contact-faq-heading">Häufige Fragen vor der Anfrage</h2>
      <div class="contact-faq" data-faq-group>
        <article class="contact-faq-item glass" data-faq-item>
          <h3 class="contact-faq-title">
            <button
              class="contact-faq-trigger"
              type="button"
              aria-expanded="false"
              aria-controls="contact-faq-panel-1"
              id="contact-faq-trigger-1">
              <span class="contact-faq-question">Für welche Projekte kann ich anfragen?</span>
              <span class="contact-faq-icon" aria-hidden="true"></span>
            </button>
          </h3>
          <div
            class="contact-faq-panel"
            id="contact-faq-panel-1"
            role="region"
            aria-labelledby="contact-faq-trigger-1"
            hidden>
            <div class="contact-faq-answer">
              <p>Für neue Websites, Relaunches, Landingpages, kleinere Webanwendungen oder Performance-Optimierungen.</p>
            </div>
          </div>
        </article>

        <article class="contact-faq-item glass" data-faq-item>
          <h3 class="contact-faq-title">
            <button
              class="contact-faq-trigger"
              type="button"
              aria-expanded="false"
              aria-controls="contact-faq-panel-2"
              id="contact-faq-trigger-2">
              <span class="contact-faq-question">Wie schnell meldest du dich?</span>
              <span class="contact-faq-icon" aria-hidden="true"></span>
            </button>
          </h3>
          <div
            class="contact-faq-panel"
            id="contact-faq-panel-2"
            role="region"
            aria-labelledby="contact-faq-trigger-2"
            hidden>
            <div class="contact-faq-answer">
              <p>In der Regel innerhalb von 48 Stunden, oft auch schneller.</p>
            </div>
          </div>
        </article>

        <article class="contact-faq-item glass" data-faq-item>
          <h3 class="contact-faq-title">
            <button
              class="contact-faq-trigger"
              type="button"
              aria-expanded="false"
              aria-controls="contact-faq-panel-3"
              id="contact-faq-trigger-3">
              <span class="contact-faq-question">Ist das Erstgespräch kostenlos?</span>
              <span class="contact-faq-icon" aria-hidden="true"></span>
            </button>
          </h3>
          <div
            class="contact-faq-panel"
            id="contact-faq-panel-3"
            role="region"
            aria-labelledby="contact-faq-trigger-3"
            hidden>
            <div class="contact-faq-answer">
              <p>Ja. Das erste Gespräch ist kostenlos und unverbindlich.</p>
            </div>
          </div>
        </article>

        <article class="contact-faq-item glass" data-faq-item>
          <h3 class="contact-faq-title">
            <button
              class="contact-faq-trigger"
              type="button"
              aria-expanded="false"
              aria-controls="contact-faq-panel-4"
              id="contact-faq-trigger-4">
              <span class="contact-faq-question">Arbeitest du mit Templates?</span>
              <span class="contact-faq-icon" aria-hidden="true"></span>
            </button>
          </h3>
          <div
            class="contact-faq-panel"
            id="contact-faq-panel-4"
            role="region"
            aria-labelledby="contact-faq-trigger-4"
            hidden>
            <div class="contact-faq-answer">
              <p>Nein. Ich entwickle individuelle Lösungen statt auf vorgefertigte Baukasten-Templates zu setzen.</p>
            </div>
          </div>
        </article>

        <article class="contact-faq-item glass" data-faq-item>
          <h3 class="contact-faq-title">
            <button
              class="contact-faq-trigger"
              type="button"
              aria-expanded="false"
              aria-controls="contact-faq-panel-5"
              id="contact-faq-trigger-5">
              <span class="contact-faq-question">Kann ich auch anfragen, wenn mein Projekt noch nicht komplett definiert ist?</span>
              <span class="contact-faq-icon" aria-hidden="true"></span>
            </button>
          </h3>
          <div
            class="contact-faq-panel"
            id="contact-faq-panel-5"
            role="region"
            aria-labelledby="contact-faq-trigger-5"
            hidden>
            <div class="contact-faq-answer">
              <p>Ja. Genau dafür ist das Erstgespräch da: um Idee, Ziel und sinnvollen nächsten Schritt gemeinsam zu schärfen.</p>
            </div>
          </div>
        </article>
      </div>
    </div>
  </section>
</main>

<?php if ($turnstileSiteKey !== ''): ?>
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif; ?>

<?php include '../includes/footer.php'; ?>
