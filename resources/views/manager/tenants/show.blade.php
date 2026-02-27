
@extends('layouts.app')

@section('page-title', 'Fiche locataire')

@section('breadcrumb')
    <span>Accueil</span> / <a href="{{ route('manager.tenants.index') }}">Locataires</a> / <span>Fiche</span>
@endsection

@section('content')
<style>
    .pg-title { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 600; color: #1A1A2E; margin-bottom: 4px; }
    .card-loc { background: #fff; border: 1px solid #EEECEA; border-radius: 14px; padding: 28px 32px; margin-bottom: 32px; }
    .loc-header { display: flex; align-items: center; gap: 18px; margin-bottom: 18px; }
    .loc-avatar { width: 48px; height: 48px; border-radius: 12px; background: #1A1A2E; color: #C9A96E; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; font-family: 'DM Sans', sans-serif; }
    .loc-info { font-size: 15px; color: #1A1A2E; }
    .loc-label { color: #8B8FA8; font-size: 12px; margin-right: 8px; }
    .loc-status { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }
    .ls-actif { background: #ECFDF5; color: #059669; }
    .ls-inactif { background: #F3F4F6; color: #6B7280; }
    .table-paiements { width: 100%; border-collapse: collapse; margin-top: 18px; }
    .table-paiements th { padding: 10px 16px; text-align: left; font-size: 11px; font-weight: 700; color: #8B8FA8; background: #F8F7F5; border-bottom: 1px solid #EEECEA; }
    .table-paiements td { padding: 12px 16px; font-size: 13px; color: #1A1A2E; border-bottom: 1px solid #F5F3F1; }
    .table-paiements tr:last-child td { border-bottom: none; }
    .btn-retour { display: inline-flex; align-items: center; gap: 7px; background: #F8F7F5; color: #8B8FA8; border: 1px solid #E5E3DF; border-radius: 8px; padding: 8px 18px; font-size: 13px; font-weight: 600; text-decoration: none; margin-bottom: 18px; transition: all 0.2s; }
    .btn-retour:hover { background: #C9A96E; color: #1A1A2E; border-color: #C9A96E; }
</style>

<a href="{{ route('manager.tenants.index') }}" class="btn-retour">
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
    Retour à la liste
</a>

<div class="pg-title">Fiche du locataire</div>

<div class="card-loc">
    <div class="loc-header">
        <div class="loc-avatar">
            {{ strtoupper(substr($tenant->name, 0, 1)) }}{{ strtoupper(substr(strstr($tenant->name, ' ') ?: $tenant->name, 1, 1)) }}
        </div>
        <div>
            <div class="loc-info" style="font-weight:600;font-size:17px;">{{ $tenant->name }}</div>
            <div class="loc-label">Depuis {{ $tenant->created_at->format('M Y') }}</div>
        </div>
    </div>
    <div style="margin-bottom:10px;">
        <span class="loc-label">Email :</span> {{ $tenant->email }}<br>
        <span class="loc-label">Téléphone :</span> {{ $tenant->phone ?? '—' }}<br>
        <span class="loc-label">Appartement :</span> {{ $tenant->apartment ? $tenant->apartment->number : 'Non assigné' }}<br>
        <span class="loc-label">Immeuble :</span> {{ $tenant->apartment && $tenant->apartment->building ? $tenant->apartment->building->name : '—' }}<br>
        <span class="loc-label">Statut :</span>
        @if($tenant->apartment)
            <span class="loc-status ls-actif"><span class="dot"></span> Actif</span>
        @else
            <span class="loc-status ls-inactif"><span class="dot"></span> Inactif</span>
        @endif
    </div>
</div>

<div style="margin-bottom:24px;">
    <div class="pg-title" style="font-size:18px;margin-bottom:10px;">Loyers</div>
    <table class="table-paiements">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tenant->payments as $payment)
            <tr>
                <td>{{ \Carbon\Carbon::parse($payment->month)->translatedFormat('F Y') }}</td>
                <td>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                <td>{{ $payment->status == 'paid' ? 'Payé' : 'Impayé' }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Aucun paiement enregistré</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
