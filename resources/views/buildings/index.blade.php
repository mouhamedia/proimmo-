@extends('layouts.app')

@section('page-title', 'Immeubles')

@section('breadcrumb')
    <span>Accueil</span> / <span>Immeubles</span>
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
    .pg-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

    .btn-add {
        display: inline-flex; align-items: center; gap: 8px;
        background: #1A1A2E; color: #C9A96E;
        border: 1px solid #C9A96E; border-radius: 8px;
        padding: 10px 20px;
        font-size: 13px; font-weight: 600;
        text-decoration: none; font-family: 'DM Sans', sans-serif;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-add:hover { background: #C9A96E; color: #1A1A2E; }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }
    @media (max-width: 640px) { .stats-row { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 12px;
        padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(13,17,23,0.06); }
    .stat-icon {
        width: 42px; height: 42px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 26px; font-weight: 600;
        color: #1A1A2E; line-height: 1; margin-bottom: 2px;
    }
    .stat-lbl { font-size: 11px; color: #8B8FA8; }

    /* Table card */
    .table-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 14px;
        overflow: hidden;
    }
    .table-top {
        padding: 16px 24px;
        border-bottom: 1px solid #EEECEA;
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; flex-wrap: wrap;
    }
    .table-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .count-badge {
        font-size: 12px; color: #8B8FA8;
        background: #F8F7F5; padding: 3px 10px; border-radius: 20px;
    }

    /* Search */
    .search-wrap { position: relative; }
    .search-icon {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%); color: #8B8FA8; pointer-events: none;
    }
    .search-input {
        height: 36px; background: #F8F7F5;
        border: 1px solid #E5E3DF; border-radius: 8px;
        padding: 0 12px 0 34px;
        font-size: 13px; font-family: 'DM Sans', sans-serif;
        color: #1A1A2E; outline: none; width: 210px;
        transition: border-color 0.2s;
    }
    .search-input:focus { border-color: #C9A96E; background: #fff; }
    .search-input::placeholder { color: #B0ACA8; }

    /* Table */
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 11px 22px;
        text-align: left;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #8B8FA8; background: #F8F7F5;
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
        padding: 14px 22px;
        font-size: 13px; color: #1A1A2E;
        vertical-align: middle;
    }

    /* Building name cell */
    .building-name-cell {
        display: flex; align-items: center; gap: 10px;
    }
    .building-avatar {
        width: 34px; height: 34px;
        background: linear-gradient(135deg, #1A1A2E, #2D2D50);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .building-avatar svg { color: #C9A96E; }
    .building-name { font-weight: 600; font-size: 14px; color: #1A1A2E; }
    .building-id   { font-size: 10px; color: #9CA3AF; letter-spacing: 0.5px; }

    /* Address */
    .address-cell { color: #4B5563; max-width: 220px; }
    .address-icon { color: #C9A96E; flex-shrink: 0; }

    /* Floors badge */
    .floors-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 6px; padding: 3px 10px;
        font-size: 12px; font-weight: 600; color: #4B5563;
    }

    /* Apt count */
    .apt-count {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 12px; color: #6B7280;
    }
    .apt-count strong { color: #1A1A2E; font-size: 14px; }

    /* Actions */
    .actions { display: flex; gap: 6px; align-items: center; }
    .act-btn {
        width: 30px; height: 30px;
        border: none; border-radius: 7px;
        cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.15s; text-decoration: none;
    }
    .act-btn.edit   { background: #FEF3C7; color: #D97706; }
    .act-btn.edit:hover { background: #FDE68A; }
    .act-btn.view   { background: #EFF6FF; color: #2563EB; }
    .act-btn.view:hover { background: #DBEAFE; }
    .act-btn.del    { background: #FEF2F2; color: #DC2626; }
    .act-btn.del:hover  { background: #FEE2E2; }

    /* Empty */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-icon {
        width: 56px; height: 56px; background: #F8F7F5;
        border-radius: 14px;
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
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Header --}}
<div class="page-header">
    <div>
        <div class="pg-title">Immeubles</div>
        <div class="pg-sub">Gérez l'ensemble de votre parc immobilier</div>
    </div>
    <a href="{{ route('buildings.create') }}" class="btn-add">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Créer un immeuble
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;">
            <svg width="22" height="22" fill="none" stroke="#2563EB" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->count() }}</div>
            <div class="stat-lbl">Immeubles</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF8EE;">
            <svg width="22" height="22" fill="none" stroke="#C9A96E" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->sum('floors') }}</div>
            <div class="stat-lbl">Étages au total</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;">
            <svg width="22" height="22" fill="none" stroke="#059669" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->sum(fn($b) => $b->apartments_count ?? $b->apartments->count()) }}</div>
            <div class="stat-lbl">Appartements</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-top">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="table-title">Liste des immeubles</div>
            <span class="count-badge">{{ $buildings->count() }}</span>
        </div>
        <div class="search-wrap">
            <svg class="search-icon" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher…">
        </div>
    </div>

    @if($buildings->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="empty-title">Aucun immeuble enregistré</div>
            <div class="empty-sub">Commencez par créer votre premier immeuble.</div>
            <a href="{{ route('buildings.create') }}" class="btn-add" style="display:inline-flex;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Créer un immeuble
            </a>
        </div>
    @else
        <table id="buildTable">
            <thead>
                <tr>
                    <th>Immeuble</th>
                    <th>Adresse</th>
                    <th>Étages</th>
                    <th>Appartements</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buildings as $building)
                <tr>
                    {{-- Name + avatar --}}
                    <td>
                        <div class="building-name-cell">
                            <div class="building-avatar">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <div class="building-name">{{ $building->name }}</div>
                                <div class="building-id">#{{ str_pad($building->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Address --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <svg class="address-icon" width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="address-cell">{{ $building->address }}</span>
                        </div>
                    </td>

                    {{-- Floors --}}
                    <td>
                        <span class="floors-badge">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                            </svg>
                            {{ $building->floors }} étage{{ $building->floors > 1 ? 's' : '' }}
                        </span>
                    </td>

                    {{-- Apartment count --}}
                    <td>
                        <div class="apt-count">
                            <strong>{{ $building->apartments_count ?? $building->apartments->count() }}</strong>
                            <span>appt.</span>
                        </div>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions">
                            @if(Route::has('buildings.show'))
                            <a href="{{ route('buildings.show', $building) }}" class="act-btn view" title="Voir">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('buildings.edit', $building) }}" class="act-btn edit" title="Modifier">
                                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('buildings.destroy', $building) }}"
                                  onsubmit="return confirm('Supprimer l\'immeuble {{ addslashes($building->name) }} ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn del" title="Supprimer">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<script>
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#buildTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

@endsection