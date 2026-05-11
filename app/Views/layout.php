<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'HealthyDiet') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/style.css') ?>">
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <div class="sidebar-brand">
                <h2>HealthyDiet</h2>
                <p>Votre espace bien-être pour suivre vos objectifs, votre IMC et vos régimes alimentaires.</p>
            </div>

            <nav class="sidebar-nav">
                <a class="sidebar-link active" href="<?= base_url('dashboard') ?>">Tableau de bord</a>
                <a class="sidebar-link" href="<?= base_url('regime') ?>">Mon regime</a>
                <a class="sidebar-link" href="<?= base_url('profil') ?>">Mon profil</a>
                <a class="sidebar-link" href="<?= base_url('regime/objectif') ?>">Mes objectifs</a>
            </nav>

            <div class="sidebar-note">
                Votre espace personnel.
            </div>
        </aside>

        <div class="main-panel">
            <header class="topbar">
                <div class="topbar-brand">HealthyDiet</div>

                <div class="topbar-actions">
                    <?php 
                    $userSession = session()->get('user'); 
                    $isGold = isset($userSession['option_gold']) && $userSession['option_gold'] > 0;
                    if (!$isGold && $userSession) {
                    ?>
                    <form action="<?= base_url('profil/acheter-gold') ?>" method="post" class="form-gold">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-gold">🌟 Acheter Option Gold (20 000 Ar)</button>
                    </form>
                    <?php } elseif ($isGold && $userSession) { ?>
                        <div class="badge-gold">🌟 Membre Gold</div>
                    <?php } ?>
                    <div class="profile-pill">
                        <?= esc('Profil utilisateur') ?>
                    </div>
                    <a class="logout-btn" href="<?= base_url('logout') ?>">Se déconnecter</a>
                </div>
            </header>

            <main class="page-content">
                <div class="content-card">
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
                    
                    <?= $this->renderSection('content') ?>
                </div>
            </main>

            <footer class="footer">
                HealthyDiet
            </footer>
        </div>
    </div>
</body>
</html>
