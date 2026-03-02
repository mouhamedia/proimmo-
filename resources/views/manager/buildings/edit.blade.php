@extends('layouts.app')

@section('page-title', 'Modifier un immeuble')

@section('breadcrumb')
    <a href="{{ route('manager.buildings.index') }}" style="color:#8A8478;text-decoration:none;transition:color 0.2s;font-family:'Syne',sans-serif;font-size:13px;"
       onmouseover="this.style.color='#0F0E0C'" onmouseout="this.style.color='#8A8478'">Immeubles</a>
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

    .form-wrap {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px;
        align-items: start;
        max-width: 960px;
    }
    @media (max-width: 860px) { .form-wrap { grid-template-columns: 1fr; } }

    /* Header */
    .pg-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }
    .pg-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 36px; font-weight: 600;
        color: var(--ink); margin-bottom: 4px; line-height: 1;
    }
    .pg-sub {
        font-family: 'Syne', sans-serif;
        font-size: 12.5px; color: var(--muted);
    }
    .building-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--navy);
        color: var(--gold-lt);
        border: 1px solid var(--gold);
        border-radius: 10px; padding: 10px 16px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px; font-weight: 600;
        flex-shrink: 0;
    }

    /* Main card */
    .fcard {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
    }
    .fcard-head {
        padding: 18px 26px;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 12px;
        background: var(--paper);
    }
    .fcard-icon {
        width: 36px; height: 36px;
        background: var(--navy); border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .fcard-title {
        font-family: 'Syne', sans-serif;
        font-size: 13.5px; font-weight: 700; color: var(--ink);
    }
    .fcard-sub {
        font-family: 'Syne', sans-serif;
        font-size: 11px; color: var(--muted); margin-top: 1px;
    }
    .fcard-body { padding: 26px; }

    /* Fields */
    .field { margin-bottom: 20px; }
    .field:last-child { margin-bottom: 0; }

    .field > label {
        display: block;
        font-family: 'Syne', sans-serif;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: var(--muted); margin-bottom: 8px;
    }
    .req { color: #DC2626; margin-left: 2px; }

    .field input[type="text"],
    .field input[type="number"],
    .field textarea {
        width: 100%;
        height: 46px;
        background: var(--paper);
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 0 14px;
        font-family: 'Syne', sans-serif;
        font-size: 13.5px;
        color: var(--ink);
        outline: none;
        transition: all 0.2s;
    }
    .field input:focus,
    .field textarea:focus {
        border-color: var(--gold);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(184,146,74,0.12);
    }
    .field input::placeholder { color: #C4BFB8; }
    .field-hint {
        font-family: 'Syne', sans-serif;
        font-size: 11px; color: var(--muted); margin-top: 6px;
    }

    /* Error block */
    .err-block {
        background: #FEF2F2; border: 1px solid #FECACA;
        border-radius: 10px; padding: 12px 16px;
        margin-bottom: 20px; list-style: none; margin-left: 0;
    }
    .err-block li {
        font-family: 'Syne', sans-serif;
        color: #DC2626; font-size: 12.5px;
        display: flex; align-items: flex-start; gap: 6px;
    }
    .err-block li::before { content: '✕'; font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    /* Stepper */
    .stepper-wrap {
        display: flex; align-items: center;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        overflow: hidden;
        background: var(--paper);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stepper-wrap:focus-within {
        border-color: var(--gold);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(184,146,74,0.12);
    }
    .stepper-btn {
        width: 46px; height: 46px;
        background: transparent; border: none;
        font-size: 22px; font-weight: 300;
        color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s; flex-shrink: 0;
        font-family: 'Syne', sans-serif;
    }
    .stepper-btn:hover { background: rgba(184,146,74,0.1); color: var(--gold); }
    .stepper-input {
        flex: 1; height: 46px;
        background: transparent !important;
        border: none !important; box-shadow: none !important;
        text-align: center;
        font-family: 'Cormorant Garamond', serif;
        font-size: 22px !important; font-weight: 600 !important;
        color: var(--ink);
        outline: none; padding: 0 !important; min-width: 0;
    }

    /* Actions */
    .form-actions {
        display: flex; gap: 10px; align-items: center;
        padding: 18px 26px;
        border-top: 1px solid var(--border);
        background: var(--paper);
    }
    .btn-save {
        height: 42px;
        background: var(--navy); color: var(--gold-lt);
        border: 1px solid var(--gold); border-radius: 10px;
        padding: 0 22px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px; font-weight: 600;
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-save:hover { background: var(--gold); color: var(--navy); }
    .btn-cancel {
        height: 42px;
        background: transparent; color: var(--muted);
        border: 1.5px solid var(--border); border-radius: 10px;
        padding: 0 18px;
        font-family: 'Syne', sans-serif;
        font-size: 12.5px; font-weight: 500;
        cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: var(--ink); color: var(--ink); }

    /* Sidebar */
    .side-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden;
        margin-bottom: 16px;
        position: relative;
    }
    .side-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, var(--gold), var(--gold-lt));
    }
    .side-head {
        padding: 14px 18px;
        border-bottom: 1px solid var(--border);
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: var(--muted);
    }
    .side-body { padding: 16px 18px; }

    .info-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: 9px 0; border-bottom: 1px solid #F5F1EC;
        font-size: 12px;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-lbl {
        font-family: 'Syne', sans-serif;
        color: var(--muted); font-size: 11.5px;
    }
    .info-val {
        font-family: 'Syne', sans-serif;
        font-weight: 600; color: var(--ink);
        text-align: right; font-size: 12.5px;
        max-width: 160px; word-break: break-word;
    }

    /* Floor visualizer */
    .floor-viz {
        display: flex; flex-direction: column-reverse; gap: 3px;
        margin-bottom: 10px;
    }
    .floor-bar {
        height: 12px; border-radius: 3px;
        background: linear-gradient(90deg, var(--navy), var(--navy-lt));
        opacity: 0.15;
        transition: all 0.25s;
        align-self: center;
    }
    .floor-bar.active { opacity: 1; background: linear-gradient(90deg, var(--gold), var(--gold-lt)); }
    .floor-label {
        font-family: 'Syne', sans-serif;
        font-size: 11px; color: var(--muted); text-align: center;
        margin-top: 6px;
    }

    /* Danger zone */
    .danger-zone {
        background: #FEF2F2; border: 1px solid #FEE2E2;
        border-radius: 14px; padding: 18px;
    }
    .danger-title {
        font-family: 'Syne', sans-serif;
        font-size: 11px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #991B1B; margin-bottom: 8px;
    }
    .danger-desc {
        font-family: 'Syne', sans-serif;
        font-size: 12px; color: #B91C1C; line-height: 1.5; margin-bottom: 14px;
    }
    .btn-danger {
        width: 100%; height: 38px;
        background: transparent; color: #DC2626;
        border: 1.5px solid #DC2626; border-radius: 8px;
        font-family: 'Syne', sans-serif;
        font-size: 12px; font-weight: 600;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-danger:hover { background: #DC2626; color: #fff; }
</style>

{{-- Page header --}}
<div class="pg-header">
    <div>
        <div class="pg-title">Modifier l'immeuble</div>
        <div class="pg-sub">Mettez à jour les informations de l'immeuble</div>
    </div>
    <div class="building-badge">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        {{ $building->name }}
    </div>
</div>

{{-- ✅ ROUTE CORRIGÉE : manager.buildings.update --}}
<form method="POST" action="{{ route('manager.buildings.update', $building) }}">
@csrf
@method('PUT')

<div class="form-wrap">

    {{-- MAIN CARD --}}
    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="#D4AA6A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <div class="fcard-title">Modifier les informations</div>
                <div class="fcard-sub">Les modifications prennent effet immédiatement</div>
            </div>
        </div>

        <div class="fcard-body">

            @if($errors->any())
                <ul class="err-block">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif

            {{-- Nom --}}
            <div class="field">
                <label>Nom de l'immeuble <span class="req">*</span></label>
                <input type="text" name="name"
                    placeholder="ex: Résidence Les Acacias"
                    value="{{ old('name', $building->name) }}"
                    required>
                <div class="field-hint">Nom unique qui identifie l'immeuble dans votre portefeuille</div>
            </div>

            {{-- Adresse --}}
            <div class="field">
                <label>Adresse <span class="req">*</span></label>
                <input type="text" name="address"
                    placeholder="ex: 14 Rue Carnot, Dakar"
                    value="{{ old('address', $building->address) }}"
                    required>
                <div class="field-hint">Adresse complète avec quartier et ville</div>
            </div>

            {{-- Étages --}}
            <div class="field">
                <label>Nombre d'étages <span class="req">*</span></label>
                <div class="stepper-wrap">
                    <button type="button" class="stepper-btn" onclick="stepFloors(-1)">−</button>
                    <input type="number" name="floors" id="floorsInput"
                        class="stepper-input"
                        value="{{ old('floors', $building->floors) }}"
                        min="1" max="50" required
                        oninput="updateViz(this.value)">
                    <button type="button" class="stepper-btn" onclick="stepFloors(1)">+</button>
                </div>
                <div class="field-hint">Rez-de-chaussée non compris — minimum 1 étage</div>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications
            </button>
            {{-- ✅ ROUTE CORRIGÉE : manager.buildings.index --}}
            <a href="{{ route('manager.buildings.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>
</form>
    {{-- SIDEBAR --}}
    <div>
        {{-- Infos actuelles --}}
        <div class="side-card">
            <div class="side-head">Informations actuelles</div>
            <div class="side-body">
                <div class="info-row">
                    <span class="info-lbl">Nom</span>
                    <span class="info-val">{{ $building->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Adresse</span>
                    <span class="info-val">{{ $building->address ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Étages</span>
                    <span class="info-val">{{ $building->floors }} étage(s)</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Appartements</span>
                    <span class="info-val" style="color:var(--gold);">{{ $building->apartments_count ?? $building->apartments()->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Créé le</span>
                    <span class="info-val">{{ $building->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Floor visualizer --}}
        <div class="side-card">
            <div class="side-head">Aperçu des étages</div>
            <div class="side-body">
                <div class="floor-viz" id="floorViz"></div>
                <div class="floor-label" id="floorLabel"></div>
            </div>
        </div>

        {{-- Danger zone --}}
        {{-- ✅ ROUTE CORRIGÉE : manager.buildings.destroy --}}
        <div class="danger-zone">
            <div class="danger-title">Zone de danger</div>
            <div class="danger-desc">
                La suppression est définitive. Tous les appartements liés seront également supprimés.
            </div>
            <form method="POST" action="{{ route('manager.buildings.destroy', $building) }}"
                  onsubmit="return confirm('Supprimer définitivement l\'immeuble « {{ addslashes($building->name) }} » et tous ses appartements ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer cet immeuble
                </button>
            </form>
        </div>
    </div>

</div>
</form>

<script>
    const MAX_BARS = 8;

    function updateViz(val) {
        const n = Math.max(1, Math.min(50, parseInt(val) || 1));
        const viz = document.getElementById('floorViz');
        const label = document.getElementById('floorLabel');
        viz.innerHTML = '';
        const show = Math.min(n, MAX_BARS);
        for (let i = 0; i < MAX_BARS; i++) {
            const bar = document.createElement('div');
            bar.className = 'floor-bar' + (i < show ? ' active' : '');
            const width = 60 + ((MAX_BARS - i - 1) / MAX_BARS) * 30;
            bar.style.width = width + '%';
            viz.appendChild(bar);
        }
        label.textContent = n + (n > MAX_BARS ? '+ étages (affiché: ' + MAX_BARS + ')' : ' étage' + (n > 1 ? 's' : ''));
    }

    function stepFloors(delta) {
        const input = document.getElementById('floorsInput');
        const next = Math.max(1, Math.min(50, (parseInt(input.value) || 1) + delta));
        input.value = next;
        updateViz(next);
    }

    updateViz(document.getElementById('floorsInput').value);
    document.getElementById('floorsInput').addEventListener('input', function() {
        updateViz(this.value);
    });
</script>
@endsection
