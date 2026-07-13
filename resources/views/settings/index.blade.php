@extends('layouts.app')

@section('page-title', 'Paramètres')

@section('breadcrumb')
    <span>Paramètres</span>
@endsection

@section('content')
<style>
    .settings-shell { display: grid; gap: 20px; }
    .settings-hero {
        background: linear-gradient(135deg, #1B1E2F 0%, #27314D 70%, #C9A96E 170%);
        color: #fff; border-radius: 20px; padding: 28px; position: relative; overflow: hidden;
    }
    .settings-hero::after {
        content: ''; position: absolute; right: -90px; top: -90px; width: 240px; height: 240px;
        border-radius: 50%; background: rgba(201,169,110,0.16);
    }
    .settings-kicker { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #E5C98A; margin-bottom: 10px; }
    .settings-title { font-size: 30px; font-weight: 700; margin-bottom: 10px; }
    .settings-sub { max-width: 760px; color: rgba(255,255,255,0.8); line-height: 1.7; font-size: 14px; }

    .settings-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
    @media (max-width: 960px) { .settings-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 640px) { .settings-grid { grid-template-columns: 1fr; } }

    .card {
        background: #fff; border: 1px solid #EEECEA; border-radius: 16px; padding: 18px;
        box-shadow: 0 10px 24px rgba(16,24,40,0.04);
    }
    .card h3 { margin: 0 0 6px; font-size: 15px; color: #1A1A2E; }
    .card p { margin: 0; font-size: 12px; color: #6B7280; line-height: 1.6; }
    .value { margin-top: 12px; font-size: 18px; font-weight: 700; color: #1A1A2E; word-break: break-word; }

    .panel {
        background: #fff; border: 1px solid #EEECEA; border-radius: 18px; overflow: hidden;
    }
    .panel-head { padding: 18px 20px; border-bottom: 1px solid #F3F1EE; }
    .panel-title { font-size: 15px; font-weight: 700; color: #1A1A2E; }
    .panel-sub { font-size: 12px; color: #8B8FA8; margin-top: 4px; }
    .panel-body { padding: 20px; display: grid; gap: 14px; }
    .action {
        display: flex; justify-content: space-between; gap: 12px; align-items: center;
        padding: 14px 16px; border-radius: 14px; background: #FAF9F7; border: 1px solid #F0ECE7;
        color: #1A1A2E; text-decoration: none;
    }
    .action strong { display: block; margin-bottom: 3px; }
    .action span { color: #6B7280; font-size: 12px; }
    .badge { font-size: 11px; font-weight: 700; padding: 6px 10px; border-radius: 999px; background: #ECFDF5; color: #047857; white-space: nowrap; }
</style>

<div class="settings-shell">
    <section class="settings-hero">
        <div class="settings-kicker">Système</div>
        <div class="settings-title">Paramètres de votre espace</div>
        <div class="settings-sub">
            Cette page centralise les informations de compte et les raccourcis utiles. Elle sert de base pour évoluer vers de vrais réglages métier sans casser la navigation actuelle.
        </div>
    </section>

    <section class="settings-grid">
        <div class="card">
            <h3>Utilisateur connecté</h3>
            <p>Compte actif dans l’application</p>
            <div class="value">{{ $user->name }}</div>
        </div>
        <div class="card">
            <h3>Email</h3>
            <p>Adresse liée au compte</p>
            <div class="value">{{ $user->email }}</div>
        </div>
        <div class="card">
            <h3>Rôle</h3>
            <p>Profil d’accès actuel</p>
            <div class="value">{{ $user->role ?? 'non défini' }}</div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div class="panel-title">Actions rapides</div>
            <div class="panel-sub">Liens utiles pour continuer la gestion</div>
        </div>
        <div class="panel-body">
            <a class="action" href="{{ route('manager.dashboard') }}">
                <div>
                    <strong>Retour au dashboard</strong>
                    <span>Revenir à la vue globale de gestion</span>
                </div>
                <span class="badge">ouvrir</span>
            </a>
            <a class="action" href="{{ route('payments.index') }}">
                <div>
                    <strong>Consulter les paiements</strong>
                    <span>Voir les encaissements et les montants en attente</span>
                </div>
                <span class="badge">finance</span>
            </a>
            <a class="action" href="{{ route('reports.index') }}">
                <div>
                    <strong>Voir les rapports</strong>
                    <span>Accéder à l’analyse consolidée de la résidence</span>
                </div>
                <span class="badge">analyse</span>
            </a>
        </div>
    </section>
</div>
@endsection