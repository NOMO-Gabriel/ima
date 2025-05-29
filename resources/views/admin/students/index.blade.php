@extends('layouts.app')

@section('title', 'Gestion des Étudiants')

@section('content')
    <div class="students-dashboard">
        <!-- En-tête de page avec actions principales -->
        <div class="page-header">
            <div class="header-content">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}">
                        Administration
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Étudiants</span>
                </div>
                <h1 class="page-title">Gestion des Étudiants</h1>
                <p class="page-description">Gérez tous les étudiants du système avec leurs profils et inscriptions.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.students.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter un étudiant</span>
                </a>
            </div>
        </div>

        <!-- Statistiques en une seule ligne -->
        <div class="stats-container">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $stats['total'] ?? $studentUsers->total() }}</h3>
                    <p class="stats-label">Total Étudiants</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar primary" style="width: 100%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $stats['active'] ?? $studentUsers->where('status', 'active')->count() }}</h3>
                    <p class="stats-label">Étudiants Actifs</p>
                </div>
                <div class="stats-trend">
                    @php
                        $activePercentage = ($studentUsers->total() > 0) ? ($studentUsers->where('status', 'active')->count() / $studentUsers->total()) * 100 : 0;
                    @endphp
                    <div class="progress-bar success" style="width: {{ $activePercentage }}%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $stats['pending_validation'] ?? $studentUsers->where('status', 'pending_validation')->count() }}</h3>
                    <p class="stats-label">En Attente Validation</p>
                </div>
                <div class="stats-trend">
                    @php
                        $pendingPercentage = ($studentUsers->total() > 0) ? ($studentUsers->where('status', 'pending_validation')->count() / $studentUsers->total()) * 100 : 0;
                    @endphp
                    <div class="progress-bar warning" style="width: {{ $pendingPercentage }}%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon info">
                    <i class="fas fa-file-contract"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $stats['pending_contract'] ?? $studentUsers->where('status', 'pending_contract')->count() }}</h3>
                    <p class="stats-label">En Attente Contrat</p>
                </div>
                <div class="stats-trend">
                    @php
                        $contractPercentage = ($studentUsers->total() > 0) ? ($studentUsers->where('status', 'pending_contract')->count() / $studentUsers->total()) * 100 : 0;
                    @endphp
                    <div class="progress-bar info" style="width: {{ $contractPercentage }}%"></div>
                </div>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="card filter-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-filter"></i>Filtres
                </h2>
                <button class="btn btn-icon filter-toggle" type="button">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="card-body filter-body">
                <form action="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" method="GET" id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="status">
                                <i class="fas fa-user-shield"></i>Statut
                            </label>
                            <div class="select-wrapper">
                                <select id="status" name="status" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="establishment">
                                <i class="fas fa-university"></i>Établissement
                            </label>
                            <div class="search-wrapper">
                                <input type="text" id="establishment" name="establishment" value="{{ request('establishment') }}" class="form-control" placeholder="Nom de l'établissement...">
                                <button type="button" class="search-clear" {{ request('establishment') ? '' : 'style=display:none' }}>
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="search">
                                <i class="fas fa-search"></i>Recherche
                            </label>
                            <div class="search-wrapper">
                                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom, email, téléphone...">
                                <button type="button" class="search-clear" {{ request('search') ? '' : 'style=display:none' }}>
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Appliquer les filtres
                        </button>
                        <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                            <i class="fas fa-redo-alt"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des étudiants -->
        <div class="card data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-graduate"></i>Liste des étudiants
                </h2>
                <div class="view-actions">
                    <div class="view-switcher">
                        <button type="button" class="btn btn-icon active" id="tableViewBtn" title="Vue tableau">
                            <i class="fas fa-list"></i>
                        </button>
                        <button type="button" class="btn btn-icon" id="cardViewBtn" title="Vue cartes">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv text-primary"></i>CSV</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf text-danger"></i>PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Vue tableau -->
                <div class="table-view">
                    <div class="table-responsive">
                        <table class="table students-table">
                            <thead>
                            <tr>
                                <th class="sortable" data-sort="name">
                                    <span>Étudiant</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th>Contact & Établissement</th>
                                <th>Profil Étudiant</th>
                                <th class="sortable" data-sort="status">
                                    <span>Statut</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="sortable" data-sort="created_at">
                                    <span>Date d'inscription</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($studentUsers as $student)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <img src="{{ $student->profile_photo_url }}" alt="{{ $student->first_name }}" class="avatar">
                                                <span class="user-status {{ $student->is_online ? 'online' : 'offline' }}"></span>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $student->first_name }} {{ $student->last_name }}</div>
                                                <div class="user-date">
                                                    @if($student->student && $student->student->parent_phone_number)
                                                        <span class="badge date-badge">
                                                            <i class="fas fa-users"></i>Parent: {{ $student->student->parent_phone_number }}
                                                        </span>
                                                    @endif
                                                    <span class="badge date-badge">
                                                        <i class="far fa-calendar-alt"></i>{{ $student->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-contact">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $student->email }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                                            </div>
                                            @if($student->student && $student->student->establishment)
                                                <div class="contact-item">
                                                    <i class="fas fa-university"></i>
                                                    <span>{{ $student->student->establishment }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="student-profile">
                                            @if($student->student)
                                                @if($student->city)
                                                    <div class="profile-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>{{ $student->city }}</span>
                                                    </div>
                                                @endif
                                                @if($student->wanted_entrance_exams && count($student->wanted_entrance_exams) > 0)
                                                    <div class="profile-item">
                                                        <i class="fas fa-graduation-cap"></i>
                                                        <span>{{ count($student->wanted_entrance_exams) }} concours souhaité(s)</span>
                                                    </div>
                                                @endif
                                                @if($student->validated_at)
                                                    <div class="profile-item">
                                                        <i class="fas fa-check-circle text-success"></i>
                                                        <span>Validé le {{ $student->validated_at->format('d/m/Y') }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted">Profil non complété</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusInfo = [
                                                'pending_validation' => [
                                                    'class' => 'warning',
                                                    'icon' => 'hourglass-start',
                                                    'text' => 'En attente de validation'
                                                ],
                                                'pending_contract' => [
                                                    'class' => 'info',
                                                    'icon' => 'file-contract',
                                                    'text' => 'En attente de contrat'
                                                ],
                                                'active' => [
                                                    'class' => 'success',
                                                    'icon' => 'check-circle',
                                                    'text' => 'Actif'
                                                ],
                                                'suspended' => [
                                                    'class' => 'danger',
                                                    'icon' => 'ban',
                                                    'text' => 'Suspendu'
                                                ],
                                                'rejected' => [
                                                    'class' => 'secondary',
                                                    'icon' => 'times-circle',
                                                    'text' => 'Rejeté'
                                                ],
                                                'archived' => [
                                                    'class' => 'dark',
                                                    'icon' => 'archive',
                                                    'text' => 'Archivé'
                                                ]
                                            ];
                                            $status = $statusInfo[$student->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => ucfirst($student->status)];
                                        @endphp
                                        <div class="status-badge {{ $status['class'] }}">
                                            <i class="fas fa-{{ $status['icon'] }}"></i>
                                            <span>{{ $status['text'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="inscription-date">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $student->created_at->format('d/m/Y H:i') }}
                                            </div>
                                            @if($student->created_at->diffInDays() < 7)
                                                <span class="recent-badge">récent</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" class="btn-action view" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" class="btn-action edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn-action more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-file-alt text-primary"></i>Dossier d'inscription
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-chart-line text-primary"></i>Notes et résultats
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-calendar-check text-primary"></i>Présences
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    @if($student->status === 'pending_validation')
                                                        <li>
                                                            <a class="dropdown-item text-success" href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student->id]) }}">
                                                                <i class="fas fa-check-circle"></i>Finaliser inscription
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if($student->status === 'active')
                                                        <li>
                                                            <form action="#" method="POST" class="dropdown-form">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-warning">
                                                                    <i class="fas fa-ban"></i>Suspendre
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @elseif($student->status === 'suspended')
                                                        <li>
                                                            <form action="#" method="POST" class="dropdown-form">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check-circle"></i>Réactiver
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if(auth()->id() !== $student->id)
                                                        <li>
                                                            <form action="{{ route('admin.students.destroy', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" method="POST" class="dropdown-form delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <h4>Aucun étudiant trouvé</h4>
                                            <p>Essayez de modifier vos filtres ou d'ajouter un nouvel étudiant.</p>
                                            <div class="empty-actions">
                                                <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                                                    <i class="fas fa-filter"></i>Réinitialiser les filtres
                                                </a>
                                                <a href="{{ route('admin.students.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                                                    <i class="fas fa-user-plus"></i>Ajouter un étudiant
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Vue cartes -->
                <div class="card-view" style="display: none;">
                    <div class="student-cards">
                        @forelse ($studentUsers as $student)
                            <div class="student-card">
                                <div class="student-card-header">
                                    <div class="student-card-avatar">
                                        <img src="{{ $student->profile_photo_url }}" alt="{{ $student->first_name }}">
                                        <span class="user-status {{ $student->is_online ? 'online' : 'offline' }}"></span>
                                    </div>
                                    <div class="student-card-info">
                                        <h3 class="student-card-name">{{ $student->first_name }} {{ $student->last_name }}</h3>
                                        <div class="student-card-roles">
                                            @foreach($student->roles as $role)
                                                <span class="role-badge small teal">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="student-card-status">
                                        @php
                                            $status = $statusInfo[$student->status] ?? ['class' => 'secondary', 'icon' => 'question'];
                                        @endphp
                                        <span class="status-indicator {{ $status['class'] }}">
                                            <i class="fas fa-{{ $status['icon'] }}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="student-card-body">
                                    <div class="student-card-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $student->email }}</span>
                                    </div>
                                    <div class="student-card-detail">
                                        <i class="fas fa-phone-alt"></i>
                                        <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                                    </div>
                                    @if($student->student)
                                        @if($student->student->establishment)
                                            <div class="student-card-detail">
                                                <i class="fas fa-university"></i>
                                                <span>{{ $student->student->establishment }}</span>
                                            </div>
                                        @endif
                                        @if($student->student->parent_phone_number)
                                            <div class="student-card-detail">
                                                <i class="fas fa-users"></i>
                                                <span>Parent: {{ $student->student->parent_phone_number }}</span>
                                            </div>
                                        @endif
                                        @if($student->city)
                                            <div class="student-card-detail">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ $student->city }}</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="student-card-detail">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Inscrit le {{ $student->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="student-card-footer">
                                    <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" class="student-card-btn view" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" class="student-card-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="student-card-btn more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-file-alt text-primary"></i>Dossier d'inscription
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-chart-line text-primary"></i>Notes et résultats
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            @if(auth()->id() !== $student->id)
                                                <li>
                                                    <form action="{{ route('admin.students.destroy', ['locale' => app()->getLocale(), 'studentUser' => $student->id]) }}" method="POST" class="dropdown-form delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h4>Aucun étudiant trouvé</h4>
                                <p>Essayez de modifier vos filtres ou d'ajouter un nouvel étudiant.</p>
                                <div class="empty-actions">
                                    <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                                        <i class="fas fa-filter"></i>Réinitialiser les filtres
                                    </a>
                                    <a href="{{ route('admin.students.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i>Ajouter un étudiant
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($studentUsers->hasPages())
                <div class="card-footer">
                    <div class="pagination-info">
                        Affichage de <span>{{ $studentUsers->firstItem() ?? 0 }}</span> à <span>{{ $studentUsers->lastItem() ?? 0 }}</span> sur <span>{{ $studentUsers->total() }}</span> étudiants
                    </div>
                    <div class="pagination-controls">
                        {{ $studentUsers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Styles spécifiques aux étudiants -->
    <style>
        .student-profile .profile-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .student-profile .profile-item i {
            width: 16px;
            margin-right: 0.5rem;
            color: var(--text-secondary);
        }
        
        .date-info .inscription-date {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
        }
        
        .date-info .inscription-date i {
            margin-right: 0.25rem;
            color: var(--text-secondary);
        }
        
        .student-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: var(--spacing-md);
            padding: var(--spacing-md);
        }
        
        .student-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid var(--border-color);
        }
        
        .student-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .student-card-header {
            padding: var(--spacing-md);
            display: flex;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }
        
        .student-card-avatar {
            position: relative;
            margin-right: var(--spacing-md);
        }
        
        .student-card-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-bg);
            box-shadow: var(--shadow-sm);
        }
        
        .student-card-info {
            flex: 1;
        }
        
        .student-card-name {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 var(--spacing-xs) 0;
        }
        
        .student-card-roles {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
        }
        
        .student-card-status {
            position: absolute;
            top: var(--spacing-md);
            right: var(--spacing-md);
        }
        
        .student-card-body {
            padding: var(--spacing-md);
        }
        
        .student-card-detail {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-size: 0.875rem;
        }
        
        .student-card-detail i {
            width: 16px;
            margin-right: var(--spacing-md);
            color: var(--text-secondary);
        }
        
        .student-card-footer {
            padding: var(--spacing-sm);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
            background-color: var(--section-bg);
        }
        
        .student-card-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            color: var(--text-secondary);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }
        
        .student-card-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .student-card-btn.view:hover {
            background-color: var(--info-light);
            color: var(--info);
        }
        
        .student-card-btn.edit:hover {
            background-color: var(--success-light);
            color: var(--success);
        }
        
        /* Styles pour les badges de statut spécifiques aux étudiants */
        .status-badge.warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }
        
        .status-badge.info {
            background-color: var(--info-light);
            color: var(--info);
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Script similaire aux enseignants
        document.addEventListener('DOMContentLoaded', function() {
            // Vue tableau/cartes toggle
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableView = document.querySelector('.table-view');
            const cardView = document.querySelector('.card-view');

            if (tableViewBtn && cardViewBtn && tableView && cardView) {
                tableViewBtn.addEventListener('click', function() {
                    tableView.style.display = 'block';
                    cardView.style.display = 'none';
                    tableViewBtn.classList.add('active');
                    cardViewBtn.classList.remove('active');
                    localStorage.setItem('students-view', 'table');
                });

                cardViewBtn.addEventListener('click', function() {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    cardViewBtn.classList.add('active');
                    tableViewBtn.classList.remove('active');
                    localStorage.setItem('students-view', 'card');
                });

                // Restaurer la préférence d'affichage
                const savedView = localStorage.getItem('students-view');
                if (savedView === 'card') {
                    cardViewBtn.click();
                }
            }

            // Toggle des filtres
            const filterToggle = document.querySelector('.filter-toggle');
            const filterBody = document.querySelector('.filter-body');

            if (filterToggle && filterBody) {
                filterToggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('fa-chevron-up')) {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                        filterBody.style.display = 'none';
                    } else {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                        filterBody.style.display = 'block';
                    }
                });
            }

            // Gestion des boutons d'effacement de la recherche
            const searchInputs = document.querySelectorAll('input[type="text"]');
            searchInputs.forEach(input => {
                const clearBtn = input.parentNode.querySelector('.search-clear');
                if (clearBtn) {
                    input.addEventListener('input', function() {
                        if (this.value) {
                            clearBtn.style.display = 'flex';
                        } else {
                            clearBtn.style.display = 'none';
                        }
                    });

                    clearBtn.addEventListener('click', function() {
                        input.value = '';
                        clearBtn.style.display = 'none';
                        input.focus();
                    });
                }
            });

            // Gestion des confirmations de suppression
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush