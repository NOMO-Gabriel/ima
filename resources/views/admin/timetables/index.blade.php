@extends('layouts.app')

@section('content')
<h1>(Centre {{ $center->name }}) Emploi du temps de la semaine du {{ $weekStartDate->format('d/m/Y') }}</h1>

<form method="GET" action="{{ route('admin.timetables.index', app()->getLocale()) }}" class="mb-4">
    <div class="row align-items-end">
        <div class="col-md-4">
            <label for="center_id" class="form-label">Changer de centre</label>
            <select name="center_id" id="center_id" class="form-select" required onchange="this.form.submit()">
                @foreach (\App\Models\Center::all() as $c)
                    <option value="{{ $c->id }}" {{ $center->id === $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="week_start_date" value="{{ $weekStartDate->toDateString() }}">
    </div>
</form>

<div class="navigation-weeks mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $prevWeek, 'center_id' => $center->id]) }}" class="btn btn-primary">&laquo; Semaine précédente</a>
    <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $nextWeek, 'center_id' => $center->id]) }}" class="btn btn-primary">Semaine suivante &raquo;</a>
</div>

<style>
    table.timetable {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        font-family: Arial, sans-serif;
    }
    table.timetable th, table.timetable td {
        border: 1px solid #333;
        padding: 10px;
        vertical-align: top;
        word-wrap: break-word;
        height: 90px;
    }
    table.timetable th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
        text-align: center;
    }
    table.timetable td {
        background-color: #f8f9fa;
    }
    table.timetable td:hover {
        background-color: #e2e6ea;
        cursor: pointer;
    }
    .slot-info {
        font-size: 0.85em;
        margin-bottom: 10px;
    }
    .day-cell {
        background-color: #e9ecef;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        width: 120px;
    }
    .time-cell {
        background-color: #f1f3f4;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        width: 100px;
    }
</style>

@php
    use Illuminate\Support\Str;
    $slotsByDay = $timetable->slots->groupBy('week_day');
@endphp

<table class="timetable">
    <thead>
        <tr>
            <th rowspan="2">Jour</th>
            <th rowspan="2">Horaire</th>
            @foreach ($formations as $formation)
                <th colspan="{{ $formation->rooms->count() }}">{{ $formation->name }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($formations as $formation)
                @foreach ($formation->rooms as $room)
                    <th>{{ $room->name }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($days as $dayIndex => $day)
            @foreach ($periods as $periodIndex => $period)
                <tr>
                    @if ($periodIndex === 0)
                        <td rowspan="{{ count($periods) }}" class="day-cell">
                            <strong>{{ $day->locale('fr')->isoFormat('dddd') }}</strong>
                        </td>
                    @endif

                    <td class="time-cell">
                        <strong>{{ $period['start'] }} - {{ $period['end'] }}</strong>
                    </td>

                    @foreach ($formations as $formation)
                        @foreach ($formation->rooms as $room)
                            @php
                                $slot = $timetable->slots->firstWhere(fn($s) =>
                                    $s->week_day === $dayNames[$dayIndex] &&
                                    $s->start_time === $period['start'] &&
                                    $s->formation_id === $formation->id &&
                                    $s->room_id === $room->id
                                );
                            @endphp
                            <td class="{{ $slot ? '' : 'empty' }}">
                                @if ($slot)
                                    <a href="{{ route('admin.slots.edit', ['locale' => app()->getLocale(), 'slot' => $slot]) }}" style="display:block; color:inherit; text-decoration:none;">
                                        <div class="slot-info">
                                            <strong>COURS :</strong> {{ $slot->course->title ?? '—' }}<br>
                                            <strong>PROF :</strong> {{ $slot->teacher ? $slot->teacher->first_name . ' ' . $slot->teacher->last_name : '—' }}
                                        </div>
                                    </a>
                                @else
                                    <em><a href="#" style="text-decoration: none; color: gray;">Ajouter</a></em>
                                @endif
                            </td>
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
@endsection