@extends('layouts.technician')

@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Espace technicien')

@section('content')
<style>
    .dash-hero {
        background: #1A1A2E; border-radius: 16px; padding: 28px 32px;
        margin-bottom: 24px; position: relative; overflow: hidden;
        display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;
    }
    .dash-hero::before { content: ''; position: absolute; top: -80px; right: -80px; width: 280px; height: 280px; background: #EA580C; opacity: 0.07; border-radius: 50%; }
    .hero-text { position: relative; z-index: 1; }
    .hero-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: #FED7AA; margin-bottom: 8px; }
    .hero-title { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #fff; margin-bottom: 6px; }
    .hero-sub { font-size: 13px; color: rgba(255,255,255,0.4); }
    .hero-stat { position: relative; z-index: 1; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 16px 24px; flex-shrink: 0; text-align: center; }
    .hero-stat-val { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 600; color: #FED7AA; line-height: 1; }
    .hero-stat-lbl { font-size: 11px; color: rgba(255,255,255,0.4); margin-top: 3px; }

    .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
    @media (max-width: 700px) { .stats-grid { grid-template-columns: 1fr 1fr; } }

    .stat-card { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; padding: 18px; position: relative; overflow: hidden; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
    .stat-card.amber::before  { background: #F59E0B; }
    .stat-card.blue::before   { background: #3B82F6; }
    .stat-card.green::before  { background: #10B981; }
    .stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
    .stat-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; }
    .stat-val { font-family: 'Playfair Display', serif; font-size: 26px; font-weight: 600; color: #1A1A2E; line-height: 1; margin-bottom: 3px; }
    .stat-lbl { font-size: 12px; color: #8B8FA8; }

    .card { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; }
    .card-head { padding: 15px 20px; border-bottom: 1px solid #EEECEA; display: flex; align-items: center; justify-content: space-between; }
    .card-title { font-size: 14px; font-weight: 700; color: #1A1A2E; }
    .card-link { font-size: 12px; color: #EA580C; text-decoration: none; font-weight: 600; }
    .card-link:hover { text-decoration: underline; }

    .ticket-row { display: grid; grid-template-columns: 1fr 110px 90px; gap: 16px; padding: 13px 20px; border-bottom: 1px solid #F5F3F1; align-items: center; }
    .ticket-row:last-child { border-bottom: none; }
    .ticket-row:hover { background: #FAFAF8; }
    .ticket-desc { font-size: 13px; color: #1A1A2E; line-height: 1.4; }
    .ticket-apt  { font-size: 11px; color: #8B8FA8; margin-top: 2px; }
    .ticket-date { font-size: 12px; color: #6B7280; }

    .status-badge { display: inline-flex; align-items: center; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
    .status-open        { background: #FEF3C7; color: #D97706; }
    .status-in_progress { background: #DBEAFE; color: #1D4ED8; }
    .status-closed      { background: #D1FAE5; color: #065F46; }

    .empty-state { padding: 40px 20px; text-align: center; font-size: 13px; color: #8B8FA8; }
    .empty-icon { font-size: 32px; margin-bottom: 10px; }

    .profile-card { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .profile-avatar { width: 52px; height: 52px; background: linear-gradient(135deg, #EA580C, #DC2626); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: 700; color: #fff; flex-shrink: 0; font-family: 'DM Sans', sans-serif; }
    .profile-name { font-size: 16px; font-weight: 700; color: #1A1A2E; margin-bottom: 3px; }
    .profile-comp { font-size: 13px; color: #8B8FA8; }
    .profile-code { margin-left: auto; background: #FFF7ED; border: 1px solid #FED7AA; border-radius: 8px; padding: 8px 14px; text-align: center; flex-shrink: 0; }
    .code-label { font-size: 10px; font-weight: 700; color: #EA580C; letter-spacing: 1px; text-transform: uppercase; }
    .code-val { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: #1A1A2E; }
</style>

<div class="dash-hero">
    <div class="hero-text">
        <div class="hero-eyebrow">Espace technicien</div>
        <div class="hero-title">Bonjour, {{ explode(' ', auth()->user()->name)[0] }} 🔧</div>
        <div class="hero-sub">Vos interventions du jour.</div>
    </div>
    <div class="hero-stat">
        <div class="hero-stat-val">{{ $openCount + $inProgressCount }}</div>
        <div class="hero-stat-lbl">Interventions actives</div>
    </div>
</div>

@php $techProfile = \App\Models\Technician::where('user_id', auth()->id())->first(); @endphp
@if($techProfile)
<div class="profile-card">
    <div class="profile-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div>
        <div class="profile-name">{{ auth()->user()->name }}</div>
        <div class="profile-comp">Compétence : {{ $techProfile->competence ?? '—' }}</div>
    </div>
    <div class="profile-code">
        <div class="code-label">Mon code</div>
        <div class="code-val">{{ $techProfile->code }}</div>
    </div>
</div>
@endif

<div class="stats-grid">
    <div class="stat-card amber">
        <div class="stat-top">
            <div class="stat-icon" style="background:#FEF3C7;">
                <svg width="18" height="18" fill="none" stroke="#D97706" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-val">{{ $openCount }}</div>
        <div class="stat-lbl">Tickets ouverts</div>
    </div>

    <div class="stat-card blue">
        <div class="stat-top">
            <div class="stat-icon" style="background:#DBEAFE;">
                <svg width="18" height="18" fill="none" stroke="#1D4ED8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-val">{{ $inProgressCount }}</div>
        <div class="stat-lbl">En cours</div>
    </div>

    <div class="stat-card green">
        <div class="stat-top">
            <div class="stat-icon" style="background:#ECFDF5;">
                <svg width="18" height="18" fill="none" stroke="#059669" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-val">{{ $closedCount }}</div>
        <div class="stat-lbl">Terminés</div>
    </div>
</div>

<div class="card">
    <div class="card-head">
        <span class="card-title">Interventions actives</span>
        <a href="{{ route('technician.tickets.index') }}" class="card-link">Voir tout →</a>
    </div>
    @if($recentTickets->count())
        @foreach($recentTickets as $ticket)
        <div class="ticket-row">
            <div>
                <div class="ticket-desc">{{ Str::limit($ticket->description, 70) }}</div>
                <div class="ticket-apt">Appt. {{ $ticket->apartment->number ?? '—' }} — {{ $ticket->apartment->building->name ?? '' }}</div>
            </div>
            <div>
                <span class="status-badge status-{{ $ticket->status }}">
                    {{ $ticket->status === 'open' ? 'Ouvert' : 'En cours' }}
                </span>
            </div>
            <div class="ticket-date">{{ $ticket->created_at->diffForHumans() }}</div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">✅</div>
            Aucune intervention active. Tout est à jour !
        </div>
    @endif
</div>
@endsection
