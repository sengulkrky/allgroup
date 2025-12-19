<?php

// ----------------------------------------
//  SECURITY & VALIDATION
// ----------------------------------------

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Max file size (5MB)
$maxFileSize = 5 * 1024 * 1024;

// Allow only PDF
function isValidPDF($file) {
    return isset($file['type']) && $file['type'] === 'application/pdf';
}

// ----------------------------------------
//  RETRIEVE FORM FIELDS
// ----------------------------------------

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    die("Required fields are missing.");
}

// ----------------------------------------
//  FILE HANDLING
// ----------------------------------------

$cvFile         = $_FILES['cv'] ?? null;
$motivationFile = $_FILES['motivation'] ?? null;

$attachments = [];

// ---- CV (required) ----
if (!$cvFile || $cvFile['error'] !== UPLOAD_ERR_OK) {
    die("CV upload is verplicht.");
}

if ($cvFile['size'] > $maxFileSize) {
    die("CV is te groot. Max 5MB.");
}

if (!isValidPDF($cvFile)) {
    die("CV moet een PDF zijn.");
}

$attachments[] = $cvFile;


// ---- Motivation letter (optional) ----
if ($motivationFile && $motivationFile['error'] === UPLOAD_ERR_OK) {

    if ($motivationFile['size'] > $maxFileSize) {
        die("Motivatiebrief is te groot. Max 5MB.");
    }

    if (!isValidPDF($motivationFile)) {
        die("Motivatiebrief moet een PDF zijn.");
    }

    $attachments[] = $motivationFile;
}


// ----------------------------------------
//  BUILD EMAIL
// ----------------------------------------

$to = "sengul.krky03@gmail.com";  // <-- VERANDER DIT NAAR JUIST ADRES
$subject = "Nieuwe contactaanvraag - $name";

$boundary = md5(time());
$headers = "From: {$email}\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";


// Email body START
$body  = "--{$boundary}\r\n";
$body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";

$body .= "Naam: $name\n";
$body .= "E-mail: $email\n\n";
$body .= "Bericht:\n$message\n\n";


// ATTACHMENTS
foreach ($attachments as $file) {

    $fileContent = chunk_split(base64_encode(file_get_contents($file['tmp_name'])));
    $fileName    = basename($file['name']);

    $body .= "--{$boundary}\r\n";
    $body .= "Content-Type: application/pdf; name=\"{$fileName}\"\r\n";
    $body .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= $fileContent . "\r\n";
}

$body .= "--{$boundary}--";


// ----------------------------------------
//  SEND EMAIL
// ----------------------------------------

$mailSent = mail($to, $subject, $body, $headers);


// ----------------------------------------
//  LANGUAGE DETECTION + REDIRECT
// ----------------------------------------

// Find which page the user came from
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$language = 'nl'; // default

if (strpos($referer, '/fr/') !== false) {
    $language = 'fr';
} elseif (strpos($referer, '/en/') !== false) {
    $language = 'en';
}

// Redirect to success page per language
if ($mailSent) {
    header("Location: /$language/success.html");
    exit;
} else {
    die("Er ging iets mis bij het verzenden van de e-mail.");
}

?>
