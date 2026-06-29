@extends('layouts.tenant')

@section('page-title', 'Nouveau ticket')
@section('breadcrumb', 'Tickets → Créer')

@section('content')
<style>
    .form-card { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; max-width: 640px; }
    .form-head { padding: 20px 24px; border-bottom: 1px solid #EEECEA; }
    .form-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; color: #1A1A2E; }
    .form-sub { font-size: 13px; color: #8B8FA8; margin-top: 4px; }
    .form-body { padding: 24px; }

    .apt-info { display: flex; align-items: center; gap: 12px; background: #F0FDFA; border: 1px solid #CCFBF1; border-radius: 10px; padding: 14px 16px; margin-bottom: 24px; }
    .apt-info-icon { width: 36px; height: 36px; background: #0D9488; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .apt-info-text .label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #0F766E; }
    .apt-info-text .value { font-size: 14px; font-weight: 600; color: #134E4A; }

    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .form-label span { color: #EF4444; margin-left: 2px; }
    .form-textarea {
        width: 100%; padding: 11px 14px; border: 1px solid #D1D5DB; border-radius: 9px;
        font-size: 13px; font-family: 'DM Sans', sans-serif; color: #1A1A2E;
        resize: vertical; min-height: 130px; transition: border-color 0.2s;
        background: #fff;
    }
    .form-textarea:focus { outline: none; border-color: #0D9488; box-shadow: 0 0 0 3px rgba(13,148,136,0.08); }
    .char-count { font-size: 11px; color: #8B8FA8; text-align: right; margin-top: 4px; }

    .form-hint { font-size: 12px; color: #9CA3AF; background: #F9FAFB; border-radius: 8px; padding: 10px 14px; margin-bottom: 24px; }
    .hint-title { font-weight: 600; color: #6B7280; margin-bottom: 6px; }
    .hint-list { list-style: none; padding: 0; }
    .hint-list li { display: flex; align-items: center; gap: 6px; margin-bottom: 4px; font-size: 12px; }
    .hint-list li::before { content: '→'; color: #0D9488; font-weight: 700; }

    .form-actions { display: flex; align-items: center; gap: 12px; padding-top: 4px; }
    .btn-primary { display: inline-flex; align-items: center; gap: 7px; padding: 11px 22px; border-radius: 9px; background: #0D9488; color: #fff; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; font-family: 'DM Sans', sans-serif; }
    .btn-primary:hover { background: #0F766E; }
    .btn-secondary { display: inline-flex; align-items: center; gap: 7px; padding: 11px 18px; border-radius: 9px; background: #fff; color: #6B7280; font-size: 13px; font-weight: 600; border: 1px solid #D1D5DB; text-decoration: none; transition: all 0.2s; }
    .btn-secondary:hover { background: #F9FAFB; color: #1A1A2E; }

    .error-msg { font-size: 12px; color: #DC2626; margin-top: 4px; }
</style>

<div style="margin-bottom: 16px;">
    <a href="{{ route('tenant.tickets.index') }}" style="font-size:13px;color:#0D9488;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour aux tickets
    </a>
</div>

<div class="form-card">
    <div class="form-head">
        <div class="form-title">Nouveau ticket de maintenance</div>
        <div class="form-sub">Décrivez le problème que vous rencontrez dans votre appartement.</div>
    </div>

    <div class="form-body">
        <div class="apt-info">
            <div class="apt-info-icon">
                <svg width="18" height="18" fill="none" stroke="#fff" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="apt-info-text">
                <div class="label">Appartement concerné</div>
                <div class="value">Appartement {{ $apartment->number }} — {{ $apartment->building->name ?? '' }}</div>
            </div>
        </div>

        <div class="form-hint">
            <div class="hint-title">Exemples de problèmes à signaler :</div>
            <ul class="hint-list">
                <li>Fuite d'eau, problème de plomberie</li>
                <li>Panne électrique ou d'éclairage</li>
                <li>Problème de serrure ou de porte</li>
                <li>Climatisation ou chauffage défectueux</li>
            </ul>
        </div>

        <form method="POST" action="{{ route('tenant.tickets.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="description">
                    Description du problème <span>*</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    class="form-textarea"
                    placeholder="Décrivez le problème en détail : lieu précis, symptômes observés, depuis quand…"
                    maxlength="500"
                    oninput="document.getElementById('charCount').textContent = this.value.length"
                >{{ old('description') }}</textarea>
                <div class="char-count"><span id="charCount">{{ strlen(old('description', '')) }}</span> / 500</div>
                @error('description')
                    <div class="error-msg">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Soumettre le ticket
                </button>
                <a href="{{ route('tenant.tickets.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
