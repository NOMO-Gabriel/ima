@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>
                        {{ $direction === 'in' ? 'Enregistrer une entrée' : 'Enregistrer une sortie' }} -
                        {{ $material->name }}
                    </h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Informations du matériel -->
                    <div class="alert alert-info mb-4">
                        <h6>Informations du matériel :</h6>
                        <p class="mb-1"><strong>Nom :</strong> {{ $material->name }}</p>
                        <p class="mb-1"><strong>Stock actuel :</strong> {{ $material->stock }} {{ $material->unit }}</p>
                        <p class="mb-0"><strong>Type :</strong> {{ ucfirst($material->type) }}</p>
                    </div>

                    <form action="{{ route('commands.store', $material) }}" method="POST">
                        @csrf
                        <input type="hidden" name="direction" value="{{ $direction }}">

                        <div class="mb-3">
                            <label for="quantity" class="form-label">
                                Quantité *
                                @if($direction === 'out')
                                    <small class="text-muted">(Stock disponible: {{ $material->stock }})</small>
                                @endif
                            </label>
                            <input type="number"
                                   class="form-control"
                                   id="quantity"
                                   name="quantity"
                                   min="1"
                                   @if($direction === 'out') max="{{ $material->stock }}" @endif
                                   value="{{ old('quantity') }}"
                                   required>
                            @if($direction === 'out')
                                <div class="form-text">
                                    Maximum autorisé : {{ $material->stock }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ville</label>
                            <select class="form-control" id="city_id" name="city_id">
                                <option value="">Sélectionner une ville</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="center_id" class="form-label">Centre</label>
                            <select class="form-control" id="center_id" name="center_id">
                                <option value="">Sélectionner un centre</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                        {{ $center->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.materials.show', $material) }}" class="btn btn-secondary">
                                        Annuler
                                    </a>
                                    <button type="submit" class="btn {{ $direction === 'in' ? 'btn-success' : 'btn-warning' }}">
                                        {{ $direction === 'in' ? 'Enregistrer l\'entrée' : 'Enregistrer la sortie' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection