<?php
/**
 * Contact form handler
 * Expects a JSON POST body with: name, email, subject, message
 */
header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

// Read and decode JSON body
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data || !is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Invalid request body']);
    exit;
}

// Sanitise inputs
$name    = trim(strip_tags($data['name']    ?? ''));
$email   = trim(strip_tags($data['email']   ?? ''));
$subject = trim(strip_tags($data['subject'] ?? 'Kontaktanfrage'));
$message = trim(strip_tags($data['message'] ?? ''));

// Validate required fields
if ($name === '' || $email === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Pflichtfelder fehlen']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Ungültige E-Mail-Adresse']);
    exit;
}

// Destination – replace with your actual address
$to = 'hallo@jasonholweg.de';

$mailSubject = '[Portfolio] ' . $subject;
$mailBody    = "Name: $name\n"
             . "E-Mail: $email\n\n"
             . "Nachricht:\n$message\n";

$headers  = "From: noreply@jasonholweg.de\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $mailSubject, $mailBody, $headers)) {
    echo json_encode(['ok' => true]);
} else {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'E-Mail konnte nicht gesendet werden']);
}
