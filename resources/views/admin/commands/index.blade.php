@extends('layouts.app')

@section('content')
<h1>Liste des commandes</h1>

<a href="{{ route('admin.commands.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Créer une commande</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Quantité totale</th>
            <th>Utilisateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($commands as $command)
            <tr>
                <td>{{ $command->id }}</td>
                <td>{{ $command->updated_at->format('d/m/Y H:i') }}</td>
                <td>{{ $command->quantity }}</td>
                <td>{{ $command->user->name ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.commands.show', ['locale' => app()->getLocale(), 'command' => $command->id]) }}" class="btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('admin.commands.edit', ['locale' => app()->getLocale(), 'command' => $command->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('admin.commands.destroy', ['locale' => app()->getLocale(), 'command' => $command->id]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Aucune commande trouvée.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
