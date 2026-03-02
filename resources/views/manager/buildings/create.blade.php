@extends('layouts.app')

@section('page-title', 'Nouvel immeuble')

@section('breadcrumb')
    <a href="{{ route('manager.buildings.index') }}" style="color:#8A8478;text-decoration:none;font-family:'Syne',sans-serif;font-size:13px;"
       onmouseover="this.style.color='#0F0E0C'" onmouseout="this.style.color='#8A8478'">Immeubles</a>
    &nbsp;/&nbsp;
    <span style="color:#0F0E0C;font-weight:600;font-family:'Syne',sans-serif;font-size:13px;">Nouvel immeuble</span>
@endsection

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
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
        --error:   #C0392B;
        --error-bg:#FFF1F0;
    }

    .form-wrap {
        display: grid;
        grid-template-columns: 1fr 290px;
        gap: 24px;
        align-items: start;
        max-width: 960px;
    }
    @media (max-width: 860px) { .form-wrap { grid-template-columns: 1fr; } }

    .pg-header { margin-bottom: 28px; }
    .pg-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 32px; font-weight: 600;
        color: var(--ink); line-height: 1; margin-bottom: 6px;
    }
    .pg-sub { font-family: 'Syne', sans-serif; font-size: 12.5px; color: var(--muted); }

    .fcard { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
    .fcard-head {
        padding: 18px 26px; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: 14px; background: #fff;
    }
    .fcard-icon {
        width: 36px; height: 36px; background: var(--navy);
        border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .fcard-title { font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--ink); }
    .fcard-sub   { font-family: 'Syne', sans-serif; font-size: 11px; color: var(--muted); margin-top: 2px; }
    .fcard-body  { padding: 26px; }

    .field { margin-bottom: 20px; }
    .field:last-child { margin-bottom: 0; }
    .field > label {
        display: block; font-family: 'Syne', sans-serif;
        font-size: 10px; font-weight: 700; letter-spacing: 2px;
        text-transform: uppercase; color: var(--ink); margin-bottom: 8px;
    }
    .req { color: var(--gold); margin-left: 2px; font-size: 14px; }

    .field input[type="text"] {
        width: 100%; height: 46px; background: var(--paper);
        border: 1px solid var(--border); border-radius: 10px;
        padding: 0 16px; font-family: 'Syne', sans-serif;
        font-size: 13px; color: var(--ink); outline: none;
        transition: all 0.2s; box-sizing: border-box;
    }
    .field input[type="text"]:focus {
        border-color: var(--gold); background: #fff;
        box-shadow: 0 0 0 3px rgba(184,146,74,0.12);
    }
    .field input[type="text"]::placeholder { color: #C0B9B0; }
    .field-hint { font-family: 'Syne', sans-serif; font-size: 11px; color: var(--muted); margin-top: 6px; }

    .stepper-wrap {
        display: flex; align-items: center;
        border: 1px solid var(--border); border-radius: 10px;
        overflow: hidden; background: var(--paper);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .stepper-wrap:focus-within {
        border-color: var(--gold); background: #fff;
        box-shadow: 0 0 0 3px rgba(184,146,74,0.12);
    }
    .stepper-btn {
        width: 46px; height: 46px; background: transparent; border: none;
        font-size: 22px; font-weight: 300; color: var(--muted); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.15s; flex-shrink: 0;
    }
    .stepper-btn:hover { background: rgba(184,146,74,0.1); color: var(--gold); }
    .stepper-input {
        flex: 1; height: 46px; background: transparent; border: none;
        text-align: center; font-family: 'Cormorant Garamond', serif;
        font-size: 22px; font-weight: 600; color: var(--ink);
        outline: none; padding: 0; min-width: 0;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }
    input[type=number] { -moz-appearance: textfield; }

    .err-block {
        background: var(--error-bg); border: 1px solid #FFCBC9;
        border-radius: 10px; padding: 13px 16px;
        margin-bottom: 20px; list-style: none;
    }
    .err-block li {
        font-family: 'Syne', sans-serif; color: var(--error);
        font-size: 12.5px; display: flex; align-items: flex-start;
        gap: 7px; margin-bottom: 4px;
    }
    .err-block li:last-child { margin-bottom: 0; }
    .err-block li::before { content: '✕'; font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    .form-actions {
        display: flex; gap: 10px; align-items: center;
        padding: 18px 26px; border-top: 1px solid var(--border);
        background: var(--paper);
    }
    .btn-save {
        height: 42px; background: var(--navy); color: var(--gold-lt);
        border: 1px solid var(--gold); border-radius: 10px; padding: 0 24px;
        font-family: 'Syne', sans-serif; font-size: 12.5px; font-weight: 600;
        cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.2s; letter-spacing: 0.02em;
    }
    .btn-save:hover {
        background: var(--gold); color: var(--navy);
        box-shadow: 0 4px 20px rgba(184,146,74,0.3); transform: translateY(-1px);
    }
    .btn-cancel {
        height: 42px; background: transparent; color: var(--muted);
        border: 1px solid var(--border); border-radius: 10px; padding: 0 18px;
        font-family: 'Syne', sans-serif; font-size: 12.5px; font-weight: 600;
        cursor: pointer; text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: var(--ink); color: var(--ink); background: var(--cream); }

    .side-card {
        background: #fff; border: 1px solid var(--border);
        border-radius: 14px; overflow: hidden; margin-bottom: 16px;
    }
    .side-card:last-child { margin-bottom: 0; }
    .side-head {
        padding: 14px 18px; border-bottom: 1px solid var(--border);
        font-family: 'Syne', sans-serif; font-size: 12px; font-weight: 700;
        color: var(--ink); display: flex; align-items: center; gap: 8px;
    }
    .side-body { padding: 18px; }

    .floor-viz { display: flex; flex-direction: column-reverse; gap: 4px; margin-bottom: 12px; }
    .floor-bar {
        height: 13px; border-radius: 4px;
        background: linear-gradient(90deg, var(--navy), var(--navy-lt));
        opacity: 0.1; transition: all 0.25s; align-self: center;
    }
    .floor-bar.active {
        opacity: 1;
        background: linear-gradient(90deg, var(--gold), var(--gold-lt));
    }
    .floor-label {
        font-family: 'Cormorant Garamond', serif;
        font-size: 15px; font-weight: 600; color: var(--ink); text-align: center;
    }

    .tip {
        display: flex; align-items: flex-start; gap: 10px;
        margin-bottom: 14px; font-family: 'Syne', sans-serif;
        font-size: 12px; color: #4B5563; line-height: 1.55;
    }
    .tip:last-child { margin-bottom: 0; }
    .tip-n {
        width: 20px; height: 20px; background: var(--navy); color: var(--gold-lt);
        border-radius: 5px; font-size: 9px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }
</style>

<div class="pg-header">
    <div class="pg-title">Nouvel immeuble</div>
    <div class="pg-sub">Remplissez les informations pour créer l'immeuble</div>
</div>

{{-- ✅ ROUTE CORRIGÉE --}}
<form method="POST" action="{{ route('manager.buildings.store') }}">
@csrf

<div class="form-wrap">

    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="#D4AA6A" viewBox="0 0 24 24">
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
                    placeholder="ex : Résidence Les Acacias"
                    value="{{ old('name') }}" required>
                <div class="field-hint">Nom unique pour identifier l'immeuble dans votre portefeuille</div>
            </div>

            <div class="field">
                <label>Adresse <span class="req">*</span></label>
                <input type="text" name="address"
                    placeholder="ex : 14 Rue Carnot, Plateau, Dakar"
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
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Créer l'immeuble
            </button>
            {{-- ✅ ROUTE CORRIGÉE --}}
            <a href="{{ route('manager.buildings.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    <div>
        <div class="side-card">
            <div class="side-head">
                <svg width="13" height="13" fill="none" stroke="#B8924A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10M12 3v18M5 7l7-4 7 4"/>
                </svg>
                Aperçu des étages
            </div>
            <div class="side-body">
                <div class="floor-viz" id="floorViz"></div>
                <div class="floor-label" id="floorLabel">1 étage</div>
            </div>
        </div>

        <div class="side-card">
            <div class="side-head">
                <svg width="13" height="13" fill="none" stroke="#B8924A" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Conseils
            </div>
            <div class="side-body">
                <div class="tip">
                    <div class="tip-n">1</div>
                    <div>Choisissez un nom court et mémorable, ex : <strong>Résidence Fann</strong>.</div>
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
            const w = 50 + ((MAX_BARS - i - 1) / MAX_BARS) * 40;
            bar.style.width = w + '%';
            viz.appendChild(bar);
        }
        lbl.textContent = n + (n > MAX_BARS ? ' étages (affiché : ' + MAX_BARS + ')' : ' étage' + (n > 1 ? 's' : ''));
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
