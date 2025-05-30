@extends('layouts.app')

@section('title', 'Modifier l\'Enseignant: ' . $teacherUser->full_name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifier: {{ $teacherUser->full_name }}</h1>
        <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    @if(session('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
     @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
             <strong>Erreurs de validation :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de modification</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.teachers.update', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST">
                @method('PUT')
                @include('admin.teachers._form', ['teacherUser' => $teacherUser])
            </form>
        </div>
    </div>
</div>
@endsection