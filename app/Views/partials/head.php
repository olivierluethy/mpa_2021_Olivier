<?php
/**
 * Gemeinsamer Dokumentkopf (Dark Mode, Tailwind via Play-CDN).
 * Erwartet optional: $pageTitle
 */
$pageTitle = $pageTitle ?? 'Rechnungen verwalten';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> · Rechnungen verwalten</title>
    <link rel="shortcut icon" href="/images/icon.png">
    <meta name="author" content="Olivier Luethy">
    <!-- Tailwind CSS (Play CDN – build-less Umgebung, daher kein Stylesheet-File) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="min-h-screen bg-neutral-900 text-neutral-200 font-sans antialiased">
