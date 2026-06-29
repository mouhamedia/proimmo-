@extends('layouts.tenant')

@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Espace locataire')

@section('content')
<style>
    .dash-hero { background:#1A1A2E; border-radius:16px; padding:28px 32px; margin-bottom:24px; position:relative; overflow:hidden; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; }
    .dash-hero::before { content:''; position:absolute; top:-80px; right:-80px; width:280px; height:280px; background:#0D9488; opacity:.07; border-radius:50%; }
    .hero-text { position:relative; z-index:1; }
    .hero-eyebrow { font-size:10px; font-weight:700; letter-spacing:2.5px; text-transform:uppercase; color:#5EEAD4; margin-bottom:8px; }
    .hero-title { font-family:'Playfair Display',serif; font-size:26px; font-weight:600; color:#fff; margin-bottom:6px; }
    .hero-sub { font-size:13px; color:rgba(255,255,255,.4); }
    .hero-apt { position:relative; z-index:1; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); border-radius:12px; padding:16px 20px; flex-shrink:0; min-width:160px; }
    .apt-label { font-size:10px; color:#5EEAD4; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; margin-bottom:6px; }
    .apt-number { font-family:'Playfair Display',serif; font-size:28px; font-weight:600; color:#fff; line-height:1; }
    .apt-type { font-size:11px; color:rgba(255,255,255,.4); margin-top:3px; }

    /* Rappel impayé */
    .alert-overdue { background:#FEF2F2; border:1px solid #FECACA; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
    .alert-overdue-icon { width:40px; height:40px; background:#FEE2E2; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .alert-overdue-text .title { font-size:14px; font-weight:700; color:#991B1B; margin-bottom:3px; }
    .alert-overdue-text .sub { font-size:12px; color:#B91C1C; }
    .alert-overdue-btn { margin-left:auto; background:#EF4444; color:#fff; padding:9px 16px; border-radius:8px; text-decoration:none; font-size:12px; font-weight:700; flex-shrink:0; transition:background .2s; }
    .alert-overdue-btn:hover { background:#DC2626; }

    /* Alert mois en cours */
    .alert-due { background:#FFF7ED; border:1px solid #FED7AA; border-radius:12px; padding:14px 20px; margin-bottom:20px; display:flex; align-items:center; gap:12px; }
    .alert-due-text { font-size:13px; color:#92400E; flex:1; }
    .alert-due-btn { background:#EA580C; color:#fff; padding:8px 14px; border-radius:8px; text-decoration:none; font-size:12px; font-weight:700; flex-shrink:0; transition:background .2s; }
    .alert-due-btn:hover { background:#C2410C; }

    .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
    @media(max-width:800px){.stats-grid{grid-template-columns:1fr 1fr;}}
    .stat-card { background:#fff; border:1px solid #EEECEA; border-radius:14px; padding:18px; position:relative; overflow:hidden; }
    .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
    .stat-card.teal::before  { background:#0D9488; }
    .stat-card.green::before { background:#10B981; }
    .stat-card.red::before   { background:#EF4444; }
    .stat-card.amber::before { background:#F59E0B; }
    .stat-top { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px; }
    .stat-icon { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; }
    .stat-val { font-family:'Playfair Display',serif; font-size:26px; font-weight:600; color:#1A1A2E; line-height:1; margin-bottom:3px; }
    .stat-lbl { font-size:12px; color:#8B8FA8; }

    .apt-card { background:#fff; border:1px solid #EEECEA; border-radius:14px; padding:20px; margin-bottom:20px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
    .apt-card-icon { width:52px; height:52px; background:#F0FDFA; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .apt-card-title { font-family:'Playfair Display',serif; font-size:18px; font-weight:600; color:#1A1A2E; margin-bottom:4px; }
    .apt-card-sub { font-size:13px; color:#8B8FA8; }
    .apt-card-rent { text-align:right; flex-shrink:0; }
    .rent-amount { font-family:'Playfair Display',serif; font-size:22px; font-weight:600; color:#0D9488; }
    .rent-label { font-size:11px; color:#8B8FA8; }

    .main-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media(max-width:800px){.main-grid{grid-template-columns:1fr;}}

    .card { background:#fff; border:1px solid #EEECEA; border-radius:14px; overflow:hidden; }
    .card-head { padding:15px 20px; border-bottom:1px solid #EEECEA; display:flex; align-items:center; justify-content:space-between; }
    .card-title { font-size:14px; font-weight:700; color:#1A1A2E; }
    .card-link { font-size:12px; color:#0D9488; text-decoration:none; font-weight:600; }
    .card-link:hover { text-decoration:underline; }

    .ticket-item { display:flex; align-items:flex-start; gap:10px; padding:12px 18px; border-bottom:1px solid #F5F3F1; }
    .ticket-item:last-child { border-bottom:none; }
    .ticket-desc { font-size:13px; color:#1A1A2E; flex:1; line-height:1.4; }
    .ticket-date { font-size:10px; color:#8B8FA8; margin-top:2px; }

    .status-badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; white-space:nowrap; flex-shrink:0; }
    .status-open        { background:#FEF3C7; color:#D97706; }
    .status-in_progress { background:#DBEAFE; color:#1D4ED8; }
    .status-closed      { background:#D1FAE5; color:#065F46; }

    .pay-item { display:flex; align-items:center; gap:10px; padding:11px 18px; border-bottom:1px solid #F5F3F1; }
    .pay-item:last-child { border-bottom:none; }
    .pay-info-label { font-size:12px; font-weight:600; color:#1A1A2E; }
    .pay-date { font-size:10px; color:#8B8FA8; }

    .empty-state { padding:30px 18px; text-align:center; font-size:13px; color:#8B8FA8; }

    .action-btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:9px; text-decoration:none; font-size:13px; font-weight:600; transition:all .2s; background:#0D9488; color:#fff; }
    .action-btn:hover { background:#0F766E; }
</style>

<div class="dash-hero">
    <div class="hero-text">
        <div class="hero-eyebrow">Espace locataire</div>
        <div class="hero-title">Bonjour, {{ explode(' ', auth()->user()->name)[0] }} 👋</div>
        <div class="hero-sub">Bienvenue dans votre espace personnel.</div>
    </div>
    @if($apartment)
    <div class="hero-apt">
        <div class="apt-label">Appartement</div>
        <div class="apt-number">{{ $apartment->number }}</div>
        <div class="apt-type">{{ $apartment->type ?? 'Standard' }}</div>
    </div>
    @endif
</div>

{{-- Rappel loyers en retard --}}
@if($overdueCount > 0)
<div class="alert-overdue">
    <div class="alert-overdue-icon">
        <svg width="20" height="20" fill="none" stroke="#EF4444" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
        </svg>
    </div>
    <div class="alert-overdue-text">
        <div class="title">⚠️ {{ $overdueCount }} loyer{{ $overdueCount > 1 ? 's' : '' }} en retard</div>
        <div class="sub">Montant total dû : {{ number_format($overdueAmount, 0, ',', ' ') }} FCFA — Régularisez dès que possible.</div>
    </div>
    <a href="{{ route('tenant.payments.index') }}" class="alert-overdue-btn">Payer maintenant</a>
</div>
@else
{{-- Rappel loyer du mois en cours --}}
@if($apartment)
<div class="alert-due">
    <svg width="16" height="16" fill="none" stroke="#EA580C" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <div class="alert-due-text">
        Loyer du mois de <strong>{{ now()->translatedFormat('F Y') }}</strong> —
        {{ number_format($apartment->rent_amount, 0, ',', ' ') }} FCFA à régler avant le {{ $nextDueDate?->format('d/m/Y') ?? '30' }}
    </div>
    <a href="{{ route('tenant.payments.index') }}" class="alert-due-btn">Payer</a>
</div>
@endif
@endif

{{-- Infos appartement --}}
@if($apartment)
<div class="apt-card">
    <div class="apt-card-icon">
        <svg width="26" height="26" fill="none" stroke="#0D9488" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 22V12h6v10"/>
        </svg>
    </div>
    <div style="flex:1;">
        <div class="apt-card-title">Appartement {{ $apartment->number }}</div>
        <div class="apt-card-sub">{{ $apartment->building->name ?? '—' }}@if($apartment->building?->residence) — {{ $apartment->building->residence->name }}@endif</div>
    </div>
    <div class="apt-card-rent">
        <div class="rent-amount">{{ number_format($apartment->rent_amount, 0, ',', ' ') }} FCFA</div>
        <div class="rent-label">/ mois</div>
    </div>
</div>
@endif

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card teal">
        <div class="stat-top"><div class="stat-icon" style="background:#F0FDFA;">
            <svg width="18" height="18" fill="none" stroke="#0D9488" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div></div>
        <div class="stat-val">{{ $ticketsCount }}</div>
        <div class="stat-lbl">Tickets soumis</div>
    </div>
    <div class="stat-card amber">
        <div class="stat-top"><div class="stat-icon" style="background:#FEF3C7;">
            <svg width="18" height="18" fill="none" stroke="#D97706" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        </div></div>
        <div class="stat-val">{{ $openTickets }}</div>
        <div class="stat-lbl">Tickets ouverts</div>
    </div>
    <div class="stat-card green">
        <div class="stat-top"><div class="stat-icon" style="background:#ECFDF5;">
            <svg width="18" height="18" fill="none" stroke="#059669" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div></div>
        <div class="stat-val">{{ $paidCount }}</div>
        <div class="stat-lbl">Loyers payés</div>
    </div>
    <div class="stat-card red">
        <div class="stat-top"><div class="stat-icon" style="background:#FEF2F2;">
            <svg width="18" height="18" fill="none" stroke="#EF4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div></div>
        <div class="stat-val">{{ $overdueCount }}</div>
        <div class="stat-lbl">Mois en retard</div>
    </div>
</div>

<div class="main-grid">
    {{-- Tickets récents --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Tickets récents</span>
            <a href="{{ route('tenant.tickets.index') }}" class="card-link">Voir tout →</a>
        </div>
        @if($recentTickets->count())
            @foreach($recentTickets as $ticket)
            <div class="ticket-item">
                <div style="flex:1;">
                    <div class="ticket-desc">{{ Str::limit($ticket->description, 55) }}</div>
                    <div class="ticket-date">{{ $ticket->created_at->diffForHumans() }}</div>
                </div>
                <span class="status-badge status-{{ $ticket->status }}">
                    {{ $ticket->status === 'open' ? 'Ouvert' : ($ticket->status === 'in_progress' ? 'En cours' : 'Fermé') }}
                </span>
            </div>
            @endforeach
        @else
            <div class="empty-state">Aucun ticket soumis.</div>
        @endif
        @if($apartment)
        <div style="padding:12px 18px;border-top:1px solid #F5F3F1;">
            <a href="{{ route('tenant.tickets.create') }}" class="action-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Nouveau ticket
            </a>
        </div>
        @endif
    </div>

    {{-- Paiements récents --}}
    <div class="card">
        <div class="card-head">
            <span class="card-title">Historique paiements</span>
            <a href="{{ route('tenant.payments.index') }}" class="card-link">Voir tout →</a>
        </div>
        @if($recentPayments->count())
            @foreach($recentPayments as $pay)
            <div class="pay-item">
                <div style="flex:1;">
                    <div class="pay-info-label">{{ \Carbon\Carbon::parse($pay->date)->translatedFormat('F Y') }}</div>
                    <div class="pay-date">{{ ucfirst($pay->payment_method) }}</div>
                </div>
                <span class="status-badge {{ $pay->status === 'paid' ? 'status-closed' : 'status-open' }}">
                    {{ $pay->status === 'paid' ? 'Payé' : 'En attente' }}
                </span>
                <span style="font-size:12px;font-weight:700;color:#1A1A2E;margin-left:8px;">{{ number_format($pay->amount, 0, ',', ' ') }}</span>
            </div>
            @endforeach
        @else
            <div class="empty-state">Aucun paiement enregistré.</div>
        @endif
        @if($apartment)
        <div style="padding:12px 18px;border-top:1px solid #F5F3F1;">
            <a href="{{ route('tenant.payments.index') }}" class="action-btn">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Payer mon loyer
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
