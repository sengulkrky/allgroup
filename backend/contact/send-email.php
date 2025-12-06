<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /nl/contact.html');
    exit;
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

// Basic validatie
if ($name === '' || $email === '' || $message === '') {
    die("Fout: alle velden zijn verplicht.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Fout: ongeldig e-mailadres.");
}

// Email naar je oom
$naar = "sengul.krky03@gmail.com"; // <-- HIER aanpassen
$onderwerp = "Nieuw bericht via contactformulier";
$inhoud = "
Naam: $name
Email: $email

Bericht:
$message
";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

// Verzenden
mail($naar, $onderwerp, $inhoud, $headers);

// Doorsturen naar ‘bedankt’-pagina
header('Location: /nl/bedankt.html');
exit;
