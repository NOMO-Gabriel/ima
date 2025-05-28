@extends('layouts.app')

@section('content')
<h1>Détail du matériel</h1>

<div class="mb-3"><strong>Nom :</strong> {{ $material->name }}</div>
<div class="mb-3"><strong>Description :</strong> {{ $material->description ?? 'N/A' }}</div>
<div class="mb-3"><strong>Unité :</strong> {{ $material->unit }}</div>
<div class="mb-3"><strong>Quantité :</strong> {{ $material->quantity }}</div>

<a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" class="btn btn-warning">Modifier</a>
<a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Retour</a>
@endsection
