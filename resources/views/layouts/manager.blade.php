@extends('layouts.app')

@section('content')
<div class="container">
    <nav>
        <ul>
            <li><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('manager.buildings.index') }}">Immeubles</a></li>
            <li><a href="{{ route('manager.apartments.index') }}">Appartements</a></li>
            <li><a href="{{ route('manager.tenants.index') }}">Locataires</a></li>
            <li>
                @if(Route::has('payments.index'))
                    <a href="{{ route('payments.index') }}">Paiements</a>
                @else
                    <span style="color:#aaa;cursor:not-allowed;">Paiements</span>
                @endif
            </li>
            <li>
                @if(Route::has('messages.index'))
                    <a href="{{ route('messages.index') }}">Messagerie</a>
                @else
                    <span style="color:#aaa;cursor:not-allowed;">Messagerie</span>
                @endif
            </li>
            <li>
                @if(Route::has('tickets.index'))
                    <a href="{{ route('tickets.index') }}">Tickets</a>
                @else
                    <span style="color:#aaa;cursor:not-allowed;">Tickets</span>
                @endif
            </li>
        </ul>
    </nav>
    @yield('content')
</div>

<style>
    .container { width: 100%; max-width: 100%; padding: 1rem; }
    nav ul { display: flex; flex-wrap: wrap; gap: 0.75rem; list-style: none; padding: 0; margin: 0 0 1rem; }
    nav a, nav span { display: inline-flex; align-items: center; justify-content: center; min-height: 44px; padding: 0.75rem 1rem; border-radius: 0.75rem; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.04); text-decoration: none; }
    @media (max-width: 640px) {
        .container { padding: 0.75rem; }
        nav ul { gap: 0.5rem; }
        nav a, nav span { width: 100%; justify-content: flex-start; }
    }
</style>
@endsection
