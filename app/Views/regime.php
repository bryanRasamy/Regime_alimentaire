<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="program-container">
    <div class="program-header">
        <h1 class="program-title">Votre Programme Personnalisé</h1>
        
        <?php if (!empty($infoUser)): ?>
        <div class="imc-box">
            <p class="imc-text">
                <strong>Votre IMC actuel :</strong> <?= esc($infoUser['IMC']) ?> 
                <span class="imc-details">(Poids: <?= esc($infoUser['poids']) ?> kg | Taille: <?= esc($infoUser['taille']) ?> m)</span>
            </p>
        </div>
        <?php endif; ?>

        <p class="objective-text">
            Objectif : <strong>
                <?php 
                if ($selection['objectif'] === 'augmenter_poids') echo 'Prendre du poids';
                elseif ($selection['objectif'] === 'reduire_poids') echo 'Perdre du poids';
                else echo 'Atteindre un IMC idéal';
                ?>
            </strong>
        </p>
        <p class="objective-text">
            Variation ciblée : <strong><?= esc($selection['valeur_cible']) ?> kg</strong><br>
            Objectif théorique atteint par le programme : <strong><?= esc($selection['somme_obtenue']) ?> kg</strong>
        </p>
    </div>

    <div class="program-grid">
        
        <!-- Section Régimes Alimentaires -->
        <section class="diet-section">
            <h2 class="section-title">Vos Régimes Alimentaires</h2>
            
            <?php if (!empty($regimes)): ?>
                <div class="card-grid">
                    <?php foreach ($regimes as $regime): ?>
                        <div class="regime-card">
                            <h3 class="card-title"><?= esc($regime['nom']) ?></h3>
                            <p class="card-desc"><?= esc($regime['description']) ?></p>
                            
                            <ul class="card-list">
                                <li><strong>Durée :</strong> <?= esc($regime['duree_jours']) ?> jours</li>
                                <li><strong>Variation de poids prévue :</strong> <?= esc($regime['variation_poids']) ?> kg</li>
                            </ul>
                            
                            <div class="composition-box">
                                <strong>Composition :</strong>
                                <div class="composition-details">
                                    <span>Viande: <?= esc((float)$regime['viande'] * 100) ?>%</span>
                                    <span>Poisson: <?= esc((float)$regime['poisson'] * 100) ?>%</span>
                                    <span>Volaille: <?= esc((float)$regime['volaille'] * 100) ?>%</span>
                                </div>
                            </div>
                            
                            <div class="price-tag">
                                <?= esc($regime['prix']) ?> Ar
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php 
                $prixTotal = array_sum(array_column($regimes, 'prix'));
                ?>
                <div class="total-cost-box">
                    <span class="total-cost-text">Coût total du programme alimentaire : <strong><?= number_format($prixTotal, 2, ',', ' ') ?> Ar</strong></span>
                </div>
            <?php else: ?>
                <p class="empty-state-text">Aucun régime alimentaire spécifique n'a été assigné pour le moment.</p>
            <?php endif; ?>
        </section>

        <!-- Section Activités Sportives -->
        <section class="activity-section">
            <h2 class="section-title">Vos Activités Sportives</h2>
            
            <?php if (!empty($activites)): ?>
                <div class="card-grid">
                    <?php 
                    $totalJoursSport = 0;
                    foreach ($activites as $activite): 
                        $totalJoursSport += (int)($activite['duree_jours'] ?? 0);
                    ?>
                        <div class="activity-card">
                            <h3 class="activity-title"><?= esc($activite['description']) ?></h3>
                            
                            <ul class="card-list">
                                <li><strong>Durée :</strong> <?= esc($activite['duree_jours'] ?? 0) ?> jours</li>
                                <li><strong>Variation de poids prévue :</strong> <?= esc($activite['variation_poids'] ?? 0) ?> kg</li>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-state-italic">Aucune activité sportive spécifique associée à ce programme pour l'instant.</p>
            <?php endif; ?>
        </section>

        <?php
        $totalJoursRegime = 0;
        if (!empty($regimes)) {
            $totalJoursRegime = array_sum(array_column($regimes, 'duree_jours'));
        }
        $totalJoursSport = $totalJoursSport ?? 0;
        ?>
        <div class="total-duration-box">
            <p class="total-duration-text">
                <strong>Durée totale du programme :</strong> <br><br>
                <?= $totalJoursRegime ?> jours de régimes alimentaires
                <?php if ($totalJoursSport > 0): ?>
                    <br>et <?= $totalJoursSport ?> jours d'activités sportives
                <?php endif; ?>
            </p>
        </div>

        <div class="dashboard-link-container">
            <a href="<?= base_url('regime/export/pdf') ?>" class="btn dashboard-btn" style="background: #10b981; margin-right: 15px;" target="_blank">Exporter en PDF</a>
            <a href="<?= base_url('dashboard') ?>" class="btn dashboard-btn">Allez au Tableau de Bord</a>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
