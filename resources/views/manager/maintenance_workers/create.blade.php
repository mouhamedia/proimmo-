@extends('layouts.app')

@section('page-title', 'Nouveau technicien')

@section('breadcrumb')
    <a href="{{ route('manager.maintenance_workers.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Maintenanciers</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">Nouveau technicien</span>
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

    .pg-header { margin-bottom: 28px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
    .pg-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: #1A1A2E; margin-bottom: 4px; }
    .pg-sub { font-size: 13px; color: #8B8FA8; }

    .worker-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 8px; padding: 8px 14px;
        font-size: 13px; font-weight: 600; color: #1A1A2E;
        flex-shrink: 0;
    }

    .fcard { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; }
    .fcard-head { padding: 18px 24px; border-bottom: 1px solid #EEECEA; display: flex; align-items: center; gap: 12px; }
    .fcard-icon { width: 34px; height: 34px; background: #1A1A2E; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .fcard-icon svg { color: #C9A96E; }
    .fcard-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .fcard-sub   { font-size: 11px; color: #8B8FA8; margin-top: 1px; }
    .fcard-body  { padding: 24px; }

    .field { margin-bottom: 18px; }
    .field:last-child { margin-bottom: 0; }

    label {
        display: block; font-size: 10px; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: #6B7280; margin-bottom: 7px;
    }
    label .req { color: #DC2626; margin-left: 2px; }

    input[type="text"], input[type="email"], input[type="password"] {
        width: 100%; height: 46px;
        background: #F8F7F5; border: 1.5px solid #E5E3DF;
        border-radius: 9px; padding: 0 14px;
        font-size: 14px; font-family: 'DM Sans', sans-serif;
        color: #1A1A2E; outline: none; transition: all 0.2s;
        box-sizing: border-box;
    }
    input:focus { border-color: #C9A96E; background: #fff; box-shadow: 0 0 0 3px rgba(201,169,110,0.12); }
    input::placeholder { color: #C4C0BB; }
    .field-hint { font-size: 11px; color: #9CA3AF; margin-top: 5px; }

    /* Password toggle */
    .pw-wrap { position: relative; }
    .pw-wrap input { padding-right: 44px; }
    .pw-toggle {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #9CA3AF; padding: 0; display: flex; align-items: center;
        transition: color 0.2s;
    }
    .pw-toggle:hover { color: #1A1A2E; }

    .err-block { background: #FEF2F2; border: 1px solid #FECACA; border-radius: 9px; padding: 12px 16px; margin-bottom: 18px; list-style: none; }
    .err-block li { color: #DC2626; font-size: 13px; display: flex; align-items: flex-start; gap: 6px; }
    .err-block li::before { content: '✕'; font-size: 10px; margin-top: 2px; flex-shrink: 0; }

    .form-actions { display: flex; gap: 10px; align-items: center; padding: 18px 24px; border-top: 1px solid #EEECEA; background: #FAFAF8; flex-wrap: wrap; }
    .btn-save { height: 42px; background: #1A1A2E; color: #C9A96E; border: 1px solid #C9A96E; border-radius: 8px; padding: 0 22px; font-size: 13px; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; }
    .btn-save:hover { background: #C9A96E; color: #1A1A2E; }
    .btn-cancel { height: 42px; background: transparent; color: #6B7280; border: 1.5px solid #E5E3DF; border-radius: 8px; padding: 0 18px; font-size: 13px; font-weight: 500; font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 7px; transition: all 0.2s; }
    .btn-cancel:hover { border-color: #1A1A2E; color: #1A1A2E; }

    /* Sidebar */
    .side-card { background: #fff; border: 1px solid #EEECEA; border-radius: 12px; overflow: hidden; margin-bottom: 14px; }
    .side-head { padding: 14px 18px; border-bottom: 1px solid #EEECEA; font-size: 12px; font-weight: 700; color: #1A1A2E; }
    .side-body { padding: 16px 18px; }

    .tip-item { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid #F5F3F1; font-size: 12px; }
    .tip-item:last-child { border-bottom: none; padding-bottom: 0; }
    .tip-icon { width: 28px; height: 28px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
    .tip-title { font-weight: 600; color: #1A1A2E; margin-bottom: 2px; }
    .tip-desc  { color: #8B8FA8; line-height: 1.4; }

    /* Strength bar */
    .strength-bar { display: flex; gap: 3px; margin-top: 7px; }
    .strength-seg { height: 3px; flex: 1; border-radius: 10px; background: #E5E3DF; transition: background 0.3s; }
</style>

<div class="pg-header">
    <div>
        <div class="pg-title">Nouveau technicien</div>
        <div class="pg-sub">Créez un compte pour votre technicien</div>
    </div>
    <div class="worker-badge">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Nouveau membre
    </div>
</div>

<div class="form-wrap">

    {{-- FORMULAIRE --}}
    <div>
        <form method="POST" action="{{ route('manager.maintenance_workers.store') }}">
            @csrf

            <div class="fcard">
                <div class="fcard-head">
                    <div class="fcard-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fcard-title">Informations du technicien</div>
                        <div class="fcard-sub">Remplissez les champs pour créer le compte</div>
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
                        <label>Nom complet <span class="req">*</span></label>
                        <input type="text" name="name"
                            value="{{ old('name') }}"
                            placeholder="ex: Jean Dupont" required>
                    </div>

                    <div class="field">
                        <label>Adresse email <span class="req">*</span></label>
                        <input type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="ex: jean.dupont@email.com" required>
                        <div class="field-hint">Utilisée pour la connexion au portail</div>
                    </div>

                    <div class="field">
                        <label>Compétence <span class="req">*</span></label>
                        <select name="competence" required style="width:100%;height:46px;background:#F8F7F5;border:1.5px solid #E5E3DF;border-radius:9px;padding:0 14px;font-size:14px;font-family:'DM Sans',sans-serif;color:#1A1A2E;outline:none;">
                            <option value="">Sélectionner...</option>
                            <option value="maçon" {{ old('competence')=='maçon' ? 'selected' : '' }}>Maçon</option>
                            <option value="plombier" {{ old('competence')=='plombier' ? 'selected' : '' }}>Plombier</option>
                            <option value="autre" {{ old('competence')=='autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        <div class="field-hint">Spécialité du technicien</div>
                    </div>

                    <div class="field">
                        <label>Mot de passe <span class="req">*</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="pwField"
                                placeholder="Minimum 8 caractères" required
                                oninput="updateStrength(this.value)">
                            <button type="button" class="pw-toggle" onclick="togglePw()">
                                <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="strength-bar">
                            <div class="strength-seg" id="s1"></div>
                            <div class="strength-seg" id="s2"></div>
                            <div class="strength-seg" id="s3"></div>
                            <div class="strength-seg" id="s4"></div>
                        </div>
                        <div class="field-hint" id="strengthLabel">Entrez un mot de passe</div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Créer le technicien
                    </button>
                    <a href="{{ route('manager.maintenance_workers.index') }}" class="btn-cancel">Annuler</a>
                </div>
            </div>
        </form>
    </div>

    {{-- SIDEBAR --}}
    <div>
        <div class="side-card">
            <div class="side-head">💡 Informations utiles</div>
            <div class="side-body">
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(201,169,110,0.12);">
                        <svg width="14" height="14" fill="none" stroke="#C9A96E" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="tip-title">Accès par code</div>
                        <div class="tip-desc">Le technicien pourra se connecter via son email et mot de passe sur le portail dédié.</div>
                    </div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(16,185,129,0.1);">
                        <svg width="14" height="14" fill="none" stroke="#10B981" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="tip-title">Mot de passe sécurisé</div>
                        <div class="tip-desc">Utilisez au moins 8 caractères avec des majuscules, chiffres et symboles.</div>
                    </div>
                </div>
                <div class="tip-item">
                    <div class="tip-icon" style="background:rgba(99,102,241,0.1);">
                        <svg width="14" height="14" fill="none" stroke="#6366F1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="tip-title">Email unique</div>
                        <div class="tip-desc">L'adresse email doit être unique dans le système.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function togglePw() {
    const f = document.getElementById('pwField');
    const icon = document.getElementById('eyeIcon');
    if (f.type === 'password') {
        f.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        f.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

function updateStrength(val) {
    const segs = [document.getElementById('s1'), document.getElementById('s2'), document.getElementById('s3'), document.getElementById('s4')];
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const colors = ['#EF4444','#F59E0B','#3B82F6','#10B981'];
    const labels = ['Très faible','Faible','Moyen','Fort'];
    segs.forEach((s, i) => s.style.background = i < score ? colors[score - 1] : '#E5E3DF');
    label.textContent = val.length === 0 ? 'Entrez un mot de passe' : labels[score - 1] ?? 'Très faible';
    label.style.color = val.length === 0 ? '#9CA3AF' : colors[score - 1] ?? '#EF4444';
}
</script>
@endsection
