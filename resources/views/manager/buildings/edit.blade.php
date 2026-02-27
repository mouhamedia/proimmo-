@extends('layouts.app')

@section('page-title', 'Modifier un appartement')

@section('breadcrumb')
    <a href="{{ route('manager.apartments.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Appartements</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">{{ $apartment->number }}</span>
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
    @media (max-width: 600px) {
        .form-wrap { padding: 0 4px; }
        .pg-title { font-size: 1.1rem !important; }
        .fcard-body, .form-actions { padding: 12px !important; }
        input, select { font-size: 13px !important; height: 38px !important; }
        label { font-size: 9px; }
        .apt-badge { font-size: 11px; padding: 5px 8px; }
    }

    .pg-header { margin-bottom: 28px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .pg-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

    /* Apt badge in header */
    .apt-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #F8F7F5;
        border: 1px solid #E5E3DF;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px; font-weight: 600; color: #1A1A2E;
        font-family: 'Courier New', monospace;
        letter-spacing: 1px;
        flex-shrink: 0;
    }

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

    .field-hint { font-size: 11px; color: #9CA3AF; margin-top: 5px; }

    /* Rent */
    .input-suffix-wrap { position: relative; }
    .input-suffix-wrap input { padding-right: 58px; }
    .input-suffix {
        position: absolute; right: 13px; top: 50%;
        transform: translateY(-50%);
        font-size: 10px; font-weight: 700;
        color: #9CA3AF; pointer-events: none;
    }

    /* Status pills */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .status-radio { display: none; }
    .status-pill {
        display: flex; flex-direction: column;
        align-items: center; gap: 7px;
        padding: 13px 8px;
        border: 1.5px solid #E5E3DF;
        border-radius: 9px;
        cursor: pointer;
        background: #F8F7F5;
        transition: all 0.2s;
        font-size: 12px; font-weight: 600;
        color: #6B7280; text-align: center;
        user-select: none;
    }
    .status-pill:hover { border-color: #C9A96E; background: #fff; color: #1A1A2E; }
    .status-radio:checked + .status-pill {
        border-color: #C9A96E;
        background: rgba(201,169,110,0.07);
        color: #1A1A2E;
    }
    .s-dot { width: 10px; height: 10px; border-radius: 50%; }

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
        flex-wrap: wrap;
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
        cursor: pointer;
        text-decoration: none;
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

    /* Info row */
    .info-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #F5F3F1;
        font-size: 12px;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-lbl { color: #8B8FA8; }
    .info-val { font-weight: 600; color: #1A1A2E; }

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
        <div class="pg-title">Modifier l'appartement</div>
        <div class="pg-sub">Mettez à jour les informations ci-dessous</div>
    </div>
    <div class="apt-badge">
        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        </svg>
        Appt. {{ $apartment->number }}
    </div>
</div>

<form method="POST" action="{{ route('manager.apartments.update', $apartment->id) }}">
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
                <div class="fcard-sub">Les modifications sont enregistrées immédiatement</div>
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
                        value="{{ old('number', $apartment->number) }}"
                        placeholder="ex: 3B" required>
                    <div class="field-hint">Identifiant unique dans l'immeuble</div>
                </div>
                <div class="field">
                    <label>Type <span class="req">*</span></label>
                    <select name="type" required>
                        <option value="">— Choisir —</option>
                        @foreach(['Studio','F1','F2','F3','F4','F5+','Duplex','Commerce'] as $t)
                            <option value="{{ $t }}"
                                {{ old('type', $apartment->type) == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Loyer mensuel <span class="req">*</span></label>
                    <div class="input-suffix-wrap">
                        <input type="number" name="rent_amount"
                            value="{{ old('rent_amount', $apartment->rent_amount) }}"
                            min="0" step="1000" required>
                        <span class="input-suffix">FCFA</span>
                    </div>
                </div>
                <div class="field">
                    <label>Immeuble <span class="req">*</span></label>
                    <select name="building_id" required>
                        <option value="">— Choisir —</option>
                        @foreach($buildings as $b)
                            <option value="{{ $b->id }}"
                                {{ old('building_id', $apartment->building_id) == $b->id ? 'selected' : '' }}>
                                {{ $b->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Statut <span class="req">*</span></label>
                <div class="status-grid">
                    @php $currentStatus = old('status', $apartment->status); @endphp
                    <div>
                        <input type="radio" name="status" id="sv" value="vacant"
                            class="status-radio"
                            {{ $currentStatus == 'vacant' ? 'checked' : '' }}>
                        <label for="sv" class="status-pill">
                            <span class="s-dot" style="background:#F59E0B"></span>
                            Vacant
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="so" value="occupé"
                            class="status-radio"
                            {{ $currentStatus == 'occupé' ? 'checked' : '' }}>
                        <label for="so" class="status-pill">
                            <span class="s-dot" style="background:#10B981"></span>
                            Occupé
                        </label>
                    </div>
                    <div>
                        <input type="radio" name="status" id="st" value="en travaux"
                            class="status-radio"
                            {{ $currentStatus == 'en travaux' ? 'checked' : '' }}>
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
                Enregistrer les modifications
            </button>
            <a href="{{ route('manager.apartments.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div>
        {{-- Current info --}}
        <div class="side-card">
            <div class="side-head">📋 Informations actuelles</div>
            <div class="side-body">
                <div class="info-row">
                    <span class="info-lbl">Numéro</span>
                    <span class="info-val" style="font-family:'Courier New',monospace;letter-spacing:1px">{{ $apartment->number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Immeuble</span>
                    <span class="info-val">{{ $apartment->building->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Créé le</span>
                    <span class="info-val">{{ $apartment->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Modifié le</span>
                    <span class="info-val">{{ $apartment->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Loyer actuel</span>
                    <span class="info-val" style="color:#C9A96E">{{ number_format($apartment->rent_amount, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zone de danger</div>
            <div class="danger-desc">La suppression est définitive et irréversible.</div>
            <form method="POST" action="{{ route('manager.apartments.destroy', $apartment->id) }}"
                  onsubmit="return confirm('Supprimer définitivement l\'appartement {{ addslashes($apartment->number) }} ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer cet appartement
                </button>
            </form>
        </div>
    </div>

</div>
</form>
@endsection