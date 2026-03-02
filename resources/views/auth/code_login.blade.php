
@extends('layouts.app')

@section('page-title', 'Connexion par code')

@section('content')
<div class="container" style="max-width:400px;margin:auto;padding-top:60px;">
    <h2 style="text-align:center;margin-bottom:30px;">Accès locataire / maintenancier</h2>
    <form method="POST" action="{{ route('code.login') }}">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Code d'accès</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="#0010" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Accéder</button>
    </form>
    @if(session('error'))
        <div style="background:#FEF2F2;border:1px solid #FECACA;color:#DC2626;padding:12px 16px;border-radius:10px;margin-top:20px;font-size:14px;">
            {{ session('error') }}
        </div>
    @endif
</div>
@endsection
