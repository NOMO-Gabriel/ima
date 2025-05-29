@extends('layouts.app')

@section('title', 'Gestion du Personnel')

@section('content')
    <div class="staff-dashboard">
        <!-- En-tête de page avec actions principales -->
        <div class="page-header">
            <div class="header-content">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    {{-- Assurez-vous que cette route existe, ou ajustez le lien --}}
                    <a href="#"> 
                        Administration
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Personnel</span>
                </div>
                <h1 class="page-title">Gestion du Personnel</h1>
                <p class="page-description">Gérez tout le personnel administratif du système avec leurs rôles et permissions.</p>
            </div>
            <div class="header-actions">
                @can('staff.create') {{-- Vérification de permission --}}
                <a href="{{ route('admin.staff.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter un membre du personnel</span>
                </a>
                @endcan
            </div>
        </div>

        <!-- Statistiques en une seule ligne -->
        <div class="stats-container">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="stats-content">
                    {{-- Utilisation de la variable $stats du contrôleur --}}
                    <h3 class="stats-value">{{ $stats['total'] ?? 0 }}</h3>
                    <p class="stats-label">Total Personnel</p>
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
                    <h3 class="stats-value">{{ $stats['active'] ?? 0 }}</h3>
                    <p class="stats-label">Personnel Actif</p>
                </div>
                <div class="stats-trend">
                    @php
                        $activePercentage = ($stats['total'] > 0) ? ($stats['active'] / $stats['total']) * 100 : 0;
                    @endphp
                    <div class="progress-bar success" style="width: {{ round($activePercentage) }}%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon info">
                    <i class="fas fa-user-shield"></i> {{-- Peut-être fas fa-tags pour les rôles ? --}}
                </div>
                <div class="stats-content">
                    {{-- $roles est une collection des modèles Role passés au filtre --}}
                    <h3 class="stats-value">{{ $roles->count() }}</h3>
                    <p class="stats-label">Rôles Administratifs Disponibles</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar info" style="width: 100%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-key"></i> {{-- Ou fas fa-layer-group pour multi-rôles --}}
                </div>
                <div class="stats-content">
                    {{-- Calcul des utilisateurs avec plus d'un rôle (nécessite de charger la relation roles) --}}
                    <h3 class="stats-value">{{ $staffMembers->filter(fn($user) => $user->roles->count() > 1)->count() }}</h3>
                    <p class="stats-label">Multi-rôles</p>
                </div>
                <div class="stats-trend">
                     @php
                        $multiRoleCount = $staffMembers->filter(fn($user) => $user->roles->count() > 1)->count();
                        $multiRolePercentage = ($stats['total'] > 0) ? ($multiRoleCount / $stats['total']) * 100 : 0;
                    @endphp
                    <div class="progress-bar warning" style="width: {{ round($multiRolePercentage) }}%"></div>
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
                <form action="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" method="GET" id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i>Rôle
                            </label>
                            <div class="select-wrapper">
                                <select id="role" name="role" class="form-control">
                                    <option value="">Tous les rôles</option>
                                    @foreach($roles as $role) {{-- $roles vient du contrôleur --}}
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace(['-', '_'], ' ', $role->name)) }} {{-- Amélioration affichage nom rôle --}}
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
                                    <option value="{{ \App\Models\User::STATUS_ACTIVE }}" {{ request('status') == \App\Models\User::STATUS_ACTIVE ? 'selected' : '' }}>Actif</option>
                                    <option value="{{ \App\Models\User::STATUS_SUSPENDED }}" {{ request('status') == \App\Models\User::STATUS_SUSPENDED ? 'selected' : '' }}>Suspendu</option>
                                    <option value="{{ \App\Models\User::STATUS_ARCHIVED }}" {{ request('status') == \App\Models\User::STATUS_ARCHIVED ? 'selected' : '' }}>Archivé</option>
                                    {{-- Ajoutez d'autres statuts si pertinents pour le personnel --}}
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group"> {{-- Fin du div précédent manquant --}}
                            <label for="search">
                                <i class="fas fa-search"></i>Recherche
                            </label>
                            <div class="search-wrapper">
                                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom, email ou téléphone...">
                                <button type="button" class="search-clear" {{ request('search') ? '' : 'style=display:none;' }}>
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div> {{-- Fin de filter-grid --}}

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Appliquer les filtres
                        </button>
                        <a href="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                            <i class="fas fa-redo-alt"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste du personnel -->
        <div class="card data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-users-cog"></i>Liste du personnel
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
                        <button class="btn btn-light dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
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
                        <table class="table staff-table table-hover"> {{-- Ajout de table-hover pour une meilleure UX --}}
                            <thead>
                            <tr>
                                {{-- Pour le tri, vous aurez besoin de JS ou de passer des paramètres d'URL --}}
                                <th class="sortable" data-sort="name">
                                    <span>Membre du Personnel</span>
                                    {{-- <i class="fas fa-sort"></i> --}}
                                </th>
                                <th>Contact</th>
                                <th>Rôles & Permissions</th>
                                <th class="sortable" data-sort="status">
                                    <span>Statut</span>
                                    {{-- <i class="fas fa-sort"></i> --}}
                                </th>
                                <th class="sortable" data-sort="last_login">
                                    <span>Dernière connexion</span>
                                    {{-- <i class="fas fa-sort"></i> --}}
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($staffMembers as $staffUser) {{-- La variable est $staffUser dans le contrôleur pour User --}}
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{-- Assurez-vous que profile_photo_url est défini dans le modèle User si vous utilisez Laravel Jetstream/Fortify ou une logique similaire --}}
                                                <img src="{{ $staffUser->profile_photo_url ?? asset('path/to/default-avatar.png') }}" alt="{{ $staffUser->first_name }}" class="avatar">
                                                {{-- La logique 'is_online' n'est pas standard, vous devez l'implémenter si besoin --}}
                                                {{-- <span class="user-status {{ $staffUser->is_online ? 'online' : 'offline' }}"></span> --}}
                                            </div>
                                            <div class="user-details">
                                                <a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" class="user-name-link">{{ $staffUser->first_name }} {{ $staffUser->last_name }}</a>
                                                <div class="user-date">
                                                    <span class="badge date-badge">
                                                        <i class="fas fa-user-cog"></i>Personnel
                                                    </span>
                                                    <span class="badge date-badge">
                                                        <i class="far fa-calendar-alt"></i>Créé le: {{ $staffUser->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-contact">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <a href="mailto:{{ $staffUser->email }}">{{ $staffUser->email }}</a>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <span>{{ $staffUser->phone_number ?? 'N/A' }}</span>
                                            </div>
                                            @if($staffUser->city)
                                                <div class="contact-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $staffUser->city }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="roles-permissions">
                                            <div class="role-badges">
                                                @forelse($staffUser->roles as $role)
                                                    @php
                                                        $roleColors = [
                                                            'pca' => 'purple', 'cn' => 'purple-dark', 'dg' => 'blue-dark', 'sg' => 'green-dark',
                                                            'da' => 'orange', 'rl' => 'teal', 'df-n' => 'red-dark', 'dl-n' => 'indigo-dark',
                                                            'ddo' => 'blue', 'sup' => 'cyan', 'df-v' => 'red', 'dl-v' => 'indigo',
                                                            'af' => 'pink', 'ra-v' => 'lime',
                                                            'cc' => 'sky', 'ra-c' => 'yellow', 'rf-c' => 'rose', 'rl-c' => 'fuchsia',
                                                            'pc' => 'gray', 'cd-n' => 'emerald', 'cd-v' => 'amber',
                                                            // Ajoutez d'autres rôles et couleurs
                                                        ];
                                                        $roleColorClass = $roleColors[strtolower($role->name)] ?? 'primary'; // default to primary
                                                    @endphp
                                                    <span class="role-badge {{ $roleColorClass }}">{{ ucfirst(str_replace(['-', '_'], ' ', $role->name)) }}</span>
                                                @empty
                                                    <span class="text-muted fst-italic">Aucun rôle</span>
                                                @endforelse
                                            </div>
                                            @if($staffUser->getDirectPermissions()->isNotEmpty()) {{-- isNotEmpty() est plus idiomatique --}}
                                                <div class="permissions-info" title="{{ $staffUser->getDirectPermissions()->pluck('name')->join(', ') }}">
                                                    <i class="fas fa-key text-warning"></i>
                                                    <span class="text-muted">{{ $staffUser->getDirectPermissions()->count() }} permission(s) directe(s)</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusInfo = [
                                                \App\Models\User::STATUS_ACTIVE => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Actif'],
                                                \App\Models\User::STATUS_SUSPENDED => ['class' => 'danger', 'icon' => 'ban', 'text' => 'Suspendu'],
                                                \App\Models\User::STATUS_ARCHIVED => ['class' => 'dark', 'icon' => 'archive', 'text' => 'Archivé'],
                                                // Ajoutez d'autres statuts ici si nécessaire pour le personnel
                                            ];
                                            $currentStatus = $statusInfo[$staffUser->status] ?? ['class' => 'secondary', 'icon' => 'question-circle', 'text' => ucfirst(str_replace('_', ' ', $staffUser->status))];
                                        @endphp
                                        <div class="status-badge {{ $currentStatus['class'] }}">
                                            <i class="fas fa-{{ $currentStatus['icon'] }}"></i>
                                            <span>{{ $currentStatus['text'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="login-info">
                                            @if($staffUser->last_login_at)
                                                <div class="login-time" title="{{ $staffUser->last_login_at->isoFormat('LLLL') }}">
                                                    <i class="far fa-clock"></i>
                                                    {{ $staffUser->last_login_at->diffForHumans() }}
                                                </div>
                                                @if($staffUser->last_login_at->diffInDays() < 7)
                                                    <span class="recent-badge">récent</span>
                                                @endif
                                            @else
                                                <div class="login-time never">
                                                    <i class="fas fa-power-off text-muted"></i>
                                                    <span class="text-muted">Jamais</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            @can('staff.view', $staffUser)
                                            <a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" class="btn-action view" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endcan
                                            @can('staff.update', $staffUser)
                                            <a href="{{ route('admin.staff.edit', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" class="btn-action edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endcan
                                            <div class="dropdown d-inline-block">
                                                <button class="btn-action more" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Plus d'options">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @can('staff.manage_permissions', $staffUser) {{-- Adaptez le nom de la permission --}}
                                                    <li>
                                                        {{-- La route pour updateDirectPermissions prend $staffUser en paramètre --}}
                                                        <a class="dropdown-item" href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id, 'tab' => 'permissions']) }}"> {{-- Onglet sur la page show --}}
                                                            <i class="fas fa-key text-primary me-2"></i>Gérer les permissions
                                                        </a>
                                                    </li>
                                                    @endcan
                                                    <li>
                                                        <a class="dropdown-item" href="#"> {{-- Lien à définir --}}
                                                            <i class="fas fa-history text-info me-2"></i>Historique
                                                        </a>
                                                    </li>
                                                    {{-- <li><hr class="dropdown-divider"></li> --}}
                                                    @if($staffUser->status === \App\Models\User::STATUS_ACTIVE)
                                                        @can('staff.update', $staffUser) {{-- Ou une permission plus spécifique comme 'staff.suspend' --}}
                                                        <li>
                                                            {{-- Formulaire pour changer le statut (par exemple, suspendre) --}}
                                                            <form action="{{ route('admin.staff.update', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" method="POST" class="dropdown-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status_action" value="suspend"> {{-- Pour identifier l'action dans le contrôleur --}}
                                                                <input type="hidden" name="status" value="{{ \App\Models\User::STATUS_SUSPENDED }}">
                                                                <button type="submit" class="dropdown-item text-warning">
                                                                    <i class="fas fa-user-clock me-2"></i>Suspendre
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcan
                                                    @elseif($staffUser->status === \App\Models\User::STATUS_SUSPENDED)
                                                         @can('staff.update', $staffUser) {{-- Ou 'staff.reactivate' --}}
                                                        <li>
                                                            <form action="{{ route('admin.staff.update', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" method="POST" class="dropdown-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status_action" value="reactivate">
                                                                <input type="hidden" name="status" value="{{ \App\Models\User::STATUS_ACTIVE }}">
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-user-check me-2"></i>Réactiver
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcan
                                                    @endif
                                                    @if(auth()->id() !== $staffUser->id)
                                                        @can('staff.delete', $staffUser)
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form action="{{ route('admin.staff.destroy', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" method="POST" class="dropdown-form delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                        @endcan
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
                                                <i class="fas fa-users-slash"></i>
                                            </div>
                                            <h4>Aucun membre du personnel trouvé</h4>
                                            <p>Essayez de modifier vos filtres ou <a href="{{ route('admin.staff.create', ['locale' => app()->getLocale()]) }}">d'ajouter un nouveau membre du personnel</a>.</p>
                                            <div class="empty-actions">
                                                <a href="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                                                    <i class="fas fa-redo-alt"></i>Réinitialiser les filtres
                                                </a>
                                                @can('staff.create')
                                                <a href="{{ route('admin.staff.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                                                    <i class="fas fa-user-plus"></i>Ajouter un membre
                                                </a>
                                                @endcan
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
                    <div class="staff-cards">
                        @forelse ($staffMembers as $staffUser)
                            <div class="staff-card">
                                <div class="staff-card-header">
                                    <div class="staff-card-avatar">
                                        <img src="{{ $staffUser->profile_photo_url ?? asset('path/to/default-avatar.png') }}" alt="{{ $staffUser->first_name }}">
                                        {{-- <span class="user-status {{ $staffUser->is_online ? 'online' : 'offline' }}"></span> --}}
                                    </div>
                                    <div class="staff-card-info">
                                        <h3 class="staff-card-name">
                                            <a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}">{{ $staffUser->first_name }} {{ $staffUser->last_name }}</a>
                                        </h3>
                                        <div class="staff-card-roles">
                                            @foreach($staffUser->roles as $role)
                                                @php
                                                    $roleColors = [ /* ... vos couleurs ... */ ];
                                                    $roleColorClass = $roleColors[strtolower($role->name)] ?? 'primary';
                                                @endphp
                                                <span class="role-badge small {{ $roleColorClass }}">{{ ucfirst(str_replace(['-', '_'], ' ', $role->name)) }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="staff-card-status">
                                        @php
                                            $statusInfoCard = [
                                                \App\Models\User::STATUS_ACTIVE => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Actif'],
                                                \App\Models\User::STATUS_SUSPENDED => ['class' => 'danger', 'icon' => 'ban', 'text' => 'Suspendu'],
                                                \App\Models\User::STATUS_ARCHIVED => ['class' => 'dark', 'icon' => 'archive', 'text' => 'Archivé'],
                                            ];
                                            $currentStatusCard = $statusInfoCard[$staffUser->status] ?? ['class' => 'secondary', 'icon' => 'question-circle'];
                                        @endphp
                                        <span class="status-indicator {{ $currentStatusCard['class'] }}" title="{{ $currentStatusCard['text'] ?? ucfirst(str_replace('_', ' ', $staffUser->status)) }}">
                                            <i class="fas fa-{{ $currentStatusCard['icon'] }}"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="staff-card-body">
                                    <div class="staff-card-detail">
                                        <i class="fas fa-envelope"></i>
                                        <a href="mailto:{{ $staffUser->email }}">{{ $staffUser->email }}</a>
                                    </div>
                                    <div class="staff-card-detail">
                                        <i class="fas fa-phone-alt"></i>
                                        <span>{{ $staffUser->phone_number ?? 'N/A' }}</span>
                                    </div>
                                    @if($staffUser->city)
                                        <div class="staff-card-detail">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $staffUser->city }}</span>
                                        </div>
                                    @endif
                                    @if($staffUser->getDirectPermissions()->isNotEmpty())
                                        <div class="staff-card-detail" title="{{ $staffUser->getDirectPermissions()->pluck('name')->join(', ') }}">
                                            <i class="fas fa-key"></i>
                                            <span>{{ $staffUser->getDirectPermissions()->count() }} permission(s) directe(s)</span>
                                        </div>
                                    @endif
                                    <div class="staff-card-detail">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Créé le {{ $staffUser->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="staff-card-detail">
                                        <i class="far fa-clock"></i>
                                        <span>
                                            @if($staffUser->last_login_at)
                                                Dern. con. {{ $staffUser->last_login_at->diffForHumans() }}
                                                @if($staffUser->last_login_at->diffInDays() < 7)
                                                    <span class="recent-badge small">récent</span>
                                                @endif
                                            @else
                                                <span class="text-muted">Jamais connecté</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="staff-card-footer">
                                     @can('staff.view', $staffUser)
                                    <a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" class="staff-card-btn view" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                     @can('staff.update', $staffUser)
                                    <a href="{{ route('admin.staff.edit', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" class="staff-card-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    <div class="dropdown">
                                        <button class="staff-card-btn more" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Plus d'options">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            {{-- ... Mêmes options que dans la table ... --}}
                                             @can('staff.manage_permissions', $staffUser)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id, 'tab' => 'permissions']) }}">
                                                    <i class="fas fa-key text-primary me-2"></i>Gérer les permissions
                                                </a>
                                            </li>
                                            @endcan
                                            @if(auth()->id() !== $staffUser->id)
                                                @can('staff.delete', $staffUser)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('admin.staff.destroy', ['locale' => app()->getLocale(), 'staffUser' => $staffUser->id]) }}" method="POST" class="dropdown-form delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash me-2"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                                @endcan
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state w-100"> {{-- w-100 pour prendre toute la largeur de la grille --}}
                                <div class="empty-icon">
                                    <i class="fas fa-users-slash"></i>
                                </div>
                                <h4>Aucun membre du personnel trouvé</h4>
                                <p>Essayez de modifier vos filtres ou <a href="{{ route('admin.staff.create', ['locale' => app()->getLocale()]) }}">d'ajouter un nouveau membre du personnel</a>.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if($staffMembers->hasPages())
                <div class="card-footer">
                    <div class="pagination-info">
                        Affichage de <span>{{ $staffMembers->firstItem() ?? 0 }}</span> à <span>{{ $staffMembers->lastItem() ?? 0 }}</span> sur <span>{{ $staffMembers->total() }}</span> membres du personnel
                    </div>
                    <div class="pagination-controls">
                        {{-- Pagination avec les paramètres de filtre actuels --}}
                        {{ $staffMembers->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Styles spécifiques au personnel (inchangés, mais vérifiez les couleurs) -->
    <style>
        /* ... Vos styles existants ... */
        .role-badge { /* Style de base pour les badges de rôle */
            padding: 0.25em 0.6em;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: var(--border-radius-sm);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .role-badge.small { font-size: 0.65rem; }

        /* Couleurs (exemples, à compléter avec vos noms de rôles) */
        .role-badge.primary { background-color: rgba(var(--bs-primary-rgb), 0.1); color: var(--bs-primary); }
        .role-badge.purple { background-color: rgba(147, 51, 234, 0.1); color: rgb(126, 34, 206); }
        .role-badge.purple-dark { background-color: rgba(107, 33, 168, 0.15); color: rgb(107, 33, 168); }
        .role-badge.blue-dark { background-color: rgba(29, 78, 216, 0.15); color: rgb(29, 78, 216); }
        .role-badge.green-dark { background-color: rgba(21, 128, 61, 0.15); color: rgb(21, 128, 61); }
        .role-badge.orange { background-color: rgba(251, 146, 60, 0.1); color: rgb(234, 88, 12); }
        .role-badge.teal { background-color: rgba(20, 184, 166, 0.1); color: rgb(13, 148, 136); }
        .role-badge.red-dark { background-color: rgba(185, 28, 28, 0.15); color: rgb(185, 28, 28); }
        .role-badge.indigo-dark { background-color: rgba(79, 70, 229, 0.15); color: rgb(79, 70, 229); }
        .role-badge.blue { background-color: rgba(59, 130, 246, 0.1); color: rgb(37, 99, 235); }
        .role-badge.cyan { background-color: rgba(6, 182, 212, 0.1); color: rgb(8, 145, 178); }
        .role-badge.red { background-color: rgba(239, 68, 68, 0.1); color: rgb(220, 38, 38); }
        .role-badge.indigo { background-color: rgba(99, 102, 241, 0.1); color: rgb(79, 70, 229); }
        .role-badge.pink { background-color: rgba(236, 72, 153, 0.1); color: rgb(219, 39, 119); }
        .role-badge.lime { background-color: rgba(132, 204, 22, 0.1); color: rgb(101, 163, 13); }
        .role-badge.sky { background-color: rgba(14, 165, 233, 0.1); color: rgb(2, 132, 199); }
        .role-badge.yellow { background-color: rgba(250, 204, 21, 0.1); color: rgb(217, 119, 6); } /* Tailwind amber-500 */
        .role-badge.rose { background-color: rgba(244, 63, 94, 0.1); color: rgb(225, 29, 72); }
        .role-badge.fuchsia { background-color: rgba(217, 70, 239, 0.1); color: rgb(192, 38, 211); }
        .role-badge.gray { background-color: rgba(107, 114, 128, 0.1); color: rgb(75, 85, 99); }
        .role-badge.emerald { background-color: rgba(16, 185, 129, 0.1); color: rgb(5, 150, 105); }
        .role-badge.amber { background-color: rgba(245, 158, 11, 0.1); color: rgb(217, 119, 6); }


        .status-badge { /* Style de base pour les badges de statut */
            display: inline-flex;
            align-items: center;
            padding: 0.3em 0.7em;
            font-size: 0.75rem;
            font-weight: 500;
            border-radius: var(--border-radius);
        }
        .status-badge i { margin-right: 0.4em; }
        .status-badge.success { background-color: var(--success-light); color: var(--success); }
        .status-badge.danger { background-color: var(--danger-light); color: var(--danger); }
        .status-badge.warning { background-color: var(--warning-light); color: var(--warning); }
        .status-badge.info { background-color: var(--info-light); color: var(--info); }
        .status-badge.dark { background-color: var(--dark-light, #e9ecef); color: var(--dark, #212529); }
        .status-badge.secondary { background-color: var(--secondary-light, #f8f9fa); color: var(--secondary, #6c757d); }

        .user-name-link {
            color: var(--text-primary);
            font-weight: 600;
            text-decoration: none;
        }
        .user-name-link:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .me-2 { margin-right: 0.5rem !important; } /* Helper pour les icônes dans dropdown */

        /* Styles pour .staff-cards, .staff-card, etc. restent les mêmes */
        .staff-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: var(--spacing-md);
            padding: var(--spacing-md);
        }

        .staff-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
        }

        .staff-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .staff-card-header {
            padding: var(--spacing-md);
            display: flex;
            position: relative;
            border-bottom: 1px solid var(--border-color);
            align-items: center;
        }

        .staff-card-avatar {
            position: relative;
            margin-right: var(--spacing-md);
            flex-shrink: 0;
        }

        .staff-card-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-bg); /* Assurez-vous que --card-bg est défini */
            box-shadow: var(--shadow-sm); /* Assurez-vous que --shadow-sm est défini */
        }

        .user-status { /* Pour la pastille online/offline sur l'avatar */
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }
        .user-status.online { background-color: var(--success); }
        .user-status.offline { background-color: var(--secondary); }


        .staff-card-info {
            flex: 1;
            min-width: 0; /* Pour que le nom du staff ne déborde pas */
        }

        .staff-card-name {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 var(--spacing-xs) 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .staff-card-name a { color: inherit; text-decoration: none; }
        .staff-card-name a:hover { color: var(--primary); }


        .staff-card-roles {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-xs);
        }

        .staff-card-status {
            /* position: absolute; top: var(--spacing-md); right: var(--spacing-md); */ /* Changé pour être à côté du nom */
            margin-left: auto; /* Pousse le statut à droite */
            flex-shrink: 0;
        }
        .status-indicator {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 0.8rem;
        }
        .status-indicator.success { background-color: var(--success-light); color: var(--success); }
        .status-indicator.danger { background-color: var(--danger-light); color: var(--danger); }
        .status-indicator.dark { background-color: var(--dark-light, #e9ecef); color: var(--dark, #212529); }
        .status-indicator.secondary { background-color: var(--secondary-light, #f8f9fa); color: var(--secondary, #6c757d); }


        .staff-card-body {
            padding: var(--spacing-md);
            flex-grow: 1; /* Pour que le corps prenne l'espace restant */
        }

        .staff-card-detail {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .staff-card-detail a { color: var(--text-secondary); text-decoration: none; }
        .staff-card-detail a:hover { color: var(--primary); }


        .staff-card-detail i {
            width: 18px; /* Légèrement plus grand pour l'icône */
            text-align: center; /* Centrer l'icône */
            margin-right: var(--spacing-sm); /* Ajustement de l'espacement */
            color: var(--text-muted); /* Couleur plus douce pour les icônes */
        }
        .staff-card-detail span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }


        .staff-card-footer {
            padding: var(--spacing-sm) var(--spacing-md);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
            background-color: var(--section-bg); /* Assurez-vous que --section-bg est défini */
            border-top: 1px solid var(--border-color);
        }

        .staff-card-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: transparent; /* transparent par défaut */
            color: var(--text-secondary);
            border: 1px solid var(--border-color); /* bordure légère */
            cursor: pointer;
            transition: all 0.2s;
            /* box-shadow: var(--shadow-sm); */ /* Optionnel */
        }

        .staff-card-btn:hover {
            transform: translateY(-1px); /* Effet de survol plus subtil */
            box-shadow: var(--shadow-sm);
            border-color: var(--primary-light); /* Bordure accentuée au survol */
        }

        .staff-card-btn.view:hover { background-color: var(--info-light); color: var(--info); border-color: var(--info); }
        .staff-card-btn.edit:hover { background-color: var(--success-light); color: var(--success); border-color: var(--success); }
        .staff-card-btn.more:hover { background-color: var(--secondary-light, #f8f9fa); color: var(--secondary, #6c757d); border-color: var(--secondary, #6c757d); }

        .recent-badge {
            background-color: var(--primary-light);
            color: var(--primary);
            font-size: 0.65rem;
            padding: 0.15em 0.4em;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            margin-left: 0.5em;
            vertical-align: middle;
        }
        .recent-badge.small {
            font-size: 0.6rem;
            padding: 0.1em 0.3em;
        }
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }
        .empty-state .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--border-color-heavy, #ced4da);
        }
        .empty-state h4 {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        .empty-state p {
            margin-bottom: 1.5rem;
        }
        .empty-state .empty-actions .btn {
            margin: 0 0.5rem;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: var(--spacing-md);
            background-color: var(--section-bg);
            border-top: 1px solid var(--border-color);
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Script similaire aux autres avec quelques adaptations pour le personnel
        document.addEventListener('DOMContentLoaded', function() {
            // Vue tableau/cartes toggle
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableViewEl = document.querySelector('.table-view'); // Renommé pour éviter conflit avec variable tableView
            const cardViewEl = document.querySelector('.card-view');  // Renommé

            if (tableViewBtn && cardViewBtn && tableViewEl && cardViewEl) {
                tableViewBtn.addEventListener('click', function() {
                    tableViewEl.style.display = 'block';
                    cardViewEl.style.display = 'none';
                    tableViewBtn.classList.add('active');
                    cardViewBtn.classList.remove('active');
                    localStorage.setItem('staff-view', 'table');
                });

                cardViewBtn.addEventListener('click', function() {
                    tableViewEl.style.display = 'none';
                    cardViewEl.style.display = 'block';
                    cardViewBtn.classList.add('active');
                    tableViewBtn.classList.remove('active');
                    localStorage.setItem('staff-view', 'card');
                });

                const savedView = localStorage.getItem('staff-view');
                if (savedView === 'card' && cardViewBtn) { // Vérifier que cardViewBtn existe
                    cardViewBtn.click();
                } else if (tableViewBtn) { // Par défaut ou si table est sauvegardé
                     tableViewBtn.classList.add('active'); // S'assurer que le bouton table est actif par défaut
                     cardViewEl.style.display = 'none'; // Cacher la vue carte par défaut
                     tableViewEl.style.display = 'block'; // Montrer la vue table par défaut
                }
            }

            const filterToggle = document.querySelector('.filter-toggle');
            const filterBody = document.querySelector('.filter-body');
            if (filterToggle && filterBody) {
                // Initial state based on if filters are applied (optional)
                const params = new URLSearchParams(window.location.search);
                let filtersApplied = false;
                for (const param of ['role', 'status', 'search']) {
                    if (params.has(param) && params.get(param) !== '') {
                        filtersApplied = true;
                        break;
                    }
                }
                // Si des filtres sont appliqués, on peut vouloir garder le panneau ouvert
                // Pour l'instant, on le ferme par défaut, sauf si on ajoute une logique de 'sticky'
                // filterBody.style.display = filtersApplied ? 'block' : 'none';
                // filterToggle.querySelector('i').className = filtersApplied ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
                // Par défaut, on le ferme :
                filterBody.style.display = 'none';
                filterToggle.querySelector('i').className = 'fas fa-chevron-down';


                filterToggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (filterBody.style.display === 'none' || filterBody.offsetParent === null) { // Vérifie s'il est caché
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                        filterBody.style.display = 'block';
                    } else {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                        filterBody.style.display = 'none';
                    }
                });
            }

            const searchInput = document.getElementById('search');
            const searchClear = document.querySelector('.search-clear');
            if (searchInput && searchClear) {
                searchInput.addEventListener('input', function() {
                    searchClear.style.display = this.value ? 'flex' : 'none';
                });
                searchClear.addEventListener('click', function() {
                    searchInput.value = '';
                    this.style.display = 'none';
                    // Optionnel: soumettre le formulaire pour rafraîchir sans le terme de recherche
                    // document.getElementById('filterForm').submit();
                    searchInput.focus();
                });
                // Afficher le bouton clear au chargement si le champ n'est pas vide
                if (searchInput.value) {
                    searchClear.style.display = 'flex';
                }
            }

            const deleteForms = document.querySelectorAll('form.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const staffName = this.closest('tr, .staff-card')?.querySelector('.user-name-link, .staff-card-name a')?.textContent.trim() || 'ce membre';
                    if (!confirm(`Êtes-vous sûr de vouloir supprimer ${staffName} ? Cette action est irréversible.`)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush