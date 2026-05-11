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
                <p class="login-kicker kicker-light">HealthyDiet</p>
                <h2 class="login-brand">Créer votre compte</h2>
                <p class="login-copy">
                    Renseignez vos informations pour commencer.
                </p>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-form-wrap">
                <p class="login-kicker">Inscription</p>
                <h1>Nouveau compte</h1>
                <p class="login-subtitle">Remplissez le formulaire.</p>

                <?php $security = config('Security'); ?>
                <form action="<?= base_url('inscription/user/add') ?>" method="post" data-ajax="true" data-csrf-cookie="<?= esc($security->cookieName) ?>" data-csrf-header="<?= esc($security->headerName) ?>">
                    <?= csrf_field() ?>
                    <div>
                        <label for="register-name">Nom complet</label>
                        <input type="text" id="register-name" name="name" placeholder="Votre nom" autocomplete="name" required>
                        <span class="field-error"></span>
                    </div>

                    <div>
                        <label for="register-email">Adresse email</label>
                        <input type="email" id="register-email" name="email" placeholder="exemple@email.com" autocomplete="email" required>
                        <span class="field-error"></span>
                    </div>

                    <div>
                        <label for="register-password">Mot de passe</label>
                        <div class="password-wrapper">
                            <input type="password" id="register-password" name="password" placeholder="Votre mot de passe" autocomplete="new-password" required>
                            <button type="button" class="toggle-password" aria-label="Afficher le mot de passe" title="Afficher le mot de passe">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <span class="field-error"></span>
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
