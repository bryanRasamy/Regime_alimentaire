<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$activites = $activites ?? [];
$sports = $sports ?? [];
$objectifs = $objectifs ?? [];
$niveaux = $niveaux ?? [];
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
		<h1>Activites sportives</h1>
		<p>Gestion des activites (creation, edition, suppression).</p>
	</div>
	<a class="submit-btn" href="<?= base_url('back-office/activites/create') ?>" style="text-decoration: none;">Nouvelle activite</a>
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

<form method="get" action="<?= base_url('back-office/activites') ?>" style="margin-top: 16px;">
	<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
		<div>
			<label for="id_sport">Sport</label>
			<select name="id_sport" id="id_sport">
				<option value="">Tous</option>
				<?php foreach ($sports as $sport) : ?>
					<option value="<?= esc((string) $sport['id_sport']) ?>" <?= (string) ($filters['id_sport'] ?? '') === (string) $sport['id_sport'] ? 'selected' : '' ?>>
						<?= esc((string) $sport['libelle']) ?>
					</option>
				<?php endforeach; ?>
			</select>
		</div>
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
			<label for="id_niveau">Niveau</label>
			<select name="id_niveau" id="id_niveau">
				<option value="">Tous</option>
				<?php foreach ($niveaux as $niveau) : ?>
					<option value="<?= esc((string) $niveau['id_niveau']) ?>" <?= (string) ($filters['id_niveau'] ?? '') === (string) $niveau['id_niveau'] ? 'selected' : '' ?>>
						<?= esc((string) $niveau['libelle']) ?>
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
		<div style="align-self: end;">
			<button type="submit" class="submit-btn" style="width: 100%;">Filtrer</button>
		</div>
	</div>
</form>

<div style="margin-top: 20px; overflow-x: auto;">
	<table style="width: 100%; border-collapse: collapse;">
		<thead>
			<tr>
				<th style="text-align:left; padding: 8px;">Sport</th>
				<th style="text-align:left; padding: 8px;">Objectif</th>
				<th style="text-align:left; padding: 8px;">Niveau</th>
				<th style="text-align:left; padding: 8px;">Duree</th>
				<th style="text-align:left; padding: 8px;">Variation</th>
				<th style="text-align:left; padding: 8px;">Description</th>
				<th style="text-align:left; padding: 8px;">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($activites)) : ?>
				<tr>
					<td colspan="7" style="padding: 12px;">Aucune activite trouvee.</td>
				</tr>
			<?php endif; ?>
			<?php foreach ($activites as $activite) : ?>
				<tr>
					<td style="padding: 8px;"><?= esc((string) ($activite['sport_libelle'] ?? '-')) ?></td>
					<td style="padding: 8px;"><?= esc((string) ($activite['objectif_libelle'] ?? '-')) ?></td>
					<td style="padding: 8px;"><?= esc((string) ($activite['niveau_libelle'] ?? '-')) ?></td>
					<td style="padding: 8px;"><?= esc((string) ($activite['duree_jours'] ?? '-')) ?> j</td>
					<td style="padding: 8px;"><?= esc((string) $activite['variation_poids']) ?></td>
					<td style="padding: 8px;"><?= esc((string) $activite['description']) ?></td>
					<td style="padding: 8px;">
						<a href="<?= base_url('back-office/activites/' . $activite['id_activite'] . '/edit') ?>">Modifier</a>
						<form method="post" action="<?= base_url('back-office/activites/' . $activite['id_activite'] . '/delete') ?>" style="display:inline-block; margin-left: 8px;" onsubmit="return confirm('Supprimer cette activite ?');">
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
