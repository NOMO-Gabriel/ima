@extends('layouts.app')

@section('title', 'Modifier la Formation')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Modifier la Formation</h1>

    <form action="{{ route('admin.formations.update', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" method="POST" class="max-w-xl space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $formation->name) }}" required class="w-full border rounded p-2">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" class="w-full border rounded p-2">{{ old('description', $formation->description) }}</textarea>
            @error('description') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phase_id" class="block font-medium text-gray-700">Phase</label>
            <select name="phase_id" id="phase_id" class="w-full border rounded p-2">
                <option value="">-- Sélectionner une phase --</option>
                @foreach($phases as $phase)
                    <option value="{{ $phase->id }}" {{ old('phase_id', $formation->phase_id) == $phase->id ? 'selected' : '' }}>{{ $phase->name }}</option>
                @endforeach
            </select>
            @error('phase_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
        <a href="{{ route('admin.formations.index', ['locale' => app()->getLocale()]) }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
@endsection
