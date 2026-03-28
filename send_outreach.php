<?php
/**
 * Outreach email handler via Mailgun HTTP API
 * Accepts multipart/form-data with optional screenshot attachments
 */
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

/* ── Access check ────────────────────────────────────── */
$accessCode = trim((string) ($_POST['access_code'] ?? ''));
if ($accessCode !== '2705') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Zugang verweigert.']);
    exit;
}

/* ── Input validation ────────────────────────────────── */
$recipientEmail  = trim(strip_tags($_POST['recipient_email'] ?? ''));
$companyName     = trim(strip_tags($_POST['company_name'] ?? ''));
$demoUrl         = trim(strip_tags($_POST['demo_url'] ?? ''));
$personalMessage = trim(strip_tags($_POST['personal_message'] ?? ''));

if ($recipientEmail === '' || $companyName === '' || $demoUrl === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Pflichtfelder fehlen.']);
    exit;
}

if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Ungültige E-Mail-Adresse.']);
    exit;
}

if (!filter_var($demoUrl, FILTER_VALIDATE_URL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Ungültige Demo-URL.']);
    exit;
}

/* ── Load mail config ────────────────────────────────── */
$mailConfig = loadOutreachMailConfig();

if ($mailConfig['api_key'] === '' || $mailConfig['domain'] === '' || $mailConfig['from_email'] === '') {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Mailversand ist nicht konfiguriert.']);
    exit;
}

/* ── Process uploaded screenshots ────────────────────── */
$screenshotCids = [];
$screenshotFiles = [];

if (!empty($_FILES['screenshots']['tmp_name'])) {
    $maxFiles = 3;
    $maxSize = 2 * 1024 * 1024; // 2 MB
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];

    $files = normalizeFilesArray($_FILES['screenshots']);

    foreach ($files as $i => $file) {
        if ($i >= $maxFiles) break;
        if ($file['error'] !== UPLOAD_ERR_OK) continue;
        if ($file['size'] > $maxSize) continue;

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, $allowedTypes, true)) continue;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) ?: 'png';
        $filename = 'screenshot-' . ($i + 1) . '.' . $ext;
        $screenshotCids[] = $filename;
        $screenshotFiles[] = [
            'path'     => $file['tmp_name'],
            'name'     => $filename,
            'mime'     => $mimeType,
        ];
    }
}

/* ── Build and send email ────────────────────────────── */
$subject = 'Ihre neue Webseite – Ein Vorschlag für ' . $companyName;
$htmlBody = buildOutreachHtml($companyName, $demoUrl, $personalMessage, $screenshotCids);
$textBody = buildOutreachText($companyName, $demoUrl, $personalMessage);

$result = sendOutreachViaMailgun($mailConfig, $recipientEmail, $subject, $htmlBody, $textBody, $screenshotFiles);

if (!$result['ok']) {
    error_log('Outreach mail failed: ' . $result['error']);
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'E-Mail konnte nicht gesendet werden.']);
    exit;
}

  logOutreachSend([
    'sent_at'          => gmdate('c'),
    'recipient_email'  => $recipientEmail,
    'company_name'     => $companyName,
    'demo_url'         => $demoUrl,
    'message_preview'  => mb_substr($personalMessage, 0, 180),
    'attachments_count'=> count($screenshotFiles),
    'bcc'              => getOutreachBccRecipients(),
  ]);

echo json_encode(['ok' => true]);
exit;


/* ═══════════════════════════════════════════════════════
   Helper functions
   ═══════════════════════════════════════════════════════ */

function loadOutreachMailConfig()
{
    $fileConfig = [];
    $configPath = __DIR__ . '/config.mail.php';

    if (is_file($configPath)) {
        $loaded = require $configPath;
        if (is_array($loaded)) {
            $fileConfig = $loaded;
        }
    }

    return [
        'api_key'    => trim((string) ($fileConfig['MAILGUN_API_KEY'] ?? '')),
        'domain'     => trim((string) ($fileConfig['MAILGUN_DOMAIN'] ?? '')),
        'api_base'   => rtrim((string) ($fileConfig['MAILGUN_API_BASE'] ?? 'https://api.mailgun.net'), '/'),
        'from_email' => trim((string) ($fileConfig['MAILGUN_FROM_EMAIL'] ?? '')),
        'from_name'  => trim((string) ($fileConfig['MAILGUN_FROM_NAME'] ?? 'Jason Holweg')),
    ];
}

