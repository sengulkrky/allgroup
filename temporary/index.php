<?php
$langHeader = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';

$lang = strtolower(substr($langHeader, 0, 2));

switch ($lang) {
    case 'fr':
        $target = '/fr/';
        break;
    case 'en':
        $target = '/en/';
        break;
    case 'nl':
        $target = '/nl/';
        break;

    // Fallback for all other languages
    default:
        $target = '/nl/';
        break;
}

header("Location: $target", true, 302);
exit;
?>
