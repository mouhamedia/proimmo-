
@extends('layouts.app')

@section('page-title', 'Connexion par code')

@section('content')
<style>
    .legacy-access-wrap {
        max-width: 820px;
        margin: 32px auto 0;
        padding: 28px;
        border-radius: 28px;
        background: #fff;
        border: 1px solid #EEECEA;
        box-shadow: 0 18px 46px rgba(15,23,42,0.08);
    }
    .legacy-access-head {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        margin-bottom: 18px;
    }
    .legacy-access-title { font-size: 24px; font-weight: 700; color: #171A2B; margin: 0; }
    .legacy-access-pill {
        display: inline-flex; padding: 7px 10px; border-radius: 999px; background: #FAF5EA; color: #9A6B2F; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    }
    .legacy-access-note { color: #647083; font-size: 14px; line-height: 1.7; margin-bottom: 22px; }
    .legacy-access-field { margin-bottom: 18px; }
    .legacy-access-field label { display: block; margin-bottom: 10px; font-size: 13px; font-weight: 700; color: #1A1A2E; }
    .legacy-access-field input {
        width: 100%;
        border-radius: 16px;
        border: 1px solid #E6E2DA;
        padding: 15px 16px;
        font-size: 16px;
        background: #FAF9F7;
        transition: box-shadow .2s, border-color .2s, background .2s;
    }
    .legacy-access-field input:focus { outline: none; border-color: #C9A96E; box-shadow: 0 0 0 4px rgba(201,169,110,0.15); background: #fff; }
    .legacy-actions { display: flex; gap: 12px; flex-wrap: wrap; }
    .legacy-actions button, .legacy-actions a {
        display: inline-flex; align-items: center; justify-content: center;
        min-height: 46px; padding: 0 18px; border-radius: 14px; font-weight: 700; text-decoration: none; border: 1px solid transparent;
    }
    .legacy-actions button { background: linear-gradient(135deg, #171A2B, #26314E); color: #fff; min-width: 160px; }
    .legacy-actions a { background: #fff; color: #1A1A2E; border-color: #E6E2DA; }
    .legacy-error { margin-top: 16px; background: #FEF2F2; border: 1px solid #FECACA; color: #B91C1C; padding: 14px 16px; border-radius: 14px; font-size: 13px; }
</style>

<div class="legacy-access-wrap">
    <div class="legacy-access-head">
        <h2 class="legacy-access-title">Accès locataire / maintenancier</h2>
        <span class="legacy-access-pill">Secure access</span>
    </div>
    <div class="legacy-access-note">
        Saisissez le code fourni pour être redirigé automatiquement vers votre espace. Cette version est alignée avec la page principale d’accès.
    </div>
    <form method="POST" action="{{ route('code.access') }}">
        @csrf
        <div class="legacy-access-field">
            <label for="access_code">Code d'accès</label>
            <input type="text" name="access_code" id="access_code" placeholder="#0010" value="{{ old('access_code') }}" required>
            @error('access_code')
                <div class="legacy-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="legacy-actions">
            <button type="submit">Accéder</button>
            <a href="{{ route('login') }}">Connexion classique</a>
        </div>
    </form>
    @if(session('error'))
        <div class="legacy-error">{{ session('error') }}</div>
    @endif
</div>
@endsection
