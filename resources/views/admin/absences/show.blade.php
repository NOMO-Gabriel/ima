@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Présence des élèves pour le slot : {{ $slot->title ?? "Slot #" . $slot->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.absences.store', $slot->id) }}">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->last_name }}</td>
                        <td>{{ $student->first_name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <select name="statuses[{{ $student->id }}]" class="form-select">
                                <option value="present" {{ !$student->is_absent ? 'selected' : '' }}>Présent</option>
                                <option value="absent" {{ $student->is_absent ? 'selected' : '' }}>Absent</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Enregistrer la présence</button>
        </div>
    </form>
</div>
@endsection
