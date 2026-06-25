<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

$anzahl_offen = count($rechnungen);

$badge = [
    'offen'        => 'bg-amber-500/15 text-amber-300 ring-1 ring-inset ring-amber-500/30',
    'ueberfaellig' => 'bg-rose-500/15 text-rose-300 ring-1 ring-inset ring-rose-500/30',
];
$badgeLabel = ['offen' => 'Offen', 'ueberfaellig' => 'Überfällig'];
$accent = ['offen' => 'border-l-2 border-amber-500/50', 'ueberfaellig' => 'border-l-2 border-rose-500/60'];
$istUeberfaellig = function (array $r): bool {
    try { return (new DateTime($r['datum']))->modify('+1 day') < new DateTime(); }
    catch (Exception $e) { return false; }
};

$pageTitle = 'Übersicht';
$active = 'uebersicht';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold text-neutral-100">Übersicht offener Rechnungen</h1>
        <p class="mt-1 text-sm text-neutral-400"><?= $anzahl_offen ?> offene Rechnungen</p>
    </div>
    <a href="/rechnungen/rechnungen"
       class="inline-flex items-center gap-2 rounded-lg border border-neutral-600 px-4 py-2.5 text-sm font-medium text-neutral-200 transition hover:bg-neutral-700">
        Alle Rechnungen <i class="fas fa-arrow-right"></i>
    </a>
</div>

<?php if ($anzahl_offen > 0): ?>
    <div class="overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 shadow-xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-700 text-left text-xs font-semibold uppercase tracking-wide text-neutral-400">
                        <th class="px-4 py-3">Titel</th>
                        <th class="px-4 py-3">Beschreibung</th>
                        <th class="px-4 py-3">Betrag</th>
                        <th class="px-4 py-3">Person</th>
                        <th class="px-4 py-3">Datum</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aktionen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700/60">
                    <?php foreach ($rechnungen as $r): ?>
                        <?php $kat = $istUeberfaellig($r) ? 'ueberfaellig' : 'offen'; ?>
                        <tr class="transition-colors hover:bg-neutral-700/30">
                            <td class="px-4 py-3 font-medium text-neutral-100 <?= $accent[$kat] ?>"><?= e($r['titel']) ?></td>
                            <td class="max-w-xs truncate px-4 py-3 text-neutral-300" title="<?= e($r['beschreibung']) ?>"><?= e($r['beschreibung']) ?></td>
                            <td class="whitespace-nowrap px-4 py-3 font-medium text-neutral-200">CHF <?= number_format((float)$r['betrag'], 0, '.', "'") ?>.&ndash;</td>
                            <td class="px-4 py-3 text-neutral-300"><?= e($r['namen']) ?></td>
                            <td class="whitespace-nowrap px-4 py-3 text-neutral-300"><?= e(formatDate($r['datum'])) ?></td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?= $badge[$kat] ?>"><?= $badgeLabel[$kat] ?></span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/rechnungen/uebersichtRechnung?id=<?= (int)$r['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-sky-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-sky-500">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                    <a href="/rechnungen/begleichen?id=<?= (int)$r['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-emerald-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-emerald-500">
                                        <i class="fas fa-money-check"></i> Begleichen
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
    <div class="rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-12 text-center">
        <p class="text-neutral-400">Es wurde noch keine offene Rechnung erfasst.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/foot.php'; ?>
