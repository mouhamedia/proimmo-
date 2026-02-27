@extends('layouts.app')

@section('page-title', 'Appartements')

@section('breadcrumb')
    <span>Accueil</span> / <span>Appartements</span>
@endsection

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title-text {
        font-family: 'Playfair Display', serif;
        font-size: 22px;
        font-weight: 600;
        color: #1A1A2E;
        margin-bottom: 4px;
    }
    .page-sub { font-size: 13px; color: #8B8FA8; }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #1A1A2E;
        color: #C9A96E;
        border: 1px solid #C9A96E;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-add:hover { background: #C9A96E; color: #1A1A2E; }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    @media (max-width: 768px) { .stats-row { grid-template-columns: 1fr 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(13,17,23,0.06); }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 24px;
        font-weight: 600;
        color: #1A1A2E;
        line-height: 1;
        margin-bottom: 2px;
    }
    .stat-lbl { font-size: 11px; color: #8B8FA8; }

    /* Table card */
    .table-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 14px;
        overflow: hidden;
    }
    .table-card-top {
        padding: 16px 24px;
        border-bottom: 1px solid #EEECEA;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .table-card-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .apt-count {
        font-size: 12px; color: #8B8FA8;
        background: #F8F7F5;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .search-wrap { position: relative; }
    .search-icon {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%);
        color: #8B8FA8; pointer-events: none;
    }
    .search-input {
        height: 36px;
        background: #F8F7F5;
        border: 1px solid #E5E3DF;
        border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 13px;
        font-family: 'DM Sans', sans-serif;
        color: #1A1A2E;
        outline: none;
        width: 200px;
        transition: border-color 0.2s;
    }
    .search-input:focus { border-color: #C9A96E; background: #fff; }
    .search-input::placeholder { color: #B0ACA8; }

    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 11px 20px;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #8B8FA8;
        background: #F8F7F5;
        border-bottom: 1px solid #EEECEA;
        white-space: nowrap;
    }
    tbody tr {
        border-bottom: 1px solid #F5F3F1;
        transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FAFAF9; }
    tbody td {
        padding: 13px 20px;
        font-size: 13px;
        color: #1A1A2E;
        vertical-align: middle;
    }

    /* Cells */
    .apt-num {
        font-family: 'Courier New', monospace;
        font-size: 14px;
        font-weight: 700;
        background: #F8F7F5;
        border: 1px solid #E5E3DF;
        border-radius: 6px;
        padding: 3px 10px;
        letter-spacing: 1px;
        display: inline-block;
    }
    .type-tag {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
    }
    .rent-val { font-weight: 600; }
    .rent-cur { font-size: 11px; color: #8B8FA8; margin-left: 2px; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .status-badge.occupied  { background: #ECFDF5; color: #059669; }
    .status-badge.vacant    { background: #FEF3C7; color: #D97706; }
    .status-badge.work      { background: #FEF2F2; color: #DC2626; }
    .status-badge.default   { background: #F3F4F6; color: #6B7280; }

    .building-cell { display: flex; align-items: center; gap: 6px; }
    .building-dot  { width: 8px; height: 8px; background: #C9A96E; border-radius: 2px; flex-shrink: 0; }

    .actions { display: flex; gap: 6px; }
    .act-btn {
        width: 30px; height: 30px;
        border: none; border-radius: 7px;
        cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.15s;
        text-decoration: none;
    }
    .act-btn.edit   { background: #FEF3C7; color: #D97706; }
    .act-btn.edit:hover { background: #FDE68A; }
    .act-btn.del    { background: #FEF2F2; color: #DC2626; }
    .act-btn.del:hover { background: #FEE2E2; }

    /* Empty */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-icon {
        width: 56px; height: 56px;
        background: #F8F7F5; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .empty-title { font-size: 15px; font-weight: 700; color: #1A1A2E; margin-bottom: 6px; }
    .empty-sub   { font-size: 13px; color: #8B8FA8; margin-bottom: 20px; }

    /* Flash */
    .flash {
        display: flex; align-items: center; gap: 8px;
        padding: 12px 16px; border-radius: 10px;
        font-size: 13px; margin-bottom: 20px;
    }
    .flash.ok  { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
    .flash.err { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }
</style>

@if(session('success'))
<div class="flash ok">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="page-header">
    <div>
        <div class="page-title-text">Appartements</div>
        <div class="page-sub">Gérez tous les appartements de votre portefeuille</div>
    </div>
    <a href="{{ route('manager.apartments.create') }}" class="btn-add">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un appartement
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;">
            <svg width="20" height="20" fill="none" stroke="#2563EB" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $apartments->count() }}</div>
            <div class="stat-lbl">Total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;">
            <svg width="20" height="20" fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $apartments->where('status', 'occupé')->count() }}</div>
            <div class="stat-lbl">Occupés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;">
            <svg width="20" height="20" fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $apartments->where('status', 'vacant')->count() }}</div>
            <div class="stat-lbl">Vacants</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF8EE;">
            <svg width="20" height="20" fill="none" stroke="#C9A96E" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($apartments->sum('rent_amount') / 1000, 0) }}k</div>
            <div class="stat-lbl">FCFA / mois</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-card-top">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="table-card-title">Liste des appartements</div>
            <span class="apt-count">{{ $apartments->count() }}</span>
        </div>
        <div class="search-wrap">
            <svg class="search-icon" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher…">
        </div>
    <div style="overflow-x:auto; width:100%;">
    <table id="aptTable" style="min-width:500px; width:100%; background:#fff; border-radius:12px; overflow:hidden; border:1px solid #EEECEA;">

    @if($apartments->isEmpty())
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="24" height="24" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div class="empty-title">Aucun appartement</div>
        <div class="empty-sub">Commencez par ajouter votre premier appartement.</div>
        <a href="{{ route('manager.apartments.create') }}" class="btn-add">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Ajouter
        </a>
    </div>
    @else
    <table id="aptTable">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Type</th>
                <th>Loyer mensuel</th>
                <th>Statut</th>
                <th>Immeuble</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($apartments as $apartment)
            @php
                $st = strtolower($apartment->status);
                $stClass = match(true) {
                    str_contains($st, 'occup') => 'occupied',
                    str_contains($st, 'vacant') => 'vacant',
                    str_contains($st, 'travaux') => 'work',
                    default => 'default'
                };
            @endphp
            <tr>
                <td><span class="apt-num">{{ $apartment->number }}</span></td>
                <td><span class="type-tag">{{ $apartment->type }}</span></td>
                <td>
                    <span class="rent-val">{{ number_format($apartment->rent_amount, 0, ',', ' ') }}</span>
                    <span class="rent-cur">FCFA</span>
                </td>
                <td>
                    <span class="status-badge {{ $stClass }}">
                        <span class="dot"></span>
                        {{ ucfirst($apartment->status) }}
                    </span>
                </td>
                <td>
                    <div class="building-cell">
                        <div class="building-dot"></div>
                        <span style="color:#4B5563;">{{ $apartment->building->name ?? '—' }}</span>
                    </div>
                </td>
                <td>
                    <div class="actions">
                        <a href="{{ route('manager.apartments.edit', $apartment->id) }}" class="act-btn edit" title="Modifier">
                            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('manager.apartments.destroy', $apartment->id) }}"
                              onsubmit="return confirm('Supprimer l\'appartement {{ addslashes($apartment->number) }} ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn del" title="Supprimer">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
        </div>
        <style>
            @media (max-width: 700px) {
                .container { padding: 0 4px; }
                table { font-size: 13px; }
                th, td { padding: 8px 6px !important; }
                h2, .page-title-text { font-size: 1.1rem !important; }
            }
        </style>
    @endif
</div>

<script>
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#aptTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection