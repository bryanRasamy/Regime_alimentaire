<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'HealthyDiet') ?></title>
    <style>
        :root {
            --bg: #f4f8f2;
            --surface: #ffffff;
            --surface-soft: #eef6e7;
            --primary: #2f6f3e;
            --primary-dark: #214f2c;
            --accent: #f2b84b;
            --text: #17301f;
            --muted: #6b7b6f;
            --border: #d6e2d4;
            --danger: #b43f3f;
            --shadow: 0 18px 40px rgba(31, 59, 38, 0.10);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #eef6e7 0%, #f9fbf7 45%, #f1f5ec 100%);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 270px 1fr;
        }

        .sidebar {
            background: linear-gradient(180deg, #295e36 0%, #1f4729 100%);
            color: #fff;
            padding: 32px 22px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .sidebar-brand h2 {
            margin: 0 0 8px;
            font-size: 1.7rem;
        }

        .sidebar-brand p {
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            line-height: 1.5;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar-link {
            padding: 14px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.18);
            transform: translateX(3px);
        }

        .sidebar-note {
            margin-top: auto;
            padding: 18px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.10);
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
        }

        .main-panel {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-pill {
            padding: 10px 16px;
            border-radius: 999px;
            background: var(--surface-soft);
            border: 1px solid var(--border);
            color: var(--primary-dark);
            font-weight: 600;
        }

        .logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 999px;
            background: #fff4f4;
            color: var(--danger);
            border: 1px solid #efcaca;
            font-weight: 600;
        }

        .page-content {
            padding: 28px;
        }

        .content-card {
            background: var(--surface);
            border: 1px solid rgba(214, 226, 212, 0.9);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 28px;
        }

        .footer {
            margin-top: auto;
            padding: 18px 28px 26px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 960px) {
            .app-shell {
                grid-template-columns: 1fr;
            }

            .sidebar {
                padding: 24px 18px;
            }

            .topbar,
            .page-content,
            .footer {
                padding-left: 18px;
                padding-right: 18px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .topbar-actions {
                width: 100%;
                flex-wrap: wrap;
            }
        }
    </style>
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
                <a class="sidebar-link" href="#">Mes objectifs</a>
                <a class="sidebar-link" href="#">Régimes suggérés</a>
                <a class="sidebar-link" href="#">Activités sportives</a>
                <a class="sidebar-link" href="#">Porte-monnaie</a>
            </nav>

            <div class="sidebar-note">
                Version interface après connexion. Les liens peuvent déjà être affichés même si leur logique sera branchée plus tard.
            </div>
        </aside>

        <div class="main-panel">
            <header class="topbar">
                <div class="topbar-brand">HealthyDiet</div>

                <div class="topbar-actions">
                    <div class="profile-pill">
                        <?= esc($userName ?? 'Profil utilisateur') ?>
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
                HealthyDiet - Plateforme de gestion de regime alimentaire et de suivi des objectifs de sante.
            </footer>
        </div>
    </div>
</body>
</html>
