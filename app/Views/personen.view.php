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
    <button type="button" data-modal-open="add"
       class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-900/30 transition hover:bg-indigo-500">
        <i class="fas fa-plus"></i> Person hinzufügen
    </button>
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
                                    <button type="button"
                                       class="js-edit-person inline-flex items-center gap-1.5 rounded-md bg-neutral-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-neutral-500"
                                       data-id="<?= (int)$person['id'] ?>"
                                       data-namen="<?= e($person['namen']) ?>"
                                       data-adresse="<?= e($person['adresse']) ?>"
                                       data-telefonnummer="<?= e($person['telefonnummer'] ?? '') ?>"
                                       data-email="<?= e($person['email']) ?>">
                                        <i class="fas fa-edit"></i> Bearbeiten
                                    </button>
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

<?php
$inputCls = 'w-full rounded-lg border border-neutral-600 bg-neutral-900 px-3 py-2 text-neutral-100 placeholder-neutral-500 outline-none transition focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/40';
$labelCls = 'mb-1 block text-sm font-medium text-neutral-300';
?>
<!-- Modal: Person hinzufügen / bearbeiten -->
<div id="person-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" data-modal-close></div>
    <div class="relative z-10 w-full max-w-lg rounded-2xl border border-neutral-700 bg-neutral-800 shadow-2xl shadow-black/50">
        <div class="flex items-center justify-between border-b border-neutral-700 px-6 py-4">
            <h2 id="person-modal-title" class="text-lg font-semibold text-neutral-100">Person hinzufügen</h2>
            <button type="button" data-modal-close class="text-neutral-400 transition hover:text-white" aria-label="Schliessen">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form id="person-form" method="post" class="px-6 py-5">
            <div class="space-y-4">
                <div>
                    <label for="pf-namen" class="<?= $labelCls ?>">Name</label>
                    <input type="text" name="namen" id="pf-namen" required class="<?= $inputCls ?>">
                </div>
                <div>
                    <label for="pf-adresse" class="<?= $labelCls ?>">Adresse</label>
                    <textarea name="adresse" id="pf-adresse" rows="3" required class="<?= $inputCls ?>"></textarea>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="pf-telefonnummer" class="<?= $labelCls ?>">Telefonnummer</label>
                        <input type="text" name="telefonnummer" id="pf-telefonnummer" class="<?= $inputCls ?>">
                    </div>
                    <div>
                        <label for="pf-email" class="<?= $labelCls ?>">E-Mail</label>
                        <input type="email" name="email" id="pf-email" required class="<?= $inputCls ?>">
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3 border-t border-neutral-700 pt-4">
                <button type="button" data-modal-close
                        class="rounded-lg border border-neutral-600 px-4 py-2 text-sm font-medium text-neutral-300 transition hover:bg-neutral-700">
                    Abbrechen
                </button>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500">
                    <i class="fas fa-save"></i> Speichern
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('person-modal');
    const form = document.getElementById('person-form');
    const title = document.getElementById('person-modal-title');
    const field = id => document.getElementById(id);

    function openModal() { modal.classList.remove('hidden'); modal.classList.add('flex'); }
    function closeModal() { modal.classList.add('hidden'); modal.classList.remove('flex'); }

    function openAdd() {
        title.textContent = 'Person hinzufügen';
        form.action = '/rechnungen/addPerson';
        form.reset();
        openModal();
        field('pf-namen').focus();
    }
    function openEdit(d) {
        title.textContent = 'Person bearbeiten';
        form.action = '/rechnungen/editPerson?id=' + d.id;
        field('pf-namen').value = d.namen || '';
        field('pf-adresse').value = d.adresse || '';
        field('pf-telefonnummer').value = d.telefonnummer || '';
        field('pf-email').value = d.email || '';
        openModal();
        field('pf-namen').focus();
    }

    document.querySelectorAll('[data-modal-open="add"]').forEach(b => b.addEventListener('click', openAdd));
    document.querySelectorAll('.js-edit-person').forEach(b => b.addEventListener('click', () => openEdit(b.dataset)));
    modal.querySelectorAll('[data-modal-close]').forEach(el => el.addEventListener('click', closeModal));
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
})();
</script>

<?php require __DIR__ . '/partials/foot.php'; ?>
