@extends('layouts.app')

@section('page-title', 'Appartements')

@section('breadcrumb')
    <span>Accueil</span> / <span>Appartements</span>
@endsection

@section('content')
<style>
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

    /* Stats */
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

    /* Table card */
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

    /* Cells */
    .apt-num {
        font-family: 'Courier New', monospace;
        font-size: 13px; font-weight: 700;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 6px; padding: 3px 9px;
        letter-spacing: 1px; display: inline-block;
    }

    .code-pill {
        font-family: 'Courier New', monospace;
        font-size: 12px; font-weight: 700; letter-spacing: 2px;
        color: #1A1A2E; background: #FDFAF4;
        border: 1px dashed #C9A96E; border-radius: 5px;
        padding: 3px 9px; cursor: pointer;
        display: inline-flex; align-items: center; gap: 5px;
        transition: all 0.15s; user-select: all;
    }
    .code-pill:hover { background: #1A1A2E; color: #C9A96E; border-color: #1A1A2E; border-style: solid; }
    .code-pill:hover .copy-ico { opacity: 1; }
    .copy-ico { width: 10px; opacity: 0.3; flex-shrink: 0; transition: opacity 0.15s; }
    .no-code { color: #C4C0BB; }

    .type-tag {
        background: #EFF6FF; color: #2563EB;
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 20px; display: inline-block;
    }

    .rent-val { font-weight: 600; }
    .rent-cur { font-size: 11px; color: #8B8FA8; margin-left: 2px; }

    .bld-cell { display: flex; align-items: center; gap: 6px; }
    .bld-dot  { width: 8px; height: 8px; background: #C9A96E; border-radius: 2px; flex-shrink: 0; }

    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; font-weight: 600;
        padding: 4px 10px; border-radius: 20px; white-space: nowrap;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .s-occ  { background: #ECFDF5; color: #059669; }
    .s-vac  { background: #FEF3C7; color: #D97706; }
    .s-trv  { background: #FEF2F2; color: #DC2626; }
    .s-def  { background: #F3F4F6; color: #6B7280; }

    .actions { display: flex; gap: 6px; }
    .act-btn {
        width: 30px; height: 30px; border: none; border-radius: 7px;
        cursor: pointer; display: inline-flex; align-items: center;
        justify-content: center; transition: all 0.15s; text-decoration: none;
    }
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

    /* Toast */
    .toast {
        position: fixed; bottom: 24px; right: 24px;
        background: #1A1A2E; color: #C9A96E;
        font-size: 13px; font-weight: 600;
        padding: 10px 20px; border-radius: 8px;
        z-index: 9999; opacity: 0; transform: translateY(8px);
        transition: all 0.25s; pointer-events: none;
    }
    .toast.show { opacity: 1; transform: translateY(0); }
</style>

<div class="toast" id="toast">✓ Code copié !</div>

@if(session('success'))
<div class="flash ok">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Header --}}
<div class="pg-header">
    <div>
        <div class="pg-title">Appartements</div>
        <div class="pg-sub">Gérez tous les appartements de votre portefeuille</div>
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
            <div class="stat-val">{{ $apartments->where('status','occupé')->count() }}</div>
            <div class="stat-lbl">Occupés</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF3C7;">
            <svg width="20" height="20" fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $apartments->where('status','vacant')->count() }}</div>
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
    <div class="table-top">
        <div style="display:flex;align-items:center;gap:10px;">
            <span class="table-title">Liste des appartements</span>
            <span class="count-pill">{{ $apartments->count() }}</span>
        </div>
        <div class="search-wrap">
            <svg class="search-ico" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" class="search-input" id="searchInput" placeholder="Rechercher…">
        </div>
    </div>

    @if($apartments->isEmpty())
        <div class="empty-state">
            <div class="empty-ico">
                <svg width="24" height="24" fill="none" stroke="#8B8FA8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="empty-title">Aucun appartement</div>
            <div class="empty-sub">Commencez par ajouter votre premier appartement.</div>
            <a href="{{ route('manager.apartments.create') }}" class="btn-add" style="display:inline-flex;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter
            </a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table id="aptTable">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Code d'accès</th>
                        <th>Type</th>
                        <th>Immeuble</th>
                        <th>Loyer mensuel</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($apartments as $apartment)
                    @php
                        $st = strtolower($apartment->status ?? '');
                        $stClass = match(true) {
                            str_contains($st, 'occup')   => 's-occ',
                            str_contains($st, 'vacant')  => 's-vac',
                            str_contains($st, 'travaux') => 's-trv',
                            default                      => 's-def',
                        };
                    @endphp
                    <tr>
                        <td><span class="apt-num">{{ $apartment->number }}</span></td>

                        <td>
                            @if(!empty($apartment->access_code))
                                <span class="code-pill"
                                      onclick="copyCode('{{ $apartment->access_code }}')"
                                      title="Cliquer pour copier">
                                    {{ $apartment->access_code }}
                                    <svg class="copy-ico" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                            @else
                                <span class="no-code">—</span>
                            @endif
                        </td>

                        <td><span class="type-tag">{{ $apartment->type }}</span></td>

                        <td>
                            <div class="bld-cell">
                                <div class="bld-dot"></div>
                                <span style="color:#4B5563;">{{ $apartment->building->name ?? '—' }}</span>
                            </div>
                        </td>

                        <td>
                            <span class="rent-val">{{ number_format($apartment->rent_amount, 0, ',', ' ') }}</span>
                            <span class="rent-cur">FCFA</span>
                        </td>

                        <td>
                            <span class="status-badge {{ $stClass }}">
                                <span class="dot"></span>
                                {{ ucfirst($apartment->status ?? '—') }}
                            </span>
                        </td>

                        <td>
                            <div class="actions">
                                <a href="{{ route('manager.apartments.edit', $apartment->id) }}"
                                   class="act-btn act-edit" title="Modifier">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form method="POST"
                                      action="{{ route('manager.apartments.destroy', $apartment->id) }}"
                                      onsubmit="return confirm('Supprimer l\'appartement {{ addslashes($apartment->number) }} ?')">
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
                @empty
                    <tr>
                        <td colspan="7" style="padding:32px;text-align:center;color:#8B8FA8;font-size:13px;">
                            Aucun appartement trouvé.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    document.getElementById('searchInput')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#aptTable tbody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    function copyCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            const t = document.getElementById('toast');
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2000);
        });
    }
</script>
@endsection