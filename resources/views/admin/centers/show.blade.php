@extends('layouts.app')

@section('content')
<h1>Détails du centre : {{ $center->name }}</h1>

<ul class="list-group">
    <li class="list-group-item"><strong>Code:</strong> {{ $center->code }}</li>
    <li class="list-group-item"><strong>Description:</strong> {{ $center->description ?? '-' }}</li>
    <li class="list-group-item"><strong>Adresse:</strong> {{ $center->address }}</li>
    <li class="list-group-item"><strong>Email contact:</strong> {{ $center->contact_email ?? '-' }}</li>
    <li class="list-group-item"><strong>Téléphone contact:</strong> {{ $center->contact_phone ?? '-' }}</li>
    <li class="list-group-item"><strong>Ville:</strong> {{ $center->city ? $center->city->name : '-' }}</li>
    <li class="list-group-item"><strong>Directeur:</strong> {{ $center->director ? $center->director->name : '-' }}</li>
    <li class="list-group-item"><strong>Responsable:</strong> {{ $center->head ? $center->head->name : '-' }}</li>
    <li class="list-group-item"><strong>Directeur logistique:</strong> {{ $center->logistics_director ? $center->logistics_director->name : '-' }}</li>
    <li class="list-group-item"><strong>Directeur financier:</strong> {{ $center->finance_director ? $center->finance_director->name : '-' }}</li>
    <li class="list-group-item"><strong>Académie:</strong> {{ $center->academy ? $center->academy->name : '-' }}</li>
    <li class="list-group-item"><strong>Actif:</strong> {{ $center->is_active ? 'Oui' : 'Non' }}</li>
    <li class="list-group-item"><strong>Créé le:</strong> {{ optional($center->created_at)->format('d/m/Y H:i') ?? 'non disponible' }}</li>
    <li class="list-group-item"><strong>Mis à jour le:</strong> {{ $center->updated_at->format('d/m/Y H:i') }}</li>
</ul>

<a href="{{ route('admin.centers.index', app()->getLocale()) }}" class="btn btn-secondary mt-3">Retour à la liste</a>
<a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center]) }}" class="btn btn-warning mt-3">Modifier</a>
@endsection
