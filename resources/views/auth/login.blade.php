<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — ImmoApp</title>
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

        /* Mini stats */
        .panel-stats {
            display: flex;
            gap: 24px;
        }

        .panel-stat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 16px 20px;
        }

        .ps-value {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 600;
            color: #C9A96E;
            line-height: 1;
            margin-bottom: 4px;
        }

        .ps-label {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.5px;
        }

        .panel-footer {
            font-size: 12px;
            color: rgba(255,255,255,0.25);
            position: relative;
            z-index: 1;
        }

        /* ── RIGHT PANEL (form) ── */
        .right-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 64px;
        }

        .form-header {
            margin-bottom: 36px;
        }

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

        /* Form fields */
        .field {
            margin-bottom: 20px;
        }

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

        /* Error */
        .error-block {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
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

        /* Submit button */
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
            margin-top: 8px;
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
            margin: 24px 0;
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

        /* Footer link */
        .form-footer {
            text-align: center;
            font-size: 13px;
            color: #8B8FA8;
        }

        .form-footer a {
            color: #C9A96E;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-footer a:hover { color: #A88A50; text-decoration: underline; }

        /* Remember + forgot row */
        .field-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #6B7280;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #C9A96E;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: #C9A96E;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover { text-decoration: underline; }

        /* Responsive */
        @media (max-width: 820px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 40px 28px; }
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
            <div class="panel-eyebrow">Gestion immobilière</div>
            <h2 class="panel-title">Content de<br>vous revoir.</h2>
            <p class="panel-desc">
                Gérez vos immeubles, locataires et paiements depuis un seul tableau de bord intelligent.
            </p>

            <div class="panel-stats">
                <div class="panel-stat">
                    <div class="ps-value">95%</div>
                    <div class="ps-label">Taux de satisfaction</div>
                </div>
                <div class="panel-stat">
                    <div class="ps-value">24/7</div>
                    <div class="ps-label">Disponible</div>
                </div>
                <div class="panel-stat">
                    <div class="ps-value">0 FCFA</div>
                    <div class="ps-label">Pour commencer</div>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            © {{ date('Y') }} ImmoApp — Made with ❤️ in Sénégal
        </div>
    </div>

    <!-- ══ RIGHT PANEL (form) ══ -->
    <div class="right-panel">
        <div style="max-width: 400px; width: 100%; margin: 0 auto;">

            <div class="form-header">
                <div class="form-tag">Accès sécurisé</div>
                <h1 class="form-title">Connexion</h1>
                <p class="form-sub">Entrez vos identifiants pour accéder à votre espace.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                @csrf

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="vous@exemple.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="field-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                    @endif
                </div>

                @if($errors->any())
                    <div class="error-block">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <button type="submit" class="btn-submit">
                    Se connecter
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </form>

            <div class="form-divider">ou</div>

            <div class="form-footer">
                Pas encore de compte ?
                <a href="{{ route('register') }}">S'inscrire gratuitement</a>
            </div>

        </div>
    </div>

</body>
</html>