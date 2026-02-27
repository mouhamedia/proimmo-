@extends('layouts.app')

@section('content')
<div class="container">
    <nav>
        <ul>
            <li><a href="{{ route('tenant.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('payments.index') }}">Mes paiements</a></li>
            <li><a href="{{ route('tickets.index') }}">Mes tickets</a></li>
        </ul>
    </nav>
    @yield('content')
</div>
@endsection
