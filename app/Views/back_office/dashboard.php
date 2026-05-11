<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$stats = $stats ?? [];
$objectifStats = $objectifStats ?? [];
$selectionStats = $selectionStats ?? [];
?>
<div class="page-header" style="display:flex; justify-content: space-between; align-items: center; gap: 12px;">
    <div>
        <h1>Dashboard</h1>
        <p>Vue d ensemble des activites du back office.</p>
    </div>
    <div style="display:flex; gap: 10px;">
        <a class="submit-btn" href="<?= base_url('back-office/dashboard/export/csv') ?>" style="text-decoration: none;">Export CSV</a>
        <a class="submit-btn" href="<?= base_url('back-office/dashboard/export/pdf') ?>" style="text-decoration: none;">Export PDF</a>
    </div>
</div>

<div style="margin-top: 20px; display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px;">
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Utilisateurs</div>
        <strong><?= esc((string) ($stats['users'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Admins</div>
        <strong><?= esc((string) ($stats['admins'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Regimes</div>
        <strong><?= esc((string) ($stats['regimes'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Activites</div>
        <strong><?= esc((string) ($stats['activites'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Programmes</div>
        <strong><?= esc((string) ($stats['programmes'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Codes utilises</div>
        <strong><?= esc((string) ($stats['codes_utilises'] ?? 0)) ?></strong>
    </div>
    <div style="border: 1px solid #e2e8f0; padding: 12px; border-radius: 10px;">
        <div>Montant codes</div>
        <strong><?= esc(number_format((float) ($stats['montant_codes'] ?? 0), 2, ',', ' ')) ?> Ar</strong>
    </div>
</div>

<section style="margin-top: 24px;">
    <h2>Repartition par objectif</h2>
    <div style="margin-top: 12px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding: 8px;">Objectif</th>
                    <th style="text-align:left; padding: 8px;">Regimes</th>
                    <th style="text-align:left; padding: 8px;">Activites</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($objectifStats)) : ?>
                    <tr>
                        <td colspan="3" style="padding: 12px;">Aucune donnee.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($objectifStats as $row) : ?>
                    <tr>
                        <td style="padding: 8px;"><?= esc((string) $row['libelle']) ?></td>
                        <td style="padding: 8px;"><?= esc((string) $row['regimes_count']) ?></td>
                        <td style="padding: 8px;"><?= esc((string) $row['activites_count']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<section style="margin-top: 24px;">
    <h2>Selections par objectif</h2>
    <div style="margin-top: 12px; overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align:left; padding: 8px;">Objectif</th>
                    <th style="text-align:left; padding: 8px;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($selectionStats)) : ?>
                    <tr>
                        <td colspan="2" style="padding: 12px;">Aucune donnee.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($selectionStats as $row) : ?>
                    <tr>
                        <td style="padding: 8px;"><?= esc((string) $row['objectif']) ?></td>
                        <td style="padding: 8px;"><?= esc((string) $row['total']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?= $this->endSection() ?>
