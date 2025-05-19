@extends('layouts.app')

@section('title', 'Créer une Formation')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Créer une Formation</h1>

    <form action="{{ route('admin.formations.store', ['locale' => app()->getLocale()]) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phase_id" class="block text-sm font-medium text-gray-700">Phase</label>
            <select name="phase_id" id="phase_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                <option value="">— Choisir une phase —</option>
                @foreach($phases as $phase)
                    <option value="{{ $phase->id }}" {{ old('phase_id') == $phase->id ? 'selected' : '' }}>{{ $phase->name }}</option>
                @endforeach
            </select>
            @error('phase_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Créer</button>
        </div>
    </form>
@endsection
