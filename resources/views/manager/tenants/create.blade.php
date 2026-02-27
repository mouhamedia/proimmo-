@extends('layouts.app')

@section('page-title', 'Créer un locataire')

@section('breadcrumb')
    <a href="{{ route('manager.tenants.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;"
       onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Locataires</a>
    &nbsp;/&nbsp;<span>Nouveau</span>
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

    .pg-header { margin-bottom: 28px; }
    .pg-title {
        font-family: 'Playfair Display', serif;
        font-size: 22px; font-weight: 600;
        color: #1A1A2E; margin-bottom: 4px;
    }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

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

    /* Password strength */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 44px; }
    .pw-toggle {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #8B8FA8; padding: 0; display: flex;
        align-items: center; transition: color 0.2s;
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
        background: #FAFAF8;
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
    .side-body { padding: 16px 18px; }
    .tip {
        display: flex; align-items: flex-start; gap: 9px;
        margin-bottom: 12px; font-size: 12px;
        color: #4B5563; line-height: 1.5;
    }
    .tip:last-child { margin-bottom: 0; }
    .tip-n {
        width: 18px; height: 18px; background: #1A1A2E; color: #C9A96E;
        border-radius: 4px; font-size: 9px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: 1px;
    }

    /* Apt preview */
    .apt-preview {
        background: #F8F7F5; border: 1px solid #EEECEA;
        border-radius: 9px; padding: 12px 14px;
        font-size: 12px; color: #8B8FA8;
        display: none;
    }
    .apt-preview.visible { display: block; }
    .apt-preview-num {
        font-family: 'Courier New', monospace;
        font-weight: 700; color: #1A1A2E;
        font-size: 14px; margin-bottom: 3px;
    }
</style>

<div class="pg-header">
    <div class="pg-title">Nouveau locataire</div>
    <div class="pg-sub">Remplissez les informations pour créer le compte locataire</div>
</div>

<form method="POST" action="{{ route('manager.tenants.store') }}">
@csrf

<div class="form-wrap">

    {{-- MAIN CARD --}}
    <div class="fcard">
        <div class="fcard-head">
            <div class="fcard-icon">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <div class="fcard-title">Informations du locataire</div>
                <div class="fcard-sub">Identité, contact et logement</div>
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
                    <label>Nom complet <span class="req">*</span></label>
                    <input type="text" name="name"
                        placeholder="ex: Amadou Diallo"
                        value="{{ old('name') }}" required>
                </div>
                <div class="field">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email"
                        placeholder="ex: amadou@email.com"
                        value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Téléphone</label>
                    <input type="text" name="phone"
                        placeholder="ex: +221 77 000 00 00"
                        value="{{ old('phone') }}">
                    <div class="field-hint">Optionnel — pour les notifications</div>
                </div>
                <div class="field">
                    <label>Mot de passe <span class="req">*</span></label>
                    <div class="pw-wrap">
                        <input type="password" name="password" id="pwInput"
                            placeholder="Minimum 8 caractères" required>
                        <button type="button" class="pw-toggle" onclick="togglePw()">
                            <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
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
                            {{ old('apartment_id') == $apartment->id ? 'selected' : '' }}>
                            {{ $apartment->number }}
                            @if($apartment->building)— {{ $apartment->building->name }}@endif
                        </option>
                    @endforeach
                </select>
                <div class="field-hint">Seuls les appartements vacants sont listés</div>
                <div class="apt-preview" id="aptPreview">
                    <div class="apt-preview-num" id="previewNum">—</div>
                    <div id="previewDetails"></div>
                </div>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Créer le locataire
            </button>
            <a href="{{ route('manager.tenants.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="side-card">
            <div class="side-head">💡 Conseils</div>
            <div class="side-body">
                <div class="tip">
                    <div class="tip-n">1</div>
                    <div>Utilisez l'email du locataire comme identifiant de connexion.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">2</div>
                    <div>Le mot de passe doit contenir au moins <strong>8 caractères</strong>.</div>
                </div>
                <div class="tip">
                    <div class="tip-n">3</div>
                    <div>Seuls les appartements <strong>vacants</strong> apparaissent dans la liste.</div>
                </div>
            </div>
        </div>

        <div class="side-card">
            <div class="side-head">🏠 Appartement sélectionné</div>
            <div class="side-body">
                <div id="sideAptInfo" style="font-size:12px;color:#8B8FA8;">
                    Aucun appartement sélectionné.
                </div>
            </div>
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
        const preview = document.getElementById('aptPreview');
        const sideInfo = document.getElementById('sideAptInfo');

        if (!opt.value) {
            preview.classList.remove('visible');
            sideInfo.innerHTML = '<span style="color:#8B8FA8;">Aucun appartement sélectionné.</span>';
            return;
        }

        const num      = opt.dataset.num;
        const type     = opt.dataset.type;
        const building = opt.dataset.building;
        const rent     = opt.dataset.rent;

        preview.classList.add('visible');
        document.getElementById('previewNum').textContent = 'Appt. ' + num;
        document.getElementById('previewDetails').innerHTML =
            type + (building ? ' &bull; ' + building : '') + ' &bull; ' + rent + ' FCFA/mois';

        sideInfo.innerHTML = `
            <div style="margin-bottom:8px;">
                <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:4px;">Numéro</div>
                <div style="font-family:'Courier New',monospace;font-weight:700;color:#1A1A2E;font-size:14px;">${num}</div>
            </div>
            <div style="margin-bottom:8px;">
                <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:4px;">Type</div>
                <div style="font-weight:600;color:#1A1A2E;font-size:13px;">${type}</div>
            </div>
            ${building ? `<div style="margin-bottom:8px;">
                <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:4px;">Immeuble</div>
                <div style="font-weight:600;color:#1A1A2E;font-size:13px;">${building}</div>
            </div>` : ''}
            <div>
                <div style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#8B8FA8;margin-bottom:4px;">Loyer</div>
                <div style="font-weight:700;color:#C9A96E;font-size:14px;">${rent} FCFA</div>
            </div>
        `;
    }

    // Init si old() présélectionné
    const sel = document.getElementById('aptSelect');
    if (sel && sel.value) updateAptPreview(sel);
</script>
@endsection