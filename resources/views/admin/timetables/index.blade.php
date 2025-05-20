@extends('layouts.app')

@section('content')
    <h1>Emploi du temps de la semaine du {{ $weekStartDate->format('d/m/Y') }}</h1>

    <div class="navigation-weeks" style="margin-bottom: 20px;">
        <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $prevWeek]) }}" class="btn btn-primary">&laquo; Semaine précédente</a>
        <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $nextWeek]) }}" class="btn btn-primary" style="float: right;">Semaine suivante &raquo;</a>
    </div>

    <table class="table table-bordered text-center">
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
                            $slot = $slotsByDay[$day]->firstWhere('start_time', $start) ?? null;
                        @endphp
                        <td>
                            @if ($slot)
                                <div>
                                    Salle: {{ $slot->room ?? '—' }}<br>
                                    Cours: {{ $slot->course ? $slot->course->title : '—' }}<br>
                                    Prof: {{ $slot->teacher ? $slot->teacher->name : '—' }}
                                </div>
                            @else
                                —
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
