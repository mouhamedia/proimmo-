@extends('layouts.app')

@section('page-title', 'Modifier un technicien')

@section('breadcrumb')
    <a href="{{ route('manager.maintenance_workers.index') }}" style="color:#8B8FA8;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#1A1A2E'" onmouseout="this.style.color='#8B8FA8'">Maintenanciers</a>
    &nbsp;/&nbsp;<span style="color:#1A1A2E;font-weight:600;">{{ $worker->name }}</span>
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
        display: inline-flex; align-items: center; gap: 10px;
        background: #F8F7F5; border: 1px solid #E5E3DF;
        border-radius: 8px; padding: 8px 14px;
        font-size: 13px; font-weight: 600; color: #1A1A2E;
        flex-shrink: 0;
    }
    .worker-badge-avatar {
        width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #C9A96E, #E8A455);
        display: flex; align-items: center; justify-content: center;
        font-size: 12px; font-weight: 700; color: #1A1A2E;
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
    label .opt { color: #9CA3AF; font-weight: 400; letter-spacing: 0; text-transform: none; font-size: 10px; margin-left: 4px; }

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
    .pw-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #9CA3AF; padding: 0; display: flex; align-items: center; transition: color 0.2s; }
    .pw-toggle:hover { color: #1A1A2E; }

    /* Separator */
    .section-sep { display: flex; align-items: center; gap: 12px; margin: 22px 0 20px; }
    .section-sep span { font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #9CA3AF; white-space: nowrap; }
    .section-sep::before, .section-sep::after { content: ''; flex: 1; height: 1px; background: #EEECEA; }

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

    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #F5F3F1; font-size: 12px; }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-lbl { color: #8B8FA8; }
    .info-val { font-weight: 600; color: #1A1A2E; }

    /* Profile preview */
    .profile-preview {
        display: flex; align-items: center; gap: 14px;
        padding: 14px 18px;
        background: linear-gradient(135deg, rgba(201,169,110,0.06), rgba(201,169,110,0.02));
        border-bottom: 1px solid #EEECEA;
    }
    .preview-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(135deg, #C9A96E, #E8A455);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; font-weight: 700; color: #1A1A2E;
        flex-shrink: 0;
    }
    .preview-name { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .preview-email { font-size: 11px; color: #8B8FA8; margin-top: 2px; font-family: 'Courier New', monospace; }

    /* Danger zone */
    .danger-zone { background: #FEF2F2; border: 1px solid #FEE2E2; border-radius: 12px; padding: 16px 18px; }
    .danger-title { font-size: 12px; font-weight: 700; color: #991B1B; margin-bottom: 6px; }
    .danger-desc  { font-size: 11px; color: #B91C1C; line-height: 1.5; margin-bottom: 12px; }
    .btn-danger { width: 100%; height: 36px; background: transparent; color: #DC2626; border: 1.5px solid #DC2626; border-radius: 7px; font-size: 12px; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s; }
    .btn-danger:hover { background: #DC2626; color: #fff; }

    /* Strength */
    .strength-bar { display: flex; gap: 3px; margin-top: 7px; }
    .strength-seg { height: 3px; flex: 1; border-radius: 10px; background: #E5E3DF; transition: background 0.3s; }
</style>

<div class="pg-header">
    <div>
        <div class="pg-title">Modifier le technicien</div>
        <div class="pg-sub">Mettez à jour les informations ci-dessous</div>
    </div>
    <div class="worker-badge">
        <div class="worker-badge-avatar">{{ strtoupper(substr($worker->name, 0, 1)) }}</div>
        {{ $worker->name }}
    </div>
</div>

<div class="form-wrap">
    {{-- FORMULAIRE --}}
    <div>
        <form method="POST" action="{{ route('manager.maintenance_workers.update', $worker->id) }}">
            @csrf
            @method('PUT')
            <div class="fcard">
                <div class="fcard-head">
                    <div class="fcard-icon">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="fcard-title">Informations du technicien</div>
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
                    <div class="field">
                        <label>Nom complet <span class="req">*</span></label>
                        <input type="text" name="name"
                            value="{{ old('name', $worker->name) }}"
                            placeholder="ex: Jean Dupont" required>
                    </div>
                    <div class="field">
                        <label>Adresse email <span class="req">*</span></label>
                        <input type="email" name="email"
                            value="{{ old('email', $worker->email) }}"
                            placeholder="ex: jean.dupont@email.com" required>
                    </div>
                    <div class="section-sep"><span>Changer le mot de passe</span></div>
                    <div class="field">
                        <label>Nouveau mot de passe <span class="opt">(laisser vide pour ne pas changer)</span></label>
                        <div class="pw-wrap">
                            <input type="password" name="password" id="pwField"
                                placeholder="Nouveau mot de passe..."
                                oninput="updateStrength(this.value)">
                            <button type="button" class="pw-toggle" onclick="togglePw()">
                                <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="strength-bar">
                            <div class="strength-seg" id="s1"></div>
                            <div class="strength-seg" id="s2"></div>
                            <div class="strength-seg" id="s3"></div>
                            <div class="strength-seg" id="s4"></div>
                        </div>
                        <div class="field-hint" id="strengthLabel">Laissez vide pour conserver le mot de passe actuel</div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('manager.maintenance_workers.index') }}" class="btn-cancel">Annuler</a>
                </div>
            </div>
        </form>
        {{-- Formulaire suppression (caché) --}}
        <form id="delete-worker-form"
              action="{{ route('manager.maintenance_workers.destroy', $worker->id) }}"
              method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
    {{-- SIDEBAR --}}
    <div>
        <div class="side-card">
            <div class="profile-preview">
                <div class="preview-avatar">{{ strtoupper(substr($worker->name, 0, 1)) }}</div>
                <div>
                    <div class="preview-name">{{ $worker->name }}</div>
                    <div class="preview-email">{{ $worker->email }}</div>
                </div>
            </div>
            <div class="side-body">
                <div class="info-row">
                    <span class="info-lbl">ID technicien</span>
                    <span class="info-val" style="font-family:'Courier New',monospace;">#{{ str_pad($worker->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Statut</span>
                    <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;font-weight:600;color:#059669;">
                        <span style="width:7px;height:7px;border-radius:50%;background:#10B981;display:inline-block;"></span>
                        Actif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Créé le</span>
                    <span class="info-val">{{ $worker->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-lbl">Modifié le</span>
                    <span class="info-val">{{ $worker->updated_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
        <div class="danger-zone">
            <div class="danger-title">⚠️ Zone de danger</div>
            <div class="danger-desc">La suppression du compte est définitive et irréversible.</div>
            <button type="button" class="btn-danger"
                onclick="if(confirm('Supprimer définitivement {{ addslashes($worker->name) }} ?')) document.getElementById('delete-worker-form').submit();">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Supprimer ce technicien
            </button>
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
    if (!val) {
        ['s1','s2','s3','s4'].forEach(id => document.getElementById(id).style.background = '#E5E3DF');
        document.getElementById('strengthLabel').textContent = 'Laissez vide pour conserver le mot de passe actuel';
        document.getElementById('strengthLabel').style.color = '#9CA3AF';
        return;
    }
    const segs = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const colors = ['#EF4444','#F59E0B','#3B82F6','#10B981'];
    const labels = ['Très faible','Faible','Moyen','Fort'];
    segs.forEach((s, i) => s.style.background = i < score ? colors[score - 1] : '#E5E3DF');
    const lbl = document.getElementById('strengthLabel');
    lbl.textContent = labels[score - 1] ?? 'Très faible';
    lbl.style.color = colors[score - 1] ?? '#EF4444';
}
</script>
@endsection
