@extends('layouts.app')

@section('content')
    <h1>Liste des phases</h1>

    <a href="{{ route('admin.phases.create', app()->getLocale()) }}" class="btn btn-primary mb-3">Nouvelle phase</a>

    @if ($phases->isEmpty())
        <p>Aucune phase enregistrée.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($phases as $phase)
                    <tr>
                        <td>{{ $phase->start }}</td>
                        <td>{{ $phase->end }}</td>
                        <td>
                            <a href="{{ route('admin.phases.edit', [app()->getLocale(), $phase]) }}" class="btn btn-sm btn-warning">Modifier</a>

                            <form action="{{ route('admin.phases.destroy', [app()->getLocale(), $phase]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer cette phase ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
