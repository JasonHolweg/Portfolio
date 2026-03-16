<?php
/**
 * Contact form handler via Mailgun HTTP API
 * Expects a JSON POST body with: name, email, subject, message
 */
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid request body']);
    exit;
}

$name    = trim(strip_tags($data['name'] ?? ''));
$email   = trim(strip_tags($data['email'] ?? ''));
$subject = trim(strip_tags($data['subject'] ?? 'Kontaktanfrage'));
$message = trim(strip_tags($data['message'] ?? ''));
$companyWebsite = trim((string) ($data['company_website'] ?? ''));
$turnstileToken = trim((string) ($data['turnstile_token'] ?? ''));

if ($name === '' || $email === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Pflichtfelder fehlen']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Ungültige E-Mail-Adresse']);
    exit;
}

$mailConfig = loadMailConfig();

if ($companyWebsite !== '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Anfrage konnte nicht verarbeitet werden.']);
    exit;
}

if ($mailConfig['turnstile_site_key'] !== '' || $mailConfig['turnstile_secret_key'] !== '') {
    if ($mailConfig['turnstile_site_key'] === '' || $mailConfig['turnstile_secret_key'] === '') {
        http_response_code(500);
        echo json_encode([
            'ok' => false,
            'error' => 'Sicherheitspruefung ist nicht vollstaendig konfiguriert.',
        ]);
        exit;
    }

    if ($turnstileToken === '') {
        http_response_code(422);
        echo json_encode([
            'ok' => false,
            'error' => 'Bitte bestaetige kurz die Sicherheitspruefung.',
        ]);
        exit;
    }

    $turnstileResult = verifyTurnstileToken(
        $mailConfig['turnstile_secret_key'],
        $turnstileToken,
        $_SERVER['REMOTE_ADDR'] ?? ''
    );

    if (!$turnstileResult['ok']) {
        error_log('Turnstile verification failed: ' . $turnstileResult['error']);
        http_response_code(422);
        echo json_encode([
            'ok' => false,
            'error' => 'Sicherheitspruefung fehlgeschlagen. Bitte versuche es erneut.',
        ]);
        exit;
    }
}

if (
    $mailConfig['api_key'] === ''
    || $mailConfig['domain'] === ''
    || $mailConfig['to_email'] === ''
    || $mailConfig['from_email'] === ''
) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Mailversand ist noch nicht vollständig konfiguriert.',
    ]);
    exit;
}

$mailSubject = '[Portfolio] ' . $subject;
$mailText = "Name: {$name}\n"
    . "E-Mail: {$email}\n\n"
    . "Nachricht:\n{$message}\n";

$mailHtml = buildAdminMailHtml($name, $email, $subject, $message);

$adminPayload = [
    'from' => formatFromHeader($mailConfig['from_name'], $mailConfig['from_email']),
    'to' => $mailConfig['to_email'],
    'subject' => $mailSubject,
    'text' => $mailText,
    'html' => $mailHtml,
    'h:Reply-To' => $email,
];

$result = sendViaMailgun($mailConfig, $adminPayload);

if (!$result['ok']) {
    error_log('Mailgun admin send failed: ' . $result['error']);
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'E-Mail konnte nicht gesendet werden. Bitte versuche es erneut oder schreibe direkt an hallo@jasonholweg.de.',
    ]);
    exit;
}

$confirmationPayload = [
    'from' => formatFromHeader($mailConfig['from_name'], $mailConfig['from_email']),
    'to' => $email,
    'subject' => 'Deine Anfrage ist bei mir eingegangen',
    'text' => buildConfirmationMailText($name),
    'html' => buildConfirmationMailHtml($name),
    'h:Reply-To' => $mailConfig['to_email'],
];

$confirmationResult = sendViaMailgun($mailConfig, $confirmationPayload);
if (!$confirmationResult['ok']) {
    error_log('Mailgun confirmation send failed: ' . $confirmationResult['error']);
}

echo json_encode(['ok' => true]);
exit;

function loadMailConfig()
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
        'api_key' => trim((string) configValue('MAILGUN_API_KEY', $fileConfig, '')),
        'domain' => trim((string) configValue('MAILGUN_DOMAIN', $fileConfig, '')),
        'api_base' => rtrim((string) configValue('MAILGUN_API_BASE', $fileConfig, 'https://api.mailgun.net'), '/'),
        'from_email' => trim((string) configValue('MAILGUN_FROM_EMAIL', $fileConfig, 'hallo@jasonholweg.de')),
        'from_name' => trim((string) configValue('MAILGUN_FROM_NAME', $fileConfig, 'Jason Holweg')),
        'to_email' => trim((string) configValue('MAILGUN_TO_EMAIL', $fileConfig, 'hallo@jasonholweg.de')),
        'turnstile_site_key' => trim((string) configValue('TURNSTILE_SITE_KEY', $fileConfig, '')),
        'turnstile_secret_key' => trim((string) configValue('TURNSTILE_SECRET_KEY', $fileConfig, '')),
    ];
}

