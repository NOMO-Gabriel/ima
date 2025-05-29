@extends('layouts.app')

@section('content')
<h1>Modifier le centre : {{ $center->name }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.centers.update', ['locale' => app()->getLocale(), 'center' => $center]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name">Nom</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $center->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="code">Code</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $center->code) }}" required>
    </div>

    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $center->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="address">Adresse</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $center->address) }}" required>
    </div>

    <div class="mb-3">
        <label for="contact_email">Email contact</label>
        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $center->contact_email) }}">
    </div>

    <div class="mb-3">
        <label for="contact_phone">Téléphone contact</label>
        <input type="text" name="contact_phone" class="form-control" value="{{ old('contact_phone', $center->contact_phone) }}">
    </div>

    <div class="mb-3">
        <label for="is_active">Actif ?</label>
        <select name="is_active" class="form-control">
            <option value="1" {{ old('is_active', $center->is_active) == 1 ? 'selected' : '' }}>Oui</option>
            <option value="0" {{ old('is_active', $center->is_active) == 0 ? 'selected' : '' }}>Non</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="city_id">Ville</label>
        <select name="city_id" class="form-control">
            <option value="">-- Choisir une ville --</option>
            @foreach ($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id', $center->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="director_id">Directeur</label>
        <select name="director_id" class="form-control">
            <option value="">-- Choisir un directeur --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('director_id', $center->director_id) == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="head_id">Responsable</label>
        <select name="head_id" class="form-control">
            <option value="">-- Choisir un responsable --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('head_id', $center->head_id) == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="logistics_director_id">Directeur logistique</label>
        <select name="logistics_director_id" class="form-control">
            <option value="">-- Choisir un directeur logistique --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('logistics_director_id', $center->logistics_director_id) == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="finance_director_id">Directeur financier</label>
        <select name="finance_director_id" class="form-control">
            <option value="">-- Choisir un directeur financier --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('finance_director_id', $center->finance_director_id) == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="academy_id">Académie</label>
        <select name="academy_id" class="form-control">
            <option value="">-- Choisir une académie --</option>
            @foreach ($academies as $academy)
                <option value="{{ $academy->id }}" {{ old('academy_id', $center->academy_id) == $academy->id ? 'selected' : '' }}>{{ $academy->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
