@extends('layouts.app')

@section('content')
    <h1>Modifier le créneau</h1>

    <form action="{{ route('admin.slots.update', ['locale' => app()->getLocale(), 'slot' => $slot]) }}" method="POST">
        @csrf
        @if($slot->exists)
            @method('PUT')
        @endif

        <input type="hidden" name="timetable_id" value="{{ $slot->timetable_id }}">
        <input type="hidden" name="week_day" value="{{ $slot->week_day }}">
        <input type="hidden" name="start_time" value="{{ $slot->start_time }}">
        <input type="hidden" name="end_time" value="{{ $slot->end_time }}">

        <div class="mb-3">
            <label>Jour : </label>
            <strong>{{ \Carbon\Carbon::parse($slot->week_day)->locale('fr')->isoFormat('dddd') }}</strong>
        </div>

        <div class="mb-3">
            <label>Heure : </label>
            <strong>{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</strong>
        </div>

        <div class="mb-3">
            <label for="room" class="form-label">Salle</label>
            <input type="text" name="room" id="room" class="form-control" value="{{ old('room', $slot->room) }}">
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Professeur</label>
            <select name="teacher_id" id="teacher_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $slot->teacher_id) == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="course_id" class="form-label">Cours</label>
            <select name="course_id" id="course_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach ($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $slot->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $slot->timetable->week_start_date]) }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
