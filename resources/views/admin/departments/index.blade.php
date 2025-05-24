@extends('layouts.app')

@section('content')
    <h1>Liste des Départements</h1>

    <form method="GET" action="{{ route('admin.departments.index', app()->getLocale()) }}" class="mb-4">
        <input type="text" name="search" placeholder="Recherche..." value="{{ request('search') }}">
        <select name="academy_id">
            <option value="">-- Académie --</option>
            @foreach ($academies as $academy)
                <option value="{{ $academy->id }}" {{ request('academy_id') == $academy->id ? 'selected' : '' }}>
                    {{ $academy->name }}
                </option>
            @endforeach
        </select>
        <select name="status">
            <option value="">-- Statut --</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    <a href="{{ route('admin.departments.create', ['locale' => app()->getLocale()]) }}">+ Nouveau Département</a>
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Code</th>
                <th>Académie</th>
                <th>Chef</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->code }}</td>
                    <td>{{ $department->academy->name ?? '-' }}</td>
                    <td>{{ $department->head->name ?? '-' }}</td>
                    <td>{{ $department->is_active ? '✅ Actif' : '❌ Inactif' }}</td>
                    <td>
                        <a href="{{ route('admin.departments.edit', ['locale' => app()->getLocale(), 'department' => $department]) }}">Modifier</a>
                        <form method="POST" action="{{ route('admin.departments.destroy', ['locale' => app()->getLocale(), 'department' => $department]) }}" style="display:inline-block" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button type="submit">🗑️ Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Aucun département trouvé.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $departments->links() }}
@endsection
