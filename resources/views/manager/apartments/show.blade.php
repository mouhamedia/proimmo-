@extends('layouts.app')

@section('page-title', 'Détail immeuble')

@section('breadcrumb')
    <a href="{{ route('buildings.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;"
       onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Immeubles</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">{{ $building->name }}</span>
@endsection

@section('content')
<style>
    /* ── Layout ── */
    .detail-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 900px) { .detail-layout { grid-template-columns: 1fr; } }

    /* ── Hero header ── */
    .building-hero {
        background: #1A1A2E;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .building-hero::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        background: #C9A96E;
        opacity: 0.06;
        border-radius: 50%;
        pointer-events: none;
    }

    .building-hero::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 40%;
        width: 160px; height: 160px;
        background: #C9A96E;
        opacity: 0.04;
        border-radius: 50%;
        pointer-events: none;
    }

    .hero-left { position: relative; z-index: 1; }

    .hero-eyebrow {
        font-size: 10px; font-weight: 700;
        letter-spacing: 2.5px; text-transform: uppercase;
        color: #C9A96E; margin-bottom: 10px;
        display: flex; align-items: center; gap: 8px;
    }

    .hero-name {
        font-family: 'Playfair Display', serif;
        font-size: 28px; font-weight: 600;
        color: #fff; margin-bottom: 8px; line-height: 1.2;
    }

    .hero-address {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; color: rgba(255,255,255,0.45);
    }

    .hero-address svg { color: #C9A96E; flex-shrink: 0; }

    .hero-stats {
        display: flex; gap: 12px;
        position: relative; z-index: 1;
        flex-wrap: wrap;
    }

    .hero-stat {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 10px;
        padding: 12px 18px;
        text-align: center;
        min-width: 80px;
    }

    .hero-stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #C9A96E; line-height: 1; margin-bottom: 3px;
    }

    .hero-stat-lbl {
        font-size: 10px; color: rgba(255,255,255,0.35);
        letter-spacing: 0.5px; white-space: nowrap;
    }

    /* ── Action buttons ── */
    .page-actions {
        display: flex; gap: 10px;
        margin-bottom: 24px; flex-wrap: wrap;
    }

    .btn-edit {
        display: inline-flex; align-items: center; gap: 7px;
        height: 38px; padding: 0 18px;
        background: #1A1A2E; color: #C9A96E;
        border: 1px solid #C9A96E; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; transition: all 0.2s;
    }
    .btn-edit:hover { background: #C9A96E; color: #1A1A2E; }

    .btn-add-apt {
        display: inline-flex; align-items: center; gap: 7px;
        height: 38px; padding: 0 18px;
        background: transparent; color: #1A1A2E;
        border: 1.5px solid #E5E3DF; border-radius: 8px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        text-decoration: none; transition: all 0.2s;
    }
    .btn-add-apt:hover { border-color: #C9A96E; color: #C9A96E; }

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
        width: 30px; height: 30px;
        background: #F8F7F5; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .card-icon svg { color: #C9A96E; }

    .card-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .card-count {
        font-size: 11px; color: #8B8FA8;
        background: #F8F7F5; padding: 2px 8px;
        border-radius: 20px;
    }

    .card-body { padding: 20px 22px; }

    /* ── Info grid ── */
    .info-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } }

    .info-item {}
    .info-item-lbl {
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #8B8FA8; margin-bottom: 5px;
    }
    .info-item-val {
        font-size: 14px; font-weight: 600; color: #1A1A2E;
    }

    /* ── Occupancy bar ── */
    .occ-wrap { margin-top: 16px; }
    .occ-label {
        display: flex; justify-content: space-between;
        font-size: 12px; margin-bottom: 6px;
    }
    .occ-label span:first-child { color: #6B7280; }
    .occ-label span:last-child  { font-weight: 700; color: #1A1A2E; }

    .occ-track {
        height: 6px; background: #F0EEEB;
        border-radius: 10px; overflow: hidden;
    }
    .occ-fill {
        height: 100%; border-radius: 10px;
        background: linear-gradient(90deg, #C9A96E, #D4B87A);
        transition: width 0.6s ease;
    }

    /* ── Apartments table ── */
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 10px 16px; text-align: left;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #8B8FA8; background: #F8F7F5;
        border-bottom: 1px solid #EEECEA;
    }
    tbody tr { border-bottom: 1px solid #F5F3F1; transition: background 0.12s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FAFAF9; }
    tbody td {
        padding: 12px 16px; font-size: 13px;
        color: #1A1A2E; vertical-align: middle;
    }

    .apt-num {
        font-family: 'Courier New', monospace;
        font-size: 13px; font-weight: 700;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 5px; padding: 2px 8px; letter-spacing: 1px;
    }

    .type-tag {
        background: #EFF6FF; color: #2563EB;
        font-size: 11px; font-weight: 600;
        padding: 2px 8px; border-radius: 20px; display: inline-block;
    }

    .rent-val { font-weight: 600; }
    .rent-cur { font-size: 11px; color: #8B8FA8; margin-left: 1px; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 3px 9px; border-radius: 20px;
    }
    .status-badge .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .s-occ { background: #ECFDF5; color: #059669; }
    .s-vac { background: #FEF3C7; color: #D97706; }
    .s-trv { background: #FEF2F2; color: #DC2626; }
    .s-def { background: #F3F4F6; color: #6B7280; }

    .act-btn {
        width: 28px; height: 28px; border: none;
        border-radius: 6px; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.15s; text-decoration: none;
    }
    .act-edit { background: #FEF3C7; color: #D97706; }
    .act-edit:hover { background: #FDE68A; }

    .empty-row td {
        padding: 40px; text-align: center;
        color: #8B8FA8; font-size: 13px;
    }

    /* ── Sidebar ── */
    .side-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 12px; overflow: hidden;
        margin-bottom: 14px;
    }
    .side-head {
        padding: 13px 18px; border-bottom: 1px solid #EEECEA;
        font-size: 12px; font-weight: 700; color: #1A1A2E;
    }
    .side-body { padding: 16px 18px; }

    .meta-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: 8px 0; border-bottom: 1px solid #F5F3F1;
        font-size: 12px; gap: 10px;
    }
    .meta-row:last-child { border-bottom: none; padding-bottom: 0; }
    .meta-lbl { color: #8B8FA8; flex-shrink: 0; }
    .meta-val { font-weight: 600; color: #1A1A2E; text-align: right; word-break: break-word; }

    /* Mini floor viz */
    .floor-mini {
        display: flex; flex-direction: column-reverse; gap: 3px;
        margin-bottom: 8px;
    }
    .floor-mini-bar {
        height: 10px; border-radius: 3px;
        background: linear-gradient(90deg, #C9A96E, #D4B87A);
        align-self: center;
    }
    .floor-mini-lbl { font-size: 11px; color: #8B8FA8; text-align: center; }

    /* Danger */
    .danger-zone {
        background: #FEF2F2; border: 1px solid #FEE2E2;
        border-radius: 12px; padding: 14px 16px;
    }
    .danger-title { font-size: 11px; font-weight: 700; color: #991B1B; margin-bottom: 4px; }
    .danger-desc  { font-size: 11px; color: #B91C1C; line-height: 1.5; margin-bottom: 10px; }
    .btn-danger {
        width: 100%; height: 34px;
        background: transparent; color: #DC2626;
        border: 1.5px solid #DC2626; border-radius: 7px;
        font-size: 11px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 5px;
        transition: all 0.2s;
    }
    .btn-danger:hover { background: #DC2626; color: #fff; }
</style>

{{-- ══ HERO ══ --}}
<div class="building-hero">
    <div class="hero-left">
        <div class="hero-eyebrow">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
            Immeuble
        </div>
        <div class="hero-name">{{ $building->name }}</div>
        <div class="hero-address">
            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            {{ $building->address }}
        </div>
    </div>

    @php
        $apartments  = $building->apartments ?? collect();
        $totalApts   = $apartments->count();
        $occupied    = $apartments->where('status', 'occupé')->count();
        $vacant      = $apartments->where('status', 'vacant')->count();
        $totalRent   = $apartments->sum('rent_amount');
        $occRate     = $totalApts > 0 ? round(($occupied / $totalApts) * 100) : 0;
    @endphp

    <div class="hero-stats">
        <div class="hero-stat">
            <div class="hero-stat-val">{{ $totalApts }}</div>
            <div class="hero-stat-lbl">Appartements</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">{{ $occupied }}</div>
            <div class="hero-stat-lbl">Occupés</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">{{ $building->floors }}</div>
            <div class="hero-stat-lbl">Étages</div>
        </div>
        <div class="hero-stat">
            <div class="hero-stat-val">{{ $occRate }}%</div>
            <div class="hero-stat-lbl">Taux occup.</div>
        </div>
    </div>
</div>

{{-- ══ ACTIONS ══ --}}
<div class="page-actions">
    <a href="{{ route('buildings.edit', $building->id) }}" class="btn-edit">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Modifier l'immeuble
    </a>
    <a href="{{ route('manager.apartments.create') }}?building_id={{ $building->id }}" class="btn-add-apt">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un appartement
    </a>
</div>

{{-- ══ MAIN LAYOUT ══ --}}
<div class="detail-layout">

    {{-- LEFT — Infos + Table --}}
    <div>

        {{-- Informations générales --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="card-title">Informations générales</span>
                </div>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-item-lbl">Nom</div>
                        <div class="info-item-val">{{ $building->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-lbl">Adresse</div>
                        <div class="info-item-val">{{ $building->address }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-lbl">Nombre d'étages</div>
                        <div class="info-item-val">{{ $building->floors }} étage(s)</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-lbl">Date de création</div>
                        <div class="info-item-val">{{ $building->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-lbl">Loyer total / mois</div>
                        <div class="info-item-val" style="color:#C9A96E;">
                            {{ number_format($totalRent, 0, ',', ' ') }} FCFA
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-item-lbl">Loyer moyen</div>
                        <div class="info-item-val">
                            {{ $totalApts > 0 ? number_format($totalRent / $totalApts, 0, ',', ' ') : '—' }} FCFA
                        </div>
                    </div>
                </div>

                {{-- Occupancy bar --}}
                <div class="occ-wrap">
                    <div class="occ-label">
                        <span>Taux d'occupation</span>
                        <span>{{ $occupied }} / {{ $totalApts }} appartements</span>
                    </div>
                    <div class="occ-track">
                        <div class="occ-fill" style="width: {{ $occRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Appartements --}}
        <div class="card">
            <div class="card-head">
                <div class="card-head-left">
                    <div class="card-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="card-title">Appartements</span>
                    <span class="card-count">{{ $totalApts }}</span>
                </div>
                <a href="{{ route('manager.apartments.create') }}?building_id={{ $building->id }}"
                   style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:#C9A96E;text-decoration:none;">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter
                </a>
            </div>

            @if($apartments->isEmpty())
                <div style="text-align:center;padding:48px 20px;">
                    <div style="width:48px;height:48px;background:#F8F7F5;border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                        <svg width="22" height="22" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:#1A1A2E;margin-bottom:4px;">Aucun appartement</div>
                    <div style="font-size:12px;color:#8B8FA8;">Ajoutez le premier appartement de cet immeuble.</div>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Type</th>
                                <th>Loyer</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($apartments as $apt)
                                @php
                                    $st = strtolower($apt->status ?? '');
                                    $sc = match(true) {
                                        str_contains($st, 'occup')   => 's-occ',
                                        str_contains($st, 'vacant')  => 's-vac',
                                        str_contains($st, 'travaux') => 's-trv',
                                        default                      => 's-def',
                                    };
                                @endphp
                                <tr>
                                    <td><span class="apt-num">{{ $apt->number }}</span></td>
                                    <td><span class="type-tag">{{ $apt->type }}</span></td>
                                    <td>
                                        <span class="rent-val">{{ number_format($apt->rent_amount, 0, ',', ' ') }}</span>
                                        <span class="rent-cur">FCFA</span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $sc }}">
                                            <span class="dot"></span>
                                            {{ ucfirst($apt->status ?? '—') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('manager.apartments.edit', $apt->id) }}"
                                           class="act-btn act-edit" title="Modifier">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    {{-- RIGHT — Sidebar --}}
    <div>

        {{-- Résumé --}}
        <div class="side-card">
            <div class="side-head">📊 Résumé</div>
            <div class="side-body">
                <div class="meta-row">
                    <span class="meta-lbl">Total appartements</span>
                    <span class="meta-val">{{ $totalApts }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Occupés</span>
                    <span class="meta-val" style="color:#059669;">{{ $occupied }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Vacants</span>
                    <span class="meta-val" style="color:#D97706;">{{ $vacant }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">En travaux</span>
                    <span class="meta-val" style="color:#DC2626;">
                        {{ $apartments->where('status', 'en travaux')->count() }}
                    </span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Revenus / mois</span>
                    <span class="meta-val" style="color:#C9A96E;">
                        {{ number_format($totalRent, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Taux d'occupation</span>
                    <span class="meta-val">{{ $occRate }}%</span>
                </div>
            </div>
        </div>

        {{-- Étages --}}
        <div class="side-card">
            <div class="side-head">🏢 Structure</div>
            <div class="side-body">
                @php $floors = min((int) $building->floors, 8); @endphp
                <div class="floor-mini">
                    @for($i = 0; $i < 8; $i++)
                        @php $w = 55 + ((8 - $i - 1) / 8) * 35; @endphp
                        <div class="floor-mini-bar"
                             style="width:{{ $w }}%;opacity:{{ $i < $floors ? '1' : '0.12' }}">
                        </div>
                    @endfor
                </div>
                <div class="floor-mini-lbl">{{ $building->floors }} étage(s)</div>
            </div>
        </div>

        {{-- Dates --}}
        <div class="side-card">
            <div class="side-head">🗓 Historique</div>
            <div class="side-body">
                <div class="meta-row">
                    <span class="meta-lbl">Créé le</span>
                    <span class="meta-val">{{ $building->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-lbl">Modifié le</span>
                    <span class="meta-val">{{ $building->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Danger --}}
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zone de danger</div>
            <div class="danger-desc">
                Suppression définitive. Tous les appartements liés seront aussi supprimés.
            </div>
            <form method="POST" action="{{ route('buildings.destroy', $building->id) }}"
                  onsubmit="return confirm('Supprimer définitivement « {{ addslashes($building->name) }} » et tous ses appartements ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer cet immeuble
                </button>
            </form>
        </div>

    </div>
</div>
@endsection