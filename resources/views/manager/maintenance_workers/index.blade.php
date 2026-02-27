@extends('layouts.manager')

@section('content')
<div class="container">
    <h1>Liste des maintenanciers</h1>
    <a href="{{ route('manager.maintenance_workers.create') }}" class="btn btn-primary mb-3">Créer un maintenancier</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($workers as $worker)
            <tr>
                <td>{{ $worker->name }}</td>
                <td>{{ $worker->email }}</td>
                <td>
                    <a href="{{ route('manager.maintenance_workers.edit', $worker->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('manager.maintenance_workers.destroy', $worker->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce maintenancier ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
