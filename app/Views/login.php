<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion') ?> | HealthyDiet</title>
    <style>
        :root {
            --bg: #f4f8f2;
            --surface: rgba(255, 255, 255, 0.92);
            --primary: #2f6f3e;
            --primary-dark: #214f2c;
            --accent: #f2b84b;
            --text: #17301f;
            --muted: #667567;
            --border: #d5e2d2;
            --shadow: 0 24px 60px rgba(31, 59, 38, 0.16);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(242, 184, 75, 0.30), transparent 28%),
                radial-gradient(circle at bottom right, rgba(47, 111, 62, 0.20), transparent 30%),
                linear-gradient(135deg, #eff7e9 0%, #f8fbf5 50%, #edf4ea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-shell {
            width: min(1040px, 100%);
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: var(--shadow);
            border-radius: 28px;
            overflow: hidden;
            backdrop-filter: blur(8px);
        }

        .login-aside {
            padding: 48px;
            background: linear-gradient(160deg, #2c6a3a 0%, #204a2a 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 26px;
        }

        .login-brand {
            font-size: 2rem;
            font-weight: 700;
            margin: 0 0 14px;
        }

        .login-copy {
            margin: 0;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.84);
        }

        .login-highlights {
            display: grid;
            gap: 14px;
        }

        .highlight {
            padding: 16px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .highlight strong {
            display: block;
            margin-bottom: 6px;
        }

        .login-panel {
            padding: 48px;
            display: flex;
            align-items: center;
        }

        .login-form-wrap {
            width: 100%;
        }

        .login-kicker {
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.82rem;
        }

        h1 {
            margin: 10px 0 12px;
            font-size: 2rem;
        }

        .login-subtitle {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.6;
        }

        form {
            display: grid;
            gap: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 1rem;
            color: var(--text);
        }

        input:focus {
            outline: 2px solid rgba(47, 111, 62, 0.18);
            border-color: var(--primary);
        }

        .submit-btn {
            border: none;
            border-radius: 14px;
            padding: 15px 18px;
            background: linear-gradient(135deg, var(--accent) 0%, #e6a831 100%);
            color: #2d2208;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
        }

        .form-note {
            margin-top: 14px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        @media (max-width: 900px) {
            .login-shell {
                grid-template-columns: 1fr;
            }

            .login-aside,
            .login-panel {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
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
                <p class="login-subtitle">
                    Interface HTML uniquement pour le moment. Le controleur et le modele pourront etre relies ensuite sans changer la structure visuelle.
                </p>

                <form action="<?= base_url('login/auth') ?>" method="post">
                    <div>
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="exemple@email.com">
                    </div>

                    <div>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe">
                    </div>

                    <button type="submit" class="submit-btn">Se connecter</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
