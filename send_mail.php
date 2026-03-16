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

$mailHtml = buildMailHtml($name, $email, $subject, $message);

$payload = [
    'from' => formatFromHeader($mailConfig['from_name'], $mailConfig['from_email']),
    'to' => $mailConfig['to_email'],
    'subject' => $mailSubject,
    'text' => $mailText,
    'html' => $mailHtml,
    'h:Reply-To' => $email,
];

$result = sendViaMailgun($mailConfig, $payload);

if ($result['ok']) {
    echo json_encode(['ok' => true]);
    exit;
}

error_log('Mailgun send failed: ' . $result['error']);
http_response_code(500);
echo json_encode([
    'ok' => false,
    'error' => 'E-Mail konnte nicht gesendet werden. Bitte versuche es erneut oder schreibe direkt an hallo@jasonholweg.de.',
]);

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

function extractHttpStatusCode(array $headers)
{
    foreach ($headers as $headerLine) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $headerLine, $matches)) {
            return (int) $matches[1];
        }
    }

    return 0;
}

function formatFromHeader($name, $email)
{
    if ($name === '') {
        return $email;
    }

    return sprintf('%s <%s>', $name, $email);
}

function buildMailHtml($name, $email, $subject, $message)
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
