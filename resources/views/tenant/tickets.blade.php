@extends('layouts.tenant')

@section('page-title', 'Mes tickets')
@section('breadcrumb', 'Tickets de maintenance')

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-header-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: #1A1A2E; }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 10px 18px; border-radius: 9px; text-decoration: none;
        font-size: 13px; font-weight: 600; background: #0D9488; color: #fff; transition: background 0.2s;
    }
    .btn-primary:hover { background: #0F766E; }

    .filter-bar { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .filter-btn { padding: 6px 14px; border-radius: 20px; border: 1px solid #EEECEA; background: #fff; font-size: 12px; font-weight: 600; color: #8B8FA8; cursor: pointer; text-decoration: none; transition: all 0.2s; }
    .filter-btn.active, .filter-btn:hover { background: #0D9488; color: #fff; border-color: #0D9488; }

    .tickets-table { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; }
    .table-head { display: grid; grid-template-columns: 1fr 120px 120px 90px; gap: 16px; padding: 12px 20px; background: #F8F7F5; border-bottom: 1px solid #EEECEA; font-size: 11px; font-weight: 700; color: #8B8FA8; letter-spacing: 1px; text-transform: uppercase; }
    .table-row { display: grid; grid-template-columns: 1fr 120px 120px 90px; gap: 16px; padding: 14px 20px; border-bottom: 1px solid #F5F3F1; align-items: center; transition: background 0.12s; }
    .table-row:last-child { border-bottom: none; }
    .table-row:hover { background: #FAFAF8; }

    .ticket-desc-cell { font-size: 13px; color: #1A1A2E; line-height: 1.4; }
    .ticket-apt { font-size: 11px; color: #8B8FA8; margin-top: 3px; }
    .ticket-date-cell { font-size: 12px; color: #6B7280; }

    .status-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; }
    .status-open        { background: #FEF3C7; color: #D97706; }
    .status-in_progress { background: #DBEAFE; color: #1D4ED8; }
    .status-closed      { background: #D1FAE5; color: #065F46; }

    .tech-cell { font-size: 12px; color: #6B7280; }

    .empty-state { padding: 50px 20px; text-align: center; }
    .empty-icon { font-size: 36px; margin-bottom: 12px; }
    .empty-text { font-size: 14px; color: #8B8FA8; margin-bottom: 16px; }

    @media (max-width: 700px) {
        .table-head, .table-row { grid-template-columns: 1fr 90px; }
        .table-head > *:nth-child(3), .table-row > *:nth-child(3),
        .table-head > *:nth-child(4), .table-row > *:nth-child(4) { display: none; }
    }
</style>

<div class="page-header">
    <div class="page-header-title">Mes tickets de maintenance</div>
    <a href="{{ route('tenant.tickets.create') }}" class="btn-primary">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau ticket
    </a>
</div>

{{-- Filtres --}}
<div class="filter-bar">
    <a href="{{ route('tenant.tickets.index') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">Tous ({{ $tickets->count() }})</a>
    <a href="{{ route('tenant.tickets.index', ['status' => 'open']) }}" class="filter-btn {{ request('status') === 'open' ? 'active' : '' }}">Ouverts</a>
    <a href="{{ route('tenant.tickets.index', ['status' => 'in_progress']) }}" class="filter-btn {{ request('status') === 'in_progress' ? 'active' : '' }}">En cours</a>
    <a href="{{ route('tenant.tickets.index', ['status' => 'closed']) }}" class="filter-btn {{ request('status') === 'closed' ? 'active' : '' }}">Fermés</a>
</div>

<div class="tickets-table">
    @php
        $filtered = request('status') ? $tickets->where('status', request('status')) : $tickets;
    @endphp

    @if($filtered->count())
        <div class="table-head">
            <div>Description</div>
            <div>Statut</div>
            <div>Technicien</div>
            <div>Date</div>
        </div>
        @foreach($filtered as $ticket)
        <div class="table-row">
            <div>
                <div class="ticket-desc-cell">{{ $ticket->description }}</div>
                <div class="ticket-apt">Appt. {{ $ticket->apartment->number ?? '—' }}</div>
            </div>
            <div>
                <span class="status-badge status-{{ $ticket->status }}">
                    @if($ticket->status === 'open') Ouvert
                    @elseif($ticket->status === 'in_progress') En cours
                    @else Fermé
                    @endif
                </span>
            </div>
            <div class="tech-cell">
                @if($ticket->technician_id)
                    Assigné
                @else
                    <span style="color:#D1D5DB;">Non assigné</span>
                @endif
            </div>
            <div class="ticket-date-cell">{{ $ticket->created_at->format('d/m/Y') }}</div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">🎫</div>
            <div class="empty-text">Aucun ticket pour le moment.</div>
            <a href="{{ route('tenant.tickets.create') }}" class="btn-primary">Créer un ticket</a>
        </div>
    @endif
</div>
@endsection
