<?php
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /rechnungen/login");
    exit;
}

// IDs der Personen, die bereits einer Rechnung zugeteilt sind (nicht löschbar wegen FK).
$zugeteilt_ids = [];
foreach ($personen_schon_zugeteilt as $p) {
    $zugeteilt_ids[$p['id']] = true;
}

$pageTitle = 'Personen';
$active = 'personen';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/nav.php';
?>

<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold text-neutral-100">Personen</h1>
        <p class="mt-1 text-sm text-neutral-400"><?= count($personen) ?> Personen erfasst</p>
    </div>
    <a href="/rechnungen/addPerson"
       class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:bg-indigo-500">
        <i class="fas fa-plus"></i> Person hinzufügen
    </a>
</div>

<?php if (count($personen) > 0): ?>
    <div class="overflow-hidden rounded-xl border border-neutral-700 bg-neutral-800 shadow-xl shadow-black/20">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-neutral-700 text-left text-xs font-semibold uppercase tracking-wide text-neutral-400">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Adresse</th>
                        <th class="px-4 py-3">Telefonnummer</th>
                        <th class="px-4 py-3">E-Mail</th>
                        <th class="px-4 py-3 text-right">Aktionen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-700/60">
                    <?php foreach ($personen as $person): ?>
                        <?php $istZugeteilt = isset($zugeteilt_ids[$person['id']]); ?>
                        <tr class="transition-colors hover:bg-neutral-700/30">
                            <td class="px-4 py-3 font-medium text-neutral-100"><?= e($person['namen']) ?></td>
                            <td class="px-4 py-3 text-neutral-300"><?= e($person['adresse']) ?></td>
                            <td class="px-4 py-3 text-neutral-300"><?= e($person['telefonnummer'] ?? '') ?></td>
                            <td class="px-4 py-3 text-neutral-300"><?= e($person['email']) ?></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="/rechnungen/uebersichtPerson?id=<?= (int)$person['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-sky-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-sky-500">
                                        <i class="fas fa-eye"></i> Übersicht
                                    </a>
                                    <a href="/rechnungen/editPerson?id=<?= (int)$person['id'] ?>"
                                       class="inline-flex items-center gap-1.5 rounded-md bg-neutral-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-neutral-500">
                                        <i class="fas fa-edit"></i> Bearbeiten
                                    </a>
                                    <?php if (!$istZugeteilt): ?>
                                        <a href="/rechnungen/deletePerson?id=<?= (int)$person['id'] ?>"
                                           class="inline-flex items-center gap-1.5 rounded-md bg-rose-600/90 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-rose-500">
                                            <i class="fas fa-trash"></i> Löschen
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5 rounded-md border border-neutral-700 px-2.5 py-1.5 text-xs font-medium text-neutral-500" title="Person ist Rechnungen zugeordnet">
                                            <i class="fas fa-lock"></i> verknüpft
                                        </span>
                                    <?php endif; ?>
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
        <p class="text-neutral-400">Es wurde noch keine Person hinzugefügt.</p>
    </div>
<?php endif; ?>

<?php require __DIR__ . '/partials/foot.php'; ?>
