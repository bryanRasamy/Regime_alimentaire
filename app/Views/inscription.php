<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Inscription') ?> | HealthyDiet</title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <script src="<?= base_url('assets/inscription.js') ?>" defer></script>
</head>
<body class="login-page">
    <div class="login-shell">
        <section class="login-aside">
            <div>
                <p class="login-kicker" style="color: rgba(255, 255, 255, 0.74);">HealthyDiet</p>
                <h2 class="login-brand">Creer votre compte.</h2>
                <p class="login-copy">
                    Renseignez vos informations pour commencer.
                </p>
            </div>

            <div class="login-highlights">
                <div class="highlight">
                    <strong>Compte personnel</strong>
                    Un acces simple a votre espace.
                </div>
                <div class="highlight">
                    <strong>Suivi rapide</strong>
                    Email, mot de passe et genre.
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-form-wrap">
                <p class="login-kicker">Inscription</p>
                <h1>Nouveau compte</h1>
                <p class="login-subtitle">Remplissez le formulaire.</p>

                <?php $security = config('Security'); ?>
                <form action="<?= base_url('inscription/store') ?>" method="post" data-ajax="true" data-csrf-cookie="<?= esc($security->cookieName) ?>" data-csrf-header="<?= esc($security->headerName) ?>">
                    <?= csrf_field() ?>
                    <div>
                        <label for="register-email">Adresse email</label>
                        <input type="email" id="register-email" name="email" placeholder="exemple@email.com" required>
                    </div>

                    <div>
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" placeholder="Votre mot de passe" required>
                    </div>

                    <div>
                        <label for="genre">Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Selectionnez</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                        </select>
                    </div>

                    <p class="form-feedback" role="alert" aria-live="polite"></p>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">S'inscrire</button>
                        <a class="secondary-btn" href="<?= base_url('/') ?>">Retour connexion</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
