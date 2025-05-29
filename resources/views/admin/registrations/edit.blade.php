
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Modifier l'inscription</h1>

<form method="POST" action="{{ route('admin.registrations.update', [app()->getLocale(), $registration]) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label>Numéro de reçu</label>
        <input type="text" name="receipt_number" value="{{ $registration->receipt_number }}" class="form-control" required>
    </div>

    <div class="mb-4">
        <label>Montant du contrat</label>
        <input type="number" name="contract" value="{{ $registration->contract }}" class="form-control" required>
    </div>

    <div class="mb-4">
        <label>Formation</label>
        <select name="formation_id" class="form-control">
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}" @selected($registration->formation_id == $formation->id)>
                    {{ $formation->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Centre</label>
        <select name="center_id" class="form-control">
            @foreach ($centers as $center)
                <option value="{{ $center->id }}" @selected($registration->center_id == $center->id)>
                    {{ $center->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Méthode de paiement</label>
        <select name="payment_method_id" class="form-control">
            <option value="">-- Aucune --</option>
            @foreach ($paymentMethods as $method)
                <option value="{{ $method->id }}" @selected($registration->payment_method_id == $method->id)>
                    {{ $method->label }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Mettre à jour</button>
</form>
@endsection