function normalizeFilesArray($filesArray)
{
    $normalized = [];
    if (!is_array($filesArray['tmp_name'])) {
        return [$filesArray];
    }
    foreach ($filesArray['tmp_name'] as $i => $tmpName) {
        $normalized[] = [
            'tmp_name' => $tmpName,
            'name'     => $filesArray['name'][$i],
            'size'     => $filesArray['size'][$i],
            'type'     => $filesArray['type'][$i],
            'error'    => $filesArray['error'][$i],
        ];
    }
    return $normalized;
}

function sendOutreachViaMailgun(array $config, $to, $subject, $html, $text, array $attachments)
{
    $endpoint = $config['api_base'] . '/v3/' . rawurlencode($config['domain']) . '/messages';

    $fromHeader = 'Kristian Meister <' . $config['from_email'] . '>';

    $ch = curl_init($endpoint);

    $bccRecipients = getOutreachBccRecipients();

    $postFields = [
        'from'    => $fromHeader,
        'to'      => $to,
        'bcc'     => implode(',', $bccRecipients),
        'subject' => $subject,
        'html'    => $html,
        'text'    => $text,
        'h:Reply-To' => 'hallo@jasonholweg.de',
    ];

    // Attach inline images (referenced via cid: in HTML)
    foreach ($attachments as $i => $att) {
        $postFields["inline[$i]"] = new CURLFile($att['path'], $att['mime'], $att['name']);
    }

    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $postFields,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD        => 'api:' . $config['api_key'],
        CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $responseBody = curl_exec($ch);
    $curlError = curl_error($ch);
    $statusCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($responseBody === false) {
        return ['ok' => false, 'error' => 'cURL error: ' . $curlError];
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        return ['ok' => false, 'error' => 'HTTP ' . $statusCode . ' - ' . trim((string) $responseBody)];
    }

    return ['ok' => true];
}

function getOutreachBccRecipients()
{
  return [
    'jason.patrick.holweg@gmail.com',
    'kristianmeister@yahoo.de',
  ];
}

function logOutreachSend(array $entry)
{
  $logDir = __DIR__ . '/storage';
  $logFile = $logDir . '/outreach_sent_log.jsonl';

  if (!is_dir($logDir) && !mkdir($logDir, 0755, true) && !is_dir($logDir)) {
    error_log('Outreach log failed: cannot create log directory');
    return;
  }

  $jsonLine = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
  if ($jsonLine === false) {
    error_log('Outreach log failed: json_encode returned false');
    return;
  }

  $writeResult = @file_put_contents($logFile, $jsonLine . PHP_EOL, FILE_APPEND | LOCK_EX);
  if ($writeResult === false) {
    error_log('Outreach log failed: cannot write log file');
  }
}

