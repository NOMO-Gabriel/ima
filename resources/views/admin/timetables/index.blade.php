@extends('layouts.app')

@section('content')
    <h1>Emploi du temps de la semaine du {{ $weekStartDate->format('d/m/Y') }}</h1>

    <div class="navigation-weeks mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $prevWeek]) }}" class="btn btn-primary">&laquo; Semaine précédente</a>
        <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $nextWeek]) }}" class="btn btn-primary">Semaine suivante &raquo;</a>
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
            text-transform: capitalize;
        }
        table.timetable td {
            background-color: #f8f9fa;
        }
        table.timetable td:hover {
            background-color: #e2e6ea;
            cursor: pointer;
            border-radius: 4px;
        }
        table.timetable td.empty {
            color: #bbb;
            font-style: italic;
        }
        .slot-info {
            font-size: 0.9em;
            line-height: 1.3;
        }
        .slot-info strong {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
    </style>

    <table class="timetable">
        <thead>
            <tr>
                <th>Créneau / Jour</th>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <th>{{ \Carbon\Carbon::parse($day)->locale('fr')->isoFormat('dddd') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $slotsByDay = $timetable->slots->groupBy('week_day');
                $timeSlots = [
                    ['08:00:00', '10:30:00'],
                    ['11:00:00', '13:30:00'],
                    ['14:00:00', '16:30:00'],
                ];
            @endphp

            @foreach ($timeSlots as [$start, $end])
                <tr>
                    <td><strong>{{ \Carbon\Carbon::parse($start)->format('H:i') }} - {{ \Carbon\Carbon::parse($end)->format('H:i') }}</strong></td>

                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        @php
                            $slot = isset($slotsByDay[$day]) ? $slotsByDay[$day]->firstWhere('start_time', $start) : null;
                        @endphp
                        <td class="{{ $slot ? '' : 'empty' }}">
                            <a href="{{ route('admin.slots.edit', ['locale' => app()->getLocale(), 'slot' => $slot]) }}" style="display:block; color:inherit; text-decoration:none;">
                                @if ($slot)
                                    <div class="slot-info">
                                        <p>SALLE {{ $slot->room ?? '—' }}</p>
                                        <p>COURS {{ $slot->course ? $slot->course->title : '—' }}</p>
                                        <p>PROF {{ $slot->teacher ? $slot->teacher->first_name . ' ' . $slot->teacher->last_name : '—' }}</p>
                                    </div>
                                @else
                                    <em>Ajouter</em>
                                @endif
                            </a>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
