@extends('layouts.app')

@section('page-title', 'Détail immeuble')

@section('breadcrumb')
    <a href="{{ route('manager.buildings.index') }}"
       style="color:#8A8478;text-decoration:none;transition:color 0.2s;font-family:'Syne',sans-serif;font-size:13px;"
       onmouseover="this.style.color='#0F0E0C'"
       onmouseout="this.style.color='#8A8478'">Immeubles</a>
    &nbsp;/&nbsp;
    <span style="color:#0F0E0C;font-weight:600;font-family:'Syne',sans-serif;font-size:13px;">{{ $building->name }}</span>
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    * { box-sizing: border-box; }

    :root {
        --ink:     #0F0E0C;
        --paper:   #F9F7F4;
        --cream:   #EFE9DF;
        --gold:    #B8924A;
        --gold-lt: #D4AA6A;
        --navy:    #1B2A4A;
        --navy-lt: #2C3E6B;
        --muted:   #8A8478;
        --border:  #E2DDD6;
    }

    /* ── Page header ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 6px;
    }
    .page-sub {
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        color: var(--muted);
        letter-spacing: 0.01em;
    }

    /* ── Boutons ── */
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFF7E6;
        color: #B07A20;
        border: 1px solid #F5D98A;
        border-radius: 10px;
        padding: 10px 20px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-edit:hover {
        background: #FEECC0;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(184,146,74,0.2);
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--paper);
        color: var(--muted);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 10px 20px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background: var(--cream);
        color: var(--ink);
        transform: translateY(-1px);
    }

    /* ── Hero card ── */
    .hero-card {
        background: var(--navy);
        border-radius: 20px;
        padding: 36px 40px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 28px;
        position: relative;
        overflow: hidden;
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(184,146,74,0.07);
    }
    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -40px; right: 80px;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(184,146,74,0.04);
    }
    .hero-avatar {
        width: 72px; height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, rgba(184,146,74,0.2) 0%, rgba(212,170,106,0.15) 100%);
        border: 1px solid rgba(184,146,74,0.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px; font-weight: 700;
        color: var(--gold-lt);
        flex-shrink: 0;
        position: relative; z-index: 1;
    }
    .hero-info { position: relative; z-index: 1; }
    .hero-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 30px; font-weight: 600;
        color: #fff;
        line-height: 1;
        margin-bottom: 6px;
    }
    .hero-addr {
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        display: flex; align-items: center; gap: 6px;
    }

    /* ── Stats mini ── */
    .mini-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 600px) { .mini-stats { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 380px) { .mini-stats { grid-template-columns: 1fr; } }

    .mini-stat {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 20px 22px;
        display: flex; align-items: center; gap: 14px;
        transition: box-shadow 0.2s, transform 0.2s;
        position: relative; overflow: hidden;
    }
    .mini-stat::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), var(--gold-lt));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    .mini-stat:hover::before { transform: scaleX(1); }
    .mini-stat:hover {
        box-shadow: 0 8px 28px rgba(15,14,12,0.07);
        transform: translateY(-2px);
    }
    .mini-stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .mini-stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 28px; font-weight: 600;
        color: var(--ink); line-height: 1;
        margin-bottom: 2px;
    }
    .mini-stat-lbl {
        font-family: 'Syne', sans-serif;
        font-size: 10.5px; color: var(--muted);
        letter-spacing: 0.02em;
    }

    /* ── Detail card ── */
    .detail-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .detail-card-header {
        padding: 16px 26px;
        border-bottom: 1px solid var(--border);
        background: var(--paper);
        display: flex; align-items: center; gap: 10px;
    }
    .detail-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
    }
    .detail-row {
        display: flex; align-items: center;
        padding: 17px 26px;
        border-bottom: 1px solid #F5F1EC;
        transition: background 0.15s;
    }
    .detail-row:last-child { border-bottom: none; }
    .detail-row:hover { background: #FDFCFA; }
    .detail-label {
        font-family: 'Syne', sans-serif;
        font-size: 11.5px; font-weight: 600;
        color: var(--muted);
        width: 160px;
        flex-shrink: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .detail-value {
        font-family: 'Syne', sans-serif;
        font-size: 13.5px;
        color: var(--ink);
        font-weight: 500;
    }

    /* ── Badge floor ── */
    .floor-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #EEF2FF;
        color: #3B5EC6;
        font-family: 'Syne', sans-serif;
        font-size: 11.5px; font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
    }

    /* ── Date pill ── */
    .date-pill {
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        color: var(--muted);
        background: var(--paper);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 3px 10px;
    }

    /* ── Actions bar ── */
    .actions-bar {
        display: flex; gap: 10px; flex-wrap: wrap;
        align-items: center;
    }

    /* ── Apt pill ── */
    .apt-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--paper);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 4px 12px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 17px; font-weight: 600;
        color: var(--ink);
    }

    /* Danger btn */
    .btn-danger-sm {
        display: inline-flex; align-items: center; gap: 7px;
        background: #FFF1F0; color: #C0392B;
        border: 1px solid #FFCBC9;
        border-radius: 10px;
        padding: 10px 20px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px; font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-danger-sm:hover {
        background: #FFE0DE;
        transform: translateY(-1px);
    }
</style>

{{-- Page header --}}
<div class="page-header">
    <div>
        <div class="page-title-text">Détail immeuble</div>
        <div class="page-sub">Informations complètes sur l'immeuble</div>
    </div>
    <div class="actions-bar">
        <a href="{{ route('manager.buildings.index') }}" class="btn-back">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour
        </a>
        <a href="{{ route('manager.buildings.edit', $building->id) }}" class="btn-edit">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
        </a>
    </div>
</div>

{{-- Hero --}}
<div class="hero-card">
    <div class="hero-avatar">{{ strtoupper(substr($building->name, 0, 1)) }}</div>
    <div class="hero-info">
        <div class="hero-name">{{ $building->name }}</div>
        <div class="hero-addr">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $building->address ?? 'Adresse non renseignée' }}
        </div>
    </div>
