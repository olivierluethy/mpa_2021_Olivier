<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

/**
 * Bestimmt die Kategorie einer Rechnung: beglichen | ueberfaellig | offen.
 * Überfällig = noch offen UND Datum + 1 Tag liegt in der Vergangenheit.
 */
function rechnungKategorie(array $r): string {
    if ((int)$r['status'] === 1) {
        return 'beglichen';
    }
    try {
        $faellig = (new DateTime($r['datum']))->modify('+1 day');
        if ($faellig < new DateTime()) {
            return 'ueberfaellig';
        }
    } catch (Exception $e) {}
    return 'offen';
}

$kategorien = ['offen' => 0, 'ueberfaellig' => 0, 'beglichen' => 0];
foreach ($alle_rechnungen as $r) {
    $kategorien[rechnungKategorie($r)]++;
}

// Badge-Styles je Kategorie (dezente Dark-Mode-Akzente statt Vollflächen).
$badge = [
    'offen'        => 'bg-amber-500/15 text-amber-300 ring-1 ring-inset ring-amber-500/30',
    'ueberfaellig' => 'bg-rose-500/15 text-rose-300 ring-1 ring-inset ring-rose-500/30',
    'beglichen'    => 'bg-emerald-500/15 text-emerald-300 ring-1 ring-inset ring-emerald-500/30',
];
$badgeLabel = ['offen' => 'Offen', 'ueberfaellig' => 'Überfällig', 'beglichen' => 'Beglichen'];
$accent = [
    'offen'        => 'border-l-2 border-amber-500/50',
    'ueberfaellig' => 'border-l-2 border-rose-500/60',
    'beglichen'    => 'border-l-2 border-emerald-500/40',
];

$pageTitle = 'Rechnungen';
$active = 'rechnungen';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold text-neutral-100">Rechnungen</h1>
        <p class="mt-1 text-sm text-neutral-400"><?= count($alle_rechnungen) ?> Rechnungen insgesamt</p>
    </div>
    <a href="/rechnungen/addBill"
       class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:bg-indigo-500">
        <i class="fas fa-plus"></i> Rechnung hinzufügen
    </a>
</div>

<?php
$tabs = [
    'alle'         => ['Alle', count($alle_rechnungen)],
    'offen'        => ['Offen', $kategorien['offen']],
    'ueberfaellig' => ['Überfällig', $kategorien['ueberfaellig']],
    'beglichen'    => ['Beglichen', $kategorien['beglichen']],
];
?>
<?php if (count($alle_rechnungen) > 0): ?>
    <div id="rechnung-tabs" class="mb-4 inline-flex flex-wrap gap-1 rounded-lg border border-neutral-700 bg-neutral-800/60 p-1 text-sm">
        <?php foreach ($tabs as $key => [$label, $cnt]): $on = $key === 'alle'; ?>
            <button type="button" data-filter="<?= $key ?>"
                    class="filter-tab flex items-center gap-2 rounded-md px-3 py-1.5 font-medium transition <?= $on ? 'bg-neutral-700 text-white' : 'text-neutral-400 hover:text-white' ?>">
                <?= $label ?>
                <span class="rounded-full bg-neutral-900/60 px-1.5 py-0.5 text-xs text-neutral-400"><?= $cnt ?></span>
            </button>
        <?php endforeach; ?>
    </div>

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
                    <?php foreach ($alle_rechnungen as $r): ?>
                        <?php $kat = rechnungKategorie($r); ?>
                        <tr class="transition-colors hover:bg-neutral-700/30" data-category="<?= $kat ?>">
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
                                    <a href="/rechnungen/editBill?id=<?= (int)$r['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-neutral-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-neutral-500" title="Bearbeiten">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php if ($kat !== 'beglichen'): ?>
                                        <a href="/rechnungen/begleichen?id=<?= (int)$r['id'] ?>"
                                           class="inline-flex items-center gap-1.5 rounded-md bg-emerald-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-emerald-500" title="Begleichen">
                                            <i class="fas fa-money-check"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($kat === 'ueberfaellig'): ?>
                                        <form action="/rechnungen/addReminder" method="post" class="inline">
                                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-md bg-amber-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-amber-500" title="Mahnen">
                                                <i class="fas fa-stopwatch"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="/rechnungen/deleteBill?id=<?= (int)$r['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-rose-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-rose-500" title="Löschen">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="rechnung-empty" class="hidden rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-12 text-center">
        <p class="text-neutral-400">Keine Rechnungen in dieser Kategorie.</p>
    </div>

    <script>
    (function () {
        const tabs = document.querySelectorAll('#rechnung-tabs .filter-tab');
        const rows = document.querySelectorAll('tbody tr[data-category]');
        const empty = document.getElementById('rechnung-empty');
        function apply(filter) {
            let visible = 0;
            rows.forEach(function (row) {
                const show = filter === 'alle' || row.dataset.category === filter;
                row.classList.toggle('hidden', !show);
                if (show) visible++;
            });
            empty.classList.toggle('hidden', visible !== 0);
            tabs.forEach(function (tab) {
                const on = tab.dataset.filter === filter;
                tab.classList.toggle('bg-neutral-700', on);
                tab.classList.toggle('text-white', on);
                tab.classList.toggle('text-neutral-400', !on);
            });
        }
        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () { apply(tab.dataset.filter); });
        });
    })();
    </script>
<?php else: ?>
    <div class="rounded-xl border border-dashed border-neutral-700 bg-neutral-800/50 p-12 text-center">
        <p class="text-neutral-400">Es wurde noch keine Rechnung hinzugefügt.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/foot.php'; ?>
