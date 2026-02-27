@extends('layouts.app')

@section('page-title', 'Créer un immeuble')

@section('breadcrumb')
    <a href="{{ route('buildings.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;"
       onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Immeubles</a>
    &nbsp;/&nbsp;<span>Nouveau</span>
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

    .pg-header { margin-bottom: 28px; }
    .pg-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

    /* Card */
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

    .field > label {
        display: block;
        font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #6B7280; margin-bottom: 7px;
    }
    .req { color: #DC2626; margin-left: 2px; }

    .field input[type="text"] {
        width: 100%; height: 46px;
        background: #F8F7F5;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px;
        padding: 0 14px;
        font-size: 14px;
        font-family: 'DM Sans', sans-serif;
        color: #1A1A2E; outline: none;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    .field input:focus {
        border-color: #C9A96E;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }
    .field input::placeholder { color: #C4C0BB; }
    .field-hint { font-size: 11px; color: #9CA3AF; margin-top: 5px; }

    /* Stepper */
    .stepper-wrap {
        display: flex; align-items: center;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px; overflow: hidden;
        background: #F8F7F5;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stepper-wrap:focus-within {
        border-color: #C9A96E; background: #fff;
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
        background: transparent; border: none;
        text-align: center;
        font-size: 18px; font-weight: 700;
        color: #1A1A2E; outline: none;
        padding: 0; min-width: 0;
        font-family: 'DM Sans', sans-serif;
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

    /* Buttons */
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

    .tip {
        display: flex; align-items: flex-start; gap: 9px;
        margin-bottom: 12px;
        font-size: 12px; color: #4B5563; line-height: 1.5;
    }
    .tip:last-child { margin-bottom: 0; }
    .tip-n {
        width: 18px; height: 18px;
        background: #1A1A2E; color: #C9A96E;
        border-radius: 4px; font-size: 9px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }

    /* Floor viz */
    .floor-viz {
        display: flex; flex-direction: column-reverse; gap: 3px;
        margin-bottom: 10px;
    }
    .floor-bar {
        height: 14px; border-radius: 3px;
        background: linear-gradient(90deg, #C9A96E, #D4B87A);
        opacity: 0.18; transition: all 0.25s;
        align-self: center;
    }
    .floor-bar.active { opacity: 1; }
    .floor-label { font-size: 11px; color: #8B8FA8; text-align: center; }
</style>

<div class="pg-header">
    <div class="pg-title">Nouvel immeuble</div>
    <div class="pg-sub">Remplissez les informations pour créer l'immeuble</div>
</div>

<form method="POST" action="{{ route('buildings.store') }}">
@csrf

<div class="form-wrap">

    {{-- MAIN CARD --}}
    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <div class="fcard-title">Informations de l'immeuble</div>
                <div class="fcard-sub">Nom, adresse et structure</div>
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

            <div class="field">
                <label>Nom de l'immeuble <span class="req">*</span></label>
                <input type="text" name="name"
                    placeholder="ex: Résidence Les Acacias"
                    value="{{ old('name') }}" required>
                <div class="field-hint">Nom unique pour identifier l'immeuble dans votre portefeuille</div>
            </div>

            <div class="field">
                <label>Adresse <span class="req">*</span></label>
                <input type="text" name="address"
                    placeholder="ex: 14 Rue Carnot, Plateau, Dakar"
                    value="{{ old('address') }}" required>
                <div class="field-hint">Adresse complète avec quartier et ville</div>
            </div>

            <div class="field">
                <label>Nombre d'étages <span class="req">*</span></label>
                <div class="stepper-wrap">
                    <button type="button" class="stepper-btn" onclick="stepFloors(-1)">−</button>
                    <input type="number" name="floors" id="floorsInput"
                        class="stepper-input"
                        value="{{ old('floors', 1) }}"
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
                Créer l'immeuble
            </button>
            <a href="{{ route('buildings.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div>
        {{-- Floor visualizer --}}
        <div class="side-card">
            <div class="side-head">🏢 Aperçu des étages</div>
            <div class="side-body">
                <div class="floor-viz" id="floorViz"></div>
                <div class="floor-label" id="floorLabel">1 étage</div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="side-card">
            <div class="side-head">💡 Conseils</div>
            <div class="side-body">
                <div class="tip">
                    <div class="tip-n">1</div>
                    <div>Choisissez un nom court et mémorable, ex: <strong>Résidence Fann</strong>.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">2</div>
                    <div>L'adresse complète facilite la localisation et les livraisons.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">3</div>
                    <div>Vous pourrez ajouter des appartements après la création de l'immeuble.</div>
                </div>
            </div>
        </div>
    </div>

</div>
</form>

<script>
    const MAX_BARS = 8;

    function updateViz(val) {
        const n = Math.max(1, Math.min(50, parseInt(val) || 1));
        const viz = document.getElementById('floorViz');
        const lbl = document.getElementById('floorLabel');

        viz.innerHTML = '';
        const show = Math.min(n, MAX_BARS);

        for (let i = 0; i < MAX_BARS; i++) {
            const bar = document.createElement('div');
            bar.className = 'floor-bar' + (i < show ? ' active' : '');
            const w = 55 + ((MAX_BARS - i - 1) / MAX_BARS) * 35;
            bar.style.width = w + '%';
            viz.appendChild(bar);
        }

        lbl.textContent = n + (n > MAX_BARS
            ? ' étages (affiché : ' + MAX_BARS + ')'
            : ' étage' + (n > 1 ? 's' : ''));
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