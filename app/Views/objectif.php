<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Objectif') ?> | HealthyDiet</title>
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <script src="<?= base_url('assets/objectif.js') ?>" defer></script>
</head>
<body class="login-page">
    <div class="login-shell">
        <section class="login-aside">
            <div>
                <p class="login-kicker kicker-light">HealthyDiet</p>
                <h2 class="login-brand">Definissez votre objectif.</h2>
                <p class="login-copy">
                    Choisissez ce que vous voulez atteindre pour que nous puissions adapter votre programme.
                </p>
            </div>

            <div class="login-highlights">
                <div class="highlight">
                    <strong>Suivi personnalise</strong>
                    Des recommandations adaptees a votre but.
                </div>
                <div class="highlight">
                    <strong>Progression claire</strong>
                    Un objectif chiffré pour mieux suivre vos resultats.
                </div>
            </div>
        </section>

        <section class="login-panel">
            <div class="login-form-wrap">
                <p class="login-kicker">Objectif</p>
                <h1>Votre but principal</h1>
                <p class="login-subtitle">Selectionnez une option puis indiquez votre objectif chiffre.</p>

                <?php $security = config('Security'); ?>
                <form action="<?= base_url('regime/objectif/add') ?>" method="post" data-ajax="true" data-csrf-cookie="<?= esc($security->cookieName) ?>" data-csrf-header="<?= esc($security->headerName) ?>">
                    <?= csrf_field() ?>

                    <div class="radio-group-wrapper">
                        <label>Choisissez un objectif</label>
                        <div class="radio-group radio-group-vertical">
                            <label class="radio-label">
                                <input type="radio" name="objectif" value="augmenter_poids" required>
                                <span>Augmenter son poids</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="objectif" value="reduire_poids" required>
                                <span>Reduire son poids</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="objectif" value="imc_ideale" required>
                                <span>Atteindre son IMC ideale</span>
                            </label>
                        </div>
                        <span class="field-error"></span>
                    </div>

                    <div id="objectif-value-wrapper" class="objective-value-wrapper" hidden>
                        <label for="objectif_value" id="objectif-value-label">Valeur cible</label>
                        <input type="number" id="objectif_value" name="objectif_value" step="0.1" min="0" placeholder="Entrez un nombre" autocomplete="off">
                        <span class="field-error"></span>
                    </div>

                    <p class="form-feedback" role="alert" aria-live="polite"></p>

                    <div class="form-actions form-actions-column">
                        <button type="submit" class="submit-btn btn-full">Continuer</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>
</html>