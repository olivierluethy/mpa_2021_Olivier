<?php
/**
 * Dunkle Top-Navigation + Öffnen des <main>-Containers.
 * Erwartet optional: $active  (uebersicht | rechnungen | personen)
 */
$active = $active ?? '';
$navLink = function (string $name, string $label) use ($active): string {
    $base = 'pb-1 border-b-2 transition-colors';
    $cls = $name === $active
        ? 'text-white font-semibold border-indigo-400'
        : 'text-neutral-400 border-transparent hover:text-white';
    return '<a href="/rechnungen/' . $name . '" class="' . $base . ' ' . $cls . '">' . $label . '</a>';
};
?>
<nav class="sticky top-0 z-30 flex items-center justify-between gap-4 border-b border-neutral-700 bg-neutral-800/95 px-6 py-3 backdrop-blur">
    <a href="/rechnungen/uebersicht" class="flex items-center gap-3">
        <img src="/images/icon.png" alt="" class="h-9 w-9 object-contain">
        <span class="text-lg font-semibold text-neutral-100">Rechnungen&nbsp;verwalten</span>
    </a>
    <div class="flex items-center gap-6 text-sm">
        <?= $navLink('uebersicht', 'Übersicht') ?>
        <?= $navLink('rechnungen', 'Rechnungen') ?>
        <?= $navLink('personen', 'Personen') ?>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="/rechnungen/logout" class="rounded-md bg-neutral-700 px-3 py-1.5 text-neutral-200 transition-colors hover:bg-rose-600 hover:text-white"><i class="fas fa-sign-out-alt"></i> Logout</a>
        <?php else: ?>
            <a href="/rechnungen/login" class="rounded-md bg-indigo-600 px-3 py-1.5 text-white transition-colors hover:bg-indigo-500">Login</a>
        <?php endif; ?>
    </div>
</nav>
<main class="mx-auto max-w-7xl px-6 py-8">
