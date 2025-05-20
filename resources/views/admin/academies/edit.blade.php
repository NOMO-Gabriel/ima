@extends('layouts.app')

@section('title', 'Modifier une académie')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Modifier une académie</h1>

    <form action="{{ route('admin.academies.update', ['locale' => app()->getLocale(), 'academy' => $academy]) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $academy->name) }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
            <input type="text" name="code" id="code" value="{{ old('code', $academy->code) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
            @error('code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">{{ old('description', $academy->description) }}</textarea>
        </div>

        <div>
            <label for="lang" class="block text-sm font-medium text-gray-700">Langue</label>
            <select name="lang" id="lang"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm">
                <option value="">-- Sélectionner --</option>
                <option value="FR" {{ old('lang', $academy->lang) == 'FR' ? 'selected' : '' }}>Français</option>
                <option value="EN" {{ old('lang', $academy->lang) == 'EN' ? 'selected' : '' }}>Anglais</option>
            </select>
            @error('lang') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Enregistrer les modifications
            </button>
        </div>
    </form>
@endsection
