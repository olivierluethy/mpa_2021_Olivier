<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

$reminderCounter = count($mahnungen);
$r = $rechnung[0] ?? null;
$p = $person[0] ?? null;

$kat = 'offen';
if ($r) {
    if ((int)$r['status'] === 1) {
        $kat = 'beglichen';
    } else {
        try { if ((new DateTime($r['datum']))->modify('+1 day') < new DateTime()) $kat = 'ueberfaellig'; }
        catch (Exception $e) {}
    }
}
$badge = [
    'offen'        => 'bg-amber-500/15 text-amber-300 ring-1 ring-inset ring-amber-500/30',
    'ueberfaellig' => 'bg-rose-500/15 text-rose-300 ring-1 ring-inset ring-rose-500/30',
    'beglichen'    => 'bg-emerald-500/15 text-emerald-300 ring-1 ring-inset ring-emerald-500/30',
];
$badgeLabel = ['offen' => 'Offen', 'ueberfaellig' => 'Überfällig', 'beglichen' => 'Beglichen'];

$pageTitle = 'Rechnung' . ($r ? ' · ' . $r['titel'] : '');
$active = 'rechnungen';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<a href="/rechnungen/rechnungen" class="mb-4 inline-flex items-center gap-1.5 text-sm text-neutral-400 transition hover:text-white">
    <i class="fas fa-arrow-left"></i> Zurück zu Rechnungen
</a>

<?php if ($r): ?>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Rechnung -->
        <div class="lg:col-span-2 rounded-xl border border-neutral-700 bg-neutral-800 p-6 shadow-xl shadow-black/20">
            <div class="mb-4 flex items-start justify-between gap-4">
                <h1 class="text-xl font-semibold text-neutral-100"><?= e($r['titel']) ?></h1>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?= $badge[$kat] ?>"><?= $badgeLabel[$kat] ?></span>
            </div>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs uppercase tracking-wide text-neutral-500">Betrag</dt>
                    <dd class="mt-1 text-lg font-semibold text-neutral-100">CHF <?= number_format((float)$r['betrag'], 0, '.', "'") ?>.&ndash;</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-wide text-neutral-500">Datum</dt>
                    <dd class="mt-1 text-neutral-200"><?= e(formatDate($r['datum'])) ?></dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs uppercase tracking-wide text-neutral-500">Beschreibung</dt>
                    <dd class="mt-1 text-neutral-200"><?= e($r['beschreibung']) ?></dd>
                </div>
            </dl>
        </div>

        <!-- Person -->
        <div class="rounded-xl border border-neutral-700 bg-neutral-800 p-6 shadow-xl shadow-black/20">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-neutral-400">Kunde</h2>
            <?php if ($p): ?>
                <p class="text-lg font-semibold text-neutral-100"><?= e($p['namen']) ?></p>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-neutral-500">Adresse</dt>
                        <dd class="mt-0.5 text-neutral-200"><?= e($p['adresse']) ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-neutral-500">Telefon</dt>
                        <dd class="mt-0.5 text-neutral-200"><?= e($p['telefonnummer'] ?? '') ?></dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-neutral-500">E-Mail</dt>
                        <dd class="mt-0.5 text-neutral-200"><?= e($p['email']) ?></dd>
                    </div>
                </dl>
            <?php else: ?>
                <p class="text-neutral-400">Keine Person zugeordnet.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mahnungen -->
    <h2 class="mb-3 mt-8 text-lg font-semibold text-neutral-100">Mahnungen</h2>
    <?php if ($reminderCounter > 0): ?>
        <div class="overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 shadow-xl shadow-black/20">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-neutral-700 text-left text-xs font-semibold uppercase tracking-wide text-neutral-400">
                            <th class="px-4 py-3">Titel</th>
                            <th class="px-4 py-3">Datum</th>
                            <th class="px-4 py-3 text-right">Aktionen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-700/60">
                        <?php foreach ($mahnungen as $m): ?>
                            <tr class="transition-colors hover:bg-neutral-700/30">
                                <td class="px-4 py-3 font-medium text-neutral-100"><?= e($m['titel']) ?></td>
                                <td class="whitespace-nowrap px-4 py-3 text-neutral-300"><?= e(formatDate($m['datum'])) ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="/rechnungen/editReminder?id=<?= (int)$m['id'] ?>"
                                           class="inline-flex items-center gap-1.5 rounded-md bg-neutral-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-neutral-500">
                                            <i class="fas fa-edit"></i> Bearbeiten
                                        </a>
                                        <a href="/rechnungen/deleteReminder?id=<?= (int)$m['id'] ?>"
                                           class="inline-flex items-center gap-1.5 rounded-md bg-rose-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-rose-500">
                                            <i class="fas fa-trash"></i> Löschen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-8 text-center">
            <p class="text-neutral-400">Es wurde noch keine Mahnung erfasst.</p>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-12 text-center">
        <p class="text-neutral-400">Rechnung nicht gefunden.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/foot.php'; ?>
