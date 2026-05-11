<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'HealthyDiet') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
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
                <a class="sidebar-link" href="#">Mon profil</a>
                <a class="sidebar-link" href="<?= base_url('regime/objectif') ?>">Mes objectifs</a>
                <a class="sidebar-link" href="#">Régimes suggérés</a>
                <a class="sidebar-link" href="#">Porte-monnaie</a>
            </nav>

            <div class="sidebar-note">
                Votre espace personnel.
            </div>
        </aside>

        <div class="main-panel">
            <header class="topbar">
                <div class="topbar-brand">HealthyDiet</div>

                <div class="topbar-actions">
                    <div class="profile-pill">
                        <?= esc('Profil utilisateur') ?>
                    </div>
                    <a class="logout-btn" href="<?= base_url('logout') ?>">Se déconnecter</a>
                </div>
            </header>

            <main class="page-content">
                <div class="content-card">
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
