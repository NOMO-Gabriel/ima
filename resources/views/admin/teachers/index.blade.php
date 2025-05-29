@extends('layouts.app')

@section('title', 'Gestion des Enseignants')

@section('content')
    <div class="teachers-dashboard">
        <!-- En-tête de page avec actions principales -->
        <div class="page-header">
            <div class="header-content">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}">
                        Administration
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Enseignants</span>
                </div>
                <h1 class="page-title">Gestion des Enseignants</h1>
                <p class="page-description">Gérez tous les enseignants du système avec leurs profils et assignations.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter un enseignant</span>
                </a>
            </div>
        </div>

        <!-- Statistiques en une seule ligne -->
        <div class="stats-container">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $stats['total'] ?? $teacherUsers->total() }}</h3>
                    <p class="stats-label">Total Enseignants</p>
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
                    <h3 class="stats-value">{{ $stats['active'] ?? $teacherUsers->where('status', 'active')->count() }}</h3>
                    <p class="stats-label">Enseignants Actifs</p>
                </div>
                <div class="stats-trend">
                    @php
                        $activePercentage = ($teacherUsers->total() > 0) ? ($teacherUsers->where('status', 'active')->count() / $teacherUsers->total()) * 100 : 0;
                    @endphp
                    <div class="progress-bar success" style="width: {{ $activePercentage }}%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon info">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $academies->count() ?? 0 }}</h3>
                    <p class="stats-label">Académies</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar info" style="width: 100%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $departments->count() ?? 0 }}</h3>
                    <p class="stats-label">Départements</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar warning" style="width: 100%"></div>
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
                <form action="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" method="GET" id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i>Rôle
                            </label>
                            <div class="select-wrapper">
                                <select id="role" name="role" class="form-control">
                                    <option value="">Tous les rôles</option>
                                    @foreach($spatieRoles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">
                                <i class="fas fa-user-shield"></i>Statut
                            </label>
                            <div class="select-wrapper">
                                <select id="status" name="status" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="academy_id">
                                <i class="fas fa-graduation-cap"></i>Académie
                            </label>
                            <div class="select-wrapper">
                                <select id="academy_id" name="academy_id" class="form-control">
                                    <option value="">Toutes les académies</option>
                                    @foreach($academies as $id => $name)
                                        <option value="{{ $id }}" {{ request('academy_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="department_id">
                                <i class="fas fa-building"></i>Département
                            </label>
                            <div class="select-wrapper">
                                <select id="department_id" name="department_id" class="form-control">
                                    <option value="">Tous les départements</option>
                                    @foreach($departments as $id => $name)
                                        <option value="{{ $id }}" {{ request('department_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="search">
                                <i class="fas fa-search"></i>Recherche
                            </label>
                            <div class="search-wrapper">
                                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom, email, matricule...">
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
                        <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                            <i class="fas fa-redo-alt"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des enseignants -->
        <div class="card data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-chalkboard-teacher"></i>Liste des enseignants
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
                        <table class="table teachers-table">
                            <thead>
                            <tr>
                                <th class="sortable" data-sort="name">
                                    <span>Enseignant</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th>Contact & Académie</th>
                                <th>Profil Enseignant</th>
                                <th class="sortable" data-sort="status">
                                    <span>Statut</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="sortable" data-sort="salary">
                                    <span>Salaire</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($teacherUsers as $teacher)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <img src="{{ $teacher->profile_photo_url }}" alt="{{ $teacher->first_name }}" class="avatar">
                                                <span class="user-status {{ $teacher->is_online ? 'online' : 'offline' }}"></span>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                                                <div class="user-date">
                                                    @if($teacher->teacherProfile && $teacher->teacherProfile->matricule)
                                                        <span class="badge date-badge">
                                                            <i class="fas fa-id-badge"></i>{{ $teacher->teacherProfile->matricule }}
                                                        </span>
                                                    @endif
                                                    <span class="badge date-badge">
                                                        <i class="far fa-calendar-alt"></i>{{ $teacher->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-contact">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $teacher->email }}</span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <span>{{ $teacher->phone_number ?? 'Non renseigné' }}</span>
                                            </div>
                                            @if($teacher->teacherProfile && $teacher->teacherProfile->academy)
                                                <div class="contact-item">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <span>{{ $teacher->teacherProfile->academy->name }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="teacher-profile">
                                            @if($teacher->teacherProfile)
                                                @if($teacher->teacherProfile->profession)
                                                    <div class="profile-item">
                                                        <i class="fas fa-briefcase"></i>
                                                        <span>{{ $teacher->teacherProfile->profession }}</span>
                                                    </div>
                                                @endif
                                                @if($teacher->teacherProfile->departmentModel)
                                                    <div class="profile-item">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $teacher->teacherProfile->departmentModel->name }}</span>
                                                    </div>
                                                @endif
                                                @if($teacher->teacherProfile->center)
                                                    <div class="profile-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>{{ $teacher->teacherProfile->center->name }}</span>
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
                                                'archived' => [
                                                    'class' => 'dark',
                                                    'icon' => 'archive',
                                                    'text' => 'Archivé'
                                                ]
                                            ];
                                            $status = $statusInfo[$teacher->status] ?? ['class' => 'secondary', 'icon' => 'question', 'text' => ucfirst($teacher->status)];
                                        @endphp
                                        <div class="status-badge {{ $status['class'] }}">
                                            <i class="fas fa-{{ $status['icon'] }}"></i>
                                            <span>{{ $status['text'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="salary-info">
                                            @if($teacher->teacherProfile && $teacher->teacherProfile->salary)
                                                <div class="salary-amount">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    {{ number_format($teacher->teacherProfile->salary, 0, ',', ' ') }} FCFA
                                                </div>
                                            @else
                                                <span class="text-muted">Non défini</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" class="btn-action view" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" class="btn-action edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn-action more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-calendar-alt text-primary"></i>Planning
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-users text-primary"></i>Élèves assignés
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-chart-bar text-primary"></i>Statistiques
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    @if($teacher->status === 'active')
                                                        <li>
                                                            <form action="#" method="POST" class="dropdown-form">
                                                                @csrf
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check-circle"></i>Réactiver
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endif
                                                    @if(auth()->id() !== $teacher->id)
                                                        <li>
                                                            <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" method="POST" class="dropdown-form delete-form">
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
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </div>
                                            <h4>Aucun enseignant trouvé</h4>
                                            <p>Essayez de modifier vos filtres ou d'ajouter un nouvel enseignant.</p>
                                            <div class="empty-actions">
                                                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                                                    <i class="fas fa-filter"></i>Réinitialiser les filtres
                                                </a>
                                                <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                                                    <i class="fas fa-user-plus"></i>Ajouter un enseignant
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
                    <div class="teacher-cards">
                        @forelse ($teacherUsers as $teacher)
                            <div class="teacher-card">
                                <div class="teacher-card-header">
                                    <div class="teacher-card-avatar">
                                        <img src="{{ $teacher->profile_photo_url }}" alt="{{ $teacher->first_name }}">
                                        <span class="user-status {{ $teacher->is_online ? 'online' : 'offline' }}"></span>
                                    </div>
                                    <div class="teacher-card-info">
                                        <h3 class="teacher-card-name">{{ $teacher->first_name }} {{ $teacher->last_name }}</h3>
                                        <div class="teacher-card-roles">
                                            @foreach($teacher->roles as $role)
                                                <span class="role-badge small blue">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="teacher-card-status">
                                        @php
                                            $status = $statusInfo[$teacher->status] ?? ['class' => 'secondary', 'icon' => 'question'];
                                        @endphp
                                        <span class="status-indicator {{ $status['class'] }}">
                                            <i class="fas fa-{{ $status['icon'] }}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="teacher-card-body">
                                    <div class="teacher-card-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $teacher->email }}</span>
                                    </div>
                                    <div class="teacher-card-detail">
                                        <i class="fas fa-phone-alt"></i>
                                        <span>{{ $teacher->phone_number ?? 'Non renseigné' }}</span>
                                    </div>
                                    @if($teacher->teacherProfile)
                                        @if($teacher->teacherProfile->matricule)
                                            <div class="teacher-card-detail">
                                                <i class="fas fa-id-badge"></i>
                                                <span>{{ $teacher->teacherProfile->matricule }}</span>
                                            </div>
                                        @endif
                                        @if($teacher->teacherProfile->academy)
                                            <div class="teacher-card-detail">
                                                <i class="fas fa-graduation-cap"></i>
                                                <span>{{ $teacher->teacherProfile->academy->name }}</span>
                                            </div>
                                        @endif
                                        @if($teacher->teacherProfile->salary)
                                            <div class="teacher-card-detail">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span>{{ number_format($teacher->teacherProfile->salary, 0, ',', ' ') }} FCFA</span>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="teacher-card-detail">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Créé le {{ $teacher->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <div class="teacher-card-footer">
                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" class="teacher-card-btn view" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" class="teacher-card-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="teacher-card-btn more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-calendar-alt text-primary"></i>Planning
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-users text-primary"></i>Élèves assignés
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            @if(auth()->id() !== $teacher->id)
                                                <li>
                                                    <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}" method="POST" class="dropdown-form delete-form">
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
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <h4>Aucun enseignant trouvé</h4>
                                <p>Essayez de modifier vos filtres ou d'ajouter un nouvel enseignant.</p>
                                <div class="empty-actions">
                                    <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                                        <i class="fas fa-filter"></i>Réinitialiser les filtres
                                    </a>
                                    <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i>Ajouter un enseignant
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($teacherUsers->hasPages())
                <div class="card-footer">
                    <div class="pagination-info">
                        Affichage de <span>{{ $teacherUsers->firstItem() ?? 0 }}</span> à <span>{{ $teacherUsers->lastItem() ?? 0 }}</span> sur <span>{{ $teacherUsers->total() }}</span> enseignants
                    </div>
                    <div class="pagination-controls">
                        {{ $teacherUsers->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Styles spécifiques aux enseignants -->
    <style>
        .teacher-profile .profile-item {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .teacher-profile .profile-item i {
            width: 16px;
            margin-right: 0.5rem;
            color: var(--text-secondary);
        }
        
        .salary-info .salary-amount {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--success);
        }
        
        .salary-info .salary-amount i {
            margin-right: 0.25rem;
        }
        
        .teacher-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: var(--spacing-md);
            padding: var(--spacing-md);
        }
        
        .teacher-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid var(--border-color);
        }
        
        .teacher-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }
        
        .teacher-card-header {
            padding: var(--spacing-md);
            display: flex;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }
        
        .teacher-card-avatar {
            position: relative;
            margin-right: var(--spacing-md);
        }
        
        .teacher-card-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-bg);
            box-shadow: var(--shadow-sm);
        }
        
        .teacher-card-info {
            flex: 1;
        }
        
        .teacher-card-name {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 var(--spacing-xs) 0;
        }
        
        .teacher-card-roles {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
        }
        
        .teacher-card-status {
            position: absolute;
            top: var(--spacing-md);
            right: var(--spacing-md);
        }
        
        .teacher-card-body {
            padding: var(--spacing-md);
        }
        
        .teacher-card-detail {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-size: 0.875rem;
        }
        
        .teacher-card-detail i {
            width: 16px;
            margin-right: var(--spacing-md);
            color: var(--text-secondary);
        }
        
        .teacher-card-footer {
            padding: var(--spacing-sm);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
            background-color: var(--section-bg);
        }
        
        .teacher-card-btn {
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
        
        .teacher-card-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        
        .teacher-card-btn.view:hover {
            background-color: var(--info-light);
            color: var(--info);
        }
        
        .teacher-card-btn.edit:hover {
            background-color: var(--success-light);
            color: var(--success);
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Utiliser le même script que pour les utilisateurs avec quelques adaptations
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
                    localStorage.setItem('teachers-view', 'table');
                });

                cardViewBtn.addEventListener('click', function() {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    cardViewBtn.classList.add('active');
                    tableViewBtn.classList.remove('active');
                    localStorage.setItem('teachers-view', 'card');
                });

                // Restaurer la préférence d'affichage
                const savedView = localStorage.getItem('teachers-view');
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

            // Gestion du bouton d'effacement de la recherche
            const searchInput = document.getElementById('search');
            const searchClear = document.querySelector('.search-clear');

            if (searchInput && searchClear) {
                searchInput.addEventListener('input', function() {
                    if (this.value) {
                        searchClear.style.display = 'flex';
                    } else {
                        searchClear.style.display = 'none';
                    }
                });

                searchClear.addEventListener('click', function() {
                    searchInput.value = '';
                    searchClear.style.display = 'none';
                    searchInput.focus();
                });
            }

            // Gestion des confirmations de suppression
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush text-warning">
                                                                    
