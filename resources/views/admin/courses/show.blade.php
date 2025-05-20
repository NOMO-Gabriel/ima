@extends('layouts.app')

@section('title', 'Détails du cours')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Détails du cours</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6 max-w-lg">
        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Code</h2>
            <p class="text-gray-900">{{ $course->code }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Titre</h2>
            <p class="text-gray-900">{{ $course->title }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Description</h2>
            <p class="text-gray-900 whitespace-pre-line">{{ $course->description ?? '—' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-medium text-gray-700">Formations associées</h2>
            @if($course->formations->isEmpty())
                <p class="text-gray-600">Aucune formation associée.</p>
            @else
                <ul class="list-disc pl-5 text-gray-900">
                    @foreach($course->formations as $formation)
                        <li>{{ $formation->title }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}"
           class="inline-block mt-4 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-all">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>
    </div>
@endsection
