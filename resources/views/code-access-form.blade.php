@extends('layouts.app')

@section('page-title', 'Accès locataire / maintenancier')

@section('content')
<div style="max-width:400px;margin:40px auto 0;">
    <h2 style="font-size:22px;font-weight:600;margin-bottom:18px;">Accès locataire / maintenancier</h2>
    <form method="POST" action="{{ route('code.access') }}">
        @csrf
        <label for="access_code" style="font-weight:600;margin-bottom:8px;display:block;">Code d'accès :</label>
        <input type="text" id="access_code" name="access_code" required style="padding:8px 12px;border-radius:6px;border:1px solid #ccc;width:220px;">
        <button type="submit" style="background:#C9A96E;color:#fff;padding:8px 18px;border:none;border-radius:6px;margin-left:10px;font-weight:600;">Accéder</button>
    </form>
</div>
@endsection
