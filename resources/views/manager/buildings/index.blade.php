@extends('layouts.app')

@section('page-title', 'Immeubles')

@section('breadcrumb')
    <span style="color:#1A1A2E;font-weight:600;">Immeubles</span>
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* ── Reset contextuel ── */
    * { box-sizing: border-box; }

    /* ── Variables ── */
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
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-title-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px;
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

    /* ── Bouton ajouter ── */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--navy);
        color: var(--gold-lt);
        border: 1px solid var(--gold);
        border-radius: 10px;
        padding: 11px 22px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
        letter-spacing: 0.02em;
    }
    .btn-add:hover {
        background: var(--gold);
        color: var(--navy);
        border-color: var(--gold);
        box-shadow: 0 4px 20px rgba(184,146,74,0.3);
        transform: translateY(-1px);
    }

    /* ── Stats ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 32px;
    }
    @media (max-width: 768px) { .stats-row { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 480px)  { .stats-row { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow 0.2s, transform 0.2s;
        position: relative;
        overflow: hidden;
    }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--gold), var(--gold-lt));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    .stat-card:hover::before { transform: scaleX(1); }
    .stat-card:hover {
        box-shadow: 0 8px 28px rgba(15,14,12,0.07);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-val {
        font-family: 'Cormorant Garamond', serif;
        font-size: 34px;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 3px;
    }
    .stat-lbl {
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        color: var(--muted);
        letter-spacing: 0.02em;
    }

    /* ── Table card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .table-card-top {
        padding: 18px 26px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        background: #fff;
    }
    .table-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        color: var(--ink);
    }
    .b-count {
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        color: var(--muted);
        background: var(--paper);
        border: 1px solid var(--border);
        padding: 3px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    /* ── Search ── */
    .search-wrap { position: relative; }
    .search-icon {
        position: absolute; left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--muted); pointer-events: none;
    }
    .search-input {
        height: 38px;
        background: var(--paper);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 0 14px 0 36px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px;
        color: var(--ink);
        outline: none;
        width: 220px;
        transition: all 0.2s;
    }
    .search-input:focus {
        border-color: var(--gold);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(184,146,74,0.1);
    }
    .search-input::placeholder { color: #C0B9B0; }

    /* ── Table ── */
    .table-scroll { overflow-x: auto; width: 100%; }

    table { width: 100%; border-collapse: collapse; min-width: 500px; }

    thead th {
        padding: 12px 24px;
        text-align: left;
        font-family: 'Syne', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--muted);
        background: var(--paper);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    tbody tr {
        border-bottom: 1px solid #F2EEE9;
        transition: background 0.15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FDFCFA; }
    tbody td {
        padding: 15px 24px;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        color: var(--ink);
        vertical-align: middle;
    }

    /* ── Building cell ── */
    .building-cell { display: flex; align-items: center; gap: 13px; }
    .building-avatar {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-lt) 100%);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 17px; font-weight: 700;
        color: var(--gold-lt);
        flex-shrink: 0;
    }
    .building-name {
        font-family: 'Syne', sans-serif;
        font-weight: 600;
        color: var(--ink);
        font-size: 13px;
    }
    .building-addr {
        font-family: 'Syne', sans-serif;
        font-size: 11px;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ── Floor badge ── */
    .floor-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #EEF2FF;
        color: #3B5EC6;
        font-family: 'Syne', sans-serif;
        font-size: 11.5px; font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
    }

    /* ── Apt pill ── */
    .apt-pill {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--paper);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 5px 12px;
        font-family: 'Cormorant Garamond', serif;
        font-size: 16px; font-weight: 600;
        color: var(--ink);
    }

    /* ── Actions (garde les classes Bootstrap btn btn-sm) ── */
    .actions { display: flex; gap: 6px; align-items: center; }

    .actions .btn-info {
        display: inline-flex; align-items: center; justify-content: center;
        height: 30px; padding: 0 12px;
        border-radius: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 600;
        background: #EEF2FF; color: #3B5EC6;
        border: 1px solid #C7D4FF;
        text-decoration: none;
        transition: all 0.15s;
    }
    .actions .btn-info:hover { background: #DDE6FF; transform: scale(1.05); }

    .actions .btn-warning {
        display: inline-flex; align-items: center; justify-content: center;
        height: 30px; padding: 0 12px;
        border-radius: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 600;
        background: #FFF7E6; color: #B07A20;
        border: 1px solid #F5D98A;
        text-decoration: none;
        transition: all 0.15s;
    }
    .actions .btn-warning:hover { background: #FEECC0; transform: scale(1.05); }

    .actions .btn-danger {
        display: inline-flex; align-items: center; justify-content: center;
        height: 30px; padding: 0 12px;
        border-radius: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 600;
        background: #FFF1F0; color: #C0392B;
        border: 1px solid #FFCBC9;
        cursor: pointer;
        transition: all 0.15s;
    }
    .actions .btn-danger:hover { background: #FFE0DE; transform: scale(1.05); }

    /* ── Empty state ── */
    .empty-state { text-align: center; padding: 72px 20px; }
    .empty-icon {
        width: 60px; height: 60px;
        background: var(--cream);
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 18px;
    }
    .empty-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px; font-weight: 600;
        color: var(--ink); margin-bottom: 8px;
    }
    .empty-sub {
        font-family: 'Syne', sans-serif;
        font-size: 13px; color: var(--muted); margin-bottom: 24px;
    }

    /* ── Flash ── */
    .flash {
        display: flex; align-items: center; gap: 9px;
        padding: 13px 16px;
        border-radius: 11px;
        font-family: 'Syne', sans-serif;
        font-size: 13px;
        margin-bottom: 24px;
    }
    .flash.ok  { background: #F0FAF4; border: 1px solid #A8DFC0; color: #1A6B3C; }
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

<div class="page-header">
    <div>
        <div class="page-title-text">Immeubles</div>
        <div class="page-sub">Gérez les immeubles de votre résidence</div>
    </div>
    <a href="{{ route('manager.buildings.create') }}" class="btn-add">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter un immeuble
    </a>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EEF2FF;">
            <svg width="20" height="20" fill="none" stroke="#3B5EC6" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->count() }}</div>
            <div class="stat-lbl">Total immeubles</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FAF4;">
            <svg width="20" height="20" fill="none" stroke="#1A8A4C" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->sum(fn($b) => $b->apartments_count ?? 0) }}</div>
            <div class="stat-lbl">Total appartements</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF8EE;">
            <svg width="20" height="20" fill="none" stroke="#B8924A" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $buildings->max('floors') ?? 0 }}</div>
            <div class="stat-lbl">Max étages</div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="table-card">
    <div class="table-card-top">
        <div style="display:flex;align-items:center;gap:10px;">
            <div class="table-card-title">Liste des immeubles</div>
            <span class="b-count">{{ $buildings->count() }}</span>
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
                <svg width="24" height="24" fill="none" stroke="#8A8478" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="empty-title">Aucun immeuble</div>
            <div class="empty-sub">Commencez par ajouter votre premier immeuble.</div>
            <a href="{{ route('manager.buildings.create') }}" class="btn-add">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter
            </a>
        </div>
    @else
        <div class="table-scroll">
            <table id="buildingsTable">
                <thead>
                    <tr>
                        <th>Immeuble</th>
                        <th>Étages</th>
                        <th>Appartements</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buildings as $building)
                    <tr>
                        <td>
                            <div class="building-cell">
                                <div class="building-avatar">
                                    {{ strtoupper(substr($building->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="building-name">{{ $building->name }}</div>
                                    <div class="building-addr">{{ $building->address }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="floor-badge">
                                <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
                                </svg>
                                {{ $building->floors }} étage{{ $building->floors > 1 ? 's' : '' }}
                            </span>
                        </td>
                        <td>
                            <span class="apt-pill">
                                {{ $building->apartments_count ?? $building->apartments()->count() }} appt
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('manager.buildings.show', $building->id) }}" class="btn btn-sm btn-info">Voir</a>
                                <a href="{{ route('manager.buildings.edit', $building->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('manager.buildings.destroy', $building->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet immeuble ?')">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>{{-- fin .table-scroll --}}
    @endif

</div>{{-- fin .table-card --}}

<script>
document.getElementById('searchInput')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#buildingsTable tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
@endsection
