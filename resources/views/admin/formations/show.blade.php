@extends('layouts.app')

@section('title', 'Détails de la Formation')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow space-y-4">
        <h1 class="text-2xl font-bold text-gray-800">{{ $formation->name }}</h1>

        <p><span class="font-semibold">Description :</span></p>
        <p class="text-gray-700 whitespace-pre-line">{{ $formation->description ?? '—' }}</p>

        <p><span class="font-semibold">Phase :</span> {{ $formation->phase->name ?? '—' }}</p>
        <p><span class="font-semibold">Créée le :</span> {{ $formation->created_at->format('d/m/Y') }}</p>
        <p><span class="font-semibold">Dernière modification :</span> {{ $formation->updated_at->format('d/m/Y') }}</p>

        <div class="flex justify-end space-x-2 mt-4">
            <a href="{{ route('admin.formations.edit', ['locale' => app()->getLocale(), 'formation' => $formation]) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Modifier</a>
            <form action="{{ route('admin.formations.destroy', ['locale' => app()->getLocale(), 'formation' => $formation]) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Supprimer</button>
            </form>
        </div>
    </div>
@endsection
