@extends('layouts.app')

@section('title', 'Modifier la Chambre')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier la Salle</h1>

    <form action="{{ route('admin.rooms.update', ['locale' => app()->getLocale(), 'room' => $room->id]) }}" method="POST" class="max-w-xl space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium text-gray-700">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $room->name) }}" required class="w-full border rounded p-2">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="capacity" class="block font-medium text-gray-700">Capacité</label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $room->capacity) }}" min="0" class="w-full border rounded p-2">
            @error('capacity') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
        <a href="{{ route('admin.rooms.index', ['locale' => app()->getLocale()]) }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
@endsection
