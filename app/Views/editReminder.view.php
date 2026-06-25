<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

$inputCls = 'w-full rounded-lg border border-neutral-600 bg-neutral-900 px-3 py-2 text-neutral-100 placeholder-neutral-500 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/40';
$labelCls = 'mb-1 block text-sm font-medium text-neutral-300';

$m = $mahnung[0] ?? null;

$pageTitle = 'Mahnung bearbeiten';
$active = 'rechnungen';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<a href="/rechnungen/rechnungen" class="mb-4 inline-flex items-center gap-1.5 text-sm text-neutral-400 transition hover:text-white">
    <i class="fas fa-arrow-left"></i> Zurück zu Rechnungen
</a>

<div class="mx-auto max-w-lg rounded-2xl border border-neutral-700 bg-neutral-800 p-6 shadow-xl shadow-black/20">
    <h1 class="mb-5 text-xl font-semibold text-neutral-100">Mahnung bearbeiten</h1>
    <form action="/rechnungen/editReminder?id=<?= (int)($m['id'] ?? 0) ?>" method="post" class="space-y-4">
        <div>
            <label for="titel" class="<?= $labelCls ?>">Titel</label>
            <input type="text" name="titel" id="titel" required class="<?= $inputCls ?>" value="<?= e($m['titel'] ?? '') ?>">
        </div>
        <div>
            <label for="datum" class="<?= $labelCls ?>">Datum</label>
            <input type="date" name="datum" id="datum" required class="<?= $inputCls ?>" value="<?= e($m['datum'] ?? '') ?>">
        </div>
        <div class="flex justify-end gap-3 border-t border-neutral-700 pt-4">
            <a href="/rechnungen/rechnungen" class="rounded-lg border border-neutral-600 px-4 py-2 text-sm font-medium text-neutral-300 transition hover:bg-neutral-700">Abbrechen</a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                <i class="fas fa-save"></i> Speichern
            </button>
        </div>
    </form>
</div>

<?php require __DIR__ . '/partials/foot.php'; ?>
