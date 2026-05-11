<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$codes = $codes ?? [];
$filters = $filters ?? [];
$usageByCode = $usageByCode ?? [];
$today = $today ?? date('Y-m-d');
$flashError = session()->getFlashdata('error');
$flashErrorText = '';
if (!empty($flashError)) {
    $flashErrorText = is_array($flashError) ? implode(' | ', $flashError) : (string) $flashError;
}
$flashSuccess = session()->getFlashdata('success');
$flashSuccessText = '';
if (!empty($flashSuccess)) {
    $flashSuccessText = is_array($flashSuccess) ? implode(' | ', $flashSuccess) : (string) $flashSuccess;
}
?>
<div class="page-header" style="display:flex; justify-content: space-between; align-items: center; gap: 12px;">
    <div>
        <h1>Codes porte-monnaie</h1>
        <p>Gestion des codes (creation, edition, suppression).</p>
    </div>
    <a class="submit-btn" href="<?= base_url('back-office/codes/create') ?>" style="text-decoration: none;">Nouveau code</a>
</div>

<?php if (!empty($errors)) : ?>
    <div class="form-feedback" role="alert" style="margin-top: 12px;">
        <?= esc(implode(' | ', $errors)) ?>
    </div>
<?php endif; ?>

<?php if ($flashErrorText !== '') : ?>
    <div class="form-feedback" role="alert" style="margin-top: 12px;">
        <?= esc($flashErrorText) ?>
    </div>
<?php endif; ?>

<?php if ($flashSuccessText !== '') : ?>
    <div class="form-feedback" role="status" style="margin-top: 12px;">
        <?= esc($flashSuccessText) ?>
    </div>
<?php endif; ?>

<form method="get" action="<?= base_url('back-office/codes') ?>" style="margin-top: 16px;">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
        <div>
            <label for="libelle">Libelle</label>
            <input type="text" name="libelle" id="libelle" value="<?= esc((string) ($filters['libelle'] ?? '')) ?>">
        </div>
        <div>
            <label for="montant_min">Montant min</label>
            <input type="number" step="0.01" name="montant_min" id="montant_min" value="<?= esc((string) ($filters['montant_min'] ?? '')) ?>">
        </div>
        <div>
            <label for="montant_max">Montant max</label>
            <input type="number" step="0.01" name="montant_max" id="montant_max" value="<?= esc((string) ($filters['montant_max'] ?? '')) ?>">
        </div>
        <div>
            <label for="date_min">Expiration min</label>
            <input type="date" name="date_min" id="date_min" value="<?= esc((string) ($filters['date_min'] ?? '')) ?>">
        </div>
        <div>
            <label for="date_max">Expiration max</label>
            <input type="date" name="date_max" id="date_max" value="<?= esc((string) ($filters['date_max'] ?? '')) ?>">
        </div>
        <div>
            <label for="etat">Etat</label>
            <select name="etat" id="etat">
                <option value="">Tous</option>
                <option value="valide" <?= ($filters['etat'] ?? '') === 'valide' ? 'selected' : '' ?>>Valide</option>
                <option value="expire" <?= ($filters['etat'] ?? '') === 'expire' ? 'selected' : '' ?>>Expire</option>
            </select>
        </div>
        <div style="align-self: end;">
            <button type="submit" class="submit-btn" style="width: 100%;">Filtrer</button>
        </div>
    </div>
</form>

<div style="margin-top: 20px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding: 8px;">Libelle</th>
                <th style="text-align:left; padding: 8px;">Montant</th>
                <th style="text-align:left; padding: 8px;">Expiration</th>
                <th style="text-align:left; padding: 8px;">Etat</th>
                <th style="text-align:left; padding: 8px;">Utilisations</th>
                <th style="text-align:left; padding: 8px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($codes)) : ?>
                <tr>
                    <td colspan="6" style="padding: 12px;">Aucun code trouve.</td>
                </tr>
            <?php endif; ?>
            <?php foreach ($codes as $code) : ?>
                <?php
                $isExpired = ($code['date_expiration'] ?? '') < $today;
                $usageCount = $usageByCode[(int) $code['id_code']] ?? 0;
                ?>
                <tr>
                    <td style="padding: 8px;"><?= esc((string) $code['libelle']) ?></td>
                    <td style="padding: 8px;"><?= esc((string) $code['montant']) ?></td>
                    <td style="padding: 8px;"><?= esc((string) $code['date_expiration']) ?></td>
                    <td style="padding: 8px;"><?= $isExpired ? 'Expire' : 'Valide' ?></td>
                    <td style="padding: 8px;"><?= esc((string) $usageCount) ?></td>
                    <td style="padding: 8px;">
                        <a href="<?= base_url('back-office/codes/' . $code['id_code'] . '/edit') ?>">Modifier</a>
                        <form method="post" action="<?= base_url('back-office/codes/' . $code['id_code'] . '/delete') ?>" style="display:inline-block; margin-left: 8px;" onsubmit="return confirm('Supprimer ce code ?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="submit-btn" style="padding: 6px 10px;">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
