@extends('layouts.app')

@section('title', 'Créer une Chambre')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Ajouter une Salle</h1>

    <form action="{{ route('admin.rooms.store', ['locale' => app()->getLocale()]) }}" method="POST" class="max-w-xl space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border rounded p-2">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="capacity" class="block font-medium text-gray-700">Capacité</label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity', 0) }}" min="0" class="w-full border rounded p-2">
            @error('capacity') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
        <a href="{{ route('admin.rooms.index', ['locale' => app()->getLocale()]) }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
@endsection
