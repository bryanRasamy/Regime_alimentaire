<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$regimes = $regimes ?? [];
$objectifs = $objectifs ?? [];
$filters = $filters ?? [];
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
		<h1>Regimes</h1>
		<p>Gestion des regimes (creation, edition, suppression).</p>
	</div>
	<a class="submit-btn" href="<?= base_url('back-office/regimes/create') ?>" style="text-decoration: none;">Nouveau regime</a>
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

<form method="get" action="<?= base_url('back-office/regimes') ?>" style="margin-top: 16px;">
	<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
		<div>
			<label for="id_objectif">Objectif</label>
			<select name="id_objectif" id="id_objectif">
				<option value="">Tous</option>
				<?php foreach ($objectifs as $objectif) : ?>
					<option value="<?= esc((string) $objectif['id_objectif']) ?>" <?= (string) ($filters['id_objectif'] ?? '') === (string) $objectif['id_objectif'] ? 'selected' : '' ?>>
						<?= esc((string) $objectif['libelle']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
		<div>
			<label for="variation_min">Variation min</label>
			<input type="number" step="0.1" name="variation_min" id="variation_min" value="<?= esc((string) ($filters['variation_min'] ?? '')) ?>">
		</div>
		<div>
			<label for="variation_max">Variation max</label>
			<input type="number" step="0.1" name="variation_max" id="variation_max" value="<?= esc((string) ($filters['variation_max'] ?? '')) ?>">
		</div>
		<div>
			<label for="prix_min">Prix min</label>
			<input type="number" step="0.1" name="prix_min" id="prix_min" value="<?= esc((string) ($filters['prix_min'] ?? '')) ?>">
		</div>
		<div>
			<label for="prix_max">Prix max</label>
			<input type="number" step="0.1" name="prix_max" id="prix_max" value="<?= esc((string) ($filters['prix_max'] ?? '')) ?>">
		</div>
		<div>
			<label for="duree_min">Duree min (jours)</label>
			<input type="number" name="duree_min" id="duree_min" value="<?= esc((string) ($filters['duree_min'] ?? '')) ?>">
		</div>
		<div>
			<label for="duree_max">Duree max (jours)</label>
			<input type="number" name="duree_max" id="duree_max" value="<?= esc((string) ($filters['duree_max'] ?? '')) ?>">
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
				<th style="text-align:left; padding: 8px;">Nom</th>
				<th style="text-align:left; padding: 8px;">Objectif</th>
				<th style="text-align:left; padding: 8px;">Duree</th>
				<th style="text-align:left; padding: 8px;">Variation</th>
				<th style="text-align:left; padding: 8px;">Prix</th>
				<th style="text-align:left; padding: 8px;">Tarif</th>
				<th style="text-align:left; padding: 8px;">Viande/Poisson/Volaille</th>
				<th style="text-align:left; padding: 8px;">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($regimes)) : ?>
				<tr>
					<td colspan="8" style="padding: 12px;">Aucun regime trouve.</td>
				</tr>
			<?php endif; ?>
			<?php foreach ($regimes as $regime) : ?>
				<?php
					$duree = (int) ($regime['duree_jours'] ?? 0);
					$variation = (float) ($regime['variation_poids'] ?? 0);
					$variationParSemaine = $duree > 0 ? $variation / ($duree / 7) : null;
					$prixBase = (float) ($regime['prix'] ?? 0);
					$prixCalcule = (float) ($regime['prix_calcule'] ?? $prixBase);
				?>
				<tr>
					<td style="padding: 8px;"><?= esc((string) $regime['nom']) ?></td>
					<td style="padding: 8px;"><?= esc((string) ($regime['objectif_libelle'] ?? '-')) ?></td>
					<td style="padding: 8px;"><?= esc((string) $regime['duree_jours']) ?> j</td>
					<td style="padding: 8px;">
						<?= esc((string) $regime['variation_poids']) ?>
						<?php if ($variationParSemaine !== null) : ?>
							<br><small><?= esc(number_format($variationParSemaine, 2, '.', '')) ?> / sem</small>
						<?php endif; ?>
					</td>
					<td style="padding: 8px;">
						<?= esc(number_format($prixBase, 2, '.', '')) ?>
						<?php if ($prixCalcule !== $prixBase) : ?>
							<br><small><?= esc(number_format($prixCalcule, 2, '.', '')) ?></small>
						<?php endif; ?>
					</td>
					<td style="padding: 8px;">
						<?= esc((string) ($regime['tarif_libelle'] ?? 'Standard')) ?>
						<br><small>x<?= esc(number_format((float) ($regime['tarif_coefficient'] ?? 1.0), 2, '.', '')) ?></small>
					</td>
					<td style="padding: 8px;">
						<?= esc((string) $regime['viande']) ?> / <?= esc((string) $regime['poisson']) ?> / <?= esc((string) $regime['volaille']) ?>
					</td>
					<td style="padding: 8px;">
						<a href="<?= base_url('back-office/regimes/' . $regime['id_regime'] . '/edit') ?>">Modifier</a>
						<form method="post" action="<?= base_url('back-office/regimes/' . $regime['id_regime'] . '/delete') ?>" style="display:inline-block; margin-left: 8px;" onsubmit="return confirm('Supprimer ce regime ?');">
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
