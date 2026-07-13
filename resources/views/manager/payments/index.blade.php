@extends('layouts.manager')

@section('content')
<style>
    .payments-shell { display: grid; gap: 20px; }
    .payments-hero {
        background: linear-gradient(135deg, #171A2B 0%, #24314F 70%, #C9A96E 180%);
        color: #fff; border-radius: 18px; padding: 26px; position: relative; overflow: hidden;
    }
    .payments-hero::after {
        content: ''; position: absolute; right: -80px; top: -80px; width: 220px; height: 220px; border-radius: 50%; background: rgba(201,169,110,0.14);
    }
    .payments-kicker { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #E8CB97; margin-bottom: 10px; }
    .payments-title { font-size: 28px; font-weight: 700; margin-bottom: 8px; }
    .payments-sub { max-width: 760px; color: rgba(255,255,255,0.82); line-height: 1.7; font-size: 14px; }
    .hero-meta { margin-top: 16px; display: flex; gap: 10px; flex-wrap: wrap; }
    .pill {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 999px;
        background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); font-size: 12px; font-weight: 600;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }
    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 640px) { .stats-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #fff; border: 1px solid #EEECEA; border-radius: 16px; padding: 18px;
        box-shadow: 0 10px 24px rgba(16,24,40,0.04);
    }
    .stat-label { display: block; font-size: 12px; color: #7B7F96; margin-bottom: 10px; }
    .stat-value { font-size: 28px; line-height: 1; font-weight: 700; color: #1A1A2E; }
    .stat-note { margin-top: 8px; font-size: 12px; color: #6B7280; }
    .good { color: #0F9D58; }
    .warn { color: #B45309; }

    .panel {
        background: #fff; border: 1px solid #EEECEA; border-radius: 18px; overflow: hidden;
    }
    .panel-head {
        padding: 18px 20px; border-bottom: 1px solid #F3F1EE; display: flex; justify-content: space-between; align-items: center; gap: 10px;
    }
    .panel-title { font-size: 15px; font-weight: 700; color: #1A1A2E; }
    .panel-sub { font-size: 12px; color: #8B8FA8; margin-top: 4px; }
    .panel-body { padding: 0; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 760px; }
    th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid #F4F1EC; font-size: 13px; }
    th { background: #FAF9F7; color: #7B7F96; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; }
    td { color: #1A1A2E; }
    tr:last-child td { border-bottom: none; }
    .status {
        display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;
    }
    .status.paid { background: #ECFDF5; color: #047857; }
    .status.pending { background: #FFFBEB; color: #B45309; }
    .muted { color: #8B8FA8; }
</style>

<div class="payments-shell">
    <section class="payments-hero">
        <div class="payments-kicker">Finance</div>
        <div class="payments-title">Paiements de {{ $residence->name }}</div>
        <div class="payments-sub">
            Suivi consolidé des encaissements, montants en attente et historique récent. Cette vue sert de base pour le contrôle financier quotidien.
        </div>
        <div class="hero-meta">
            <span class="pill">{{ $paymentCount }} paiement(s)</span>
            <span class="pill">{{ number_format($paidAmount, 0, ',', ' ') }} FCFA encaissés</span>
            <span class="pill">{{ number_format($pendingAmount, 0, ',', ' ') }} FCFA en attente</span>
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Total des paiements</span>
            <div class="stat-value">{{ number_format($totalAmount, 0, ',', ' ') }}</div>
            <div class="stat-note">Montant global enregistré dans la résidence</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Paiements validés</span>
            <div class="stat-value">{{ $paidCount }}</div>
            <div class="stat-note good">Encaissements confirmés</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">En attente</span>
            <div class="stat-value">{{ number_format($pendingAmount, 0, ',', ' ') }}</div>
            <div class="stat-note warn">Montant à relancer</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Taux de validation</span>
            <div class="stat-value">{{ $paymentCount > 0 ? round(($paidCount / $paymentCount) * 100) : 0 }}%</div>
            <div class="stat-note">Basé sur les statuts paid / pending</div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div>
                <div class="panel-title">Historique récent</div>
                <div class="panel-sub">Derniers paiements enregistrés</div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Locataire</th>
                            <th>Appartement</th>
                            <th>Bâtiment</th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ optional($payment->tenant)->name ?? 'N/A' }}</td>
                                <td>{{ optional($payment->apartment)->number ?? 'N/A' }}</td>
                                <td>{{ optional(optional($payment->apartment)->building)->name ?? 'N/A' }}</td>
                                <td>{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($payment->date)->format('d/m/Y') }}</td>
                                <td><span class="status {{ $payment->status }}">{{ $payment->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="muted">Aucun paiement enregistré pour cette résidence.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div style="padding:18px;">
                {{ $payments->links() }}
            </div>
        </div>
    </section>
</div>
@endsection
