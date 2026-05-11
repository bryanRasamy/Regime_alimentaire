<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion') ?> | HealthyDiet</title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <script src="<?= base_url('assets/login.js') ?>" defer></script>
</head>
<body class="login-page">
    <div class="login-shell">
        <section class="login-aside">
            <div>
                <p class="login-kicker kicker-light">HealthyDiet</p>
                <h2 class="login-brand">Votre regime commence avec un bon suivi.</h2>
                <p class="login-copy">
                    Connectez-vous pour acceder a votre espace personnel et recevoir des suggestions de regimes selon vos objectifs.
                </p>
            </div>

            <div class="login-highlights">
                <div class="highlight">
                    <strong>Objectifs personnalises</strong>
                    Prise de poids, perte de poids ou atteinte de l'IMC ideal.
                </div>
                <div class="highlight">
                    <strong>Suivi sante</strong>
                    Taille, poids et informations essentielles regroupes au meme endroit.
                </div>
                <div class="highlight">
                    <strong>Regimes et activites</strong>
                    Suggestions de programmes adaptes a la duree choisie.
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-form-wrap">
                <p class="login-kicker">Connexion</p>
                <h1>Bienvenue</h1>
                <p class="login-subtitle">Accedez a votre espace.</p>

                <?php $security = config('Security'); ?>
                <form action="<?= base_url('login/authentifier') ?>" method="post" data-ajax="true" data-csrf-cookie="<?= esc($security->cookieName) ?>" data-csrf-header="<?= esc($security->headerName) ?>">
                    <?= csrf_field() ?>
                    <div>
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.com" required>
                    </div>

                    <div>
                        <label for="password">Mot de passe</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                            <button type="button" class="toggle-password" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <p class="form-feedback" role="alert" aria-live="polite"></p>

                    <div class="form-actions form-actions-column">
                        <button type="submit" class="submit-btn btn-full">Se connecter</button>
                    </div>
                    
                    <div class="auth-link">
                        <p>Vous n'avez pas encore de compte ? <a href="<?= base_url('inscription') ?>">S'inscrire</a></p>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
