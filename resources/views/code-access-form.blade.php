@extends('layouts.app')

@section('page-title', 'Accès locataire / maintenancier')

@section('content')
<style>
    .access-shell {
        min-height: calc(100vh - 120px);
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 24px;
        align-items: center;
        padding: 24px 0 40px;
    }
    @media (max-width: 960px) {
        .access-shell { grid-template-columns: 1fr; }
    }

    .access-hero {
        position: relative;
        border-radius: 28px;
        padding: 44px;
        overflow: hidden;
        background:
            radial-gradient(circle at top right, rgba(201,169,110,0.18), transparent 28%),
            radial-gradient(circle at left bottom, rgba(230,191,129,0.12), transparent 32%),
            linear-gradient(135deg, #171A2B 0%, #22304D 100%);
        color: #fff;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.16);
    }
    .access-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #E7C88E;
        margin-bottom: 16px;
    }
    .access-title {
        font-size: clamp(30px, 4vw, 48px);
        line-height: 1.05;
        font-weight: 700;
        margin: 0 0 16px;
        max-width: 11ch;
    }
    .access-sub {
        max-width: 620px;
        font-size: 15px;
        line-height: 1.75;
        color: rgba(255,255,255,0.8);
        margin-bottom: 28px;
    }
    .access-pills { display: flex; flex-wrap: wrap; gap: 10px; }
    .pill {
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        font-size: 12px;
        font-weight: 600;
    }
    .access-metrics {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 28px;
    }
    @media (max-width: 640px) {
        .access-metrics { grid-template-columns: 1fr; }
    }
    .metric {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 18px;
        padding: 16px;
    }
    .metric-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.6px; color: rgba(255,255,255,0.58); margin-bottom: 8px; }
    .metric-value { font-size: 22px; font-weight: 700; color: #fff; line-height: 1; }
    .metric-note { margin-top: 8px; font-size: 12px; color: rgba(255,255,255,0.72); line-height: 1.55; }

    .access-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 28px;
        padding: 30px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
    }
    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }
    .card-title { font-size: 22px; font-weight: 700; color: #171A2B; margin: 0; }
    .card-badge {
        display: inline-flex;
        padding: 7px 10px;
        border-radius: 999px;
        background: #FAF5EA;
        color: #9A6B2F;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
    }
    .card-desc {
        font-size: 14px;
        line-height: 1.7;
        color: #647083;
        margin-bottom: 20px;
    }
    .form-group { margin-bottom: 18px; }
    .label-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    label {
        font-size: 13px;
        font-weight: 700;
        color: #1A1A2E;
    }
    .field-hint {
        font-size: 12px;
        color: #8B8FA8;
    }
    .code-input {
        width: 100%;
        border-radius: 16px;
        border: 1px solid #E6E2DA;
        padding: 16px 16px;
        font-size: 16px;
        background: #FAF9F7;
        color: #1A1A2E;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
        letter-spacing: 0.04em;
    }
    .code-input:focus {
        border-color: #C9A96E;
        box-shadow: 0 0 0 4px rgba(201,169,110,0.15);
        background: #fff;
    }
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 18px;
        flex-wrap: wrap;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #171A2B, #26314E);
        color: #fff;
        padding: 14px 18px;
        border-radius: 14px;
        border: 1px solid rgba(23,26,43,0.1);
        font-weight: 700;
        font-size: 14px;
        width: 100%;
        cursor: pointer;
        transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;
        box-shadow: 0 12px 24px rgba(23,26,43,0.14);
    }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 16px 32px rgba(23,26,43,0.18); }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 18px;
        border-radius: 14px;
        border: 1px solid #E6E2DA;
        background: #fff;
        color: #1A1A2E;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
    }
    .error-box {
        margin-top: 18px;
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #B91C1C;
        padding: 14px 16px;
        border-radius: 14px;
        font-size: 13px;
        line-height: 1.6;
    }
    .help-box {
        margin-top: 18px;
        padding: 14px 16px;
        border-radius: 14px;
        background: #FAF9F7;
        border: 1px dashed #E8E1D5;
        color: #6B7280;
        font-size: 13px;
        line-height: 1.65;
    }
</style>

<div class="access-shell">
    <section class="access-hero">
        <div class="access-kicker">Accès sécurisé</div>
        <h1 class="access-title">Accès locataire / maintenancier</h1>
        <div class="access-sub">
            Entrez votre code d’accès pour rejoindre automatiquement votre espace. Le système identifie ensuite votre profil et vous redirige vers le bon tableau de bord.
        </div>

        <div class="access-pills">
            <span class="pill">Locataire</span>
            <span class="pill">Maintenancier</span>
            <span class="pill">Connexion rapide</span>
        </div>

        <div class="access-metrics">
            <div class="metric">
                <div class="metric-label">Étape 1</div>
                <div class="metric-value">Code</div>
                <div class="metric-note">Saisissez le code reçu pour accéder à votre espace.</div>
            </div>
            <div class="metric">
                <div class="metric-label">Étape 2</div>
                <div class="metric-value">Vérif.</div>
                <div class="metric-note">Le système vérifie automatiquement le type de compte.</div>
            </div>
            <div class="metric">
                <div class="metric-label">Étape 3</div>
                <div class="metric-value">Entrée</div>
                <div class="metric-note">Vous arrivez sur votre tableau de bord sans mot de passe.</div>
            </div>
        </div>
    </section>

    <section class="access-card">
        <div class="card-head">
            <h2 class="card-title">Saisir le code</h2>
            <span class="card-badge">Secure access</span>
        </div>

        <div class="card-desc">
            Utilisez le code d’accès fourni par l’administration. Les locataires sont redirigés vers leur dashboard, et les maintenanciers vers leur espace technique.
        </div>

        <form method="POST" action="{{ route('code.access') }}">
            @csrf
            <div class="form-group">
                <div class="label-row">
                    <label for="access_code">Code d’accès</label>
                    <span class="field-hint">Exemple: #0010</span>
                </div>
                <input
                    type="text"
                    name="access_code"
                    id="access_code"
                    class="code-input"
                    placeholder="Entrez votre code"
                    value="{{ old('access_code') }}"
                    autocomplete="off"
                    autofocus
                    required
                >
                @error('access_code')
                    <div class="error-box">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Accéder</button>
        </form>

        @if(session('error'))
            <div class="error-box">{{ session('error') }}</div>
        @endif

        <div class="help-box">
            Si votre code ne fonctionne pas, vérifiez qu’il est bien actif et qu’il correspond à un locataire ou à un maintenancier enregistré.
        </div>

        <div class="actions">
            <a href="{{ route('login') }}" class="btn-secondary">Connexion classique</a>
        </div>
    </section>
</div>
@endsection
