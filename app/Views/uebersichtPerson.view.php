<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

$wie_oft_zu_spaet = count($zu_spaet);
$anzahl_rechnungen = count($rechnung);
$kundenName = $anzahl_rechnungen > 0 ? $rechnung[0]['namen'] : 'Person';

$badge = [
    'offen'        => 'bg-amber-500/15 text-amber-300 ring-1 ring-inset ring-amber-500/30',
    'ueberfaellig' => 'bg-rose-500/15 text-rose-300 ring-1 ring-inset ring-rose-500/30',
    'beglichen'    => 'bg-emerald-500/15 text-emerald-300 ring-1 ring-inset ring-emerald-500/30',
];
$badgeLabel = ['offen' => 'Offen', 'ueberfaellig' => 'Überfällig', 'beglichen' => 'Beglichen'];
$kategorieVon = function (array $r): string {
    if ((int)$r['status'] === 1) return 'beglichen';
    try {
        if ((new DateTime($r['datum']))->modify('+1 day') < new DateTime()) return 'ueberfaellig';
    } catch (Exception $e) {}
    return 'offen';
};

$pageTitle = 'Person · ' . $kundenName;
$active = 'personen';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <a href="/rechnungen/personen" class="mb-2 inline-flex items-center gap-1.5 text-sm text-neutral-400 transition hover:text-white">
            <i class="fas fa-arrow-left"></i> Zurück zu Personen
        </a>
        <h1 class="text-2xl font-semibold text-neutral-100"><?= e($kundenName) ?></h1>
    </div>
</div>

<!-- Kennzahlen -->
<div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <?php
        $lateCls = $wie_oft_zu_spaet > 0
            ? 'border-rose-500/40 bg-rose-500/10'
            : 'border-emerald-500/40 bg-emerald-500/10';
        $lateIconCls = $wie_oft_zu_spaet > 0 ? 'bg-rose-500/20 text-rose-300' : 'bg-emerald-500/20 text-emerald-300';
        $lateText = $wie_oft_zu_spaet > 0 ? 'text-rose-200' : 'text-emerald-200';
    ?>
    <div class="rounded-xl border <?= $lateCls ?> p-5">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg <?= $lateIconCls ?>">
                <i class="fas fa-triangle-exclamation text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold <?= $lateText ?>"><?= $wie_oft_zu_spaet ?></p>
                <p class="text-sm text-neutral-400">Rechnungen zu spät bezahlt</p>
            </div>
        </div>
    </div>
    <div class="rounded-xl border border-neutral-700 bg-neutral-800 p-5">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-neutral-700 text-neutral-300">
                <i class="fas fa-file-invoice text-xl"></i>
            </div>
            <div>
                <p class="text-3xl font-bold text-neutral-100"><?= $anzahl_rechnungen ?></p>
                <p class="text-sm text-neutral-400">Rechnungen insgesamt</p>
            </div>
        </div>
    </div>
</div>

<?php if ($anzahl_rechnungen > 0): ?>
    <h2 class="mb-3 text-lg font-semibold text-neutral-100">Bisherige Rechnungen</h2>
    <div class="overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 shadow-xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-700 text-left text-xs font-semibold uppercase tracking-wide text-neutral-400">
                        <th class="px-4 py-3">Titel</th>
                        <th class="px-4 py-3">Beschreibung</th>
                        <th class="px-4 py-3">Betrag</th>
                        <th class="px-4 py-3">Datum</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700/60">
                    <?php foreach ($rechnung as $r): ?>
                        <?php $kat = $kategorieVon($r); ?>
                        <tr class="transition-colors hover:bg-neutral-700/30">
                            <td class="px-4 py-3 font-medium text-neutral-100"><?= e($r['titel']) ?></td>
                            <td class="max-w-xs truncate px-4 py-3 text-neutral-300" title="<?= e($r['beschreibung']) ?>"><?= e($r['beschreibung']) ?></td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-neutral-200">CHF <?= number_format((float)$r['betrag'], 0, '.', "'") ?>.&ndash;</td>
                            <td class="whitespace-nowrap px-4 py-3 text-neutral-300"><?= e(formatDate($r['datum'])) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?= $badge[$kat] ?>"><?= $badgeLabel[$kat] ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-12 text-center">
        <p class="text-neutral-400">Diese Person enthält noch keine Rechnungen.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/foot.php'; ?>
