@extends('layouts.app')

@section('content')
<h1>Détails du concours blanc #{{ $exam->id }}</h1>

<table class="table table-bordered">
    <tr>
        <th>Date</th>
        <td>{{ $exam->date->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Type</th>
        <td>{{ $exam->type }}</td>
    </tr>
    <tr>
        <th>Durée (minutes)</th>
        <td>{{ $exam->duration }}</td>
    </tr>
    <tr>
        <th>Formation</th>
        <td>{{ $exam->formation->title ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Cours associés</th>
        <td>
            @if($exam->courses->count())
                <ul>
                    @foreach($exam->courses as $course)
                        <li>{{ $course->title }}</li>
                    @endforeach
                </ul>
            @else
                Aucun cours associé.
            @endif
        </td>
    </tr>
</table>

<a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'exam' => $exam->id]) }}" class="btn btn-warning">Modifier</a>
<a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Retour</a>
@endsection
