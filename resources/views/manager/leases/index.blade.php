@extends('layouts.app')

@section('page-title', 'Baux')

@section('breadcrumb')
    <span>Baux</span>
@endsection

@section('content')
<style>
    .leases-shell { display: grid; gap: 20px; }
    .leases-hero {
        background: linear-gradient(135deg, #171A2B 0%, #26314E 65%, #C9A96E 180%);
        color: #fff; border-radius: 20px; padding: 28px; position: relative; overflow: hidden;
    }
    .leases-hero::after {
        content: ''; position: absolute; right: -90px; top: -90px; width: 250px; height: 250px; border-radius: 50%; background: rgba(201,169,110,0.16);
    }
    .leases-kicker { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #E7C88E; margin-bottom: 10px; }
    .leases-title { font-size: 30px; font-weight: 700; margin-bottom: 10px; }
    .leases-sub { max-width: 780px; color: rgba(255,255,255,0.8); line-height: 1.7; font-size: 14px; }
    .hero-meta { margin-top: 18px; display: flex; gap: 10px; flex-wrap: wrap; }
    .pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 12px; border-radius: 999px;
        background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);
        font-size: 12px; font-weight: 600;
    }

    .stats-grid {
        display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px;
    }
    @media (max-width: 900px) { .stats-grid { grid-template-columns: 1fr; } }
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
        padding: 18px 20px; border-bottom: 1px solid #F3F1EE;
        display: flex; justify-content: space-between; align-items: center; gap: 10px;
    }
    .panel-title { font-size: 15px; font-weight: 700; color: #1A1A2E; }
    .panel-sub { font-size: 12px; color: #8B8FA8; margin-top: 4px; }
    .panel-body { padding: 0; }
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; min-width: 900px; }
    th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid #F4F1EC; font-size: 13px; }
    th { background: #FAF9F7; color: #7B7F96; font-size: 11px; letter-spacing: .04em; text-transform: uppercase; }
    td { color: #1A1A2E; }
    tr:last-child td { border-bottom: none; }
    .status {
        display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; font-size: 11px; font-weight: 700;
    }
    .status.active { background: #ECFDF5; color: #047857; }
    .status.expired { background: #FEF2F2; color: #B91C1C; }
    .status.me { background: #EEF2FF; color: #4338CA; }
    .muted { color: #8B8FA8; }
</style>

<div class="leases-shell">
    <section class="leases-hero">
        <div class="leases-kicker">Gestion contractuelle</div>
        <div class="leases-title">Baux et abonnements</div>
        <div class="leases-sub">
            Vue consolidée des abonnements du projet. Si tu cherchais “Baux”, cette page remplace le lien mort et affiche maintenant les données réelles de la table subscriptions.
        </div>
        <div class="hero-meta">
            <span class="pill">{{ $totalCount }} bail(aux)</span>
            <span class="pill">{{ $activeCount }} actifs</span>
            <span class="pill">{{ $expiredCount }} expirés</span>
        </div>
    </section>

    <section class="stats-grid">
        <div class="stat-card">
            <span class="stat-label">Baux actifs</span>
            <div class="stat-value">{{ $activeCount }}</div>
            <div class="stat-note good">Contrats encore en cours</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Baux expirés</span>
            <div class="stat-value">{{ $expiredCount }}</div>
            <div class="stat-note warn">À renouveler ou clôturer</div>
        </div>
        <div class="stat-card">
            <span class="stat-label">Votre bail</span>
            <div class="stat-value">{{ $myLease ? $myLease->status : 'Aucun' }}</div>
            <div class="stat-note">Compte connecté: {{ auth()->user()->name }}</div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-head">
            <div>
                <div class="panel-title">Liste des baux</div>
                <div class="panel-sub">Affichage des abonnements réels de la base</div>
            </div>
        </div>
        <div class="panel-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Plan</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Statut</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leases as $lease)
                            <tr>
                                <td>
                                    {{ optional($lease->user)->name ?? 'N/A' }}
                                    @if($myLease && $myLease->id === $lease->id)
                                        <span class="status me">vous</span>
                                    @endif
                                </td>
                                <td>{{ optional($lease->plan)->name ?? 'Plan inconnu' }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($lease->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($lease->end_date)->format('d/m/Y') }}</td>
                                <td><span class="status {{ $lease->status }}">{{ $lease->status }}</span></td>
                                <td>{{ optional($lease->plan)->price ? number_format($lease->plan->price, 0, ',', ' ') . ' FCFA' : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="muted">Aucun bail trouvé pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection