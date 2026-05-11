<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $isEdit ?? false;
$activite = $activite ?? null;
$sports = $sports ?? [];
$objectifs = $objectifs ?? [];
$niveaux = $niveaux ?? [];
?>
<h1><?= $isEdit ? 'Modifier l activite' : 'Nouvelle activite' ?></h1>

<?php if (!empty($errors)) : ?>
    <div class="form-feedback" role="alert" style="margin-top: 12px;">
        <?= esc(implode(' | ', $errors)) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= $isEdit && $activite ? base_url('back-office/activites/' . $activite['id_activite']) : base_url('back-office/activites') ?>">
    <?= csrf_field() ?>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
        <div>
            <label for="id_sport">Sport</label>
            <select id="id_sport" name="id_sport" required>
                <option value="">Selectionner</option>
                <?php foreach ($sports as $sport) : ?>
                    <option value="<?= esc((string) $sport['id_sport']) ?>" <?= (string) set_value('id_sport', $activite['id_sport'] ?? '') === (string) $sport['id_sport'] ? 'selected' : '' ?>>
                        <?= esc((string) $sport['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_objectif">Objectif</label>
            <select id="id_objectif" name="id_objectif" required>
                <option value="">Selectionner</option>
                <?php foreach ($objectifs as $objectif) : ?>
                    <option value="<?= esc((string) $objectif['id_objectif']) ?>" <?= (string) set_value('id_objectif', $activite['id_objectif'] ?? '') === (string) $objectif['id_objectif'] ? 'selected' : '' ?>>
                        <?= esc((string) $objectif['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="id_niveau">Niveau</label>
            <select id="id_niveau" name="id_niveau" required>
                <option value="">Selectionner</option>
                <?php foreach ($niveaux as $niveau) : ?>
                    <option value="<?= esc((string) $niveau['id_niveau']) ?>" <?= (string) set_value('id_niveau', $activite['id_niveau'] ?? '') === (string) $niveau['id_niveau'] ? 'selected' : '' ?>>
                        <?= esc((string) $niveau['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="duree_jours">Duree (jours)</label>
            <input type="number" id="duree_jours" name="duree_jours" value="<?= esc(set_value('duree_jours', $activite['duree_jours'] ?? '')) ?>" min="1" required>
        </div>
        <div>
            <label for="variation_poids">Variation poids</label>
            <input type="number" step="0.1" id="variation_poids" name="variation_poids" value="<?= esc(set_value('variation_poids', $activite['variation_poids'] ?? '')) ?>" required>
        </div>
    </div>

    <div style="margin-top: 12px;">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?= esc(set_value('description', $activite['description'] ?? '')) ?></textarea>
    </div>

    <div class="form-actions" style="margin-top: 16px;">
        <button type="submit" class="submit-btn"><?= $isEdit ? 'Mettre a jour' : 'Creer' ?></button>
        <a href="<?= base_url('back-office/activites') ?>" style="margin-left: 12px;">Retour</a>
    </div>
</form>
<?= $this->endSection() ?>
