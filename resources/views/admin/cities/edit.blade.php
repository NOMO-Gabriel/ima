@extends('layouts.app')

@section('content')
    <h1>Modifier la ville</h1>

    <form action="{{ route('admin.cities.update', [app()->getLocale(), $city]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom de la ville</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $city->name) }}">
        </div>
        <button type="submit" class="btn btn-primary mt-2">Mettre à jour</button>
    </form>
@endsection
