@extends('layouts.app')

@section('page-title', 'Rapports intelligents')

@section('breadcrumb')
    <span>Rapports</span>
@endsection

@section('content')
<style>
    .reports-shell { display: grid; gap: 20px; }
    .reports-hero {
        background: linear-gradient(135deg, #171A2B 0%, #202A44 55%, #C9A96E 180%);
        border-radius: 20px;
        padding: 28px;
        color: #fff;
        overflow: hidden;
        position: relative;
    }
    .reports-hero::after {
        content: '';
        position: absolute;
        right: -80px;
        top: -80px;
        width: 240px;
        height: 240px;
        border-radius: 50%;
        background: rgba(201, 169, 110, 0.14);
    }
    .hero-kicker { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #D8BD89; margin-bottom: 10px; }
    .hero-title { font-size: 30px; line-height: 1.15; font-weight: 700; margin-bottom: 10px; max-width: 760px; }
    .hero-sub { max-width: 780px; color: rgba(255,255,255,0.8); font-size: 14px; line-height: 1.7; }
    .hero-meta { margin-top: 18px; display: flex; gap: 10px; flex-wrap: wrap; }
    .pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 12px; border-radius: 999px;
        background: rgba(255,255,255,0.09); border: 1px solid rgba(255,255,255,0.12);
        font-size: 12px; font-weight: 600;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }
    @media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 640px) { .kpi-grid { grid-template-columns: 1fr; } }
    .kpi {
        background: #fff; border: 1px solid #EEECEA; border-radius: 16px;
        padding: 18px; box-shadow: 0 10px 30px rgba(16, 24, 40, 0.04);
    }
    .kpi-label { color: #7B7F96; font-size: 12px; margin-bottom: 10px; display: block; }
    .kpi-value { font-size: 30px; font-weight: 700; color: #1A1A2E; line-height: 1; }
    .kpi-note { margin-top: 8px; font-size: 12px; color: #6B7280; }
    .kpi-note.good { color: #0F9D58; }
    .kpi-note.warn { color: #B45309; }
    .kpi-note.bad { color: #B91C1C; }

    .reports-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
    }
    @media (max-width: 1024px) { .reports-grid { grid-template-columns: 1fr; } }

    .panel {
        background: #fff; border: 1px solid #EEECEA; border-radius: 18px; overflow: hidden;
    }
    .panel-head {
        padding: 18px 20px; border-bottom: 1px solid #F3F1EE;
        display: flex; justify-content: space-between; align-items: center; gap: 10px;
    }
    .panel-title { font-size: 15px; font-weight: 700; color: #1A1A2E; }
    .panel-sub { font-size: 12px; color: #8B8FA8; }
    .panel-body { padding: 20px; }

    .bars { display: flex; align-items: flex-end; gap: 10px; min-height: 230px; }
    .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 10px; }
    .bar-box { width: 100%; display: flex; align-items: flex-end; min-height: 170px; }
    .bar {
        width: 100%; border-radius: 12px 12px 4px 4px;
        background: linear-gradient(180deg, #C9A96E 0%, #A8824A 100%);
        min-height: 8px;
    }
    .bar-label { font-size: 11px; color: #8B8FA8; }
    .bar-value { font-size: 12px; font-weight: 700; color: #1A1A2E; }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }
    @media (max-width: 640px) { .grid-2 { grid-template-columns: 1fr; } }
    .mini-card {
        background: #FAF9F7; border: 1px solid #F0ECE7; border-radius: 14px; padding: 14px;
    }
    .mini-card h4 { margin: 0 0 6px; font-size: 13px; color: #1A1A2E; }
    .mini-card p { margin: 0; font-size: 12px; color: #6B7280; line-height: 1.6; }
    .mini-stat { font-size: 22px; font-weight: 700; margin-top: 10px; color: #1A1A2E; }

    .list {
        display: grid; gap: 12px;
    }
    .list-item {
        padding: 14px 16px; border: 1px solid #EEECEA; border-radius: 14px; background: #fff;
    }
    .list-top { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 6px; }
    .list-title { font-size: 13px; font-weight: 700; color: #1A1A2E; }
    .list-meta { font-size: 11px; color: #8B8FA8; }
    .list-desc { font-size: 12px; color: #5B6275; line-height: 1.6; }

    .insight {
        padding: 14px 16px; border-radius: 14px; background: linear-gradient(180deg, #FFFDF7, #FAF6EE);
        border: 1px solid #EFE5D1;
        font-size: 13px; color: #3F3A2E; line-height: 1.7;
    }
    .insight + .insight { margin-top: 10px; }

    .status-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;
        background: #F4F5F7; color: #3F465A;
    }
    .status-chip.good { background: #ECFDF5; color: #047857; }
    .status-chip.warn { background: #FFFBEB; color: #B45309; }
    .status-chip.bad { background: #FEF2F2; color: #B91C1C; }
</style>

<div class="reports-shell">
    <section class="reports-hero">
        <div class="hero-kicker">Rapport intelligent</div>
        <div class="hero-title">Tableau de bord analytique de {{ $residence->name }}</div>
        <div class="hero-sub">
            Vue consolidée des logements, paiements et tickets avec une lecture automatique des tendances.
            L’objectif est simple: voir vite ce qui va bien, ce qui bloque, et quoi faire ensuite.
        </div>
        <div class="hero-meta">
            <span class="pill">{{ $buildings }} immeuble(s)</span>
            <span class="pill">{{ $apartmentCount }} appartement(s)</span>
            <span class="pill">{{ $tenants }} locataire(s)</span>
            <span class="pill">{{ $ticketCount }} ticket(s)</span>
        </div>
    </section>

    <section class="kpi-grid">
        <div class="kpi">
            <span class="kpi-label">Taux d’occupation</span>
            <div class="kpi-value">{{ $occupancyRate }}%</div>
            <div class="kpi-note {{ $occupancyRate >= 85 ? 'good' : ($occupancyRate >= 60 ? 'warn' : 'bad') }}">
                {{ $occupiedCount }} occupé(s), {{ $vacantCount }} vacant(s), {{ $worksCount }} en travaux
            </div>
        </div>
        <div class="kpi">
            <span class="kpi-label">Taux d’encaissement</span>
            <div class="kpi-value">{{ $collectionRate }}%</div>
            <div class="kpi-note {{ $collectionRate >= 80 ? 'good' : 'warn' }}">
                {{ number_format($paidPayments, 0, ',', ' ') }} FCFA encaissés
            </div>
        </div>
        <div class="kpi">
            <span class="kpi-label">Tickets résolus</span>
            <div class="kpi-value">{{ $ticketResolutionRate }}%</div>
            <div class="kpi-note {{ $ticketResolutionRate >= 70 ? 'good' : 'warn' }}">
                {{ $closedTickets }} clôturé(s), {{ $openTickets }} ouvert(s), {{ $progressTickets }} en cours
            </div>
        </div>
        <div class="kpi">
            <span class="kpi-label">Revenu total</span>
            <div class="kpi-value">{{ number_format($totalPayments, 0, ',', ' ') }}</div>
            <div class="kpi-note {{ $revenueDelta === null ? '' : ($revenueDelta >= 0 ? 'good' : 'bad') }}">
                {{ $revenueDelta === null ? 'Comparaison mensuelle indisponible' : (($revenueDelta >= 0 ? '+' : '') . $revenueDelta . '% vs mois précédent') }}
            </div>
        </div>
    </section>

    <section class="reports-grid">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <div class="panel-title">Évolution des revenus sur 6 mois</div>
                    <div class="panel-sub">Paiements validés uniquement, basés sur le champ date</div>
                </div>
                <span class="status-chip {{ array_sum($monthlyRevenue) > 0 ? 'good' : 'warn' }}">{{ array_sum($monthlyRevenue) > 0 ? 'activité détectée' : 'aucune donnée' }}</span>
            </div>
            <div class="panel-body">
                <div class="bars">
                    @php $maxRevenue = max($monthlyRevenue ?: [0]); @endphp
                    @foreach($monthlyRevenue as $index => $revenue)
                        <div class="bar-col">
                            <div class="bar-box">
                                <div class="bar" style="height: {{ $maxRevenue > 0 ? max(8, round(($revenue / $maxRevenue) * 170)) : 8 }}px"></div>
                            </div>
                            <div class="bar-value">{{ number_format($revenue, 0, ',', ' ') }}</div>
                            <div class="bar-label">{{ $monthlyLabels[$index] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <div>
                    <div class="panel-title">Lecture rapide IA</div>
                    <div class="panel-sub">Interprétation automatique des chiffres</div>
                </div>
                <span class="status-chip {{ $occupancyRate >= 70 ? 'good' : 'warn' }}">synthèse</span>
            </div>
            <div class="panel-body">
                <div class="grid-2" style="margin-bottom:14px;">
                    <div class="mini-card">
                        <h4>Locataires</h4>
                        <p>Base active dans la résidence</p>
                        <div class="mini-stat">{{ $tenants }}</div>
                    </div>
                    <div class="mini-card">
                        <h4>Techniciens</h4>
                        <p>Ressources techniques disponibles</p>
                        <div class="mini-stat">{{ $technicians }}</div>
                    </div>
                    <div class="mini-card">
                        <h4>Paiements en attente</h4>
                        <p>Montant à relancer</p>
                        <div class="mini-stat">{{ number_format($pendingPayments, 0, ',', ' ') }}</div>
                    </div>
                    <div class="mini-card">
                        <h4>Immeubles suivis</h4>
                        <p>Couverture du portefeuille</p>
                        <div class="mini-stat">{{ $buildings }}</div>
                    </div>
                </div>

                <div class="insight">
                    @if(count($insights))
                        {{ $insights[0] }}
                    @else
                        Aucune donnée suffisante pour produire une synthèse.
                    @endif
                </div>
                @if(count($insights) > 1)
                    @for($i = 1; $i < count($insights); $i++)
                        <div class="insight">{{ $insights[$i] }}</div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <section class="reports-grid">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <div class="panel-title">Paiements récents</div>
                    <div class="panel-sub">Derniers encaissements enregistrés</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="list">
                    @forelse($recentPayments as $payment)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-title">{{ optional($payment->tenant)->name ?? 'Locataire' }} · Appartement {{ optional($payment->apartment)->number ?? 'N/A' }}</div>
                                <div class="status-chip {{ $payment->status === 'paid' ? 'good' : 'warn' }}">{{ $payment->status }}</div>
                            </div>
                            <div class="list-desc">
                                {{ number_format($payment->amount, 0, ',', ' ') }} FCFA via {{ $payment->payment_method }} le {{ \Illuminate\Support\Carbon::parse($payment->date)->format('d/m/Y') }}
                            </div>
                        </div>
                    @empty
                        <div class="list-item">
                            <div class="list-desc">Aucun paiement trouvé pour cette résidence.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <div>
                    <div class="panel-title">Tickets récents</div>
                    <div class="panel-sub">Incidents et demandes à traiter</div>
                </div>
            </div>
            <div class="panel-body">
                <div class="list">
                    @forelse($recentTickets as $ticket)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-title">Appartement {{ optional($ticket->apartment)->number ?? 'N/A' }}</div>
                                <div class="status-chip {{ $ticket->status === 'closed' ? 'good' : ($ticket->status === 'in_progress' ? 'warn' : 'bad') }}">{{ $ticket->status }}</div>
                            </div>
                            <div class="list-desc">
                                {{ \Illuminate\Support\Str::limit($ticket->description, 120) }}
                            </div>
                        </div>
                    @empty
                        <div class="list-item">
                            <div class="list-desc">Aucun ticket trouvé pour cette résidence.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection