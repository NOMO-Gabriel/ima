@extends('layouts.app')

@section('content')
    <h2>Veuillez d'abord sélectionner un centre</h2>

    <form method="GET" action="{{ route('admin.absences.index', app()->getLocale()) }}">
        <div class="form-group">
            <label for="center_id">Centre</label>
            <select name="center_id" id="center_id" class="form-control" required>
                <option value="">-- Choisir un centre --</option>
                @foreach ($centers as $center)
                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Voir l'emploi du temps</button>
    </form>
@endsection
