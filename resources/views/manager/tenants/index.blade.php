@extends('layouts.app')

@section('page-title', 'Locataires')

@section('breadcrumb')
    <span>Accueil</span> / <span>Locataires</span>
@endsection

@section('content')
<style>
    /* ── Header ── */
    .pg-header {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 28px; flex-wrap: wrap; gap: 16px;
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
        padding: 10px 20px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: all 0.2s;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-add:hover { background: #C9A96E; color: #1A1A2E; }

    /* ── Stats ── */
    .stats-row {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    @media (max-width: 768px) { .stats-row { grid-template-columns: 1fr 1fr; } }

    .stat-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 12px; padding: 18px 20px;
        display: flex; align-items: center; gap: 14px;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(13,17,23,0.06); }
    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 24px; font-weight: 600;
        color: #1A1A2E; line-height: 1; margin-bottom: 2px;
    }
    .stat-lbl { font-size: 11px; color: #8B8FA8; }

    /* ── Table card ── */
    .table-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 14px; overflow: hidden;
    }
    .table-top {
        padding: 16px 24px; border-bottom: 1px solid #EEECEA;
        display: flex; align-items: center;
        justify-content: space-between; gap: 12px; flex-wrap: wrap;
    }
    .table-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .count-pill {
        font-size: 12px; color: #8B8FA8;
        background: #F8F7F5; padding: 3px 10px; border-radius: 20px;
    }

    .search-wrap { position: relative; }
    .search-ico {
        position: absolute; left: 10px; top: 50%;
        transform: translateY(-50%); color: #8B8FA8; pointer-events: none;
    }
    .search-input {
        height: 36px; background: #F8F7F5;
        border: 1px solid #E5E3DF; border-radius: 8px;
        padding: 0 12px 0 34px; font-size: 13px;
        font-family: 'DM Sans', sans-serif; color: #1A1A2E;
        outline: none; width: 210px; transition: border-color 0.2s;
    }
    .search-input:focus { border-color: #C9A96E; background: #fff; }
    .search-input::placeholder { color: #B0ACA8; }

    /* ── Table ── */
    table { width: 100%; border-collapse: collapse; }
    thead th {
        padding: 11px 18px; text-align: left;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #8B8FA8; background: #F8F7F5;
        border-bottom: 1px solid #EEECEA; white-space: nowrap;
    }
    tbody tr { border-bottom: 1px solid #F5F3F1; transition: background 0.12s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FAFAF9; }
    tbody td { padding: 13px 18px; font-size: 13px; color: #1A1A2E; vertical-align: middle; }

    /* ── Cells ── */
    .tenant-cell { display: flex; align-items: center; gap: 10px; }
    .tenant-avatar {
        width: 34px; height: 34px; border-radius: 9px;
        background: #1A1A2E; color: #C9A96E;
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; flex-shrink: 0;
        font-family: 'DM Sans', sans-serif; letter-spacing: 0.5px;
    }
    .tenant-name { font-weight: 600; color: #1A1A2E; font-size: 13px; }
    .tenant-since { font-size: 10px; color: #8B8FA8; margin-top: 1px; }

    .email-cell {
        display: flex; align-items: center; gap: 6px;
        color: #4B5563; font-size: 12px;
    }
    .email-cell svg { color: #C9A96E; flex-shrink: 0; }

    .apt-cell { display: flex; align-items: center; gap: 6px; }
    .apt-dot  { width: 8px; height: 8px; background: #C9A96E; border-radius: 2px; flex-shrink: 0; }
    .apt-num {
        font-family: 'Courier New', monospace;
        font-size: 12px; font-weight: 700;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 5px; padding: 2px 8px; letter-spacing: 1px;
    }
    .no-apt { color: #C4C0BB; font-size: 12px; }

    .phone-cell {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #6B7280;
    }
    .phone-cell svg { color: #8B8FA8; flex-shrink: 0; }

    /* Status tenant */
    .tenant-status {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 600;
        padding: 3px 9px; border-radius: 20px;
    }
    .tenant-status .dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .ts-active   { background: #ECFDF5; color: #059669; }
    .ts-inactive { background: #F3F4F6; color: #6B7280; }

    /* Actions */
    .actions { display: flex; gap: 6px; }
    .act-btn {
        width: 30px; height: 30px; border: none; border-radius: 7px;
        cursor: pointer; display: inline-flex; align-items: center;
        justify-content: center; transition: all 0.15s; text-decoration: none;
    }
    .act-view { background: #F0F9FF; color: #0369A1; }
    .act-view:hover { background: #E0F2FE; }
    .act-edit { background: #FEF3C7; color: #D97706; }
    .act-edit:hover { background: #FDE68A; }
    .act-del  { background: #FEF2F2; color: #DC2626; }
    .act-del:hover  { background: #FEE2E2; }

    /* Empty */
    .empty-state { text-align: center; padding: 64px 20px; }
    .empty-ico {
        width: 56px; height: 56px; background: #F8F7F5; border-radius: 14px;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
    }
    .empty-title { font-size: 15px; font-weight: 700; color: #1A1A2E; margin-bottom: 6px; }
    .empty-sub   { font-size: 13px; color: #8B8FA8; margin-bottom: 20px; }

    /* Flash */
    .flash {
        display: flex; align-items: center; gap: 8px;
        padding: 12px 16px; border-radius: 10px;
        font-size: 13px; margin-bottom: 20px;
    }
    .flash.ok { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
</style>

@if(session('success'))
<div class="flash ok">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- ── Header ── --}}
<div class="pg-header">
    <div>
        <div class="pg-title">Locataires</div>
        <div class="pg-sub">Gérez tous les locataires de votre portefeuille</div>
    </div>
    <a href="{{ route('manager.tenants.create') }}" class="btn-add">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un locataire
    </a>
</div>

{{-- ── Stats ── --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;">
            <svg width="20" height="20" fill="none" stroke="#2563EB" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $tenants->count() }}</div>
            <div class="stat-lbl">Total locataires</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ECFDF5;">
            <svg width="20" height="20" fill="none" stroke="#059669" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $tenants->filter(fn($t) => $t->apartment)->count() }}</div>
            <div class="stat-lbl">Avec appartement</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;">
            <svg width="20" height="20" fill="none" stroke="#D97706" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $tenants->filter(fn($t) => !$t->apartment)->count() }}</div>
            <div class="stat-lbl">Sans logement</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF8EE;">
            <svg width="20" height="20" fill="none" stroke="#C9A96E" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $tenants->filter(fn($t) => $t->created_at->isCurrentMonth())->count() }}</div>
            <div class="stat-lbl">Ce mois</div>
        </div>
    </div>
</div>

{{-- ── Table ── --}}
<div class="table-card">
    <div class="table-top">
        <div style="display:flex;align-items:center;gap:10px;">
            <span class="table-title">Liste des locataires</span>
            <span class="count-pill">{{ $tenants->count() }}</span>
        </div>
        <div class="search-wrap">
            <svg class="search-ico" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher…">
        </div>
    </div>

    @if($tenants->isEmpty())
        <div class="empty-state">
            <div class="empty-ico">
                <svg width="24" height="24" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="empty-title">Aucun locataire</div>
            <div class="empty-sub">Ajoutez votre premier locataire pour commencer.</div>
            <a href="{{ route('manager.tenants.create') }}" class="btn-add" style="display:inline-flex;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter
            </a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table id="tenantsTable">
                <thead>
                    <tr>
                        <th>Locataire</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Appartement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tenants as $tenant)
                    <tr>
                        {{-- Nom + avatar ── --}}
                        <td>
                            <div class="tenant-cell">
                                <div class="tenant-avatar">
                                    {{ strtoupper(substr($tenant->name, 0, 1)) }}{{ strtoupper(substr(strstr($tenant->name, ' ') ?: $tenant->name, 1, 1)) }}
                                </div>
                                <div>
                                    <div class="tenant-name">{{ $tenant->name }}</div>
                                    <div class="tenant-since">Depuis {{ $tenant->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Email ── --}}
                        <td>
                            <div class="email-cell">
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $tenant->email }}
                            </div>
                        </td>

                        {{-- Téléphone ── --}}
                        <td>
                            @if(!empty($tenant->phone))
                                <div class="phone-cell">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $tenant->phone }}
                                </div>
                            @else
                                <span class="no-apt">—</span>
                            @endif
                        </td>

                        {{-- Appartement ── --}}
                        <td>
                            @if($tenant->apartment)
                                <div class="apt-cell">
                                    <div class="apt-dot"></div>
                                    <span class="apt-num">{{ $tenant->apartment->number }}</span>
                                    <span style="font-size:11px;color:#8B8FA8;">
                                        {{ $tenant->apartment->building->name ?? '' }}
                                    </span>
                                </div>
                            @else
                                <span class="no-apt">Non assigné</span>
                            @endif
                        </td>

                        {{-- Statut ── --}}
                        <td>
                            @if($tenant->apartment)
                                <span class="tenant-status ts-active">
                                    <span class="dot"></span>
                                    Actif
                                </span>
                            @else
                                <span class="tenant-status ts-inactive">
                                    <span class="dot"></span>
                                    Inactif
                                </span>
                            @endif
                        </td>

                        {{-- Actions ── --}}
                        <td>
                            <div class="actions">
                                @if(Route::has('manager.tenants.show'))
                                <a href="{{ route('manager.tenants.show', $tenant->id) }}"
                                   class="act-btn act-view" title="Voir">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @endif
                                <a href="{{ route('manager.tenants.edit', $tenant->id) }}"
                                   class="act-btn act-edit" title="Modifier">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                  <form method="POST"
                                      action="{{ route('manager.tenants.destroy', $tenant->id) }}"
                                      onsubmit="return confirm('Supprimer {{ addslashes($tenant->name) }} ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="act-btn act-del" title="Supprimer">
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
        </div>
    @endif
</div>

<script>
    document.getElementById('searchInput')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tenantsTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>
@endsection