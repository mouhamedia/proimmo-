<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription — ImmoApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #F8F7F5;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            background: #1A1A2E;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 400px; height: 400px;
            background: #C9A96E;
            opacity: 0.06;
            border-radius: 50%;
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -60px;
            width: 280px; height: 280px;
            background: #C9A96E;
            opacity: 0.04;
            border-radius: 50%;
            pointer-events: none;
        }

        .panel-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
            text-decoration: none;
        }

        .logo-mark {
            width: 42px; height: 42px;
            background: #C9A96E;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-mark svg { color: #1A1A2E; }

        .logo-name {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .panel-content {
            position: relative;
            z-index: 1;
        }

        .panel-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C9A96E;
            margin-bottom: 20px;
        }

        .panel-title {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 600;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .panel-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.45);
            line-height: 1.7;
            max-width: 340px;
            margin-bottom: 40px;
        }

        /* Benefits list */
        .benefits {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .benefit-icon {
            width: 24px; height: 24px;
            background: rgba(201,169,110,0.15);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .benefit-icon svg { color: #C9A96E; }

        .benefit-text {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            line-height: 1.5;
        }

        .benefit-text strong {
            color: rgba(255,255,255,0.85);
            font-weight: 500;
            display: block;
            margin-bottom: 1px;
        }

        .panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            position: relative;
            z-index: 1;
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 64px;
            overflow-y: auto;
        }

        .form-header { margin-bottom: 32px; }

        .form-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(201,169,110,0.1);
            border: 1px solid rgba(201,169,110,0.2);
            color: #C9A96E;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 2px;
            margin-bottom: 16px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 600;
            color: #1A1A2E;
            margin-bottom: 6px;
        }

        .form-sub {
            font-size: 14px;
            color: #8B8FA8;
        }

        /* Fields */
        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #6B7280;
            margin-bottom: 8px;
        }

        .field input {
            width: 100%;
            height: 48px;
            background: #fff;
            border: 1.5px solid #E5E3DF;
            border-radius: 8px;
            padding: 0 16px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1A1A2E;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .field input:focus {
            border-color: #C9A96E;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
        }

        .field input::placeholder { color: #C4C0BB; }

        /* Password strength */
        .pwd-strength {
            margin-top: 8px;
            display: flex;
            gap: 4px;
        }

        .pwd-bar {
            flex: 1;
            height: 3px;
            background: #E5E3DF;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .pwd-label {
            font-size: 11px;
            color: #8B8FA8;
            margin-top: 4px;
        }

        /* Two-col grid */
        .field-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Role select hint */
        .field select {
            width: 100%;
            height: 48px;
            background: #fff;
            border: 1.5px solid #E5E3DF;
            border-radius: 8px;
            padding: 0 16px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1A1A2E;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 7L11 1' stroke='%238B8FA8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            transition: border-color 0.2s;
            cursor: pointer;
        }

        .field select:focus {
            border-color: #C9A96E;
            box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
        }

        /* Error */
        .error-block {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }

        .error-block li {
            color: #DC2626;
            font-size: 13px;
            list-style: none;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .error-block li::before {
            content: '✕';
            flex-shrink: 0;
            font-size: 10px;
            margin-top: 2px;
        }

        /* Terms */
        .terms-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .terms-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #C9A96E;
            cursor: pointer;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .terms-row label {
            font-size: 12px;
            color: #8B8FA8;
            line-height: 1.5;
            cursor: pointer;
        }

        .terms-row a {
            color: #C9A96E;
            text-decoration: none;
            font-weight: 500;
        }

        .terms-row a:hover { text-decoration: underline; }

        /* Submit */
        .btn-submit {
            width: 100%;
            height: 48px;
            background: #1A1A2E;
            color: #C9A96E;
            border: 1px solid #C9A96E;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #C9A96E;
            color: #1A1A2E;
        }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #C4C0BB;
            font-size: 12px;
        }

        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E3DF;
        }

        .form-footer {
            text-align: center;
            font-size: 13px;
            color: #8B8FA8;
        }

        .form-footer a {
            color: #C9A96E;
            font-weight: 600;
            text-decoration: none;
        }

        .form-footer a:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 820px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 40px 24px; }
            .field-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ══ LEFT PANEL ══ -->
    <div class="left-panel">
        <a href="/" class="panel-logo">
            <div class="logo-mark">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                        points="9,22 9,12 15,12 15,22"/>
                </svg>
            </div>
            <span class="logo-name">ImmoApp</span>
        </a>

        <div class="panel-content">
            <div class="panel-eyebrow">Rejoignez ImmoApp</div>
            <h2 class="panel-title">Commencez<br>gratuitement.</h2>
            <p class="panel-desc">
                Créez votre compte en 2 minutes et commencez à gérer vos immeubles intelligemment.
            </p>

            <ul class="benefits">
                <li class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Aucune carte bancaire requise</strong>
                        Commencez avec le plan gratuit sans engagement
                    </div>
                </li>
                <li class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Configuration en 2 minutes</strong>
                        Ajoutez votre premier immeuble immédiatement
                    </div>
                </li>
                <li class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Données 100% sécurisées</strong>
                        Chiffrement SSL et sauvegardes automatiques
                    </div>
                </li>
                <li class="benefit-item">
                    <div class="benefit-icon">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="benefit-text">
                        <strong>Support Wave & Orange Money</strong>
                        Paiements locaux intégrés nativement
                    </div>
                </li>
            </ul>
        </div>

        <div class="panel-footer">
            © {{ date('Y') }} ImmoApp — Made with ❤️ in Sénégal
        </div>
    </div>

    <!-- ══ RIGHT PANEL (form) ══ -->
    <div class="right-panel">
        <div style="max-width: 440px; width: 100%; margin: 0 auto;">

            <div class="form-header">
                <div class="form-tag">Compte gratuit</div>
                <h1 class="form-title">Créer un compte</h1>
                <p class="form-sub">Remplissez les informations ci-dessous pour démarrer.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" autocomplete="off" novalidate>
                @csrf

                <div class="field">
                    <label for="name">Nom complet</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Amadou Diallo"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="vous@exemple.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                <div class="field-grid">
                    <div class="field" style="margin-bottom:0">
                        <label for="password">Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="8 caractères min."
                            required
                            oninput="checkStrength(this.value)"
                        >
                        <div class="pwd-strength">
                            <div class="pwd-bar" id="bar1"></div>
                            <div class="pwd-bar" id="bar2"></div>
                            <div class="pwd-bar" id="bar3"></div>
                            <div class="pwd-bar" id="bar4"></div>
                        </div>
                        <div class="pwd-label" id="pwd-label">—</div>
                    </div>

                    <div class="field" style="margin-bottom:0">
                        <label for="password_confirmation">Confirmation</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Répéter"
                            required
                        >
                    </div>
                </div>

                @if($errors->any())
                    <div class="error-block" style="margin-top:16px">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <div class="terms-row" style="margin-top:20px">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        En créant un compte, j'accepte les
                        <a href="#">Conditions d'utilisation</a> et la
                        <a href="#">Politique de confidentialité</a> d'ImmoApp.
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    Créer mon compte
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </form>

            <div class="form-divider">ou</div>

            <div class="form-footer">
                Déjà inscrit ?
                <a href="{{ route('login') }}">Se connecter</a>
            </div>

        </div>
    </div>

    <script>
        function checkStrength(val) {
            const bars = [
                document.getElementById('bar1'),
                document.getElementById('bar2'),
                document.getElementById('bar3'),
                document.getElementById('bar4'),
            ];
            const label = document.getElementById('pwd-label');
            const colors = { 0: '#E5E3DF', 1: '#EF4444', 2: '#F97316', 3: '#EAB308', 4: '#22C55E' };
            const labels = { 0: '—', 1: 'Très faible', 2: 'Faible', 3: 'Correct', 4: 'Fort' };

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            bars.forEach((bar, i) => {
                bar.style.background = i < score ? colors[score] : '#E5E3DF';
            });

            label.textContent = val.length ? labels[score] : '—';
            label.style.color = score >= 3 ? '#22C55E' : score >= 2 ? '#F97316' : '#EF4444';
        }
    </script>

</body>
</html>