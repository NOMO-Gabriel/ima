@extends('layouts.app')

@section('content')
    <h1>Liste des villes</h1>

    <a href="{{ route('admin.cities.create', app()->getLocale()) }}" class="btn btn-primary mb-3">Ajouter une ville</a>

    @if($cities->isEmpty())
        <p>Aucune ville enregistrée.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cities as $city)
                    <tr>
                        <td>{{ $city->name }}</td>
                        <td>
                            <a href="{{ route('admin.cities.edit', [app()->getLocale(), $city]) }}" class="btn btn-sm btn-warning">Modifier</a>

                            <form action="{{ route('admin.cities.destroy', [app()->getLocale(), $city]) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
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
