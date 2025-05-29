@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Départements</h1>
    <a href="{{ route('admin.departments.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary mb-3">Ajouter un département</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($departments->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Code</th>
                <th>Actif</th>
                <th>Académie</th>
                <th>Responsable</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dep)
            <tr>
                <td><a href="{{ route('admin.departments.show', ['locale' => app()->getLocale(), 'department' => $dep]) }}">{{ $dep->name }}</a></td>
                <td>{{ $dep->code ?? '-' }}</td>
                <td>{{ $dep->is_active ? 'Oui' : 'Non' }}</td>
                <td>{{ $dep->academy->name ?? '-' }}</td>
                <td>{{ $dep->head->last_name ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.departments.edit', ['locale' => app()->getLocale(), 'department' => $dep]) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('admin.departments.destroy', ['locale' => app()->getLocale(), 'department' => $dep]) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $departments->links() }}

    @else
        <p>Aucun département trouvé.</p>
    @endif
</div>
@endsection
