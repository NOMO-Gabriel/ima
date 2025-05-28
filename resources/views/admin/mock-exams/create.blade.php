@extends('layouts.app')

@section('content')
<h1>Créer un concours blanc</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.mock-exams.store', ['locale' => app()->getLocale()]) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="date" class="form-label">Date et heure</label>
        <input type="datetime-local" id="date" name="date" class="form-control" value="{{ old('date') }}" required>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select id="type" name="type" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            <option value="QCM" {{ old('type') == 'QCM' ? 'selected' : '' }}>QCM</option>
            <option value="REDACTION" {{ old('type') == 'REDACTION' ? 'selected' : '' }}>Rédaction</option>
            <option value="MIX" {{ old('type') == 'MIX' ? 'selected' : '' }}>Mixte</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="duration" class="form-label">Durée (minutes)</label>
        <input type="number" id="duration" name="duration" class="form-control" value="{{ old('duration', 0) }}" min="0" required>
    </div>

    <div class="mb-3">
        <label for="formation_id" class="form-label">Formation</label>
        <select id="formation_id" name="formation_id" class="form-select" required>
            <option value="">-- Sélectionner --</option>
            @foreach($formations as $formation)
                <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                    {{ $formation->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="course_ids" class="form-label">Cours associés (facultatif)</label>
        <select id="course_ids" name="course_ids[]" class="form-select" multiple>
            @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ collect(old('course_ids'))->contains($course->id) ? 'selected' : '' }}>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs cours.</small>
    </div>

    <button type="submit" class="btn btn-success">Créer</button>
    <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
