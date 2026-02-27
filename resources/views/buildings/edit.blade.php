@extends('layouts.app')

@section('page-title', 'Modifier un immeuble')

@section('breadcrumb')
    <a href="{{ route('buildings.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;"
       onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Immeubles</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">{{ $building->name }}</span>
@endsection

@section('content')
<style>
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
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

    .building-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 8px; padding: 8px 14px;
        font-size: 13px; font-weight: 600; color: #1A1A2E;
        flex-shrink: 0;
    }
    .building-badge svg { color: #C9A96E; }

    /* Main card */
    .fcard {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 14px;
        overflow: hidden;
    }
    .fcard-head {
        padding: 18px 24px;
        border-bottom: 1px solid #EEECEA;
        display: flex; align-items: center; gap: 12px;
    }
    .fcard-icon {
        width: 34px; height: 34px;
        background: #1A1A2E; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .fcard-icon svg { color: #C9A96E; }
    .fcard-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .fcard-sub   { font-size: 11px; color: #8B8FA8; margin-top: 1px; }
    .fcard-body  { padding: 24px; }

    /* Fields */
    .field { margin-bottom: 18px; }
    .field:last-child { margin-bottom: 0; }

    .field-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 18px;
    }
    .field-row .field { margin-bottom: 0; }

    .field > label {
        display: block;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #6B7280; margin-bottom: 7px;
    }
    .req { color: #DC2626; margin-left: 2px; }

    .field input[type="text"],
    .field input[type="number"],
    .field textarea,
    .field select {
        width: 100%;
        height: 46px;
        background: #F8F7F5;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px;
        padding: 0 14px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: #1A1A2E;
        outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }

    .field textarea {
        height: 80px;
        padding: 12px 14px;
        resize: vertical;
    }

    .field input:focus,
    .field textarea:focus,
    .field select:focus {
        border-color: #C9A96E;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }

    .field input::placeholder,
    .field textarea::placeholder { color: #C4C0BB; }

    .field-hint { font-size: 11px; color: #9CA3AF; margin-top: 5px; }

    /* Number input with suffix */
    .input-suffix-wrap { position: relative; }
    .input-suffix-wrap input { padding-right: 64px; }
    .input-suffix {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        font-size: 10px; font-weight: 700;
        color: #9CA3AF; pointer-events: none;
        letter-spacing: 0.5px; white-space: nowrap;
    }

    /* Floors visual stepper */
    .stepper-wrap {
        display: flex; align-items: center; gap: 0;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px;
        overflow: hidden;
        background: #F8F7F5;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stepper-wrap:focus-within {
        border-color: #C9A96E;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }
    .stepper-btn {
        width: 46px; height: 46px;
        background: transparent; border: none;
        font-size: 20px; font-weight: 300;
        color: #8B8FA8; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s; flex-shrink: 0;
        font-family: 'DM Sans', sans-serif;
    }
    .stepper-btn:hover { background: rgba(201,169,110,0.1); color: #C9A96E; }
    .stepper-input {
        flex: 1; height: 46px;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        text-align: center;
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1A1A2E;
        outline: none;
        padding: 0 !important;
        min-width: 0;
    }

    /* Errors */
    .err-block {
        background: #FEF2F2; border: 1px solid #FECACA;
        border-radius: 9px; padding: 12px 16px;
        margin-bottom: 18px; list-style: none;
    }
    .err-block li {
        color: #DC2626; font-size: 13px;
        display: flex; align-items: flex-start; gap: 6px;
    }
    .err-block li::before { content: '✕'; font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    /* Actions */
    .form-actions {
        display: flex; gap: 10px; align-items: center;
        padding: 18px 24px;
        border-top: 1px solid #EEECEA;
        background: #FAFAF8;
    }
    .btn-save {
        height: 42px;
        background: #1A1A2E; color: #C9A96E;
        border: 1px solid #C9A96E; border-radius: 8px;
        padding: 0 22px;
        font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-save:hover { background: #C9A96E; color: #1A1A2E; }
    .btn-cancel {
        height: 42px;
        background: transparent; color: #6B7280;
        border: 1.5px solid #E5E3DF; border-radius: 8px;
        padding: 0 18px;
        font-size: 13px; font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: #1A1A2E; color: #1A1A2E; }

    /* Sidebar */
    .side-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 12px; overflow: hidden;
        margin-bottom: 14px;
    }
    .side-head {
        padding: 14px 18px;
        border-bottom: 1px solid #EEECEA;
        font-size: 12px; font-weight: 700; color: #1A1A2E;
    }
    .side-body { padding: 16px 18px; }

    .info-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 0; border-bottom: 1px solid #F5F3F1;
        font-size: 12px;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-lbl { color: #8B8FA8; }
    .info-val { font-weight: 600; color: #1A1A2E; text-align: right; }

    /* Floor visualizer */
    .floor-viz {
        display: flex; flex-direction: column-reverse; gap: 3px;
        margin-bottom: 12px;
    }
    .floor-bar {
        height: 14px; border-radius: 3px;
        background: linear-gradient(90deg, #C9A96E, #D4B87A);
        opacity: 0.3;
        transition: all 0.3s;
    }
    .floor-bar.active { opacity: 1; }
    .floor-label {
        font-size: 11px; color: #8B8FA8; text-align: center;
        margin-top: 4px;
    }

    /* Danger zone */
    .danger-zone {
        background: #FEF2F2; border: 1px solid #FEE2E2;
        border-radius: 12px; padding: 16px 18px;
    }
    .danger-title { font-size: 12px; font-weight: 700; color: #991B1B; margin-bottom: 6px; }
    .danger-desc  { font-size: 11px; color: #B91C1C; line-height: 1.5; margin-bottom: 12px; }
    .btn-danger {
        width: 100%; height: 36px;
        background: transparent; color: #DC2626;
        border: 1.5px solid #DC2626; border-radius: 7px;
        font-size: 12px; font-weight: 600;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-danger:hover { background: #DC2626; color: #fff; }
</style>

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

<form method="POST" action="{{ route('buildings.update', $building) }}">
@csrf
@method('PUT')

<div class="form-wrap">

    {{-- MAIN CARD --}}
    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <a href="{{ route('buildings.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div>
        {{-- Infos actuelles --}}
        <div class="side-card">
            <div class="side-head">📋 Informations actuelles</div>
            <div class="side-body">
                <div class="info-row">
                    <span class="info-lbl">Nom</span>
                    <span class="info-val">{{ $building->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Adresse</span>
                    <span class="info-val" style="max-width:160px;word-break:break-word;">{{ $building->address }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Étages</span>
                    <span class="info-val">{{ $building->floors }} étage(s)</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Appartements</span>
                    <span class="info-val" style="color:#C9A96E;">{{ $building->apartments_count ?? $building->apartments()->count() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Créé le</span>
                    <span class="info-val">{{ $building->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Floor visualizer --}}
        <div class="side-card">
            <div class="side-head">🏢 Aperçu des étages</div>
            <div class="side-body">
                <div class="floor-viz" id="floorViz">
                    {{-- Généré par JS --}}
                </div>
                <div class="floor-label" id="floorLabel">{{ $building->floors }} étage(s)</div>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zone de danger</div>
            <div class="danger-desc">
                La suppression est définitive. Tous les appartements liés seront également supprimés.
            </div>
            <form method="POST" action="{{ route('buildings.destroy', $building) }}"
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
    const MAX_BARS = 8; // max barres affichées dans le viz

    function updateViz(val) {
        const n = Math.max(1, Math.min(50, parseInt(val) || 1));
        const viz = document.getElementById('floorViz');
        const label = document.getElementById('floorLabel');

        viz.innerHTML = '';
        const show = Math.min(n, MAX_BARS);

        for (let i = 0; i < MAX_BARS; i++) {
            const bar = document.createElement('div');
            bar.className = 'floor-bar' + (i < show ? ' active' : '');
            // Bars get slightly wider at bottom (perspective feel)
            const width = 60 + ((MAX_BARS - i - 1) / MAX_BARS) * 30;
            bar.style.width = width + '%';
            bar.style.alignSelf = 'center';
            viz.appendChild(bar);
        }

        label.textContent = n + (n > MAX_BARS ? '+ étages (affiché: ' + MAX_BARS + ')' : ' étage' + (n > 1 ? 's' : ''));
    }

    function stepFloors(delta) {
        const input = document.getElementById('floorsInput');
        const current = parseInt(input.value) || 1;
        const next = Math.max(1, Math.min(50, current + delta));
        input.value = next;
        updateViz(next);
    }

    // Init on load
    updateViz(document.getElementById('floorsInput').value);
    document.getElementById('floorsInput').addEventListener('input', function() {
        updateViz(this.value);
    });
</script>

@endsection