@extends('layouts.app')

@section('page-title', 'Modifier un locataire')

@section('breadcrumb')
    <a href="{{ route('manager.tenants.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;"
       onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Locataires</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">{{ $tenant->name }}</span>
@endsection

@section('content')
<style>
    .form-wrap {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 24px; align-items: start;
        max-width: 960px;
    }
    @media (max-width: 860px) { .form-wrap { grid-template-columns: 1fr; } }

    /* Header */
    .pg-header { margin-bottom: 28px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .pg-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600; color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }
    .tenant-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 8px; padding: 8px 14px;
        flex-shrink: 0;
    }
    .badge-avatar {
        width: 28px; height: 28px; border-radius: 7px;
        background: #1A1A2E; color: #C9A96E;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }
    .badge-name { font-size: 13px; font-weight: 600; color: #1A1A2E; }

    /* Card */
    .fcard { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; }
    .fcard-head {
        padding: 18px 24px; border-bottom: 1px solid #EEECEA;
        display: flex; align-items: center; gap: 12px;
    }
    .fcard-icon {
        width: 34px; height: 34px; background: #1A1A2E; border-radius: 8px;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .fcard-icon svg { color: #C9A96E; }
    .fcard-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .fcard-sub   { font-size: 11px; color: #8B8FA8; margin-top: 1px; }
    .fcard-body  { padding: 24px; }

    /* Fields */
    .field { margin-bottom: 18px; }
    .field:last-child { margin-bottom: 0; }
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
    .field-row .field { margin-bottom: 0; }

    .field > label {
        display: block; font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #6B7280; margin-bottom: 7px;
    }
    .req { color: #DC2626; margin-left: 2px; }

    .field input[type="text"],
    .field input[type="email"],
    .field input[type="password"],
    .field select {
        width: 100%; height: 46px;
        background: #F8F7F5; border: 1.5px solid #E5E3DF;
        border-radius: 9px; padding: 0 14px;
        font-size: 14px; font-family: 'DM Sans', sans-serif;
        color: #1A1A2E; outline: none;
        transition: all 0.2s; box-sizing: border-box;
    }
    .field select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg width='11' height='7' viewBox='0 0 11 7' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5.5 6L10 1' stroke='%238B8FA8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 13px center;
        padding-right: 34px; cursor: pointer;
    }
    .field input:focus, .field select:focus {
        border-color: #C9A96E; background: #fff;
        box-shadow: 0 0 0 3px rgba(201,169,110,0.12);
    }
    .field input::placeholder { color: #C4C0BB; }
    .field-hint { font-size: 11px; color: #9CA3AF; margin-top: 5px; }

    /* Password toggle */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 44px; }
    .pw-toggle {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #8B8FA8; padding: 0;
        display: flex; align-items: center; transition: color 0.2s;
    }
    .pw-toggle:hover { color: #C9A96E; }

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
        padding: 18px 24px; border-top: 1px solid #EEECEA;
        background: #FAFAF8; flex-wrap: wrap;
    }
    .btn-save {
        height: 42px; background: #1A1A2E; color: #C9A96E;
        border: 1px solid #C9A96E; border-radius: 8px;
        padding: 0 22px; font-size: 13px; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-save:hover { background: #C9A96E; color: #1A1A2E; }
    .btn-cancel {
        height: 42px; background: transparent; color: #6B7280;
        border: 1.5px solid #E5E3DF; border-radius: 8px;
        padding: 0 18px; font-size: 13px; font-weight: 500;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 7px;
        transition: all 0.2s;
    }
    .btn-cancel:hover { border-color: #1A1A2E; color: #1A1A2E; }

    /* Sidebar */
    .side-card {
        background: #fff; border: 1px solid #EEECEA;
        border-radius: 12px; overflow: hidden; margin-bottom: 14px;
    }
    .side-head {
        padding: 14px 18px; border-bottom: 1px solid #EEECEA;
        font-size: 12px; font-weight: 700; color: #1A1A2E;
    }
    .side-body { padding: 0; }

    .info-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 18px; border-bottom: 1px solid #F5F3F1;
        font-size: 12px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-lbl { color: #8B8FA8; }
    .info-val { font-weight: 600; color: #1A1A2E; text-align: right; max-width: 160px; word-break: break-word; }

    /* Danger */
    .danger-zone {
        background: #FEF2F2; border: 1px solid #FEE2E2;
        border-radius: 12px; padding: 16px 18px;
    }
    .danger-title { font-size: 12px; font-weight: 700; color: #991B1B; margin-bottom: 4px; }
    .danger-desc  { font-size: 11px; color: #B91C1C; line-height: 1.5; margin-bottom: 12px; }
    .btn-danger {
        width: 100%; height: 36px; background: transparent; color: #DC2626;
        border: 1.5px solid #DC2626; border-radius: 7px;
        font-size: 12px; font-weight: 600;
        font-family: 'DM Sans', sans-serif; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-danger:hover { background: #DC2626; color: #fff; }
</style>

{{-- Header --}}
<div class="pg-header">
    <div>
        <div class="pg-title">Modifier le locataire</div>
        <div class="pg-sub">Mettez à jour les informations ci-dessous</div>
    </div>
    <div class="tenant-badge">
        <div class="badge-avatar">
            {{ strtoupper(substr($tenant->name, 0, 1)) }}{{ strtoupper(substr(strstr($tenant->name, ' ') ?: $tenant->name, 1, 1)) }}
        </div>
        <span class="badge-name">{{ $tenant->name }}</span>
    </div>
</div>

<form method="POST" action="{{ route('manager.tenants.update', $tenant->id) }}">
@csrf @method('PUT')

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
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            @endif

            <div class="field-row">
                <div class="field">
                    <label>Nom complet <span class="req">*</span></label>
                    <input type="text" name="name"
                        value="{{ old('name', $tenant->name) }}"
                        placeholder="ex: Amadou Diallo" required>
                </div>
                <div class="field">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email"
                        value="{{ old('email', $tenant->email) }}"
                        placeholder="ex: amadou@email.com" required>
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Téléphone</label>
                    <input type="text" name="phone"
                        value="{{ old('phone', $tenant->phone ?? '') }}"
                        placeholder="ex: +221 77 000 00 00">
                </div>
                <div class="field">
                    <label>Nouveau mot de passe</label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="pwInput"
                            placeholder="Laisser vide pour ne pas changer">
                        <button type="button" class="pw-toggle" onclick="togglePw()">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="field-hint">Laisser vide pour conserver l'actuel</div>
                </div>
            </div>

            <div class="field">
                <label>Appartement <span class="req">*</span></label>
                <select name="apartment_id" id="aptSelect" onchange="updateAptPreview(this)" required>
                    <option value="">— Choisir un appartement —</option>
                    @foreach($apartments as $apartment)
                        <option value="{{ $apartment->id }}"
                            data-num="{{ $apartment->number }}"
                            data-type="{{ $apartment->type }}"
                            data-building="{{ $apartment->building->name ?? '' }}"
                            data-rent="{{ number_format($apartment->rent_amount, 0, ',', ' ') }}"
                            {{ old('apartment_id', $tenant->apartment_id) == $apartment->id ? 'selected' : '' }}>
                            {{ $apartment->number }}
                            @if($apartment->building)— {{ $apartment->building->name }}@endif
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications
            </button>
            <a href="{{ route('manager.tenants.index') }}" class="btn-cancel">Annuler</a>
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
                    <span class="info-val">{{ $tenant->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Email</span>
                    <span class="info-val" style="font-size:11px;">{{ $tenant->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Appartement</span>
                    <span class="info-val" style="font-family:'Courier New',monospace;letter-spacing:1px;">
                        {{ $tenant->apartment->number ?? '—' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Immeuble</span>
                    <span class="info-val">{{ $tenant->apartment->building->name ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Créé le</span>
                    <span class="info-val">{{ $tenant->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Loyer</span>
                    <span class="info-val" style="color:#C9A96E;">
                        @if($tenant->apartment)
                            {{ number_format($tenant->apartment->rent_amount, 0, ',', ' ') }} FCFA
                        @else
                            —
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Appartement sélectionné --}}
        <div class="side-card">
            <div class="side-head">🏠 Appartement sélectionné</div>
            <div class="side-body">
                <div id="sideAptInfo" style="padding:16px 18px;font-size:12px;color:#8B8FA8;">
                    Aucun changement.
                </div>
            </div>
        </div>

        {{-- Danger zone --}}
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zone de danger</div>
            <div class="danger-desc">La suppression est définitive. Le locataire perdra l'accès à son espace.</div>
            <form method="POST" action="{{ route('manager.tenants.destroy', $tenant->id) }}"
                  onsubmit="return confirm('Supprimer définitivement {{ addslashes($tenant->name) }} ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Supprimer ce locataire
                </button>
            </form>
        </div>

    </div>

</div>
</form>

<script>
    function togglePw() {
        const input = document.getElementById('pwInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function updateAptPreview(sel) {
        const opt = sel.options[sel.selectedIndex];
        const sideInfo = document.getElementById('sideAptInfo');

        if (!opt.value) {
            sideInfo.innerHTML = '<span style="color:#8B8FA8;">Aucun changement.</span>';
            return;
        }

        const num      = opt.dataset.num;
        const type     = opt.dataset.type;
        const building = opt.dataset.building;
        const rent     = opt.dataset.rent;

        sideInfo.innerHTML = `
            <div style="padding:16px 18px;">
                <div style="margin-bottom:10px;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:3px;">Numéro</div>
                    <div style="font-family:'Courier New',monospace;font-weight:700;color:#1A1A2E;font-size:14px;">${num}</div>
                </div>
                <div style="margin-bottom:10px;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:3px;">Type</div>
                    <div style="font-weight:600;color:#1A1A2E;font-size:13px;">${type}</div>
                </div>
                ${building ? `<div style="margin-bottom:10px;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:3px;">Immeuble</div>
                    <div style="font-weight:600;color:#1A1A2E;font-size:13px;">${building}</div>
                </div>` : ''}
                <div>
                    <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:3px;">Loyer</div>
                    <div style="font-weight:700;color:#C9A96E;font-size:14px;">${rent} FCFA</div>
                </div>
            </div>
        `;
    }

    // Init si appartement déjà sélectionné
    const sel = document.getElementById('aptSelect');
    if (sel && sel.value) updateAptPreview(sel);
</script>
@endsection