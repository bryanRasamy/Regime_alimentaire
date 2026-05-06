<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion') ?> | HealthyDiet</title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
</head>
<body class="login-page">
    <div class="login-shell">
        <section class="login-aside">
            <div>
                <p class="login-kicker" style="color: rgba(255, 255, 255, 0.74);">HealthyDiet</p>
                <h2 class="login-brand">Votre regime commence avec un bon suivi.</h2>
                <p class="login-copy">
                    Connectez-vous pour acceder a votre espace personnel, calculer votre IMC et recevoir des suggestions de regimes selon vos objectifs.
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

                <form action="<?= base_url('login/authentifier') ?>" method="post">
                    <div>
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.com" required>
                    </div>

                    <div>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Se connecter</button>
                        <a class="secondary-btn" href="<?= base_url('register') ?>">S'inscrire</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
