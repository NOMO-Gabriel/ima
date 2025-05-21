@extends('layouts.app')

@section('content')
    <h1>Modifier la phase</h1>

    <form action="{{ route('admin.phases.update', [app()->getLocale(), $phase]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="start">Date de début</label>
            <input type="date" name="start" id="start" class="form-control" value="{{ old('start', $phase->start) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="end">Date de fin</label>
            <input type="date" name="end" id="end" class="form-control" value="{{ old('end', $phase->end) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
