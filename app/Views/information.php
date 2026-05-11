<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Informations Utilisateur') ?> | HealthyDiet</title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <script src="<?= base_url('assets/information.js') ?>" defer></script>
</head>
<body class="login-page">
    <div class="login-shell">
        <section class="login-aside">
            <div>
                <p class="login-kicker kicker-light">HealthyDiet</p>
                <h2 class="login-brand">Derniere etape.</h2>
                <p class="login-copy">
                    Ces informations nous sont necessaires pour calculer votre IMC avec precision et vous proposer le programme le plus adapte.
                </p>
            </div>

            <div class="login-highlights">
                <div class="highlight">
                    <strong>Calcul d'IMC automatique</strong>
                    Base sur votre taille et votre poids.
                </div>
                <div class="highlight">
                    <strong>Confidentialite</strong>
                    Vos donnees sante restent privees et securisees.
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-form-wrap">
                <p class="login-kicker">Profil</p>
                <h1>Vos mensurations</h1>
                <p class="login-subtitle">Aidez-nous a mieux vous connaitre.</p>

                <?php $security = config('Security'); ?>
                <form action="<?= base_url('inscription/user/info/add') ?>" method="post" data-ajax="true" data-csrf-cookie="<?= esc($security->cookieName) ?>" data-csrf-header="<?= esc($security->headerName) ?>">
                    <?= csrf_field() ?>
                    
                    <div class="radio-group-wrapper">
                        <label>Genre</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="genre" value="Homme" required>
                                <span>Homme</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="genre" value="Femme" required>
                                <span>Femme</span>
                            </label>
                        </div>
                        <span class="field-error"></span>
                    </div>

                    <div>
                        <label for="taille">Taille (en metres)</label>
                        <input type="number" id="taille" name="taille" step="0.01" min="0.50" max="2.50" placeholder="ex: 1.75" required>
                        <span class="field-error"></span>
                    </div>

                    <div>
                        <label for="poids">Poids (en kg)</label>
                        <input type="number" id="poids" name="poids" step="0.1" min="20" max="300" placeholder="ex: 70.5" required>
                        <span class="field-error"></span>
                    </div>

                    <p class="form-feedback" role="alert" aria-live="polite"></p>

                    <div class="form-actions form-actions-column">
                        <button type="submit" class="submit-btn btn-full">Terminer l'inscription</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>