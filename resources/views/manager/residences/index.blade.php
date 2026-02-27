@extends('layouts.manager')

@section('content')
<div class="container">
    <h1>Mes Résidences</h1>
    <a href="{{ route('residences.create') }}" class="btn btn-primary mb-3">Créer une résidence</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($residences as $residence)
            <tr>
                <td>{{ $residence->name }}</td>
                <td>{{ $residence->address }}</td>
                <td>
                    <a href="{{ route('residences.edit', $residence->id) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('residences.destroy', $residence->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette résidence ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
