@extends('layouts.app')

@section('title', 'Détail du Centre')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Détail du Centre : {{ $center->name }}</h1>
        <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="text-blue-600 hover:underline mb-6 inline-block">
            ← Retour à la liste
        </a>

        <div class="bg-white rounded-lg shadow p-6">
            <p><strong>Code :</strong> {{ $center->code ?? '—' }}</p>
            <p><strong>Description :</strong> {{ $center->description ?? '—' }}</p>
            <p><strong>Académie :</strong> {{ $center->academy->name ?? '—' }}</p>
            <p><strong>Nombre d’étudiants :</strong> {{ $center->nb_students }}</p>
            <p><strong>Adresse :</strong> {{ $center->address ?? '—' }}</p>
            <p><strong>Email de contact :</strong> {{ $center->contact_email ?? '—' }}</p>
            <p><strong>Téléphone de contact :</strong> {{ $center->contact_phone ?? '—' }}</p>
            <p><strong>Directeur :</strong> {{ $center->director->first_name ?? '—' }} {{ $center->director->last_name ?? '—' }}</p>
            <p><strong>Centre actif :</strong> {{ $center->is_active ? 'Oui' : 'Non' }}</p>
            <p><strong>Créé le :</strong> {{ $center->created_at->format('d/m/Y') }}</p>
            <p><strong>Mis à jour le :</strong> {{ $center->updated_at->format('d/m/Y') }}</p>
        </div>
    </div>
@endsection
