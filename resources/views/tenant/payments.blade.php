@extends('layouts.tenant')

@section('page-title', 'Mes paiements')
@section('breadcrumb', 'Paiements')

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
    .page-header-title { font-family:'Playfair Display',serif; font-size:22px; font-weight:600; color:#1A1A2E; }

    /* Bandeau alerte impayés */
    .overdue-banner { background:#FEF2F2; border:1px solid #FECACA; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
    .overdue-banner .title { font-size:14px; font-weight:700; color:#991B1B; }
    .overdue-banner .sub   { font-size:12px; color:#B91C1C; margin-top:2px; }
    .overdue-amount { margin-left:auto; text-align:right; flex-shrink:0; }
    .overdue-amount .val { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:#EF4444; }
    .overdue-amount .lbl { font-size:10px; color:#B91C1C; }

    /* Stats row */
    .stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px; }
    @media(max-width:600px){.stats-row{grid-template-columns:1fr 1fr;}}
    .stat-card { background:#fff; border:1px solid #EEECEA; border-radius:14px; padding:18px 20px; }
    .stat-amount { font-family:'Playfair Display',serif; font-size:22px; font-weight:600; margin-bottom:4px; }
    .stat-label  { font-size:12px; color:#8B8FA8; }

    /* Calendrier mensuel */
    .months-section { margin-bottom:24px; }
    .section-title { font-size:14px; font-weight:700; color:#1A1A2E; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
    .months-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:10px; }

    .month-card { border-radius:12px; padding:14px 16px; border:2px solid transparent; position:relative; transition:all .2s; }
    .month-card.paid     { background:#F0FDF4; border-color:#BBF7D0; }
    .month-card.pending  { background:#FFFBEB; border-color:#FDE68A; }
    .month-card.overdue  { background:#FEF2F2; border-color:#FECACA; cursor:pointer; }
    .month-card.overdue:hover { box-shadow:0 4px 14px rgba(239,68,68,.15); transform:translateY(-1px); }
    .month-card.current  { background:#F0FDFA; border-color:#99F6E4; }
    .month-card.upcoming { background:#F9FAFB; border-color:#E5E7EB; }

    .month-label { font-size:12px; font-weight:700; color:#374151; margin-bottom:6px; text-transform:capitalize; }
    .month-amount { font-family:'Playfair Display',serif; font-size:16px; font-weight:600; margin-bottom:6px; }
    .month-status { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; display:inline-flex; align-items:center; gap:4px; }
    .ms-paid     { background:#D1FAE5; color:#065F46; }
    .ms-pending  { background:#FEF3C7; color:#D97706; }
    .ms-overdue  { background:#FEE2E2; color:#991B1B; }
    .ms-current  { background:#CCFBF1; color:#0F766E; }

    .month-pay-btn { margin-top:8px; display:block; width:100%; padding:6px 0; border-radius:7px; background:#EF4444; color:#fff; font-size:11px; font-weight:700; text-align:center; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .2s; }
    .month-pay-btn.teal  { background:#0D9488; }
    .month-pay-btn:hover { opacity:.85; }

    /* Modal paiement */
    .pay-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:500; align-items:center; justify-content:center; }
    .pay-modal-overlay.show { display:flex; }
    .pay-modal { background:#fff; border-radius:16px; padding:28px; width:100%; max-width:440px; margin:16px; }
    .modal-title { font-family:'Playfair Display',serif; font-size:20px; font-weight:600; color:#1A1A2E; margin-bottom:4px; }
    .modal-sub   { font-size:13px; color:#8B8FA8; margin-bottom:20px; }
    .modal-amount { background:#F0FDFA; border-radius:10px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; }
    .modal-amount-val { font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:#0D9488; }

    .method-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:8px; margin-bottom:20px; }
    .method-opt input[type="radio"] { display:none; }
    .method-label { display:flex; flex-direction:column; align-items:center; gap:4px; padding:10px 6px; border:2px solid #EEECEA; border-radius:9px; cursor:pointer; transition:all .2s; font-size:11px; font-weight:600; color:#374151; text-align:center; }
    .method-label:hover { border-color:#0D9488; }
    .method-opt input:checked + .method-label { border-color:#0D9488; background:#F0FDFA; color:#0F766E; }
    .method-icon { font-size:20px; }

    .modal-actions { display:flex; gap:10px; }
    .btn-confirm { flex:1; padding:12px; border-radius:9px; background:#0D9488; color:#fff; font-size:14px; font-weight:700; border:none; cursor:pointer; font-family:'DM Sans',sans-serif; transition:background .2s; }
    .btn-confirm:hover { background:#0F766E; }
    .btn-cancel  { padding:12px 18px; border-radius:9px; background:#fff; color:#6B7280; font-size:13px; font-weight:600; border:1px solid #D1D5DB; cursor:pointer; font-family:'DM Sans',sans-serif; }
    .btn-cancel:hover { background:#F9FAFB; }

    /* Historique */
    .table-card { background:#fff; border:1px solid #EEECEA; border-radius:14px; overflow:hidden; }
    .card-head  { padding:15px 20px; border-bottom:1px solid #EEECEA; }
    .card-title { font-size:14px; font-weight:700; color:#1A1A2E; }
    .table-head { display:grid; grid-template-columns:130px 1fr 130px 80px; gap:16px; padding:11px 20px; background:#F8F7F5; border-bottom:1px solid #EEECEA; font-size:11px; font-weight:700; color:#8B8FA8; letter-spacing:1px; text-transform:uppercase; }
    .table-row  { display:grid; grid-template-columns:130px 1fr 130px 80px; gap:16px; padding:13px 20px; border-bottom:1px solid #F5F3F1; align-items:center; transition:background .12s; }
    .table-row:last-child { border-bottom:none; }
    .table-row:hover { background:#FAFAF8; }
    .status-badge { display:inline-flex; font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px; }
    .status-paid    { background:#D1FAE5; color:#065F46; }
    .status-pending { background:#FEF3C7; color:#D97706; }
    .cell-date   { font-size:12px; color:#6B7280; }
    .cell-method { font-size:13px; font-weight:500; color:#1A1A2E; }
    .cell-amount { font-size:13px; font-weight:700; color:#1A1A2E; }
    .empty-state { padding:50px 20px; text-align:center; font-size:13px; color:#8B8FA8; }
    .empty-icon  { font-size:36px; margin-bottom:12px; }

    @media(max-width:700px){
        .table-head,.table-row{grid-template-columns:90px 1fr 80px;}
        .table-head>*:nth-child(3),.table-row>*:nth-child(3){display:none;}
    }
</style>

<div class="page-header">
    <div class="page-header-title">Mes paiements</div>
</div>

{{-- Bannière impayés --}}
@if($overdueCount > 0)
<div class="overdue-banner">
    <svg width="22" height="22" fill="none" stroke="#EF4444" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <div>
        <div class="title">{{ $overdueCount }} loyer{{ $overdueCount > 1 ? 's' : '' }} en retard</div>
        <div class="sub">Cliquez sur les mois en rouge ci-dessous pour les régler.</div>
    </div>
    <div class="overdue-amount">
        <div class="val">{{ number_format($overdueAmount, 0, ',', ' ') }} FCFA</div>
        <div class="lbl">Total impayé</div>
    </div>
</div>
@endif

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-amount" style="color:#059669;">{{ number_format($totalPaid, 0, ',', ' ') }} FCFA</div>
        <div class="stat-label">Total payé</div>
    </div>
    <div class="stat-card">
        <div class="stat-amount" style="color:#D97706;">{{ number_format($totalPending, 0, ',', ' ') }} FCFA</div>
        <div class="stat-label">En attente de confirmation</div>
    </div>
    <div class="stat-card">
        <div class="stat-amount" style="color:#EF4444;">{{ number_format($overdueAmount, 0, ',', ' ') }} FCFA</div>
        <div class="stat-label">Montant en retard</div>
    </div>
</div>

{{-- Calendrier mensuel --}}
@if($months->count())
<div class="months-section">
    <div class="section-title">
        <svg width="16" height="16" fill="none" stroke="#0D9488" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        Suivi mensuel des loyers
    </div>
    <div class="months-grid">
        @foreach($months as $m)
        @php
            if ($m['paid'])         $cls = 'paid';
            elseif ($m['pending'])  $cls = 'pending';
            elseif ($m['overdue'])  $cls = 'overdue';
            elseif ($m['current'])  $cls = 'current';
            else                    $cls = 'upcoming';
        @endphp
        <div class="month-card {{ $cls }}"
             @if($cls === 'overdue' || $cls === 'current')
             onclick="openModal('{{ $m['month']->format('Y-m') }}', '{{ $m['label'] }}', '{{ number_format($m['amount'], 0, ',', ' ') }}')"
             @endif>
            <div class="month-label">{{ $m['label'] }}</div>
            <div class="month-amount" style="color:{{ $m['paid'] ? '#059669' : ($m['overdue'] ? '#EF4444' : ($m['pending'] ? '#D97706' : '#0D9488')) }}">
                {{ number_format($m['amount'], 0, ',', ' ') }} FCFA
            </div>
            @if($m['paid'])
                <span class="month-status ms-paid">✓ Payé</span>
            @elseif($m['pending'])
                <span class="month-status ms-pending">⏳ En attente</span>
            @elseif($m['overdue'])
                <span class="month-status ms-overdue">⚠ En retard</span>
                <button class="month-pay-btn">Payer maintenant</button>
            @elseif($m['current'])
                <span class="month-status ms-current">📅 Ce mois</span>
                <button class="month-pay-btn teal">Payer le loyer</button>
            @else
                <span class="month-status" style="background:#F3F4F6;color:#9CA3AF;">À venir</span>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Modal paiement --}}
<div class="pay-modal-overlay" id="payModal">
    <div class="pay-modal">
        <div class="modal-title">Payer le loyer</div>
        <div class="modal-sub" id="modalSub">Mois sélectionné</div>
        <div class="modal-amount">
            <span style="font-size:13px;color:#6B7280;">Montant</span>
            <span class="modal-amount-val" id="modalAmount">—</span>
        </div>
        <form method="POST" action="{{ route('tenant.payments.store') }}" id="payForm">
            @csrf
            <input type="hidden" name="month" id="modalMonthInput">
            <div class="method-grid">
                @foreach(['Wave' => '📱', 'Orange Money' => '🟠', 'Virement' => '🏦', 'Espèces' => '💵', 'Carte bancaire' => '💳', 'Autre' => '🔄'] as $method => $icon)
                <div class="method-opt">
                    <input type="radio" name="payment_method" id="m2_{{ Str::slug($method) }}" value="{{ $method }}" {{ $method === 'Wave' ? 'checked' : '' }}>
                    <label class="method-label" for="m2_{{ Str::slug($method) }}">
                        <span class="method-icon">{{ $icon }}</span>
                        {{ $method }}
                    </label>
                </div>
                @endforeach
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-confirm">Confirmer le paiement</button>
                <button type="button" class="btn-cancel" onclick="closeModal()">Annuler</button>
            </div>
        </form>
    </div>
</div>

{{-- Historique --}}
<div class="table-card">
    <div class="card-head">
        <div class="card-title">Historique complet</div>
    </div>
    @if($payments->count())
        <div class="table-head">
            <div>Mois</div>
            <div>Méthode</div>
            <div>Montant</div>
            <div>Statut</div>
        </div>
        @foreach($payments as $pay)
        <div class="table-row">
            <div class="cell-date">{{ \Carbon\Carbon::parse($pay->date)->translatedFormat('F Y') }}</div>
            <div class="cell-method">{{ $pay->payment_method }}</div>
            <div class="cell-amount">{{ number_format($pay->amount, 0, ',', ' ') }} FCFA</div>
            <div><span class="status-badge status-{{ $pay->status }}">{{ $pay->status === 'paid' ? 'Payé' : 'En attente' }}</span></div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon">💳</div>
            Aucun paiement enregistré. Utilisez le calendrier ci-dessus pour payer votre loyer.
        </div>
    @endif
</div>

<script>
function openModal(month, label, amount) {
    document.getElementById('modalSub').textContent    = 'Loyer de ' + label;
    document.getElementById('modalAmount').textContent = amount + ' FCFA';
    document.getElementById('modalMonthInput').value   = month;
    document.getElementById('payModal').classList.add('show');
}
function closeModal() {
    document.getElementById('payModal').classList.remove('show');
}
document.getElementById('payModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