function buildOutreachHtml($companyName, $demoUrl, $personalMessage, $screenshotCids)
{
    $safeCompany = htmlspecialchars($companyName, ENT_QUOTES, 'UTF-8');
    $safeDemoUrl = htmlspecialchars($demoUrl, ENT_QUOTES, 'UTF-8');
    $safeYear = date('Y');

    $personalBlock = '';
    if ($personalMessage !== '') {
        $safeMessage = nl2br(htmlspecialchars($personalMessage, ENT_QUOTES, 'UTF-8'));
        $personalBlock = <<<HTML
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
              <tr>
                <td style="padding:22px;border:1px solid #1e1e30;border-radius:18px;background-color:#090c16;">
                  <div style="margin:0 0 8px;font-size:12px;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;">Pers&ouml;nliche Nachricht</div>
                  <p style="margin:0;font-size:16px;line-height:1.75;color:#e2e8f0;">{$safeMessage}</p>
                </td>
              </tr>
            </table>
HTML;
    }

    $screenshotBlock = '';
    if (!empty($screenshotCids)) {
        $images = '';
        foreach ($screenshotCids as $cid) {
            $images .= '<img src="cid:' . $cid . '" style="width:100%;max-width:580px;border-radius:16px;border:1px solid #1e1e30;margin:0 0 16px;display:block;" alt="Demo Screenshot">';
        }
        $screenshotBlock = <<<HTML
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
              <tr>
                <td>
                  <div style="margin:0 0 14px;font-size:12px;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;">So k&ouml;nnte Ihre neue Webseite aussehen</div>
                  {$images}
                </td>
              </tr>
            </table>
HTML;
    }

    return <<<HTML
<!DOCTYPE html>
<html lang="de" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ihre neue Webseite</title>
  <!--[if mso]>
  <style>body,table,td{font-family:Arial,Helvetica,sans-serif!important;}</style>
  <![endif]-->
</head>
<body style="margin:0;padding:0;width:100%;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

  <!-- Full-width dark background wrapper (table-based for email client support) -->
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#070811;margin:0;padding:0;">
    <tr>
      <td align="center" style="padding:40px 16px;background-color:#070811;">

        <!-- Inner content column -->
        <table role="presentation" width="680" cellpadding="0" cellspacing="0" border="0" style="max-width:680px;width:100%;">

          <!-- Pill badge -->
          <tr>
            <td style="padding:0 0 20px;">
              <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="padding:10px 18px;border:1px solid #2a2a3d;border-radius:999px;background-color:#12121f;color:#dbe6ff;font-size:12px;letter-spacing:0.08em;text-transform:uppercase;">
                    Webdesign-Vorschlag
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Main card -->
          <tr>
            <td style="border:1px solid #1e1e30;border-radius:28px;background-color:#0e0e1c;box-shadow:0 24px 80px rgba(0,0,0,0.35);">

              <!-- Header area -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="padding:44px 32px 24px;">

                    <!-- JH Logo -->
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="width:56px;height:56px;border-radius:16px;background:linear-gradient(135deg, #ff6b6b, #a855f7 55%, #3b82f6);text-align:center;line-height:56px;font-size:22px;font-weight:800;color:#ffffff;box-shadow:0 14px 30px rgba(168,85,247,0.28);">
                          JH
                        </td>
                      </tr>
                    </table>

                    <h1 style="margin:28px 0 8px;font-size:32px;line-height:1.1;letter-spacing:-0.03em;color:#ffffff;">
                      Wir sind der Meinung,<br>
                      <span style="color:#a855f7;">Sie haben eine bessere Webseite verdient.</span>
                    </h1>

                    <p style="margin:18px 0 0;font-size:17px;line-height:1.75;color:#cbd5e1;">
                      Hallo {$safeCompany},<br><br>
                      ich habe mir Ihre aktuelle Webseite angeschaut und mir die Freiheit genommen, einen unverbindlichen Entwurf f&uuml;r Sie zu erstellen &ndash; eine moderne Webseite, die mehr Kunden bringt und Ihre Geschichte erz&auml;hlt.
                    </p>

                  </td>
                </tr>
              </table>

              <!-- Content area -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                  <td style="padding:0 32px 32px;">

                    {$personalBlock}

                    {$screenshotBlock}

                    <!-- Demo CTA box -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
                      <tr>
                        <td style="padding:28px;border:1px solid #1a3a38;border-radius:22px;background-color:#0c1520;">
                          <h2 style="margin:0 0 10px;font-size:22px;color:#ffffff;letter-spacing:-0.02em;">Ihre Demo-Webseite ist bereit</h2>
                          <p style="margin:0 0 20px;font-size:15px;line-height:1.7;color:#94a3b8;">
                            Ich habe einen individuellen Entwurf f&uuml;r Sie erstellt. Schauen Sie sich Ihre neue Webseite an &ndash; komplett unverbindlich.
                          </p>
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="border-radius:14px;background:linear-gradient(135deg, #ff6b6b 0%, #f472b6 34%, #a855f7 68%, #3b82f6 100%);">
                                <a href="{$safeDemoUrl}" style="display:inline-block;padding:16px 28px;color:#ffffff;text-decoration:none;font-size:16px;font-weight:700;letter-spacing:-0.01em;">
                                  Demo ansehen &rarr;
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <!-- Process steps -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
                      <tr>
                        <td style="padding:0 0 16px;font-size:12px;letter-spacing:0.1em;text-transform:uppercase;color:#94a3b8;">So geht es weiter</td>
                      </tr>
                      <tr>
                        <td style="padding:12px 0;vertical-align:top;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="52" style="vertical-align:top;padding:0 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:12px;background-color:#2a1215;color:#ff6b6b;text-align:center;line-height:36px;font-weight:700;font-size:15px;">1</div>
                              </td>
                              <td style="vertical-align:top;">
                                <div style="font-size:15px;font-weight:600;color:#ffffff;margin:0 0 2px;">Demo ansehen</div>
                                <div style="font-size:14px;color:#94a3b8;line-height:1.5;">Schauen Sie sich den Entwurf in Ruhe an.</div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:12px 0;vertical-align:top;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="52" style="vertical-align:top;padding:0 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:12px;background-color:#1a1228;color:#a855f7;text-align:center;line-height:36px;font-weight:700;font-size:15px;">2</div>
                              </td>
                              <td style="vertical-align:top;">
                                <div style="font-size:15px;font-weight:600;color:#ffffff;margin:0 0 2px;">Gemeinsam besprechen</div>
                                <div style="font-size:14px;color:#94a3b8;line-height:1.5;">Wir gehen die Seite zusammen durch und passen sie an Ihre W&uuml;nsche an.</div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:12px 0;vertical-align:top;">
                          <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td width="52" style="vertical-align:top;padding:0 16px 0 0;">
                                <div style="width:36px;height:36px;border-radius:12px;background-color:#0c1f1d;color:#4ecdc4;text-align:center;line-height:36px;font-weight:700;font-size:15px;">3</div>
                              </td>
                              <td style="vertical-align:top;">
                                <div style="font-size:15px;font-weight:600;color:#ffffff;margin:0 0 2px;">Live schalten</div>
                                <div style="font-size:14px;color:#94a3b8;line-height:1.5;">Sobald alles passt, geht Ihre neue Webseite online.</div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <!-- Portfolio hint -->
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
                      <tr>
                        <td style="padding:22px;border:1px solid #1e1e30;border-radius:18px;background-color:#090c16;">
                          <p style="margin:0 0 14px;font-size:15px;line-height:1.7;color:#e2e8f0;">
                            Schauen Sie sich gerne auch mein Portfolio an, um zu sehen, was alles m&ouml;glich ist:
                          </p>
                          <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="border-radius:12px;border:1px solid #2a2a3d;background-color:#12121f;">
                                <a href="https://jasonholweg.de" style="display:inline-block;padding:12px 22px;color:#ffffff;text-decoration:none;font-size:14px;font-weight:600;">
                                  JasonHolweg.de besuchen &rarr;
                                </a>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>

                    <!-- Reply CTA -->
                    <p style="margin:0;font-size:16px;line-height:1.75;color:#cbd5e1;">
                      Ich freue mich auf Ihre R&uuml;ckmeldung &ndash; antworten Sie einfach auf diese E-Mail oder schreiben Sie mir an <a href="mailto:hallo@jasonholweg.de" style="color:#4ecdc4;text-decoration:none;font-weight:600;">hallo@jasonholweg.de</a>.
                    </p>
                    <p style="margin:18px 0 0;font-size:16px;color:#cbd5e1;">
                      Viele Gr&uuml;&szlig;e<br>
                      <strong style="color:#ffffff;">Kristian Meister</strong><br>
                      <span style="font-size:14px;color:#94a3b8;">Im Auftrag von Jason Holweg &middot; Webentwicklung & Design</span>
                    </p>

                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:20px 4px 0;">
              <p style="font-size:13px;line-height:1.7;color:#7c8aa5;margin:0;">
                Jason Holweg &middot; Webentwicklung & Design &middot; Deutschland<br>
                <a href="https://jasonholweg.de" style="color:#7c8aa5;text-decoration:underline;">jasonholweg.de</a> &middot; <a href="mailto:hallo@jasonholweg.de" style="color:#7c8aa5;text-decoration:underline;">hallo@jasonholweg.de</a>
              </p>
              <p style="font-size:11px;color:#4a5568;margin:10px 0 0;">
                Sie erhalten diese E-Mail, weil wir glauben, dass wir Ihnen einen Mehrwert bieten k&ouml;nnen. Wenn Sie kein Interesse haben, ignorieren Sie diese Nachricht einfach. &copy; {$safeYear}
              </p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
HTML;
}

