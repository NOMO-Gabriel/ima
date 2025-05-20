@extends('layouts.app')

@section('content')
    <h1>Présences pour le créneau du {{ $slot->week_day }} ({{ $slot->start_time }} - {{ $slot->end_time }})</h1>

    @if ($students->isEmpty())
        <p>Aucun étudiant inscrit à ce créneau.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    @php
                        $isAbsent = in_array($student->id, $absentStudentIds);
                    @endphp
                    <tr>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>
                            @if ($isAbsent)
                                <span class="badge bg-danger">Absent</span>
                            @else
                                <span class="badge bg-success">Présent</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.absences.toggle', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <button type="submit" class="btn btn-sm {{ $isAbsent ? 'btn-success' : 'btn-danger' }}">
                                    Marquer {{ $isAbsent ? 'présent' : 'absent' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
