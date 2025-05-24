@extends('layouts.app')

@section('content')
    <h1>Liste des concours</h1>

    <a href="{{ route('admin.entrance-exams.create', app()->getLocale()) }}" class="btn btn-primary mb-3">Ajouter un concours</a>

    @if ($entrance_exams->isEmpty())
        <p>Aucun concours enregistré.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entrance_exams as $exam)
                    <tr>
                        <td>{{ $exam->code }}</td>
                        <td>{{ $exam->name }}</td>
                        <td>
                            <a href="{{ route('admin.entrance-exams.edit', [app()->getLocale(), $exam]) }}" class="btn btn-sm btn-warning">Modifier</a>
                            <form action="{{ route('admin.entrance-exams.destroy', [app()->getLocale(), $exam]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer ce concours ?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
