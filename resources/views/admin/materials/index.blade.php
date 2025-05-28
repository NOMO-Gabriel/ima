@extends('layouts.app')

@section('content')
<h1>Liste des matériels</h1>

<a href="{{ route('admin.materials.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Ajouter un matériel</a>
<a href="{{ route('admin.commands.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Commander un matériel</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Unité</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($materials as $material)
            <tr>
                <td>{{ $material->name }}</td>
                <td>{{ $material->unit }}</td>
                <td>{{ $material->quantity }}</td>
                <td>
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('admin.materials.destroy', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce matériel ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Aucun matériel trouvé.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
