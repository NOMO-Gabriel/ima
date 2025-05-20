@extends('layouts.app')

@section('title', 'Détails de l\'académie')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Détails de l'académie</h1>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">
        <div>
            <h2 class="text-sm text-gray-500">Nom</h2>
            <p class="text-lg font-medium">{{ $academy->name }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Code</h2>
            <p class="text-lg font-medium">{{ $academy->code ?? '—' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Description</h2>
            <p class="text-gray-700">{{ $academy->description ?? '—' }}</p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Langue</h2>
            <p class="text-gray-700">
                {{ $academy->lang === 'FR' ? 'Français' : ($academy->lang === 'EN' ? 'Anglais' : '—') }}
            </p>
        </div>

        <div>
            <h2 class="text-sm text-gray-500">Date de création</h2>
            <p class="text-gray-700">{{ $academy->created_at->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}"
           class="text-blue-600 hover:underline">
            ← Retour à la liste
        </a>
    </div>
@endsection
