<?php
$root      = '../';
$pageTitle = 'Impressum – Jason Holweg';
$pageDesc  = 'Impressum und Anbieterkennzeichnung gemäß § 5 TMG für die Website von Jason Holweg.';
include '../includes/header.php';
?>

<header class="page-hero" role="banner">
  <div class="orb" style="width:400px;height:400px;top:-60px;right:-80px;background:radial-gradient(circle,rgba(59,130,246,0.18),transparent 70%)"></div>
  <div class="container" style="position:relative;z-index:1">
    <p class="section-label">Rechtliches</p>
    <h1 class="fade-up"><span class="grad-text">Impressum</span></h1>
  </div>
</header>

<main>
  <section class="legal-page section">
    <div class="container">
      <div class="glass fade-up">

        <p class="last-updated">Stand: <?= date('d.m.Y') ?></p>

        <h2>Angaben gemäß § 5 TMG</h2>
        <!-- TODO: Replace placeholder address with your actual business address before deployment -->
        <address>
          <strong>Jason Holweg</strong><br>
          Musterstraße 1<br>
          12345 Musterstadt<br>
          Deutschland
        </address>

        <h2>Kontakt</h2>
        <p>
          E-Mail: <a href="mailto:hallo@jasonholweg.de">hallo@jasonholweg.de</a>
        </p>

        <h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
        <address>
          Jason Holweg<br>
          Musterstraße 1<br>
          12345 Musterstadt
        </address>

        <h2>Haftung für Inhalte</h2>
        <p>
          Als Diensteanbieter bin ich gemäß § 7 Abs. 1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich.
          Nach §§ 8 bis 10 TMG bin ich als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.
        </p>
        <p>
          Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt.
          Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich.
          Bei Bekanntwerden von entsprechenden Rechtsverletzungen werde ich diese Inhalte umgehend entfernen.
        </p>

        <h2>Haftung für Links</h2>
        <p>
          Mein Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte ich keinen Einfluss habe.
          Deshalb kann ich für diese fremden Inhalte auch keine Gewähr übernehmen.
          Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.
          Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft.
          Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.
        </p>
        <p>
          Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar.
          Bei Bekanntwerden von Rechtsverletzungen werde ich derartige Links umgehend entfernen.
        </p>

        <h2>Urheberrecht</h2>
        <p>
          Die durch den Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht.
          Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
          Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet.
        </p>
        <p>
          Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet.
          Insbesondere werden Inhalte Dritter als solche gekennzeichnet.
          Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitte ich um einen entsprechenden Hinweis.
          Bei Bekanntwerden von Rechtsverletzungen werde ich derartige Inhalte umgehend entfernen.
        </p>

        <h2>Streitschlichtung</h2>
        <p>
          Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit:
          <a href="https://ec.europa.eu/consumers/odr/" target="_blank" rel="noopener noreferrer">https://ec.europa.eu/consumers/odr/</a>.
          Meine E-Mail-Adresse finden Sie oben im Impressum.
        </p>
        <p>
          Ich bin nicht bereit oder verpflichtet, an Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle teilzunehmen.
        </p>

      </div>
    </div>
  </section>
</main>

<?php include '../includes/footer.php'; ?>
