@extends('layouts.app')

@section('content')
<h1>Liste des concours blancs</h1>

<a href="{{ route('admin.mock-exams.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Créer un nouveau concours blanc</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Type</th>
            <th>Durée (min)</th>
            <th>Formation</th>
            <th>Cours associés</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mockExams as $mockExam)
            <tr>
                <td>{{ $mockExam->id }}</td>
                <td>{{ $mockExam->date->format('d/m/Y H:i') }}</td>
                <td>{{ $mockExam->type }}</td>
                <td>{{ $mockExam->duration }}</td>
                <td>{{ $mockExam->formation->name ?? 'N/A' }}</td>
                <td>
                    @if($mockExam->courses->count())
                        <ul class="mb-0">
                            @foreach($mockExam->courses as $course)
                                <li>{{ $course->title }}</li>
                            @endforeach
                        </ul>
                    @else
                        Aucun
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.mock-exams.show', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('admin.mock-exams.destroy', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Aucun concours blanc trouvé.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
