@extends('layouts.app')

@section('content')
<div class="container">
    <nav>
        <ul>
            <li><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('buildings.index') }}">Immeubles</a></li>
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
@endsection
