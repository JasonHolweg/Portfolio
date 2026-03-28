<?php
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$accessCode = trim((string) ($_GET['access_code'] ?? ''));
if ($accessCode !== '2705') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'Zugang verweigert.']);
    exit;
}

$limit = (int) ($_GET['limit'] ?? 50);
if ($limit < 1) {
    $limit = 1;
}
if ($limit > 200) {
    $limit = 200;
}

$logFile = __DIR__ . '/storage/outreach_sent_log.jsonl';
if (!is_file($logFile)) {
    echo json_encode(['ok' => true, 'items' => []]);
    exit;
}

$lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($lines === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Logdatei konnte nicht gelesen werden.']);
    exit;
}

$items = [];
$slice = array_reverse(array_slice($lines, -$limit));

foreach ($slice as $line) {
    $decoded = json_decode($line, true);
    if (!is_array($decoded)) {
        continue;
    }
    $items[] = [
        'sent_at' => (string) ($decoded['sent_at'] ?? ''),
        'recipient_email' => (string) ($decoded['recipient_email'] ?? ''),
        'company_name' => (string) ($decoded['company_name'] ?? ''),
        'demo_url' => (string) ($decoded['demo_url'] ?? ''),
        'attachments_count' => (int) ($decoded['attachments_count'] ?? 0),
        'bcc' => array_values(array_filter((array) ($decoded['bcc'] ?? []), 'is_string')),
    ];
}

echo json_encode(['ok' => true, 'items' => $items], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
