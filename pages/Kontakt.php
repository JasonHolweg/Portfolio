<?php
$root      = '../';
$pageTitle = 'Kontakt – Jason Holweg';
$pageDesc  = 'Nimm Kontakt mit Jason Holweg auf – ich freue mich auf dein Projekt und antworte innerhalb von 48 Stunden.';
include '../includes/header.php';
?>

<header class="page-hero" role="banner">
  <div class="orb" style="width:450px;height:450px;top:-60px;right:-80px;background:radial-gradient(circle,rgba(168,85,247,0.22),transparent 70%)"></div>
  <div class="orb" style="width:350px;height:350px;bottom:-40px;left:-60px;background:radial-gradient(circle,rgba(78,205,196,0.18),transparent 70%)"></div>
  <div class="container" style="position:relative;z-index:1">
    <p class="section-label">Schreib mir</p>
    <h1 class="fade-up"><span class="grad-text">Kontakt</span></h1>
    <p class="fade-up fade-up-d1">
      Hast du ein Projekt im Kopf? Ich antworte innerhalb von 48 Stunden.
    </p>
  </div>
</header>

<main>
  <section class="section" aria-labelledby="contact-heading">
    <div class="container">
      <h2 class="sr-only" id="contact-heading">Kontaktformular</h2>

      <div class="contact-layout">

        <!-- Contact info -->
        <div class="contact-info" role="list" aria-label="Kontaktinformationen">

          <article class="contact-item glass fade-up" role="listitem">
            <div class="contact-item-icon" style="background:rgba(78,205,196,0.12);border:1px solid rgba(78,205,196,0.25)">📧</div>
            <div class="contact-item-text">
              <strong>E-Mail</strong>
              <span><a href="mailto:hallo@jasonholweg.de" style="color:var(--c2)">hallo@jasonholweg.de</a></span>
            </div>
          </article>

          <article class="contact-item glass fade-up fade-up-d1" role="listitem">
            <div class="contact-item-icon" style="background:rgba(168,85,247,0.12);border:1px solid rgba(168,85,247,0.25)">🌍</div>
            <div class="contact-item-text">
              <strong>Standort</strong>
              <span>Deutschland</span>
            </div>
          </article>

          <article class="contact-item glass fade-up fade-up-d2" role="listitem">
            <div class="contact-item-icon" style="background:rgba(251,191,36,0.12);border:1px solid rgba(251,191,36,0.25)">⏱️</div>
            <div class="contact-item-text">
              <strong>Antwortzeit</strong>
              <span>Innerhalb von 48 Stunden</span>
            </div>
          </article>

          <article class="contact-item glass fade-up fade-up-d3" role="listitem">
            <div class="contact-item-icon" style="background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.25)">💬</div>
            <div class="contact-item-text">
              <strong>Erstgespräch</strong>
              <span>Kostenlos &amp; unverbindlich</span>
            </div>
          </article>

        </div>

        <!-- Contact form -->
        <div class="contact-form glass fade-up fade-up-d1">
          <form id="contact-form" novalidate aria-label="Kontaktformular">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="f-name">Name *</label>
                <input class="form-control" type="text" id="f-name" name="name"
                       placeholder="Max Mustermann" required autocomplete="name">
              </div>
              <div class="form-group">
                <label class="form-label" for="f-email">E-Mail *</label>
                <input class="form-control" type="email" id="f-email" name="email"
                       placeholder="max@beispiel.de" required autocomplete="email">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-subject">Betreff</label>
              <input class="form-control" type="text" id="f-subject" name="subject"
                     placeholder="Neue Website für mein Unternehmen">
            </div>

            <div class="form-group">
              <label class="form-label" for="f-message">Nachricht *</label>
              <textarea class="form-control" id="f-message" name="message"
                        rows="6" placeholder="Beschreib kurz dein Projekt…" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
              Nachricht senden ✉️
            </button>

            <div id="form-status" class="form-status" role="alert" aria-live="polite"></div>

          </form>
        </div>

      </div>
    </div>
  </section>
</main>

<?php include '../includes/footer.php'; ?>