function configValue($key, array $fileConfig, $default = '')
{
    $envValue = getenv($key);
    if ($envValue !== false && $envValue !== '') {
        return $envValue;
    }

    if (array_key_exists($key, $fileConfig) && $fileConfig[$key] !== '') {
        return $fileConfig[$key];
    }

    return $default;
}

function sendViaMailgun(array $config, array $payload)
{
    $endpoint = $config['api_base'] . '/v3/' . rawurlencode($config['domain']) . '/messages';
    $encodedPayload = http_build_query($payload);

    if (function_exists('curl_init')) {
        return sendViaMailgunCurl($endpoint, $config['api_key'], $encodedPayload);
    }

    return sendViaMailgunStream($endpoint, $config['api_key'], $encodedPayload);
}

function sendViaMailgunCurl($endpoint, $apiKey, $encodedPayload)
{
    $ch = curl_init($endpoint);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $encodedPayload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERPWD => 'api:' . $apiKey,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_TIMEOUT => 20,
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

function sendViaMailgunStream($endpoint, $apiKey, $encodedPayload)
{
    $headers = [
        'Authorization: Basic ' . base64_encode('api:' . $apiKey),
        'Content-Type: application/x-www-form-urlencoded',
        'Content-Length: ' . strlen($encodedPayload),
    ];

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $encodedPayload,
            'ignore_errors' => true,
            'timeout' => 20,
        ],
    ]);

    $responseBody = @file_get_contents($endpoint, false, $context);
    $statusCode = extractHttpStatusCode($http_response_header ?? []);

    if ($responseBody === false) {
        return ['ok' => false, 'error' => 'HTTP request failed'];
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        return ['ok' => false, 'error' => 'HTTP ' . $statusCode . ' - ' . trim((string) $responseBody)];
    }

    return ['ok' => true];
}

function verifyTurnstileToken($secretKey, $token, $remoteIp)
{
    $payload = [
        'secret' => $secretKey,
        'response' => $token,
    ];

    if ($remoteIp !== '') {
        $payload['remoteip'] = $remoteIp;
    }

    $endpoint = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $encodedPayload = http_build_query($payload);

    if (function_exists('curl_init')) {
        $response = postFormRequestCurl($endpoint, $encodedPayload);
    } else {
        $response = postFormRequestStream($endpoint, $encodedPayload);
    }

    if (!$response['ok']) {
        return $response;
    }

    $decoded = json_decode($response['body'], true);
    if (!is_array($decoded)) {
        return ['ok' => false, 'error' => 'Invalid Turnstile response'];
    }

    if (!empty($decoded['success'])) {
        return ['ok' => true];
    }

    $errorCodes = [];
    if (!empty($decoded['error-codes']) && is_array($decoded['error-codes'])) {
        $errorCodes = $decoded['error-codes'];
    }

    return ['ok' => false, 'error' => implode(', ', $errorCodes) ?: 'verification_failed'];
}

function extractHttpStatusCode(array $headers)
{
    foreach ($headers as $headerLine) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $headerLine, $matches)) {
            return (int) $matches[1];
        }
    }

    return 0;
}

function postFormRequestCurl($endpoint, $encodedPayload)
{
    $ch = curl_init($endpoint);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $encodedPayload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_TIMEOUT => 20,
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

    return ['ok' => true, 'body' => $responseBody];
}

function postFormRequestStream($endpoint, $encodedPayload)
{
    $headers = [
        'Content-Type: application/x-www-form-urlencoded',
        'Content-Length: ' . strlen($encodedPayload),
    ];

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => implode("\r\n", $headers),
            'content' => $encodedPayload,
            'ignore_errors' => true,
            'timeout' => 20,
        ],
    ]);

    $responseBody = @file_get_contents($endpoint, false, $context);
    $statusCode = extractHttpStatusCode($http_response_header ?? []);

    if ($responseBody === false) {
        return ['ok' => false, 'error' => 'HTTP request failed'];
    }

    if ($statusCode < 200 || $statusCode >= 300) {
        return ['ok' => false, 'error' => 'HTTP ' . $statusCode . ' - ' . trim((string) $responseBody)];
    }

    return ['ok' => true, 'body' => $responseBody];
}

function formatFromHeader($name, $email)
{
    if ($name === '') {
        return $email;
    }

    return sprintf('%s <%s>', $name, $email);
}

function buildAdminMailHtml($name, $email, $subject, $message)
{
    $safeName = nl2br(htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
    $safeEmail = nl2br(htmlspecialchars($email, ENT_QUOTES, 'UTF-8'));
    $safeSubject = nl2br(htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'));
    $safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));

    return <<<HTML
<html lang="de">
  <body style="margin:0;padding:24px;background:#06060f;color:#f8fafc;font-family:Inter,Arial,sans-serif;">
    <div style="max-width:680px;margin:0 auto;padding:24px;border:1px solid rgba(255,255,255,0.12);border-radius:20px;background:#0d0d1a;">
      <h1 style="margin:0 0 24px;font-size:24px;line-height:1.2;">Neue Kontaktanfrage</h1>
      <p style="margin:0 0 12px;"><strong>Name:</strong><br>{$safeName}</p>
      <p style="margin:0 0 12px;"><strong>E-Mail:</strong><br>{$safeEmail}</p>
      <p style="margin:0 0 12px;"><strong>Betreff:</strong><br>{$safeSubject}</p>
      <p style="margin:0;"><strong>Nachricht:</strong><br>{$safeMessage}</p>
    </div>
  </body>
</html>
HTML;
}

