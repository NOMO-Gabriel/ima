@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle phase</h1>

    <form action="{{ route('admin.phases.store', app()->getLocale()) }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="start">Date de début</label>
            <input type="date" name="start" id="start" class="form-control" value="{{ old('start') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="end">Date de fin</label>
            <input type="date" name="end" id="end" class="form-control" value="{{ old('end') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
    </form>
@endsection
