@extends('layouts.app')

@section('page-title', 'Tableau de bord')

@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('content')
<style>
    /* ── Hero ── */
    .dash-hero {
        background: #1A1A2E;
        border-radius: 16px;
        padding: 30px 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }
    .dash-hero::before {
        content: '';
        position: absolute; top: -70px; right: -70px;
        width: 260px; height: 260px;
        background: #C9A96E; opacity: 0.07;
        border-radius: 50%; pointer-events: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute; bottom: -50px; left: 38%;
        width: 180px; height: 180px;
        background: #C9A96E; opacity: 0.04;
        border-radius: 50%; pointer-events: none;
    }
    .hero-left { position: relative; z-index: 1; }
    .hero-eyebrow {
        font-size: 10px; font-weight: 700;
        letter-spacing: 2.5px; text-transform: uppercase;
        color: #C9A96E; margin-bottom: 8px;
    }
    .hero-name {
        font-family: 'Playfair Display', serif;
        font-size: 26px; font-weight: 600;
        color: #fff; margin-bottom: 10px;
    }
    .hero-role-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(201,169,110,0.12);
        border: 1px solid rgba(201,169,110,0.25);
        color: #E8D5B0; font-size: 11px; font-weight: 600;
        padding: 4px 12px; border-radius: 20px;
        letter-spacing: 1px; text-transform: uppercase;
    }
    .role-dot { width: 6px; height: 6px; border-radius: 50%; background: #C9A96E; flex-shrink: 0; }
    .hero-avatar {
        position: relative; z-index: 1; flex-shrink: 0;
    }
    .hero-avatar img {
        width: 68px; height: 68px; border-radius: 50%;
        border: 3px solid rgba(201,169,110,0.45);
        object-fit: cover; display: block;
    }

    /* ── Stats ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; } }

    .stat-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 14px; padding: 20px;
        position: relative; overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.07); }
    .stat-card::before {
        content: ''; position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        border-radius: 14px 14px 0 0;
    }
    .stat-card.blue::before  { background: #3B82F6; }
    .stat-card.green::before { background: #10B981; }
    .stat-card.gold::before  { background: #C9A96E; }
    .stat-card.red::before   { background: #EF4444; }

    .stat-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 14px;
    }
    .stat-ico {
        width: 38px; height: 38px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px; flex-shrink: 0;
    }
    .stat-card.blue  .stat-ico { background: #EFF6FF; }
    .stat-card.green .stat-ico { background: #ECFDF5; }
    .stat-card.gold  .stat-ico { background: #FDF8EE; }
    .stat-card.red   .stat-ico { background: #FEF2F2; }

    .stat-trend {
        font-size: 10px; font-weight: 700;
        padding: 3px 7px; border-radius: 20px;
    }
    .trend-up   { background: #ECFDF5; color: #059669; }
    .trend-down { background: #FEF2F2; color: #DC2626; }
    .trend-neu  { background: #F3F4F6; color: #6B7280; }

    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 30px; font-weight: 600;
        color: #1A1A2E; line-height: 1; margin-bottom: 4px;
    }
    .stat-lbl { font-size: 12px; color: #8B8FA8; }

    /* ── Code d'accès ── */
    .access-card {
        background: #1A1A2E;
        border: 1px solid rgba(201,169,110,0.2);
        border-radius: 16px;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative; overflow: hidden;
    }
    .access-card::before {
        content: '';
        position: absolute; right: -50px; top: -50px;
        width: 200px; height: 200px;
        background: #C9A96E; opacity: 0.06;
        border-radius: 50%; pointer-events: none;
    }
    .access-inner { position: relative; z-index: 1; }
    .access-eyebrow {
        font-size: 10px; font-weight: 700;
        letter-spacing: 2.5px; text-transform: uppercase;
        color: #C9A96E; margin-bottom: 8px;
    }
    .access-title {
        font-family: 'Playfair Display', serif;
        font-size: 18px; font-weight: 600;
        color: #fff; margin-bottom: 5px;
    }
    .access-sub { font-size: 13px; color: rgba(255,255,255,0.38); margin-bottom: 20px; }

    .code-form { display: flex; gap: 10px; flex-wrap: wrap; }
    .code-input {
        flex: 1; min-width: 200px; height: 46px;
        background: rgba(255,255,255,0.07);
        border: 1.5px solid rgba(201,169,110,0.3);
        border-radius: 10px; padding: 0 16px;
        font-size: 15px; font-weight: 700;
        font-family: 'Courier New', monospace;
        color: #fff; outline: none;
        letter-spacing: 3px; text-transform: uppercase;
        transition: all 0.2s;
    }
    .code-input:focus {
        border-color: #C9A96E;
        background: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }
    .code-input::placeholder { color: rgba(255,255,255,0.22); letter-spacing: 1px; font-size: 13px; font-weight: 400; font-family: 'DM Sans', sans-serif; }
    .btn-gold {
        height: 46px; padding: 0 28px;
        background: #C9A96E; color: #1A1A2E;
        border: none; border-radius: 10px;
        font-size: 13px; font-weight: 700;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; transition: all 0.2s;
        display: inline-flex; align-items: center; gap: 7px;
        white-space: nowrap;
    }
    .btn-gold:hover { background: #D4B87A; box-shadow: 0 4px 12px rgba(201,169,110,0.35); }
    .error-msg {
        width: 100%; color: #FCA5A5;
        font-size: 12px; margin-top: 4px;
        display: flex; align-items: center; gap: 5px;
    }

    /* ── Manager CTA ── */
    .manager-cta {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 14px; padding: 20px 24px;
        display: flex; align-items: center;
        justify-content: space-between;
        gap: 16px; margin-bottom: 16px; flex-wrap: wrap;
    }
    .cta-left { display: flex; align-items: center; gap: 14px; }
    .cta-icon {
        width: 42px; height: 42px; border-radius: 10px;
        background: #1A1A2E;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cta-icon svg { color: #C9A96E; }
    .cta-title {
        font-family: 'Playfair Display', serif;
        font-size: 14px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 2px;
    }
    .cta-sub { font-size: 12px; color: #8B8FA8; }
    .btn-dark {
        display: inline-flex; align-items: center; gap: 7px;
        height: 38px; padding: 0 18px;
        background: #1A1A2E; color: #C9A96E;
        border: 1px solid #C9A96E; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; transition: all 0.2s;
        white-space: nowrap; flex-shrink: 0;
    }
    .btn-dark:hover { background: #C9A96E; color: #1A1A2E; }

    /* ── Quick actions ── */
    .quick-row {
        display: flex; gap: 10px;
        margin-bottom: 24px; flex-wrap: wrap;
    }
    .quick-btn {
        display: inline-flex; align-items: center; gap: 7px;
        height: 38px; padding: 0 16px;
        background: #fff; color: #1A1A2E;
        border: 1.5px solid #E5E3DF; border-radius: 8px;
        font-size: 12px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; transition: all 0.2s;
    }
    .quick-btn:hover { border-color: #C9A96E; color: #C9A96E; }
    .quick-btn svg { color: #C9A96E; flex-shrink: 0; }
</style>

{{-- ══ HERO ══ --}}
<div class="dash-hero">
    <div class="hero-left">
        <div class="hero-eyebrow">Tableau de bord</div>
        <div class="hero-name">{{ auth()->user()->name }}</div>
        <div class="hero-role-badge">
            <span class="role-dot"></span>
            {{ ucfirst(auth()->user()->role) }}
        </div>
    </div>
    <div class="hero-avatar">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=C9A96E&color=1A1A2E&bold=true&size=136"
             alt="{{ auth()->user()->name }}">
    </div>
</div>

{{-- ══ CODE D'ACCÈS — locataires & techniciens ══ --}}
@if(in_array(auth()->user()->role, ['tenant', 'technician']))
<div class="access-card">
    <div class="access-inner">
        <div class="access-eyebrow">Accès requis</div>
        <div class="access-title">Entrez votre code d'accès</div>
        <div class="access-sub">Votre gestionnaire vous a remis un code au format ABC-1234.</div>
        <form method="POST" action="{{ route('dashboard.verifyCode') }}">
            @csrf
            <div class="code-form">
                <input type="text" name="code"
                    placeholder="ex : ABC-1234"
                    class="code-input"
                    maxlength="8"
                    autocomplete="off"
                    required
                    oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9\-]/g,'')">
                @error('code')
                    <div class="error-msg">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
                <button type="submit" class="btn-gold">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Valider
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ══ CTA + RACCOURCIS — managers & admins ══ --}}
@if(in_array(auth()->user()->role, ['manager', 'admin']))
<div class="manager-cta">
    <div class="cta-left">
        <div class="cta-icon">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <div>
            <div class="cta-title">Dashboard complet</div>
            <div class="cta-sub">Immeubles, locataires, paiements — vue portefeuille complète.</div>
        </div>
    </div>
    <a href="{{ route('manager.dashboard') }}" class="btn-dark">
        Accéder
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

<div class="quick-row">
    @if(Route::has('buildings.create'))
    <a href="{{ route('buildings.create') }}" class="quick-btn">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvel immeuble
    </a>
    @endif
    @if(Route::has('manager.apartments.create'))
    <a href="{{ route('manager.apartments.create') }}" class="quick-btn">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvel appartement
    </a>
    @endif
    @if(Route::has('access-codes.index'))
    <a href="{{ route('access-codes.index') }}" class="quick-btn">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
        Codes d'accès
    </a>
    @endif
    @if(Route::has('buildings.index'))
    <a href="{{ route('buildings.index') }}" class="quick-btn">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
        </svg>
        Voir immeubles
    </a>
    @endif
</div>
@endif

{{-- ══ STATS ══ --}}
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-ico">🏢</div>
            @if(isset($stats['apartments_trend']))
                <span class="stat-trend trend-up">+{{ $stats['apartments_trend'] }}%</span>
            @else
                <span class="stat-trend trend-neu">—</span>
            @endif
        </div>
        <div class="stat-val">{{ $stats['apartments'] ?? '—' }}</div>
        <div class="stat-lbl">Appartements</div>
    </div>

    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-ico">👥</div>
            @if(isset($stats['tenants_trend']))
                <span class="stat-trend trend-up">+{{ $stats['tenants_trend'] }}%</span>
            @else
                <span class="stat-trend trend-neu">—</span>
            @endif
        </div>
        <div class="stat-val">{{ $stats['tenants'] ?? '—' }}</div>
        <div class="stat-lbl">Locataires</div>
    </div>

    <div class="stat-card gold">
        <div class="stat-top">
            <div class="stat-ico">💳</div>
            @if(isset($stats['payments_trend']))
                <span class="stat-trend trend-up">+{{ $stats['payments_trend'] }}%</span>
            @else
                <span class="stat-trend trend-neu">—</span>
            @endif
        </div>
        <div class="stat-val">{{ $stats['payments'] ?? '—' }}</div>
        <div class="stat-lbl">Paiements</div>
    </div>

    <div class="stat-card red">
        <div class="stat-top">
            <div class="stat-ico">⚠️</div>
            @if(isset($stats['incidents_trend']))
                <span class="stat-trend trend-down">+{{ $stats['incidents_trend'] }}</span>
            @else
                <span class="stat-trend trend-neu">—</span>
            @endif
        </div>
        <div class="stat-val">{{ $stats['incidents'] ?? '—' }}</div>
        <div class="stat-lbl">Incidents</div>
    </div>
</div>

@endsection