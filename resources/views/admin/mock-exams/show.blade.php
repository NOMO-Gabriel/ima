@extends('layouts.app')

@section('content')
<h1>Détails du concours blanc #{{ $mockExam->id }}</h1>

<table class="table table-bordered">
    <tr>
        <th>Date</th>
        <td>{{ $mockExam->date->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
        <th>Type</th>
        <td>{{ $mockExam->type }}</td>
    </tr>
    <tr>
        <th>Durée (minutes)</th>
        <td>{{ $mockExam->duration }}</td>
    </tr>
    <tr>
        <th>Formation</th>
        <td>{{ $mockExam->formation->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>Cours associés</th>
        <td>
            @if($mockExam->courses->count())
                <ul>
                    @foreach($mockExam->courses as $course)
                        <li>{{ $course->title }}</li>
                    @endforeach
                </ul>
            @else
                Aucun cours associé.
            @endif
        </td>
    </tr>
</table>

<a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}" class="btn btn-warning">Modifier</a>
<a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Retour</a>
@endsection
