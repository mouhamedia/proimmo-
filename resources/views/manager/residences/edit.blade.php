@extends('layouts.manager')

@section('content')
<div class="container">
    <h1>Modifier une résidence</h1>
    <form action="{{ route('residences.update', $residence->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $residence->name }}" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ $residence->address }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('residences.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
