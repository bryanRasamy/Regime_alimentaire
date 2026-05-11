<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="program-container">
    <div class="program-header">
        <h1 class="program-title">Mon Profil</h1>
        <p class="objective-text">Gérez vos informations et votre porte-monnaie.</p>
    </div>

    <?php if (session()->getFlashdata('success')) { ?>
        <div class="alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php } ?>

    <?php if (session()->getFlashdata('error')) { ?>
        <div class="alert-error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php } ?>

    <div class="program-grid profile-grid">
        
        <!-- Section Informations -->
        <section class="diet-section">
            <h2 class="section-title">Mes Informations</h2>
            <div class="regime-card">
                <ul class="card-list profile-list">
                    <li><strong>Nom :</strong> <?= esc($userData['nom']) ?></li>
                    <li><strong>Email :</strong> <?= esc($userData['email']) ?></li>
                    <li class="profile-list-item-mt">
                        <strong>Solde de votre porte-monnaie :</strong><br>
                        <span class="price-tag profile-price-tag">
                            <?= number_format($userData['porte_monnaie'], 2, ',', ' ') ?> Ar
                        </span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Section Porte monnaie -->
        <section class="activity-section">
            <h2 class="section-title">Recharger mon compte</h2>
            <div class="activity-card wallet-card">
                <h3 class="activity-title wallet-title">Code de recharge</h3>
                <p class="card-desc">Entrez votre code pour ajouter des fonds à votre porte-monnaie.</p>
                
                <form action="<?= base_url('profil/recharger') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-input-group">
                        <input type="text" name="code" placeholder="Ex: CODE123..." required
                               class="form-input-code">
                    </div>
                    <button type="submit" class="btn dashboard-btn btn-wallet">
                        Valider le code
                    </button>
                </form>
            </div>
        </section>

    </div>
</div>
<?= $this->endSection() ?>
