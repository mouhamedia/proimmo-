@extends('layouts.manager')

@section('content')
<div class="container">
    <h1>Modifier un maintenancier</h1>
    <form action="{{ route('manager.maintenance_workers.update', $worker->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $worker->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $worker->email }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Modifier</button>
        <a href="{{ route('manager.maintenance_workers.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
