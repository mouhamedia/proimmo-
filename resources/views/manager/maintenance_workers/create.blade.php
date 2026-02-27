@extends('layouts.manager')

@section('content')
<div class="container">
    <h1>Créer un maintenancier</h1>
    <form action="{{ route('manager.maintenance_workers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('manager.maintenance_workers.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
