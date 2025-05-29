
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Nouvelle inscription</h1>

<form method="POST" action="{{ route('admin.registrations.store', app()->getLocale()) }}">
    @csrf

    <div class="mb-4">
        <label>Étudiant</label>
        <select name="student_id" class="form-control">
            @foreach ($students as $student)
                <option value="{{ $student->id }}">{{ $student->first_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Formation</label>
        <select name="formation_id" class="form-control">
            @foreach ($formations as $formation)
                <option value="{{ $formation->id }}">{{ $formation->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Centre</label>
        <select name="center_id" class="form-control">
            @foreach ($centers as $center)
                <option value="{{ $center->id }}">{{ $center->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Méthode de paiement</label>
        <select name="payment_method_id" class="form-control">
            <option value="">-- Aucune --</option>
            @foreach ($paymentMethods as $method)
                <option value="{{ $method->id }}">{{ $method->label }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label>Numéro de reçu</label>
        <input type="text" name="receipt_number" class="form-control" required>
    </div>

    <div class="mb-4">
        <label>Montant du contrat</label>
        <input type="number" name="contract" step="0.01" class="form-control" required>
    </div>

    <div class="mb-4">
        <label>Premier versement (facultatif)</label>
        <input type="number" name="first_installment" step="0.01" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
@endsection
