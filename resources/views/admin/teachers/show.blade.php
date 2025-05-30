@extends('layouts.app')

@section('title', 'Profil Enseignant: ' . $teacherUser->full_name)

@push('styles')
<style>
    .profile-details dt { font-weight: 600; color: #5a5c69; }
    .profile-details dd { margin-bottom: .75rem; color: #364a63; }
    .status-badge { padding: 0.3em 0.6em; border-radius: 0.25rem; font-size: 0.85em; font-weight: 600; color: #fff; text-align: center; }
    .status-badge.success { background-color: #28a745; }
    .status-badge.warning { background-color: #ffc107; color: #212529; }
    .status-badge.danger { background-color: #dc3545; }
    .status-badge.secondary { background-color: #6c757d; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil de: {{ $teacherUser->full_name }}</h1>
        <div>
            <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Modifier
            </a>
            <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}" class="rounded-circle img-thumbnail mb-3" width="150" height="150">
                    <h4 class="mb-0">{{ $teacherUser->full_name }}</h4>
                    <p class="text-muted mb-1">{{ $teacherUser->teacherProfile->profession ?? 'Profession non spécifiée' }}</p>
                    <span class="status-badge {{ $teacherUser->status === 'active' ? 'success' : ($teacherUser->status === 'suspended' ? 'danger' : 'secondary') }}">
                        {{ $teacherUser->status_label }}
                    </span>
                </div>
                <div class="card-footer text-center">
                    @foreach($teacherUser->roles as $role)
                        <span class="badge bg-info text-dark me-1">{{ $role->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Informations du Compte</h6></div>
                <div class="card-body profile-details">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Créé le:</dt><dd class="col-sm-7">{{ $teacherUser->created_at->format('d/m/Y H:i') }}</dd>
                        @if($teacherUser->email_verified_at)
                        <dt class="col-sm-5">Email vérifié:</dt><dd class="col-sm-7">{{ $teacherUser->email_verified_at->format('d/m/Y H:i') }}</dd>
                        @else
                        <dt class="col-sm-5">Email vérifié:</dt><dd class="col-sm-7 text-warning">Non</dd>
                        @endif
                        @if($teacherUser->last_login_at)<dt class="col-sm-5">Dern. connexion:</dt><dd class="col-sm-7">{{ $teacherUser->last_login_at->format('d/m/Y H:i') }}</dd>@endif
                        @if($teacherUser->validator)<dt class="col-sm-5">Validé par:</dt><dd class="col-sm-7">{{ $teacherUser->validator->full_name }} ({{ $teacherUser->validated_at->format('d/m/Y') }})</dd>@endif
                        @if($teacherUser->finalizer)<dt class="col-sm-5">Finalisé par:</dt><dd class="col-sm-7">{{ $teacherUser->finalizer->full_name }} ({{ $teacherUser->finalized_at->format('d/m/Y') }})</dd>@endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Détails de l'Enseignant</h6></div>
                <div class="card-body profile-details">
                    <h5 class="mb-3 border-bottom pb-2">Informations Personnelles (Utilisateur)</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Email:</dt><dd class="col-sm-8">{{ $teacherUser->email }}</dd>
                        <dt class="col-sm-4">Téléphone:</dt><dd class="col-sm-8">{{ $teacherUser->phone_number ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Genre:</dt><dd class="col-sm-8">{{ $teacherUser->gender_label ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Adresse de résidence:</dt><dd class="col-sm-8">{{ $teacherUser->address ?? 'N/A' }}</dd>
                    </dl>
                    <hr>
                    <h5 class="mb-3 border-bottom pb-2">Informations Professionnelles (Profil Enseignant)</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Matricule:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->matricule ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">N° CNI:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->cni ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Date de Naissance:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->birthdate ? $teacherUser->teacherProfile->birthdate->format('d/m/Y') : 'N/A' }}</dd>
                        <dt class="col-sm-4">Lieu de Naissance:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->birthplace ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Salaire:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->salary ? number_format($teacherUser->teacherProfile->salary, 0, ',', ' ') . ' XAF' : 'N/A' }}</dd>
                        <dt class="col-sm-4">Académie d'affectation:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->academy->name ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Département d'affectation:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->department->name ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Ville d'affectation (Profil):</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->city->name ?? 'N/A' }}</dd>
                        <dt class="col-sm-4">Centre Principal:</dt><dd class="col-sm-8">{{ $teacherUser->teacherProfile->center->name ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection