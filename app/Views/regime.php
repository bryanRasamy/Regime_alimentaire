<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="program-container">
    <div class="program-header" style="margin-bottom: 30px;">
        <h1 style="font-size: 2rem; color: #1c2b36; margin-bottom: 10px;">Votre Programme Personnalisé</h1>
        
        <?php if (!empty($infoUser)): ?>
        <div style="background: #e0f2fe; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px; display: inline-block;">
            <p style="color: #0369a1; font-size: 1.05rem; margin: 0;">
                <strong>Votre IMC actuel :</strong> <?= esc($infoUser['IMC']) ?> 
                <span style="font-size: 0.9rem; color: #0284c7;">(Poids: <?= esc($infoUser['poids']) ?> kg | Taille: <?= esc($infoUser['taille']) ?> m)</span>
            </p>
        </div>
        <?php endif; ?>

        <p style="color: #64748b; font-size: 1.1rem;">
            Objectif : <strong>
                <?php 
                if ($selection['objectif'] === 'augmenter_poids') echo 'Prendre du poids';
                elseif ($selection['objectif'] === 'reduire_poids') echo 'Perdre du poids';
                else echo 'Atteindre un IMC idéal';
                ?>
            </strong>
        </p>
        <p style="color: #64748b; font-size: 1.1rem;">
            Variation ciblée : <strong><?= esc($selection['valeur_cible']) ?> kg</strong><br>
            Objectif théorique atteint par le programme : <strong><?= esc($selection['somme_obtenue']) ?> kg</strong>
        </p>
    </div>

    <div class="program-grid" style="display: grid; grid-template-columns: 1fr; gap: 30px;">
        
        <!-- Section Régimes Alimentaires -->
        <section class="diet-section">
            <h2 style="font-size: 1.5rem; color: #1c2b36; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Vos Régimes Alimentaires</h2>
            
            <?php if (!empty($regimes)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    <?php foreach ($regimes as $regime): ?>
                        <div class="card" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                            <h3 style="color: #3b82f6; margin-bottom: 10px; font-size: 1.2rem;"><?= esc($regime['nom']) ?></h3>
                            <p style="font-size: 0.95rem; color: #475569; margin-bottom: 15px;"><?= esc($regime['description']) ?></p>
                            
                            <ul style="list-style: none; padding: 0; margin-bottom: 15px; font-size: 0.9rem; color: #334155;">
                                <li style="margin-bottom: 5px;"><strong>Durée :</strong> <?= esc($regime['duree_jours']) ?> jours</li>
                                <li style="margin-bottom: 5px;"><strong>Variation de poids prévue :</strong> <?= esc($regime['variation_poids']) ?> kg</li>
                            </ul>
                            
                            <div style="background: #f8fafc; padding: 10px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 15px;">
                                <strong>Composition :</strong>
                                <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                    <span>Viande: <?= esc((float)$regime['viande'] * 100) ?>%</span>
                                    <span>Poisson: <?= esc((float)$regime['poisson'] * 100) ?>%</span>
                                    <span>Volaille: <?= esc((float)$regime['volaille'] * 100) ?>%</span>
                                </div>
                            </div>
                            
                            <div style="font-weight: 600; color: #10b981; font-size: 1.1rem;">
                                <?= esc($regime['prix']) ?> Ar
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php 
                $prixTotal = array_sum(array_column($regimes, 'prix'));
                ?>
                <div style="margin-top: 20px; padding: 15px; background: #e0f2fe; border-radius: 8px; text-align: right;">
                    <span style="font-size: 1.1rem; color: #0369a1;">Coût total du programme alimentaire : <strong><?= number_format($prixTotal, 2, ',', ' ') ?> Ar</strong></span>
                </div>
            <?php else: ?>
                <p style="color: #64748b;">Aucun régime alimentaire spécifique n'a été assigné pour le moment.</p>
            <?php endif; ?>
        </section>

        <!-- Section Activités Sportives -->
        <section class="activity-section">
            <h2 style="font-size: 1.5rem; color: #1c2b36; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Vos Activités Sportives</h2>
            
            <?php if (!empty($activites)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    <?php 
                    $totalJoursSport = 0;
                    foreach ($activites as $activite): 
                        $totalJoursSport += (int)($activite['duree_jours'] ?? 0);
                    ?>
                        <div class="card" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border-left: 4px solid #f59e0b;">
                            <h3 style="color: #f59e0b; margin-bottom: 10px; font-size: 1.2rem;"><?= esc($activite['description']) ?></h3>
                            
                            <ul style="list-style: none; padding: 0; font-size: 0.9rem; color: #334155;">
                                <li style="margin-bottom: 5px;"><strong>Durée :</strong> <?= esc($activite['duree_jours']) ?> jours</li>
                                <li style="margin-bottom: 5px;"><strong>Variation de poids prévue :</strong> <?= esc($activite['variation_poids']) ?> kg</li>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="color: #64748b; font-style: italic; background: #f8fafc; padding: 15px; border-radius: 8px;">Aucune activité sportive spécifique associée à ce programme pour l'instant.</p>
            <?php endif; ?>
        </section>

        <?php
        $totalJoursRegime = 0;
        if (!empty($regimes)) {
            $totalJoursRegime = array_sum(array_column($regimes, 'duree_jours'));
        }
        $totalJoursSport = $totalJoursSport ?? 0;
        ?>
        <div style="margin-top: 20px; padding: 20px; background: #f0fdf4; border-radius: 8px; text-align: center; border: 1px solid #bbf7d0;">
            <p style="font-size: 1.2rem; color: #166534; margin: 0;">
                <strong>Durée totale du programme :</strong> <br><br>
                <?= $totalJoursRegime ?> jours de régimes alimentaires
                <?php if ($totalJoursSport > 0): ?>
                    <br>et <?= $totalJoursSport ?> jours d'activités sportives
                <?php endif; ?>
            </p>
        </div>

        <div style="margin-top: 10px; text-align: center;">
            <a href="<?= base_url('dashboard') ?>" class="btn" style="padding: 10px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-weight: 500; transition: background 0.2s;">Allez au Tableau de Bord</a>
        </div>

    </div>
</div>
<?= $this->endSection() ?>
