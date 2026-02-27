@extends('layouts.app')

@section('page-title', 'Détail immeuble')

@section('content')
<div class="container mt-4">
    <h2>Détail de l'immeuble</h2>
    <div class="card p-4 mb-3">
        <p><strong>Nom :</strong> {{ $building->name }}</p>
        <p><strong>Adresse :</strong> {{ $building->address }}</p>
        <p><strong>Nombre d'étages :</strong> {{ $building->floors }}</p>
    </div>
    <a href="{{ route('buildings.edit', $building) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('buildings.index') }}" class="btn btn-secondary">Retour à la liste</a>

    <hr>
    <h3>Appartements de cet immeuble</h3>
    <a href="{{ route('apartments.create') }}?building_id={{ $building->id }}" class="btn btn-success mb-2">Ajouter un appartement</a>
    <ul class="list-group">
        @foreach($building->apartments ?? [] as $apartment)
            <li class="list-group-item">
                <a href="{{ route('apartments.show', $apartment) }}">Appartement {{ $apartment->number }} - {{ $apartment->type }} ({{ $apartment->status }})</a>
            </li>
        @endforeach
        @if(empty($building->apartments) || (is_object($building->apartments) && $building->apartments->isEmpty()))
            <li class="list-group-item text-muted">Aucun appartement pour cet immeuble.</li>
        @endif
    </ul>
</div>
@endsection