</div>

{{-- Mini stats --}}
<div class="mini-stats">
    <div class="mini-stat">
        <div class="mini-stat-icon" style="background:#EEF2FF;">
            <svg width="18" height="18" fill="none" stroke="#3B5EC6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-val">{{ $building->floors }}</div>
            <div class="mini-stat-lbl">Étage{{ $building->floors > 1 ? 's' : '' }}</div>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon" style="background:#F0FAF4;">
            <svg width="18" height="18" fill="none" stroke="#1A8A4C" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-val">{{ $building->apartments_count ?? $building->apartments()->count() }}</div>
            <div class="mini-stat-lbl">Appartements</div>
        </div>
    </div>
    <div class="mini-stat">
        <div class="mini-stat-icon" style="background:#FDF8EE;">
            <svg width="18" height="18" fill="none" stroke="#B8924A" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="mini-stat-val">{{ $building->created_at->diffInDays(now()) }}</div>
            <div class="mini-stat-lbl">Jours actif</div>
        </div>
    </div>
</div>

{{-- Detail rows --}}
<div class="detail-card">
    <div class="detail-card-header">
        <svg width="13" height="13" fill="none" stroke="var(--muted)" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="detail-card-title">Informations</span>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
            Nom
        </div>
        <div class="detail-value">{{ $building->name }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            Adresse
        </div>
        <div class="detail-value">{{ $building->address ?? '—' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
            </svg>
            Étages
        </div>
        <div class="detail-value">
            <span class="floor-badge">
                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
                </svg>
                {{ $building->floors }} étage{{ $building->floors > 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Appartements
        </div>
        <div class="detail-value">
            <span class="apt-pill">{{ $building->apartments_count ?? $building->apartments()->count() }} appt</span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Créé le
        </div>
        <div class="detail-value">
            <span class="date-pill">{{ $building->created_at->format('d/m/Y') }}</span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Modifié le
        </div>
        <div class="detail-value">
            <span class="date-pill">{{ $building->updated_at->format('d/m/Y') }}</span>
        </div>
    </div>
</div>

{{-- Danger zone --}}
<div class="detail-card">
    <div class="detail-card-header">
        <svg width="13" height="13" fill="none" stroke="#C0392B" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
        <span class="detail-card-title" style="color:#C0392B;">Zone dangereuse</span>
    </div>
    <div class="detail-row" style="justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <div style="font-family:'Syne',sans-serif;font-size:13px;font-weight:600;color:var(--ink);margin-bottom:3px;">Supprimer cet immeuble</div>
            <div style="font-family:'Syne',sans-serif;font-size:12px;color:var(--muted);">Cette action est irréversible. Tous les appartements associés seront supprimés.</div>
        </div>
        <form action="{{ route('manager.buildings.destroy', $building->id) }}" method="POST" style="flex-shrink:0;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger-sm" onclick="return confirm('Supprimer définitivement cet immeuble ?')">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Supprimer
            </button>
        </form>
    </div>
</div>

@endsection
