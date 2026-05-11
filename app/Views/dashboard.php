<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
    <h1>Tableau de bord</h1>
    <p class="dashboard-intro">Voici les statistiques principales de l'application et les tendances du suivi des objectifs.</p>

    <div class="dashboard-cards">
        <article class="dashboard-card">
            <strong><?= esc($totalUsers) ?></strong>
            <span>Utilisateurs enregistrés</span>
        </article>
        <article class="dashboard-card">
            <strong><?= esc($totalGoldUsers) ?></strong>
            <span>Abonnements Gold actifs</span>
        </article>
        <article class="dashboard-card">
            <strong><?= number_format($totalGoldAmount, 2, ',', ' ') ?> €</strong>
            <span>Montant Gold total</span>
        </article>
        <article class="dashboard-card">
            <strong><?= number_format($totalWalletRecharge, 2, ',', ' ') ?> €</strong>
            <span>Recharge porte-monnaie validée</span>
        </article>
    </div>

    <section class="dashboard-section">
        <h2>Répartition des objectifs</h2>
        <div class="objective-chart">
            <?php $labelMap = ['augmenter_poids' => 'Gain de poids', 'reduire_poids' => 'Perte de poids', 'imc_ideale' => 'IMC idéal']; ?>
            <?php foreach ($objectiveStats as $stat): ?>
                <?php $label = $labelMap[$stat['objectif']] ?? $stat['objectif']; ?>
                <div class="objective-row">
                    <span><?= esc($label) ?></span>
                    <strong><?= esc($stat['total']) ?></strong>
                    <div class="objective-bar" style="width: <?= min(100, max(5, round(($stat['total'] / max(1, $totalUsers)) * 100))) ?>%;"></div>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <section class="dashboard-section">
        <h2>Régimes par objectif</h2>
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Objectif</th>
                    <th>Nombre de régimes</th>
                    <th>Prix moyen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($regimesByObjective as $row): ?>
                    <tr>
                        <td><?= esc($row['objectif']) ?></td>
                        <td><?= esc($row['total_regimes']) ?></td>
                        <td><?= number_format($row['prix_moyen'], 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <section class="dashboard-section">
        <h2>Dernières actions</h2>
        <p>Bienvenue, <?= esc($userName) ?>. Utilisez le menu pour accéder au profil, aux objectifs, et aux régimes suggérés.</p>
    </section>
<?= $this->endSection() ?>
