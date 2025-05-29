@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Détail de l'inscription</h1>

<p><strong>Étudiant :</strong> {{ $registration->student->full_name }}</p>
<p><strong>Formation :</strong> {{ $registration->formation->title }}</p>
<p><strong>Montant contrat :</strong> {{ $registration->contract }} FCFA</p>
<p><strong>Versements :</strong></p>
<ul>
    @foreach ($registration->installments as $installment)
        <li>{{ $installment->amount }} FCFA le {{ $installment->created_at->format('d/m/Y') }}</li>
    @endforeach
</ul>

<a href="{{ route('admin.registrations.edit', [app()->getLocale(), $registration]) }}" class="btn btn-warning">Modifier</a>
@endsection