function buildOutreachText($companyName, $demoUrl, $personalMessage)
{
    $text = "Hallo {$companyName},\n\n"
        . "wir sind der Meinung, Sie haben eine bessere Webseite verdient.\n\n"
        . "Ich habe mir Ihre aktuelle Webseite angeschaut und mir die Freiheit genommen, "
        . "einen unverbindlichen Entwurf für Sie zu erstellen – eine moderne Webseite, "
        . "die mehr Kunden bringt und Ihre Geschichte erzählt.\n\n";

    if ($personalMessage !== '') {
        $text .= "--- Persönliche Nachricht ---\n{$personalMessage}\n\n";
    }

    $text .= "Ihre Demo-Webseite: {$demoUrl}\n\n"
        . "So geht es weiter:\n"
        . "1. Demo ansehen – Schauen Sie sich den Entwurf in Ruhe an.\n"
        . "2. Gemeinsam besprechen – Wir gehen die Seite zusammen durch.\n"
        . "3. Live schalten – Sobald alles passt, geht Ihre neue Webseite online.\n\n"
        . "Schauen Sie sich auch gerne mein Portfolio an: https://jasonholweg.de\n\n"
        . "Ich freue mich auf Ihre Rückmeldung!\n\n"
        . "Viele Grüße\n"
        . "Jason Holweg\n"
        . "hallo@jasonholweg.de\n"
        . "jasonholweg.de\n";

    return $text;
}
