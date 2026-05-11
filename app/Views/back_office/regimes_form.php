<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$isEdit = $isEdit ?? false;
$regime = $regime ?? null;
$objectifs = $objectifs ?? [];
?>
<h1><?= $isEdit ? 'Modifier le regime' : 'Nouveau regime' ?></h1>

<?php if (!empty($errors)) : ?>
    <div class="form-feedback" role="alert" style="margin-top: 12px;">
        <?= esc(implode(' | ', $errors)) ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= $isEdit && $regime ? base_url('back-office/regimes/' . $regime['id_regime']) : base_url('back-office/regimes') ?>">
    <?= csrf_field() ?>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px;">
        <div>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc(set_value('nom', $regime['nom'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="id_objectif">Objectif</label>
            <select id="id_objectif" name="id_objectif" required>
                <option value="">Selectionner</option>
                <?php foreach ($objectifs as $objectif) : ?>
                    <option value="<?= esc((string) $objectif['id_objectif']) ?>" <?= (string) set_value('id_objectif', $regime['id_objectif'] ?? '') === (string) $objectif['id_objectif'] ? 'selected' : '' ?>>
                        <?= esc((string) $objectif['libelle']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="duree_jours">Duree (jours)</label>
            <input type="number" id="duree_jours" name="duree_jours" value="<?= esc(set_value('duree_jours', $regime['duree_jours'] ?? '')) ?>" min="1" required>
        </div>
        <div>
            <label for="variation_poids">Variation poids</label>
            <input type="number" step="0.1" id="variation_poids" name="variation_poids" value="<?= esc(set_value('variation_poids', $regime['variation_poids'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="prix">Prix</label>
            <input type="number" step="0.01" id="prix" name="prix" value="<?= esc(set_value('prix', $regime['prix'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="viande">% Viande</label>
            <input type="number" step="0.1" id="viande" name="viande" value="<?= esc(set_value('viande', $regime['viande'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="poisson">% Poisson</label>
            <input type="number" step="0.1" id="poisson" name="poisson" value="<?= esc(set_value('poisson', $regime['poisson'] ?? '')) ?>" required>
        </div>
        <div>
            <label for="volaille">% Volaille</label>
            <input type="number" step="0.1" id="volaille" name="volaille" value="<?= esc(set_value('volaille', $regime['volaille'] ?? '')) ?>" required>
        </div>
    </div>

    <div style="margin-top: 12px;">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4"><?= esc(set_value('description', $regime['description'] ?? '')) ?></textarea>
    </div>

    <div class="form-actions" style="margin-top: 16px;">
        <button type="submit" class="submit-btn"><?= $isEdit ? 'Mettre a jour' : 'Creer' ?></button>
        <a href="<?= base_url('back-office/regimes') ?>" style="margin-left: 12px;">Retour</a>
    </div>
</form>
<?= $this->endSection() ?>
