@extends('layouts.app')

@section('title', 'Liste des Chambres')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Salles</h1>

    <a href="{{ route('admin.rooms.create', ['locale' => app()->getLocale()]) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">Nouvelle Chambre</a>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">Nom</th>
                <th class="px-4 py-2 border">Capacité</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rooms as $room)
                <tr>
                    <td class="px-4 py-2 border">{{ $room->name }}</td>
                    <td class="px-4 py-2 border">{{ $room->capacity }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.rooms.edit', ['locale' => app()->getLocale(), 'room' => $room->id]) }}" class="text-blue-600 hover:underline">Modifier</a>
                        <form action="{{ route('admin.rooms.destroy', ['locale' => app()->getLocale(), 'room' => $room->id]) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
