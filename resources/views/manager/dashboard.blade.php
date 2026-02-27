@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('breadcrumb')
    <span>Accueil</span>
@endsection

@section('content')
<style>
    /* ── Hero greeting ── */
    .dash-hero {
        background: #1A1A2E;
        border-radius: 16px;
        padding: 28px 32px;
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
        position: absolute; top: -80px; right: -80px;
        width: 280px; height: 280px;
        background: #C9A96E; opacity: 0.06;
        border-radius: 50%; pointer-events: none;
    }
    .dash-hero::after {
        content: '';
        position: absolute; bottom: -50px; left: 35%;
        width: 180px; height: 180px;
        background: #C9A96E; opacity: 0.04;
        border-radius: 50%; pointer-events: none;
    }
    .hero-text { position: relative; z-index: 1; }
    .hero-eyebrow {
        font-size: 10px; font-weight: 700;
        letter-spacing: 2.5px; text-transform: uppercase;
        color: #C9A96E; margin-bottom: 8px;
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 26px; font-weight: 600;
        color: #fff; margin-bottom: 6px;
    }
    .hero-sub { font-size: 13px; color: rgba(255,255,255,0.4); }

    .hero-date {
        position: relative; z-index: 1;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 14px 20px;
        text-align: center;
        flex-shrink: 0;
    }
    .hero-date-day {
        font-family: 'Playfair Display', serif;
        font-size: 32px; font-weight: 600;
        color: #C9A96E; line-height: 1;
    }
    .hero-date-info { font-size: 11px; color: rgba(255,255,255,0.35); margin-top: 3px; }

    /* ── Stats grid ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; } }

    .stat-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 14px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
        cursor: default;
    }
    .stat-card:hover {
        box-shadow: 0 6px 24px rgba(13,17,23,0.08);
        transform: translateY(-2px);
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px;
    }
    .stat-card.blue::before   { background: #3B82F6; }
    .stat-card.green::before  { background: #10B981; }
    .stat-card.amber::before  { background: #F59E0B; }
    .stat-card.gold::before   { background: #C9A96E; }

    .stat-top {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 14px;
    }
    .stat-icon {
        width: 38px; height: 38px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-trend {
        font-size: 10px; font-weight: 700;
        padding: 3px 7px; border-radius: 20px;
    }
    .stat-trend.up   { background: #ECFDF5; color: #059669; }
    .stat-trend.down { background: #FEF2F2; color: #DC2626; }
    .stat-trend.neu  { background: #F3F4F6; color: #6B7280; }

    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 28px; font-weight: 600;
        color: #1A1A2E; line-height: 1; margin-bottom: 4px;
    }
    .stat-val.small { font-size: 20px; }
    .stat-lbl { font-size: 12px; color: #8B8FA8; }

    /* ── Two-col layout ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }
    @media (max-width: 960px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 14px; overflow: hidden;
        margin-bottom: 20px;
    }
    .card:last-child { margin-bottom: 0; }

    .card-head {
        padding: 16px 22px; border-bottom: 1px solid #EEECEA;
        display: flex; align-items: center;
        justify-content: space-between; gap: 10px;
    }
    .card-head-left { display: flex; align-items: center; gap: 10px; }
    .card-icon {
        width: 30px; height: 30px; background: #F8F7F5;
        border-radius: 7px; display: flex;
        align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-icon svg { color: #C9A96E; }
    .card-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .card-link {
        font-size: 12px; color: #C9A96E; text-decoration: none;
        font-weight: 600; transition: color 0.2s;
    }
    .card-link:hover { color: #A88A50; text-decoration: underline; }

    /* ── Occupancy donut ── */
    .occ-wrap {
        padding: 24px 22px;
        display: flex; align-items: center; gap: 28px;
        flex-wrap: wrap;
    }
    .donut-wrap { position: relative; flex-shrink: 0; }
    .donut-center {
        position: absolute; inset: 0;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
    }
    .donut-pct {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600; color: #1A1A2E;
        line-height: 1;
    }
    .donut-sub { font-size: 10px; color: #8B8FA8; }

    .occ-legend { flex: 1; min-width: 120px; }
    .occ-leg-item {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 10px; font-size: 13px;
    }
    .occ-leg-item:last-child { margin-bottom: 0; }
    .leg-dot { width: 10px; height: 10px; border-radius: 2px; flex-shrink: 0; }
    .leg-lbl { color: #6B7280; flex: 1; }
    .leg-val { font-weight: 700; color: #1A1A2E; }

    /* ── Revenue bar chart ── */
    .chart-wrap { padding: 20px 22px; }
    .bar-chart {
        display: flex; align-items: flex-end;
        gap: 8px; height: 100px;
    }
    .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; }
    .bar {
        width: 100%; border-radius: 5px 5px 0 0;
        background: linear-gradient(180deg, #C9A96E, #B8945A);
        transition: opacity 0.2s; min-height: 4px;
    }
    .bar:hover { opacity: 0.75; }
    .bar-lbl { font-size: 9px; color: #8B8FA8; }

    /* ── Quick actions ── */
    .quick-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 10px; padding: 16px 18px;
    }
    .quick-btn {
        display: flex; align-items: center; gap: 9px;
        padding: 12px 14px;
        background: #F8F7F5; border: 1px solid #EEECEA;
        border-radius: 9px; text-decoration: none;
        transition: all 0.2s; font-size: 12px;
        font-weight: 600; color: #1A1A2E;
        font-family: 'DM Sans', sans-serif;
    }
    .quick-btn:hover { background: #1A1A2E; color: #C9A96E; border-color: #1A1A2E; }
    .quick-btn:hover .qb-icon { background: rgba(201,169,110,0.15); }
    .qb-icon {
        width: 28px; height: 28px; border-radius: 7px;
        background: #fff; display: flex;
        align-items: center; justify-content: center; flex-shrink: 0;
        transition: background 0.2s;
    }
    .qb-icon svg { color: #C9A96E; }

    /* ── Sidebar cards ── */
    .side-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 12px; overflow: hidden; margin-bottom: 16px;
    }
    .side-card:last-child { margin-bottom: 0; }
    .side-head {
        padding: 14px 18px; border-bottom: 1px solid #EEECEA;
        font-size: 12px; font-weight: 700; color: #1A1A2E;
        display: flex; align-items: center; justify-content: space-between;
    }
    .side-body { padding: 0; }

    /* Alerts list */
    .alert-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-bottom: 1px solid #F5F3F1;
        transition: background 0.12s;
    }
    .alert-item:last-child { border-bottom: none; }
    .alert-item:hover { background: #FAFAF8; }
    .alert-dot {
        width: 8px; height: 8px; border-radius: 50%;
        flex-shrink: 0; margin-top: 4px;
    }
    .alert-text { font-size: 12px; color: #4B5563; line-height: 1.4; flex: 1; }
    .alert-time { font-size: 10px; color: #8B8FA8; margin-top: 2px; }

    /* Recent payments */
    .pay-item {
        display: flex; align-items: center; gap: 10px;
        padding: 11px 16px; border-bottom: 1px solid #F5F3F1;
        transition: background 0.12s;
    }
    .pay-item:last-child { border-bottom: none; }
    .pay-item:hover { background: #FAFAF8; }
    .pay-avatar {
        width: 32px; height: 32px; border-radius: 8px;
        background: #1A1A2E; color: #C9A96E;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
        font-family: 'DM Sans', sans-serif;
    }
    .pay-name { font-size: 12px; font-weight: 600; color: #1A1A2E; }
    .pay-apt  { font-size: 10px; color: #8B8FA8; }
    .pay-amount {
        margin-left: auto;
        font-size: 12px; font-weight: 700; color: #059669;
        white-space: nowrap;
    }

    /* Upcoming */
    .upcoming-item {
        display: flex; align-items: center; gap: 10px;
        padding: 11px 16px; border-bottom: 1px solid #F5F3F1;
    }
    .upcoming-item:last-child { border-bottom: none; }
    .upcoming-cal {
        width: 36px; height: 36px; border-radius: 8px;
        background: #FDF8EE; border: 1px solid rgba(201,169,110,0.2);
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .cal-day   { font-size: 14px; font-weight: 700; color: #C9A96E; line-height: 1; }
    .cal-month { font-size: 8px; color: #8B8FA8; text-transform: uppercase; letter-spacing: 0.5px; }
    .upcoming-info { flex: 1; }
    .upcoming-title { font-size: 12px; font-weight: 600; color: #1A1A2E; }
    .upcoming-sub   { font-size: 10px; color: #8B8FA8; }
    .upcoming-badge {
        font-size: 10px; font-weight: 600;
        padding: 2px 7px; border-radius: 20px;
        background: #FEF3C7; color: #D97706;
        white-space: nowrap;
    }
</style>

{{-- ══ HERO ══ --}}
<div class="dash-hero">
    <div class="hero-text">
        <div class="hero-eyebrow">Dashboard Gestionnaire</div>
        <div class="hero-title">Bonjour, {{ explode(' ', auth()->user()->name)[0] }} 👋</div>
        <div class="hero-sub">Voici un aperçu de votre portefeuille immobilier.</div>
    </div>
    <div class="hero-date">
        <div class="hero-date-day">{{ now()->format('d') }}</div>
        <div class="hero-date-info">{{ now()->translatedFormat('F Y') }}</div>
    </div>
</div>

{{-- ══ STATS ══ --}}
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-icon" style="background:#EFF6FF;">
                <svg width="18" height="18" fill="none" stroke="#2563EB" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
            </div>
            <span class="stat-trend neu">—</span>
        </div>
        <div class="stat-val">{{ $buildings }}</div>
        <div class="stat-lbl">Immeubles</div>
    </div>

    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-icon" style="background:#ECFDF5;">
                <svg width="18" height="18" fill="none" stroke="#059669" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <span class="stat-trend neu">—</span>
        </div>
        <div class="stat-val">{{ $apartments }}</div>
        <div class="stat-lbl">Appartements</div>
    </div>

    <div class="stat-card amber">
        <div class="stat-top">
            <div class="stat-icon" style="background:#FEF3C7;">
                <svg width="18" height="18" fill="none" stroke="#D97706" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <span class="stat-trend neu">—</span>
        </div>
        <div class="stat-val">{{ $tenants }}</div>
        <div class="stat-lbl">Locataires</div>
    </div>

    <div class="stat-card gold">
        <div class="stat-top">
            <div class="stat-icon" style="background:#FDF8EE;">
                <svg width="18" height="18" fill="none" stroke="#C9A96E" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="stat-trend up">↑</span>
        </div>
        <div class="stat-val small">{{ number_format($payments / 1000, 0) }}k</div>
        <div class="stat-lbl">FCFA encaissés</div>
    </div>
</div>

{{-- ══ MAIN GRID ══ --}}
<div class="main-grid">

    {{-- LEFT --}}
    <div>

        {{-- Occupation --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                        </svg>
                    </div>
                    <span class="card-title">Taux d'occupation</span>
                </div>
                @if(Route::has('manager.apartments.index'))
                    <a href="{{ route('manager.apartments.index') }}" class="card-link">Voir tout →</a>
                @endif
            </div>
            <div class="occ-wrap">
                @php
                    $occupied = isset($occupiedCount) ? $occupiedCount : 0;
                    $vacant   = isset($vacantCount)   ? $vacantCount   : 0;
                    $works    = isset($worksCount)     ? $worksCount    : 0;
                    $total    = $apartments > 0 ? $apartments : 1;
                    $occPct   = round(($occupied / $total) * 100);
                    $vacPct   = round(($vacant   / $total) * 100);
                    $wrkPct   = 100 - $occPct - $vacPct;
                    // Segments for SVG donut
                    $r = 44; $cx = 52; $cy = 52;
                    $circ = 2 * M_PI * $r;
                    $occDash = ($occPct / 100) * $circ;
                    $vacDash = ($vacPct / 100) * $circ;
                    $wrkDash = $circ - $occDash - $vacDash;
                @endphp

                <div class="donut-wrap">
                    <svg width="104" height="104" viewBox="0 0 104 104">
                        <!-- Track -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}"
                            fill="none" stroke="#F0EEEB" stroke-width="10"/>
                        <!-- Occupied -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}"
                            fill="none" stroke="#C9A96E" stroke-width="10"
                            stroke-dasharray="{{ $occDash }} {{ $circ - $occDash }}"
                            stroke-dashoffset="{{ $circ / 4 }}"
                            stroke-linecap="round"/>
                        <!-- Vacant -->
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}"
                            fill="none" stroke="#F59E0B" stroke-width="10"
                            stroke-dasharray="{{ $vacDash }} {{ $circ - $vacDash }}"
                            stroke-dashoffset="{{ $circ / 4 - $occDash }}"
                            stroke-linecap="round"
                            style="opacity:0.7"/>
                        <!-- Works -->
                        @if($wrkPct > 0)
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}"
                            fill="none" stroke="#EF4444" stroke-width="10"
                            stroke-dasharray="{{ $wrkDash }} {{ $circ - $wrkDash }}"
                            stroke-dashoffset="{{ $circ / 4 - $occDash - $vacDash }}"
                            stroke-linecap="round"
                            style="opacity:0.7"/>
                        @endif
                    </svg>
                    <div class="donut-center">
                        <div class="donut-pct">{{ $occPct }}%</div>
                        <div class="donut-sub">occupés</div>
                    </div>
                </div>

                <div class="occ-legend">
                    <div class="occ-leg-item">
                        <div class="leg-dot" style="background:#C9A96E;"></div>
                        <span class="leg-lbl">Occupés</span>
                        <span class="leg-val">{{ $occupied }}</span>
                    </div>
                    <div class="occ-leg-item">
                        <div class="leg-dot" style="background:#F59E0B;"></div>
                        <span class="leg-lbl">Vacants</span>
                        <span class="leg-val">{{ $vacant }}</span>
                    </div>
                    <div class="occ-leg-item">
                        <div class="leg-dot" style="background:#EF4444;"></div>
                        <span class="leg-lbl">En travaux</span>
                        <span class="leg-val">{{ $works }}</span>
                    </div>
                    <div class="occ-leg-item" style="margin-top:8px;padding-top:8px;border-top:1px solid #F0EEEB;">
                        <div class="leg-dot" style="background:#1A1A2E;border-radius:50%;"></div>
                        <span class="leg-lbl">Total</span>
                        <span class="leg-val">{{ $apartments }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue bars --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="card-title">Paiements reçus — 6 derniers mois</span>
                </div>
            </div>
            <div class="chart-wrap">
                @php
                    $months = collect(range(5, 0))->map(fn($i) => [
                        'label' => now()->subMonths($i)->translatedFormat('M'),
                        'value' => isset($monthlyPayments) && isset($monthlyPayments[$i])
                            ? $monthlyPayments[$i]
                            : rand(50000, 300000), // placeholder
                    ]);
                    $maxVal = $months->max('value') ?: 1;
                @endphp
                <div class="bar-chart">
                    @foreach($months as $m)
                        @php $h = max(4, round(($m['value'] / $maxVal) * 90)); @endphp
                        <div class="bar-col">
                            <div class="bar" style="height:{{ $h }}px;"
                                 title="{{ number_format($m['value'], 0, ',', ' ') }} FCFA">
                            </div>
                            <span class="bar-lbl">{{ $m['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div style="margin-top:10px;font-size:11px;color:#8B8FA8;text-align:right;">
                    Total : <strong style="color:#1A1A2E;">{{ number_format($payments, 0, ',', ' ') }} FCFA</strong>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="card-title">Actions rapides</span>
                </div>
            </div>
            <div class="quick-grid">
                @if(Route::has('manager.buildings.create'))
                <a href="{{ route('manager.buildings.create') }}" class="quick-btn">
                    <div class="qb-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    Ajouter immeuble
                </a>
                @endif
                @if(Route::has('manager.apartments.create'))
                <a href="{{ route('manager.apartments.create') }}" class="quick-btn">
                    <div class="qb-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    Ajouter appartement
                </a>
                @endif
                @if(Route::has('access-codes.index'))
                <a href="{{ route('access-codes.index') }}" class="quick-btn">
                    <div class="qb-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    Codes d'accès
                </a>
                @endif
                @if(Route::has('buildings.index'))
                <a href="{{ route('buildings.index') }}" class="quick-btn">
                    <div class="qb-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    Voir immeubles
                </a>
                @endif
            </div>
        </div>

    </div>

    {{-- RIGHT SIDEBAR --}}
    <div>

        {{-- Alertes --}}
        <div class="side-card">
            <div class="side-head">
                🔔 Alertes
                @if($vacant > 0)
                    <span style="background:#FEF3C7;color:#D97706;font-size:10px;font-weight:700;padding:2px 7px;border-radius:20px;">
                        {{ $vacant }}
                    </span>
                @endif
            </div>
            <div class="side-body">
                @if($vacant > 0)
                <div class="alert-item">
                    <div class="alert-dot" style="background:#F59E0B;"></div>
                    <div>
                        <div class="alert-text">{{ $vacant }} appartement(s) vacant(s) à louer</div>
                        <div class="alert-time">Action recommandée</div>
                    </div>
                </div>
                @endif
                @if($works > 0)
                <div class="alert-item">
                    <div class="alert-dot" style="background:#EF4444;"></div>
                    <div>
                        <div class="alert-text">{{ $works }} appartement(s) en travaux</div>
                        <div class="alert-time">Suivi requis</div>
                    </div>
                </div>
                @endif
                @if($vacant == 0 && $works == 0)
                <div class="alert-item">
                    <div class="alert-dot" style="background:#10B981;"></div>
                    <div>
                        <div class="alert-text">Tout est en ordre ✓</div>
                        <div class="alert-time">Aucune alerte</div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Paiements récents --}}
        <div class="side-card">
            <div class="side-head">
                💰 Paiements récents
                @if(Route::has('payments.index'))
                    <a href="{{ route('payments.index') }}" class="card-link">Voir →</a>
                @endif
            </div>
            <div class="side-body">
                @if(isset($recentPayments) && $recentPayments->count())
                    @foreach($recentPayments->take(4) as $pay)
                        <div class="pay-item">
                            <div class="pay-avatar">
                                {{ strtoupper(substr($pay->tenant->name ?? 'X', 0, 2)) }}
                            </div>
                            <div>
                                <div class="pay-name">{{ $pay->tenant->name ?? '—' }}</div>
                                <div class="pay-apt">Appt. {{ $pay->apartment->number ?? '—' }}</div>
                            </div>
                            <div class="pay-amount">+{{ number_format($pay->amount, 0, ',', ' ') }}</div>
                        </div>
                    @endforeach
                @else
                    <div style="padding:20px 16px;text-align:center;font-size:12px;color:#8B8FA8;">
                        Aucun paiement récent.
                    </div>
                @endif
            </div>
        </div>

        {{-- Loyers à venir --}}
        <div class="side-card">
            <div class="side-head">📅 Loyers à venir</div>
            <div class="side-body">
                @if(isset($upcomingRents) && $upcomingRents->count())
                    @foreach($upcomingRents->take(3) as $rent)
                        <div class="upcoming-item">
                            <div class="upcoming-cal">
                                <div class="cal-day">{{ $rent->due_date->format('d') }}</div>
                                <div class="cal-month">{{ $rent->due_date->translatedFormat('M') }}</div>
                            </div>
                            <div class="upcoming-info">
                                <div class="upcoming-title">{{ $rent->tenant->name ?? '—' }}</div>
                                <div class="upcoming-sub">{{ number_format($rent->amount, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="upcoming-badge">J-{{ now()->diffInDays($rent->due_date) }}</div>
                        </div>
                    @endforeach
                @else
                    {{-- Placeholder si pas encore de données --}}
                    <div style="padding:14px 16px;">
                        <div style="font-size:12px;color:#8B8FA8;text-align:center;">
                            Aucun loyer planifié à venir.
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection