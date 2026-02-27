@extends('layouts.app')

@section('content')
<div class="container max-w-md mx-auto mt-10">
    <h2 class="text-xl font-bold mb-4">Code d'accès appartement</h2>
    @if(session('info'))
        <div class="alert alert-info mb-4">{{ session('info') }}</div>
    @endif
    <form method="POST" action="{{ route('access-code.submit') }}">
        @csrf
        <div class="mb-4">
            <label for="access_code" class="block font-medium">Code d'accès</label>
            <input type="text" name="access_code" id="access_code" class="form-input w-full" required>
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>
@endsection
