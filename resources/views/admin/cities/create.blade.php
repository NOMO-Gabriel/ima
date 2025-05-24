@extends('layouts.app')

@section('content')
    <h1>Ajouter une ville</h1>

    <form action="{{ route('admin.cities.store', app()->getLocale()) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom de la ville</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Enregistrer</button>
    </form>
@endsection
