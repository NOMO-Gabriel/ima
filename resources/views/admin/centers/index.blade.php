@extends('layouts.app')

@section('content')
<h1>Liste des centres</h1>

<a href="{{ route('admin.centers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Créer un centre</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Code</th>
            <th>Ville</th>
            <th>Directeur</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($centers as $center)
        <tr>
            <td>{{ $center->name }}</td>
            <td>{{ $center->code }}</td>
            <td>{{ $center->city ? $center->city->name : '-' }}</td>
            <td>{{ $center->director ? $center->director->last_name : '-' }}</td>
            <td>{{ $center->is_active ? 'Oui' : 'Non' }}</td>
            <td>
                <a href="{{ route('admin.centers.show', ['locale' => app()->getLocale(), 'center' => $center]) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center]) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('admin.centers.destroy', ['locale' => app()->getLocale(), 'center' => $center]) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $centers->links() }}
@endsection