function buildConfirmationMailText($name)
{
    return "Hallo {$name},\n\n"
        . "deine Anfrage ist erfolgreich bei mir eingegangen.\n"
        . "Ich schaue sie mir persönlich an und melde mich in der Regel innerhalb der nächsten 48 Stunden bei dir zurück.\n\n"
        . "Wenn du in der Zwischenzeit noch etwas ergänzen möchtest, kannst du einfach auf diese E-Mail antworten.\n\n"
        . "Viele Grüße\n"
        . "Jason Holweg\n"
        . "jasonholweg.de\n";
}

function buildConfirmationMailHtml($name)
{
    $safeName = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $safeYear = date('Y');

    return <<<HTML
<html lang="de">
  <body style="margin:0;padding:0;background:#05060d;color:#f8fafc;font-family:Inter,Arial,sans-serif;">
    <div style="background:
      radial-gradient(circle at top left, rgba(168,85,247,0.22), transparent 32%),
      radial-gradient(circle at bottom right, rgba(78,205,196,0.18), transparent 30%),
      linear-gradient(180deg, #070811 0%, #0b0d18 100%);
      padding:32px 16px;">
      <div style="max-width:680px;margin:0 auto;">
        <div style="padding:14px 18px;margin:0 0 18px;display:inline-block;border:1px solid rgba(255,255,255,0.1);border-radius:999px;background:rgba(255,255,255,0.05);color:#dbe6ff;font-size:12px;letter-spacing:0.08em;text-transform:uppercase;">
          Anfrage eingegangen
        </div>

        <div style="border:1px solid rgba(255,255,255,0.12);border-radius:28px;overflow:hidden;background:
          linear-gradient(180deg, rgba(255,255,255,0.08), rgba(255,255,255,0.04));
          box-shadow:0 24px 80px rgba(0,0,0,0.3);backdrop-filter:blur(12px);">
          <div style="padding:40px 28px 18px;">
            <div style="width:58px;height:58px;border-radius:18px;background:
              linear-gradient(135deg, rgba(255,107,107,0.95), rgba(168,85,247,0.95) 55%, rgba(59,130,246,0.95));
              display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#ffffff;box-shadow:0 14px 30px rgba(168,85,247,0.28);">
              JH
            </div>
            <h1 style="margin:26px 0 14px;font-size:34px;line-height:1.05;letter-spacing:-0.03em;color:#ffffff;">
              Danke, {$safeName}.<br>
              Ich kümmere mich darum.
            </h1>
            <p style="margin:0 0 22px;font-size:17px;line-height:1.75;color:#cbd5e1;max-width:34rem;">
              deine Anfrage ist erfolgreich bei mir eingegangen. Ich schaue sie mir persönlich an und melde mich in der Regel innerhalb der nächsten 48 Stunden mit einer individuellen Rückmeldung bei dir.
            </p>
          </div>

          <div style="padding:0 28px 28px;">
            <div style="display:block;padding:22px;border:1px solid rgba(255,255,255,0.1);border-radius:22px;background:rgba(7,10,20,0.55);">
              <div style="margin:0 0 8px;font-size:13px;letter-spacing:0.08em;text-transform:uppercase;color:#94a3b8;">So geht es weiter</div>
              <p style="margin:0 0 10px;font-size:16px;line-height:1.7;color:#e2e8f0;">
                Ich prüfe dein Anliegen persönlich und melde mich mit einem klaren nächsten Schritt.
              </p>
              <p style="margin:0;font-size:15px;line-height:1.7;color:#94a3b8;">
                Wenn du in der Zwischenzeit noch etwas ergänzen möchtest, kannst du einfach auf diese E-Mail antworten.
              </p>
            </div>
          </div>

          <div style="padding:0 28px 32px;">
            <a href="https://jasonholweg.de" style="display:inline-block;padding:15px 22px;border-radius:14px;background:linear-gradient(135deg, #ff6b6b 0%, #f472b6 34%, #a855f7 68%, #3b82f6 100%);color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;box-shadow:0 14px 28px rgba(59,130,246,0.24);">
              Website ansehen
            </a>
          </div>
        </div>

        <p style="margin:18px 0 0;padding:0 4px;font-size:13px;line-height:1.7;color:#7c8aa5;">
          Jason Holweg · Webentwicklung & Design · Deutschland<br>
          Diese E-Mail wurde automatisch als Bestätigung deiner Anfrage versendet. © {$safeYear}
        </p>
      </div>
    </div>
  </body>
</html>
HTML;
}
