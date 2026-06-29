@extends('layouts.technician')

@section('page-title', 'Mes interventions')
@section('breadcrumb', 'Interventions')

@section('content')
<style>
    .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-header-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: #1A1A2E; }

    .filter-bar { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .filter-btn { padding: 6px 14px; border-radius: 20px; border: 1px solid #EEECEA; background: #fff; font-size: 12px; font-weight: 600; color: #8B8FA8; cursor: pointer; text-decoration: none; transition: all 0.2s; }
    .filter-btn.active, .filter-btn:hover { background: #EA580C; color: #fff; border-color: #EA580C; }

    .tickets-list { display: flex; flex-direction: column; gap: 12px; }

    .ticket-card { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; overflow: hidden; transition: box-shadow 0.2s; }
    .ticket-card:hover { box-shadow: 0 4px 16px rgba(13,17,23,0.07); }

    .ticket-card-head { padding: 14px 18px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; border-bottom: 1px solid #F5F3F1; }
    .ticket-card-body { padding: 14px 18px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }

    .ticket-id { font-size: 10px; font-weight: 700; color: #8B8FA8; letter-spacing: 1px; margin-bottom: 4px; }
    .ticket-desc { font-size: 14px; font-weight: 500; color: #1A1A2E; line-height: 1.45; flex: 1; }

    .status-badge { display: inline-flex; align-items: center; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 20px; flex-shrink: 0; }
    .status-open        { background: #FEF3C7; color: #D97706; }
    .status-in_progress { background: #DBEAFE; color: #1D4ED8; }
    .status-closed      { background: #D1FAE5; color: #065F46; }

    .ticket-meta { display: flex; align-items: center; gap: 14px; flex: 1; flex-wrap: wrap; }
    .meta-item { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #6B7280; }
    .meta-icon { width: 14px; height: 14px; opacity: 0.6; }

    .status-form { display: flex; align-items: center; gap: 8px; margin-left: auto; flex-shrink: 0; }
    .status-select {
        padding: 7px 10px; border: 1px solid #D1D5DB; border-radius: 8px;
        font-size: 12px; font-family: 'DM Sans', sans-serif; color: #374151;
        background: #fff; cursor: pointer; transition: border-color 0.2s;
    }
    .status-select:focus { outline: none; border-color: #EA580C; }
    .btn-update { padding: 7px 14px; border-radius: 8px; background: #EA580C; color: #fff; font-size: 12px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; font-family: 'DM Sans', sans-serif; }
    .btn-update:hover { background: #C2410C; }

    .empty-state { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; padding: 60px 20px; text-align: center; }
    .empty-icon { font-size: 40px; margin-bottom: 14px; }
    .empty-text { font-size: 14px; color: #8B8FA8; }

    @media (max-width: 600px) {
        .ticket-card-body { flex-direction: column; align-items: flex-start; }
        .status-form { margin-left: 0; width: 100%; }
        .status-select { flex: 1; }
    }
</style>

<div class="page-header">
    <div class="page-header-title">Mes interventions</div>
    <span style="font-size:13px;color:#8B8FA8;">{{ $tickets->count() }} ticket(s) au total</span>
</div>

<div class="filter-bar">
    <a href="{{ route('technician.tickets.index') }}" class="filter-btn {{ !request('status') ? 'active' : '' }}">Tous</a>
    <a href="{{ route('technician.tickets.index', ['status' => 'open']) }}" class="filter-btn {{ request('status') === 'open' ? 'active' : '' }}">Ouverts</a>
    <a href="{{ route('technician.tickets.index', ['status' => 'in_progress']) }}" class="filter-btn {{ request('status') === 'in_progress' ? 'active' : '' }}">En cours</a>
    <a href="{{ route('technician.tickets.index', ['status' => 'closed']) }}" class="filter-btn {{ request('status') === 'closed' ? 'active' : '' }}">Terminés</a>
</div>

@php
    $filtered = request('status') ? $tickets->where('status', request('status')) : $tickets;
@endphp

@if($filtered->count())
<div class="tickets-list">
    @foreach($filtered as $ticket)
    <div class="ticket-card">
        <div class="ticket-card-head">
            <div style="flex:1;">
                <div class="ticket-id">#{{ $ticket->id }}</div>
                <div class="ticket-desc">{{ $ticket->description }}</div>
            </div>
            <span class="status-badge status-{{ $ticket->status }}">
                @if($ticket->status === 'open') Ouvert
                @elseif($ticket->status === 'in_progress') En cours
                @else Terminé
                @endif
            </span>
        </div>
        <div class="ticket-card-body">
            <div class="ticket-meta">
                <div class="meta-item">
                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    </svg>
                    Appt. {{ $ticket->apartment->number ?? '—' }}
                    @if($ticket->apartment?->building)
                        — {{ $ticket->apartment->building->name }}
                    @endif
                </div>
                <div class="meta-item">
                    <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $ticket->created_at->format('d/m/Y') }}
                </div>
            </div>

            @if($ticket->status !== 'closed')
            <form method="POST" action="{{ route('technician.tickets.update', $ticket->id) }}" class="status-form">
                @csrf
                @method('PATCH')
                <select name="status" class="status-select">
                    <option value="open"        {{ $ticket->status === 'open'        ? 'selected' : '' }}>Ouvert</option>
                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                    <option value="closed"      {{ $ticket->status === 'closed'      ? 'selected' : '' }}>Terminé</option>
                </select>
                <button type="submit" class="btn-update">Mettre à jour</button>
            </form>
            @else
            <span style="font-size:12px;color:#059669;font-weight:600;margin-left:auto;">✓ Intervention terminée</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="empty-icon">🔧</div>
    <div class="empty-text">Aucune intervention dans cette catégorie.</div>
</div>
@endif
@endsection
