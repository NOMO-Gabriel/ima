
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Inscriptions</h1>
<a href="{{ route('admin.registrations.create', app()->getLocale()) }}" class="btn btn-primary mb-4">Nouvelle inscription</a>

<table class="table-auto w-full">
    <thead>
        <tr>
            <th>#</th>
            <th>Étudiant</th>
            <th>Formation</th>
            <th>Montant contrat</th>
            <th>Versements</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registrations as $registration)
        <tr>
            <td>{{ $registration->id }}</td>
            <td>{{ $registration->student->first_name }}</td>
            <td>{{ $registration->formation->title }}</td>
            <td>{{ $registration->contract }} FCFA</td>
            <td>{{ $registration->installments->sum('amount') }} FCFA</td>
            <td>
                <a href="{{ route('admin.registrations.show', [app()->getLocale(), $registration]) }}" class="btn btn-sm btn-info">Voir</a>
                <a href="{{ route('admin.registrations.edit', [app()->getLocale(), $registration]) }}" class="btn btn-sm btn-warning">Modifier</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $registrations->links() }}
@endsection
