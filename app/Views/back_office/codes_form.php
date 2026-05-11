<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $isEdit ?? false;
$code = $code ?? [];
$errors = $errors ?? [];
$actionUrl = $isEdit && !empty($code)
    ? base_url('back-office/codes/' . $code['id_code'])
    : base_url('back-office/codes');
?>
<div class="page-header" style="display:flex; justify-content: space-between; align-items: center; gap: 12px;">
    <div>
        <h1><?= $isEdit ? 'Modifier le code' : 'Nouveau code' ?></h1>
        <p>Renseignez les informations du code.</p>
    </div>
    <a class="submit-btn" href="<?= base_url('back-office/codes') ?>" style="text-decoration: none;">Retour</a>
</div>

<?php if (!empty($errors)) : ?>
    <div class="form-feedback" role="alert" style="margin-top: 12px;">
        <?= esc(implode(' | ', $errors)) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= $actionUrl ?>" style="margin-top: 16px; max-width: 480px;">
    <?= csrf_field() ?>
    <div style="display:grid; gap: 12px;">
        <div>
            <label for="libelle">Libelle</label>
            <input type="text" name="libelle" id="libelle" value="<?= esc((string) old('libelle', $code['libelle'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="montant">Montant (Ar)</label>
            <input type="number" step="0.01" name="montant" id="montant" value="<?= esc((string) old('montant', $code['montant'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="date_expiration">Date expiration</label>
            <input type="date" name="date_expiration" id="date_expiration" value="<?= esc((string) old('date_expiration', $code['date_expiration'] ?? '')) ?>" required>
        </div>
        <button type="submit" class="submit-btn"><?= $isEdit ? 'Mettre a jour' : 'Creer' ?></button>
    </div>
</form>
<?= $this->endSection() ?>
