@php
    $layout = auth()->user()->role === 'tenant'
        ? 'layouts.tenant'
        : (in_array(auth()->user()->role, ['technician', 'maintenance'], true)
            ? 'layouts.technician'
            : (auth()->user()->role === 'admin'
                ? 'layouts.admin'
                : 'layouts.app'));
@endphp

@extends($layout)

@section('page-title', 'Messagerie interne')

@section('breadcrumb')
    <span>Messagerie</span>
@endsection

@section('content')
<style>
    .msg-shell { display: grid; grid-template-columns: 320px 1fr; gap: 18px; }
    @media (max-width: 980px) { .msg-shell { grid-template-columns: 1fr; } }
    .msg-panel {
        background: #fff; border: 1px solid #EEECEA; border-radius: 20px; overflow: hidden;
        box-shadow: 0 12px 30px rgba(16,24,40,0.05);
    }
    .msg-head { padding: 18px 20px; border-bottom: 1px solid #F3F1EE; }
    .msg-title { font-size: 16px; font-weight: 700; color: #1A1A2E; }
    .msg-sub { font-size: 12px; color: #8B8FA8; margin-top: 4px; }
    .msg-body { padding: 18px 20px; }
    .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin-bottom: 18px; }
    @media (max-width: 640px) { .stats-grid { grid-template-columns: 1fr; } }
    .stat {
        background: #FAF9F7; border: 1px solid #F0ECE7; border-radius: 14px; padding: 14px;
    }
    .stat-label { font-size: 11px; color: #8B8FA8; text-transform: uppercase; letter-spacing: 1.3px; margin-bottom: 6px; }
    .stat-value { font-size: 24px; font-weight: 700; color: #1A1A2E; line-height: 1; }
    .contacts { display: grid; gap: 10px; }
    .contact {
        display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 14px;
        text-decoration: none; color: inherit; border: 1px solid #EEECEA; transition: transform .15s, border-color .15s, background .15s;
        background: #fff;
    }
    .contact:hover { border-color: #D9C7A0; transform: translateY(-1px); }
    .contact.active { background: #FFFDF7; border-color: #C9A96E; }
    .avatar {
        width: 42px; height: 42px; border-radius: 14px; background: linear-gradient(135deg, #171A2B, #27314D);
        color: #E7C88E; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;
    }
    .contact-main { min-width: 0; flex: 1; }
    .contact-top { display: flex; justify-content: space-between; gap: 8px; align-items: center; }
    .contact-name { font-size: 13px; font-weight: 700; color: #1A1A2E; }
    .contact-role { font-size: 10px; color: #8B8FA8; text-transform: uppercase; letter-spacing: 1.2px; }
    .contact-last { font-size: 12px; color: #5B6275; margin-top: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .contact-badge { font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 999px; background: #ECFDF5; color: #047857; }
    .contact-badge.warn { background: #FEF3C7; color: #B45309; }

    .thread {
        min-height: 560px; display: flex; flex-direction: column;
    }
    .thread-top {
        padding: 18px 20px; border-bottom: 1px solid #F3F1EE; display: flex; justify-content: space-between; gap: 12px; align-items: center;
    }
    .thread-user { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .thread-avatar { width: 46px; height: 46px; border-radius: 16px; background: linear-gradient(135deg, #C9A96E, #A8824A); color: #1A1A2E; display:flex; align-items:center; justify-content:center; font-weight:700; }
    .thread-name { font-size: 16px; font-weight: 700; color: #1A1A2E; }
    .thread-meta { font-size: 12px; color: #8B8FA8; margin-top: 2px; }
    .thread-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .chip { padding: 8px 10px; border-radius: 999px; background: #FAF9F7; border: 1px solid #EEECEA; font-size: 11px; color: #5B6275; font-weight: 700; }

    .messages-list { flex: 1; overflow-y: auto; padding: 20px; background: linear-gradient(180deg, #fff 0%, #FCFBF8 100%); }
    .bubble-row { display: flex; margin-bottom: 12px; }
    .bubble-row.me { justify-content: flex-end; }
    .bubble {
        max-width: min(78%, 560px);
        padding: 12px 14px;
        border-radius: 18px;
        border: 1px solid #EEECEA;
        background: #fff;
        box-shadow: 0 6px 18px rgba(16,24,40,0.04);
    }
    .bubble.me { background: linear-gradient(135deg, #171A2B, #2A3554); color: #fff; border-color: transparent; }
    .bubble-top { display:flex; justify-content:space-between; gap:10px; margin-bottom: 6px; align-items:center; }
    .bubble-name { font-size: 11px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase; color: #8B8FA8; }
    .bubble.me .bubble-name { color: rgba(255,255,255,0.58); }
    .bubble-time { font-size: 10px; color: #8B8FA8; white-space: nowrap; }
    .bubble.me .bubble-time { color: rgba(255,255,255,0.58); }
    .bubble-body { font-size: 14px; line-height: 1.7; color: #1A1A2E; white-space: pre-wrap; word-break: break-word; }
    .bubble.me .bubble-body { color: rgba(255,255,255,0.95); }

    .composer { padding: 18px 20px; border-top: 1px solid #F3F1EE; background: #fff; }
    .form-row { display: grid; grid-template-columns: 1fr; gap: 12px; }
    .field { display: grid; gap: 8px; }
    .field label { font-size: 12px; font-weight: 700; color: #1A1A2E; }
    .field select, .field input, .field textarea {
        width: 100%; border: 1px solid #E6E2DA; border-radius: 14px; padding: 12px 14px; font-size: 14px; background: #FAF9F7; color: #1A1A2E;
    }
    .field textarea { min-height: 110px; resize: vertical; }
    .send-row { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin-top: 12px; flex-wrap: wrap; }
    .send-btn {
        background: linear-gradient(135deg, #171A2B, #26314E); color: #fff; border: none; border-radius: 14px;
        padding: 12px 16px; font-weight: 700; cursor: pointer;
    }
    .empty { padding: 24px; text-align: center; color: #8B8FA8; font-size: 13px; }
    .section-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #8B8FA8; margin: 16px 0 10px; }

    @media (max-width: 980px) {
        .thread { min-height: 0; }
        .messages-list { min-height: 360px; }
    }
    @media (max-width: 640px) {
        .msg-body, .composer, .messages-list, .thread-top { padding-left: 14px; padding-right: 14px; }
        .bubble { max-width: 100%; }
        .thread-actions { width: 100%; }
        .chip { width: 100%; justify-content: center; text-align: center; }
        .send-row { align-items: stretch; }
        .send-btn { width: 100%; }
    }
</style>

<div class="msg-shell">
    <section class="msg-panel">
        <div class="msg-head">
            <div class="msg-title">Contacts</div>
            <div class="msg-sub">Tous les acteurs autorisés selon votre rôle</div>
        </div>
        <div class="msg-body">
            <div class="stats-grid">
                <div class="stat"><div class="stat-label">Non lus</div><div class="stat-value">{{ $unreadTotal }}</div></div>
                <div class="stat"><div class="stat-label">Envoyés</div><div class="stat-value">{{ $sentTotal }}</div></div>
                <div class="stat"><div class="stat-label">Reçus</div><div class="stat-value">{{ $receivedTotal }}</div></div>
            </div>

            <div class="section-label">Récents</div>
            <div class="contacts">
                @forelse($recipients as $recipient)
                    <a href="{{ route('messages.index', $recipient) }}" class="contact {{ $selectedRecipient && $selectedRecipient->id === $recipient->id ? 'active' : '' }}">
                        <div class="avatar">{{ strtoupper(substr($recipient->name, 0, 1)) }}</div>
                        <div class="contact-main">
                            <div class="contact-top">
                                <div class="contact-name">{{ $recipient->name }}</div>
                                @if($recipient->unread_count > 0)
                                    <div class="contact-badge warn">{{ $recipient->unread_count }}</div>
                                @endif
                            </div>
                            <div class="contact-role">{{ $recipient->role }}</div>
                            <div class="contact-last">
                                {{ $recipient->last_message ? \Illuminate\Support\Str::limit($recipient->last_message->body, 52) : 'Aucun message encore' }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty">Aucun contact disponible pour votre rôle.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="msg-panel thread">
        <div class="thread-top">
            @if($selectedRecipient)
                <div class="thread-user">
                    <div class="thread-avatar">{{ strtoupper(substr($selectedRecipient->name, 0, 1)) }}</div>
                    <div>
                        <div class="thread-name">{{ $selectedRecipient->name }}</div>
                        <div class="thread-meta">{{ $selectedRecipient->role }} · échanges sécurisés</div>
                    </div>
                </div>
                <div class="thread-actions">
                    <span class="chip">{{ $thread->count() }} message(s)</span>
                    <span class="chip">{{ $selectedRecipient->email }}</span>
                </div>
            @else
                <div class="thread-user">
                    <div class="thread-avatar">✉</div>
                    <div>
                        <div class="thread-name">Messagerie interne</div>
                        <div class="thread-meta">Sélectionnez un contact pour commencer</div>
                    </div>
                </div>
            @endif
        </div>

        <div class="messages-list">
            @if($selectedRecipient)
                @forelse($thread as $message)
                    <div class="bubble-row {{ $message->sender_id === auth()->id() ? 'me' : '' }}">
                        <div class="bubble {{ $message->sender_id === auth()->id() ? 'me' : '' }}">
                            <div class="bubble-top">
                                <div class="bubble-name">{{ $message->sender_id === auth()->id() ? 'Vous' : $message->sender->name }}</div>
                                <div class="bubble-time">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($message->subject)
                                <div class="bubble-body" style="font-weight:700;margin-bottom:6px;">{{ $message->subject }}</div>
                            @endif
                            <div class="bubble-body">{{ $message->body }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty">Commencez la conversation en envoyant un premier message.</div>
                @endforelse
            @else
                <div class="empty">Choisissez un contact pour afficher l’historique.</div>
            @endif
        </div>

        <div class="composer">
            <form method="POST" action="{{ route('messages.store') }}">
                @csrf
                <div class="form-row">
                    <div class="field">
                        <label for="recipient_id">Destinataire</label>
                        <select name="recipient_id" id="recipient_id" required>
                            <option value="">Sélectionner un contact</option>
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}" {{ $selectedRecipient && $selectedRecipient->id === $recipient->id ? 'selected' : '' }}>
                                    {{ $recipient->name }} · {{ $recipient->role }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="subject">Sujet</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Objet du message (optionnel)">
                    </div>
                    <div class="field">
                        <label for="body">Message</label>
                        <textarea name="body" id="body" placeholder="Écrivez votre message..." required>{{ old('body') }}</textarea>
                    </div>
                </div>
                <div class="send-row">
                    <div style="font-size:12px;color:#8B8FA8;line-height:1.6;">
                        La messagerie fonctionne entre locataire, technicien, gestionnaire et administrateur selon les droits du compte.
                    </div>
                    <button type="submit" class="send-btn">Envoyer</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection