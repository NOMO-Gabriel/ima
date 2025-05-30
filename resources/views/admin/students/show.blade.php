@extends('layouts.app') {{-- ou votre layout admin --}}

@section('title', 'Profil Étudiant - ' . $studentUser->first_name . ' ' . $studentUser->last_name)

@section('content')
<div class="student-profile-page">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}">Étudiants</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $studentUser->first_name }} {{ $studentUser->last_name }}</span>
            </div>
            <h1 class="page-title">
                Profil de {{ $studentUser->first_name }} {{ $studentUser->last_name }}
            </h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
            {{-- <a href="{{-- route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) --}}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Modifier l'étudiant
            </a> --}}
        </div>
    </div>

    <div class="profile-layout">
        <!-- Colonne de gauche : Informations principales -->
        <div class="profile-sidebar">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $studentUser->profile_photo_url }}" alt="Photo de {{ $studentUser->first_name }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="card-title">{{ $studentUser->first_name }} {{ $studentUser->last_name }}</h4>
                    <p class="text-muted">Étudiant</p>
                    @php
                        $statusConfig = App\Models\User::getStatuses();
                        $currentStatusLabel = $statusConfig[$studentUser->status] ?? ucfirst(str_replace('_', ' ', $studentUser->status));
                        $statusClass = '';
                        if ($studentUser->status === 'active') $statusClass = 'success';
                        elseif (in_array($studentUser->status, ['pending_validation', 'pending_finalization'])) $statusClass = 'warning';
                        elseif (in_array($studentUser->status, ['suspended', 'rejected'])) $statusClass = 'danger';
                        else $statusClass = 'secondary';
                    @endphp
                    <span class="badge bg-{{ $statusClass }} p-2">{{ $currentStatusLabel }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-envelope fa-fw me-2"></i>{{ $studentUser->email }}</li>
                    @if($studentUser->phone_number)
                    <li class="list-group-item"><i class="fas fa-phone fa-fw me-2"></i>{{ $studentUser->phone_number }}</li>
                    @endif
                    @if($studentUser->gender && isset(App\Http\Controllers\StudentController::getGenders()[$studentUser->gender]))
                    <li class="list-group-item"><i class="fas fa-venus-mars fa-fw me-2"></i>{{ App\Http\Controllers\StudentController::getGenders()[$studentUser->gender] }}</li>
                    @endif
                    <li class="list-group-item"><i class="fas fa-city fa-fw me-2"></i>{{ $studentUser->city ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="fas fa-map-marker-alt fa-fw me-2"></i>{{ $studentUser->address ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="fas fa-calendar-alt fa-fw me-2"></i>Inscrit le: {{ $studentUser->created_at->format('d/m/Y H:i') }}</li>
                    @if($studentUser->last_login_at)
                    <li class="list-group-item"><i class="fas fa-sign-in-alt fa-fw me-2"></i>Dernière connexion: {{ $studentUser->last_login_at->format('d/m/Y H:i') }}</li>
                    @endif
                </ul>
            </div>

            @if($studentUser->student)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-user-graduate fa-fw me-2"></i>Informations Étudiant (Profil)</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @if($studentUser->student->parent_phone_number)
                    <li class="list-group-item"><i class="fas fa-user-friends fa-fw me-2"></i>Tel. Parent: {{ $studentUser->student->parent_phone_number }}</li>
                    @endif
                    @if($studentUser->student->establishment)
                    <li class="list-group-item"><i class="fas fa-school fa-fw me-2"></i>Établissement: {{ $studentUser->student->establishment }}</li>
                    @endif
                    {{-- Ajoutez d'autres champs du modèle Student ici --}}
                </ul>
            </div>
            @endif

            <div class="card mt-4">
                 <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-history fa-fw me-2"></i>Historique du compte</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @if($studentUser->validated_by && $studentUser->validated_at)
                    <li class="list-group-item">
                        <i class="fas fa-check-circle fa-fw me-2 text-success"></i>Validé par: {{ $studentUser->validator->name ?? 'N/A' }}
                        <small class="d-block text-muted">{{ $studentUser->validated_at->format('d/m/Y H:i') }}</small>
                    </li>
                    @endif
                     @if($studentUser->finalized_by && $studentUser->finalized_at)
                    <li class="list-group-item">
            @extends('layouts.app') {{-- ou votre layout admin --}}

@section('title', 'Profil Étudiant - ' . $studentUser->full_name)

@section('content')
<div class="student-profile-page">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}">Étudiants</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $studentUser->full_name }}</span>
            </div>
            <h1 class="page-title">
                Profil de {{ $studentUser->full_name }}
            </h1>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="profile-layout">
        <!-- Colonne de gauche : Informations principales -->
        <div class="profile-sidebar">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $studentUser->profile_photo_url }}" alt="Photo de {{ $studentUser->full_name }}" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h4 class="card-title">{{ $studentUser->full_name }}</h4>
                    <p class="text-muted">{{ $studentUser->account_type_label }}</p>
                    @php
                        $statusClass = 'secondary'; // Default
                        if ($studentUser->status === \App\Models\User::STATUS_ACTIVE) $statusClass = 'success';
                        elseif (in_array($studentUser->status, [\App\Models\User::STATUS_PENDING_VALIDATION, \App\Models\User::STATUS_PENDING_CONTRACT])) $statusClass = 'warning';
                        elseif (in_array($studentUser->status, [\App\Models\User::STATUS_SUSPENDED, \App\Models\User::STATUS_REJECTED])) $statusClass = 'danger';
                    @endphp
                    <span class="badge status-badge-profile {{ $statusClass }} p-2">{{ $studentUser->status_label }}</span>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-envelope fa-fw me-2"></i>{{ $studentUser->email }}</li>
                    @if($studentUser->phone_number)
                    <li class="list-group-item"><i class="fas fa-phone fa-fw me-2"></i>{{ $studentUser->phone_number }}</li>
                    @endif
                    @if($studentUser->gender_label)
                    <li class="list-group-item"><i class="fas fa-venus-mars fa-fw me-2"></i>{{ $studentUser->gender_label }}</li>
                    @endif
                    <li class="list-group-item"><i class="fas fa-city fa-fw me-2"></i>{{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}</li>
                    <li class="list-group-item"><i class="fas fa-map-marker-alt fa-fw me-2"></i>{{ $studentUser->address ?? 'N/A' }}</li>
                    <li class="list-group-item"><i class="fas fa-calendar-alt fa-fw me-2"></i>Membre depuis: {{ $studentUser->created_at->format('d/m/Y') }}</li>
                    @if($studentUser->last_login_at)
                    <li class="list-group-item"><i class="fas fa-sign-in-alt fa-fw me-2"></i>Dernière connexion: {{ $studentUser->last_login_at->format('d/m/Y H:i') }}</li>
                    @endif
                </ul>
            </div>

            @if($studentUser->student) {{-- Vérifie si le profil étudiant existe --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-user-graduate fa-fw me-2"></i>Détails Étudiant</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @if($studentUser->student->parent_phone_number)
                    <li class="list-group-item"><i class="fas fa-user-friends fa-fw me-2"></i>Tel. Parent: {{ $studentUser->student->parent_phone_number }}</li>
                    @endif
                    @if($studentUser->student->establishment)
                    <li class="list-group-item"><i class="fas fa-school fa-fw me-2"></i>Établissement: {{ $studentUser->student->establishment }}</li>
                    @endif
                    {{-- <li class="list-group-item">
                        <i class="fas fa-file-signature fa-fw me-2"></i>Entièrement inscrit: 
                        <span class="badge bg-{{ $studentUser->student->full_registered ? 'success' : 'warning' }}">
                            {{ $studentUser->student->full_registered ? 'Oui' : 'Non' }}
                        </span>
                    </li> --}}
                </ul>
            </div>
            @endif

            <div class="card mt-4">
                 <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-history fa-fw me-2"></i>Historique du compte</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @if($studentUser->validated_by && $studentUser->validated_at)
                    <li class="list-group-item">
                        <i class="fas fa-check-circle fa-fw me-2 text-success"></i>Validé par: {{ $studentUser->validator->full_name ?? 'N/A' }}
                        <small class="d-block text-muted">{{ $studentUser->validated_at->format('d/m/Y H:i') }}</small>
                    </li>
                    @endif
                     @if($studentUser->finalized_by && $studentUser->finalized_at)
                    <li class="list-group-item">
                        <i class="fas fa-flag-checkered fa-fw me-2 text-primary"></i>Finalisé par: {{ $studentUser->finalizer->full_name ?? 'N/A' }}
                         <small class="d-block text-muted">{{ $studentUser->finalized_at->format('d/m/Y H:i') }}</small>
                    </li>
                    @endif
                     @if($studentUser->status === \App\Models\User::STATUS_REJECTED && $studentUser->rejection_reason)
                    <li class="list-group-item">
                        <i class="fas fa-times-circle fa-fw me-2 text-danger"></i>Motif du rejet:
                        <p class="mb-0 mt-1"><small>{{ $studentUser->rejection_reason }}</small></p>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Colonne de droite : Inscriptions et autres détails -->
        <div class="profile-main-content">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-id-card-alt fa-fw me-2"></i>Inscriptions</h5>
                </div>
                <div class="card-body">
                    @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                        @foreach($studentUser->student->enrollments as $enrollment)
                            <div class="enrollment-card {{ !$loop->last ? 'mb-3' : '' }} p-3 border rounded">
                                <h6 class="fw-bold text-primary">{{ $enrollment->formation->name ?? 'Formation non spécifiée' }}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <strong>Centre:</strong> {{ $enrollment->center->name ?? 'Centre non spécifié' }}
                                        </p>
                                        <p class="mb-1">
                                            <strong>Date d'inscription:</strong> {{ $enrollment->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1">
                                            <strong>N° Reçu:</strong> {{ $enrollment->receipt_number }}
                                        </p>
                                        <p class="mb-1">
                                            <strong>Montant Contrat:</strong> {{ number_format($enrollment->contract, 0, ',', ' ') }} XAF
                                        </p>
                                    </div>
                                </div>
                                @if($enrollment->special_conditions)
                                <hr class="my-2">
                                <p class="mb-0">
                                    <strong>Conditions spéciales:</strong><br>
                                    <small class="text-muted">{{ nl2br(e($enrollment->special_conditions)) }}</small>
                                </p>
                                @endif

                                {{-- Si vous avez la relation additionalFormations() et qu'elle est pertinente ici --}}
                                @if(method_exists($enrollment, 'additionalFormations') && $enrollment->additionalFormations->isNotEmpty())
                                    <hr class="my-2">
                                    <p class="mb-1"><strong>Formations additionnelles (via table pivot) :</strong></p>
                                    <ul>
                                        @foreach($enrollment->additionalFormations as $addFormation)
                                            <li><small>{{ $addFormation->name }}</small></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p class="mb-0">Cet étudiant n'a aucune inscription pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-layout {
        display: flex;
        gap: 1.5rem; /* Espace entre les colonnes */
    }
    .profile-sidebar {
        flex: 0 0 340px; /* Largeur fixe pour la sidebar */
        min-width: 300px;
    }
    .profile-main-content {
        flex: 1; /* Prend l'espace restant */
        min-width: 0; /* Important pour le flex-shrink */
    }
    .card .card-header h5 i { vertical-align: -0.125em; } /* Ajustement icônes titres */
    .list-group-item i.fa-fw { color: #858796; } /* Couleur icônes liste */
    
    .enrollment-card { background-color: #f8f9fc; }
    .enrollment-card h6 { font-size: 1.1rem; }

    .status-badge-profile { /* Assurez-vous que ces classes sont définies comme dans index.blade.php ou globalement */
        padding: 0.4em 0.8em;
        border-radius: 0.25rem;
        font-size: 0.9em;
        font-weight: 600;
        color: #fff;
    }
    .status-badge-profile.success { background-color: #1cc88a; }
    .status-badge-profile.warning { background-color: #f6c23e; color: #5a5c69;}
    .status-badge-profile.danger { background-color: #e74a3b; }
    .status-badge-profile.secondary { background-color: #858796; }


    @media (max-width: 991.98px) { /* Bootstrap lg breakpoint */
        .profile-layout {
            flex-direction: column;
        }
        .profile-sidebar {
            flex: 0 0 auto; /* Réinitialise la largeur pour l'empilement */
            margin-bottom: 1.5rem; /* Ajoute de l'espace en dessous quand empilé */
        }
    }
</style>
@endpush            <i class="fas fa-flag-checkered fa-fw me-2 text-primary"></i>Finalisé par: {{ $studentUser->finalizer->name ?? 'N/A' }}
                         <small class="d-block text-muted">{{ $studentUser->finalized_at->format('d/m/Y H:i') }}</small>
                    </li>
                    @endif
                     @if($studentUser->status === 'rejected' && $studentUser->rejection_reason)
                    <li class="list-group-item">
                        <i class="fas fa-times-circle fa-fw me-2 text-danger"></i>Motif du rejet:
                        <p class="mb-0 mt-1"><small>{{ $studentUser->rejection_reason }}</small></p>
                    </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Colonne de droite : Inscriptions et autres détails -->
        <div class="profile-main-content">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-id-card-alt fa-fw me-2"></i>Inscriptions</h5>
                </div>
                <div class="card-body">
                    @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                        @foreach($studentUser->student->enrollments as $enrollment)
                            <div class="enrollment-card {{ !$loop->last ? 'mb-3' : '' }} p-3 border rounded">
                                <h6 class="text-primary">{{ $enrollment->formation->name ?? 'Formation non spécifiée' }}</h6>
                                <p class="mb-1">
                                    <strong>Centre:</strong> {{ $enrollment->center->name ?? 'Centre non spécifié' }} <br>
                                    <strong>Date d'inscription:</strong> {{ $enrollment->created_at->format('d/m/Y') }} <br>
                                    <strong>N° Reçu:</strong> {{ $enrollment->receipt_number }} <br>
                                    <strong>Montant Contrat:</strong> {{ number_format($enrollment->contract, 2, ',', ' ') }} XAF
                                </p>
                                @if($enrollment->special_conditions)
                                <p class="mb-0">
                                    <strong>Conditions spéciales:</strong><br>
                                    <small>{{ nl2br(e($enrollment->special_conditions)) }}</small>
                                </p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p class="mb-0">Cet étudiant n'a aucune inscription pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Vous pouvez ajouter d'autres sections ici : notes, paiements, etc. --}}
            <!-- <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="fas fa-money-check-alt fa-fw me-2"></i>Historique des Paiements</h5>
                </div>
                <div class="card-body">
                    <p>Aucun paiement enregistré pour le moment.</p>
                </div>
            </div> -->
        </div>
    </div>
</div>

<style>
    .profile-layout {
        display: flex;
        gap: 1.5rem;
    }
    .profile-sidebar {
        flex: 0 0 320px; /* Fixed width for sidebar */
    }
    .profile-main-content {
        flex: 1; /* Takes remaining space */
    }
    .card-title i { vertical-align: middle; }
    .enrollment-card { background-color: #f8f9fa; }
    @media (max-width: 991px) {
        .profile-layout {
            flex-direction: column;
        }
        .profile-sidebar {
            flex: 0 0 auto; /* Reset width for stacking */
        }
    }
</style>
@endsection