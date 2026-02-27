@extends('layouts.app')

@section('page-title', 'Créer un appartement')

@section('breadcrumb')
    <a href="{{ route('manager.apartments.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Appartements</a>
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

    /* Header */
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

    .fcard-body { padding: 24px; }

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

    label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #6B7280;
        margin-bottom: 7px;
    }
    label .req { color: #DC2626; margin-left: 2px; }

    input[type="text"],
    input[type="number"],
    select {
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

    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='11' height='7' viewBox='0 0 11 7' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5.5 6L10 1' stroke='%238B8FA8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 13px center;
        padding-right: 34px;
        cursor: pointer;
    }

    input:focus, select:focus {
        border-color: #C9A96E;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }

    input::placeholder { color: #C4C0BB; }

    .field-hint {
        font-size: 11px; color: #9CA3AF; margin-top: 5px;
    }

    /* Rent field with suffix */
    .input-suffix-wrap { position: relative; }
    .input-suffix-wrap input { padding-right: 58px; }
    .input-suffix {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        font-size: 10px; font-weight: 700;
        color: #9CA3AF; pointer-events: none;
        letter-spacing: 0.5px;
    }

    /* Status radio pills */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .status-radio { display: none; }
    .status-pill {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        padding: 13px 8px;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px;
        cursor: pointer;
        background: #F8F7F5;
        transition: all 0.2s;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        text-align: center;
        user-select: none;
    }
    .status-pill:hover { border-color: #C9A96E; background: #fff; color: #1A1A2E; }
    .status-radio:checked + .status-pill {
        border-color: #C9A96E;
        background: rgba(201,169,110,0.07);
        color: #1A1A2E;
    }
    .s-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

    /* Errors */
    .err-block {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        border-radius: 9px;
        padding: 12px 16px;
        margin-bottom: 18px;
        list-style: none;
    }
    .err-block li {
        color: #DC2626; font-size: 13px;
        display: flex; align-items: flex-start; gap: 6px;
    }
    .err-block li::before { content: '✕'; font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    /* Actions bar */
    .form-actions {
        display: flex; gap: 10px; align-items: center;
        padding: 18px 24px;
        border-top: 1px solid #EEECEA;
        background: #FAFAF8;
    }
    .btn-save {
        height: 42px;
        background: #1A1A2E;
        color: #C9A96E;
        border: 1px solid #C9A96E;
        border-radius: 8px;
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
        background: transparent;
        color: #6B7280;
        border: 1.5px solid #E5E3DF;
        border-radius: 8px;
        padding: 0 18px;
        font-size: 13px; font-weight: 500;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: #1A1A2E; color: #1A1A2E; }

    /* Sidebar */
    .side-card {
        background: #fff;
        border: 1px solid #EEECEA;
        border-radius: 12px;
        overflow: hidden;
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
        margin-bottom: 12px; font-size: 12px;
        color: #4B5563; line-height: 1.5;
    }
    .tip:last-child { margin-bottom: 0; }
    .tip-n {
        width: 18px; height: 18px;
        background: #1A1A2E; color: #C9A96E;
        border-radius: 4px; font-size: 9px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }
</style>

<div class="pg-header">
    <div class="pg-title">Nouvel appartement</div>
    <div class="pg-sub">Remplissez les informations ci-dessous pour créer l'appartement</div>
</div>

<form method="POST" action="{{ route('manager.apartments.store') }}">
@csrf

<div class="form-wrap">

    {{-- MAIN CARD --}}
    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" stroke-width="2" points="9,22 9,12 15,12 15,22"/>
                </svg>
            </div>
            <div>
                <div class="fcard-title">Informations générales</div>
                <div class="fcard-sub">Identifiant, type, loyer et immeuble</div>
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

            <div class="field-row">
                <div class="field">
                    <label>Numéro <span class="req">*</span></label>
                    <input type="text" name="number"
                        placeholder="ex: 3B, A-205"
                        value="{{ old('number') }}" required>
                    <div class="field-hint">Identifiant unique dans l'immeuble</div>
                </div>
                <div class="field">
                    <label>Type <span class="req">*</span></label>
                    <select name="type" required>
                        <option value="">— Choisir —</option>
                        @foreach(['Studio','F1','F2','F3','F4','F5+','Duplex','Commerce'] as $t)
                            <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Loyer mensuel <span class="req">*</span></label>
                    <div class="input-suffix-wrap">
                        <input type="number" name="rent_amount"
                            placeholder="150 000"
                            value="{{ old('rent_amount') }}"
                            min="0" step="1000" required>
                        <span class="input-suffix">FCFA</span>
                    </div>
                </div>
                <div class="field">
                    <label>Immeuble <span class="req">*</span></label>
                    <select name="building_id" required>
                        <option value="">— Choisir —</option>
                        @foreach($buildings as $b)
                            <option value="{{ $b->id }}" {{ old('building_id') == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Statut <span class="req">*</span></label>
                <div class="status-grid">
                    <div>
                        <input type="radio" name="status" id="sv" value="vacant"
                            class="status-radio"
                            {{ old('status', 'vacant') == 'vacant' ? 'checked' : '' }}>
                        <label for="sv" class="status-pill">
                            <span class="s-dot" style="background:#F59E0B"></span>
                            Vacant
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="so" value="occupé"
                            class="status-radio"
                            {{ old('status') == 'occupé' ? 'checked' : '' }}>
                        <label for="so" class="status-pill">
                            <span class="s-dot" style="background:#10B981"></span>
                            Occupé
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="st" value="en travaux"
                            class="status-radio"
                            {{ old('status') == 'en travaux' ? 'checked' : '' }}>
                        <label for="st" class="status-pill">
                            <span class="s-dot" style="background:#EF4444"></span>
                            En travaux
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Créer l'appartement
            </button>
            <a href="{{ route('manager.apartments.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="side-card">
            <div class="side-head">💡 Conseils</div>
            <div class="side-body">
                <div class="tip">
                    <div class="tip-n">1</div>
                    <div>Numérotez clairement : <strong>A-101</strong>, <strong>3B</strong>. Évitez les espaces.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">2</div>
                    <div>Le loyer est modifiable ultérieurement sans impacter les baux existants.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">3</div>
                    <div>Statut <strong>Vacant</strong> = appartement visible à la location.</div>
                </div>
            </div>
        </div>
        <div class="side-card">
            <div class="side-head">📍 Immeuble sélectionné</div>
            <div class="side-body" style="font-size:12px;color:#8B8FA8;">
                Sélectionnez un immeuble dans le formulaire pour l'associer.
            </div>
        </div>
    </div>

</div>
</form>
@endsection