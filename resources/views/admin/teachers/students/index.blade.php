@extends('layouts.app') {{-- ou votre layout admin --}}

@section('title', 'Gestion des Étudiants')

@section('content')
<div class="users-dashboard">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Étudiants</span>
            </div>
            <h1 class="page-title">Gestion des Étudiants</h1>
            <p class="page-description">Consulter les informations des étudiants.</p>
        </div>
    </div>

    <!-- Métriques -->
    <div class="metrics-grid">
        <div class="metric-card primary">
            <div class="metric-icon"><i class="fas fa-user-graduate"></i></div>
            <div class="metric-content">
                <div class="metric-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="metric-label">Total Étudiants</div>
            </div>
        </div>
        <div class="metric-card success">
            <div class="metric-icon"><i class="fas fa-user-check"></i></div>
            <div class="metric-content">
                <div class="metric-value">{{ $stats['active'] ?? 0 }}</div>
                <div class="metric-label">Étudiants Actifs</div>
            </div>
        </div>
        <div class="metric-card warning">
            <div class="metric-icon"><i class="fas fa-clock"></i></div>
            <div class="metric-content">
                <div class="metric-value">{{ $stats['pending_validation'] ?? 0 }}</div>
                <div class="metric-label">En Attente Validation</div>
            </div>
        </div>
    </div>

    <!-- Section des filtres et recherche -->
    <div class="filters-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-filter"></i> Filtres et Recherche</h2>
            <button class="section-toggle" type="button"><i class="fas fa-chevron-down"></i></button>
        </div>
        
        <div class="section-content" style="display: block;">
            <form action="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" method="GET" class="filters-form">
                <div class="filters-grid">
                    <!-- Recherche principale -->
                    <div class="filter-group primary">
                        <label class="filter-label"><i class="fas fa-search"></i> Recherche générale</label>
                        <div class="search-input-group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..." class="form-input">
                        </div>
                    </div>

                    <!-- Filtre par Genre -->
                    <div class="filter-group">
                        <label class="filter-label"><i class="fas fa-venus-mars"></i> Genre</label>
                        <select name="gender" class="form-select">
                            <option value="">Tous les genres</option>
                            @foreach($genders as $value => $label) {{-- $genders vient de User::getGenders() --}}
                                <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtre par Ville -->
                    <div class="filter-group">
                        <label class="filter-label"><i class="fas fa-city"></i> Ville</label>
                        <select name="city_id" class="form-select">
                            <option value="">Toutes les villes</option>
                            @foreach($citiesForFilter as $id => $name)
                                <option value="{{ $id }}" {{ request('city_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filtre par Centre -->
                    <div class="filter-group">
                        <label class="filter-label"><i class="fas fa-school"></i> Centre</label>
                        <select name="center_id" class="form-select">
                            <option value="">Tous les centres</option>
                            @foreach($centersForFilter as $id => $name)
                                <option value="{{ $id }}" {{ request('center_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtre par statut -->
                    <div class="filter-group">
                        <label class="filter-label"><i class="fas fa-flag"></i> Statut</label>
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            @foreach($statuses as $value => $label) {{-- $statuses vient du contrôleur --}}
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filters-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Effacer
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des étudiants -->
    <div class="data-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-users"></i> Liste des Étudiants
                <span class="section-badge">{{ $studentUsers->total() }}</span>
            </h2>
             <div class="section-actions">
                <div class="view-switcher">
                    <button type="button" class="view-btn active" data-view="table">
                        <i class="fas fa-table"></i>
                    </button>
                    <button type="button" class="view-btn" data-view="grid">
                        <i class="fas fa-th"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="section-content">
            <!-- Vue tableau -->
            <div class="table-view">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="sortable" data-sort="first_name">Étudiant <i class="fas fa-sort"></i></th>
                                <th class="sortable" data-sort="email">Contact <i class="fas fa-sort"></i></th>
                                <th>Ville</th>
                                <th>Centre Principal</th>
                                <th class="sortable" data-sort="status">Statut <i class="fas fa-sort"></i></th>
                                <th class="sortable" data-sort="created_at">Inscrit le <i class="fas fa-sort"></i></th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentUsers as $studentUser)
                                <tr class="table-row">
                                    <td class="user-cell">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <img src="{{ $studentUser->profile_photo_url }}" alt="{{ $studentUser->full_name }}">
                                                <div class="status-indicator {{ $studentUser->status }}"></div>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">
                                                    <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}">
                                                        {{ $studentUser->full_name }}
                                                    </a>
                                                </div>
                                                <div class="user-meta">
                                                    @if($studentUser->gender_label)
                                                        <span class="meta-item"><i class="fas fa-venus-mars"></i> {{ $studentUser->gender_label }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="contact-cell">
                                        <div class="contact-info">
                                            <div class="contact-item"><i class="fas fa-envelope"></i> <a href="mailto:{{ $studentUser->email }}">{{ $studentUser->email }}</a></div>
                                            @if($studentUser->phone_number)
                                                <div class="contact-item"><i class="fas fa-phone"></i> <a href="tel:{{ $studentUser->phone_number }}">{{ $studentUser->phone_number }}</a></div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="city-cell">
                                        {{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}
                                    </td>
                                    <td class="center-cell">
                                        @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                                            {{ $studentUser->student->enrollments->first()->center->name ?? 'N/A' }}
                                            @if($studentUser->student->enrollments->count() > 1)
                                                <span class="badge bg-info text-dark ms-1">+{{ $studentUser->student->enrollments->count() - 1 }}</span>
                                            @endif
                                        @else
                                            <span class="no-data">Non inscrit</span>
                                        @endif
                                    </td>
                                    <td class="status-cell">
                                        @php
                                            $statusClass = 'secondary'; // Default
                                            if ($studentUser->status === \App\Models\User::STATUS_ACTIVE) $statusClass = 'success';
                                            elseif (in_array($studentUser->status, [\App\Models\User::STATUS_PENDING_VALIDATION, \App\Models\User::STATUS_PENDING_CONTRACT])) $statusClass = 'warning';
                                            elseif (in_array($studentUser->status, [\App\Models\User::STATUS_SUSPENDED, \App\Models\User::STATUS_REJECTED])) $statusClass = 'danger';
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $studentUser->status_label }}
                                        </span>
                                    </td>
                                    <td class="date-cell">
                                        <div class="date-info">
                                            <div class="date-primary">{{ $studentUser->created_at->format('d/m/Y') }}</div>
                                            <div class="date-secondary">{{ $studentUser->created_at->format('H:i') }}</div>
                                        </div>
                                    </td>
                                    <td class="actions-cell">
                                        <div class="actions-menu">
                                            <button type="button" class="actions-trigger"><i class="fas fa-ellipsis-h"></i></button>
                                            <div class="actions-dropdown">
                                                <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}" class="action-item">
                                                    <i class="fas fa-eye"></i> Voir le profil
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-state">
                                        <div class="empty-content">
                                            <div class="empty-icon"><i class="fas fa-user-graduate"></i></div>
                                            <h3 class="empty-title">Aucun étudiant trouvé</h3>
                                            <p class="empty-text">Aucun étudiant ne correspond à vos critères de recherche.</p>
                                            <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                                                <i class="fas fa-sync-alt"></i> Réinitialiser les filtres
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Vue grille -->
            <div class="grid-view" style="display: none;">
                <div class="users-grid">
                    @forelse($studentUsers as $studentUser)
                        <div class="user-card">
                            <div class="card-header">
                                <div class="user-avatar">
                                    <img src="{{ $studentUser->profile_photo_url }}" alt="{{ $studentUser->full_name }}">
                                    <div class="status-indicator {{ $studentUser->status }}"></div>
                                </div>
                                <div class="card-actions">
                                    <div class="actions-menu">
                                        <button type="button" class="actions-trigger"><i class="fas fa-ellipsis-v"></i></button>
                                        <div class="actions-dropdown">
                                            <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}" class="action-item">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="user-name">
                                    <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}">
                                        {{ $studentUser->full_name }}
                                    </a>
                                </h3>
                                <div class="user-meta mb-2" style="font-size: 0.85em; color: #6c757d;">
                                    @if($studentUser->gender_label)
                                        <span class="d-block"><i class="fas fa-venus-mars me-1"></i> {{ $studentUser->gender_label }}</span>
                                    @endif
                                    <span class="d-block"><i class="fas fa-city me-1"></i> {{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}</span>
                                     @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                                        <span class="d-block"><i class="fas fa-school me-1"></i> {{ $studentUser->student->enrollments->first()->center->name ?? 'N/A' }}</span>
                                    @endif
                                </div>
                                <div class="user-contacts">
                                    <div class="contact-item"><i class="fas fa-envelope me-1"></i> <span>{{ $studentUser->email }}</span></div>
                                    @if($studentUser->phone_number)
                                        <div class="contact-item"><i class="fas fa-phone me-1"></i> <span>{{ $studentUser->phone_number }}</span></div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                @php
                                    $statusClass = 'secondary'; // Default
                                    if ($studentUser->status === \App\Models\User::STATUS_ACTIVE) $statusClass = 'success';
                                    elseif (in_array($studentUser->status, [\App\Models\User::STATUS_PENDING_VALIDATION, \App\Models\User::STATUS_PENDING_CONTRACT])) $statusClass = 'warning';
                                    elseif (in_array($studentUser->status, [\App\Models\User::STATUS_SUSPENDED, \App\Models\User::STATUS_REJECTED])) $statusClass = 'danger';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $studentUser->status_label }}
                                </span>
                                <div class="card-date"><i class="fas fa-calendar me-1"></i> {{ $studentUser->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                             <div class="empty-state" style="grid-column: 1 / -1;">
                                <div class="empty-content">
                                    <div class="empty-icon"><i class="fas fa-user-graduate"></i></div>
                                    <h3 class="empty-title">Aucun étudiant trouvé</h3>
                                    <p class="empty-text">Aucun étudiant ne correspond à vos critères de recherche.</p>
                                    <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                                        <i class="fas fa-sync-alt"></i> Réinitialiser les filtres
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($studentUsers->hasPages())
            <div class="section-footer">
                <div class="pagination-info">
                    <span>Affichage de {{ $studentUsers->firstItem() ?? 0 }} à {{ $studentUsers->lastItem() ?? 0 }} sur {{ $studentUsers->total() }} étudiants</span>
                </div>
                <div class="pagination-controls">
                    {{ $studentUsers->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-badge {
        padding: 0.3em 0.6em;
        border-radius: 0.25rem;
        font-size: 0.85em;
        font-weight: 600;
        color: #fff;
        text-align: center;
    }
    .status-badge.success { background-color: #28a745; }
    .status-badge.warning { background-color: #ffc107; color: #212529; }
    .status-badge.danger { background-color: #dc3545; }
    .status-badge.info { background-color: #17a2b8; }
    .status-badge.secondary { background-color: #6c757d; }
    .status-badge.dark { background-color: #343a40; }

    /* Users Grid Styles from your original if needed */
    .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .user-card {
        background-color: #fff;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        display: flex;
        flex-direction: column;
    }
    .user-card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #e3e6f0;
    }
    .user-card .user-avatar { position: relative; }
    .user-card .user-avatar img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
    .user-card .user-avatar .status-indicator { /* Styles for online/offline dot */ }
    .user-card .card-body { padding: 1.25rem; flex-grow: 1; }
    .user-card .user-name { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.25rem; }
    .user-card .user-name a { color: #4e73df; text-decoration: none; }
    .user-card .user-name a:hover { text-decoration: underline; }
    .user-card .user-contacts .contact-item { display: flex; align-items: center; font-size: 0.9em; color: #5a5c69; margin-bottom: 0.25rem; }
    .user-card .user-contacts .contact-item i { margin-right: 0.5em; color: #858796; }
    .user-card .card-footer {
        padding: 0.75rem 1.25rem;
        background-color: #f8f9fc;
        border-top: 1px solid #e3e6f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85em;
    }
    .user-card .card-date { color: #858796; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle des sections de filtres
    document.querySelectorAll('.section-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.closest('.filters-section').querySelector('.section-content');
            const icon = this.querySelector('i');
            
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                content.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });
    });

    // Basculer entre les vues table/grille
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            document.querySelector('.table-view').style.display = view === 'table' ? 'block' : 'none';
            document.querySelector('.grid-view').style.display = view === 'grid' ? 'block' : 'none';
            
            localStorage.setItem('students-view-preference', view);
        });
    });

    const savedView = localStorage.getItem('students-view-preference');
    const tableView = document.querySelector('.table-view');
    const gridView = document.querySelector('.grid-view');
    const tableButton = document.querySelector('.view-btn[data-view="table"]');
    const gridButton = document.querySelector('.view-btn[data-view="grid"]');

    if (tableView && gridView && tableButton && gridButton) {
        if (savedView === 'grid') {
            tableView.style.display = 'none';
            gridView.style.display = 'block';
            tableButton.classList.remove('active');
            gridButton.classList.add('active');
        } else { // Default to table view
            tableView.style.display = 'block';
            gridView.style.display = 'none';
            gridButton.classList.remove('active');
            tableButton.classList.add('active');
        }
    }


    // Menu d'actions des lignes/cartes
    document.querySelectorAll('.actions-trigger').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation(); // Empêche la fermeture immédiate si le dropdown est dans le trigger
            const dropdown = this.nextElementSibling;
            
            // Fermer tous les autres menus ouverts
            document.querySelectorAll('.actions-dropdown.active').forEach(menu => {
                if (menu !== dropdown) {
                    menu.classList.remove('active');
                    menu.style.display = 'none';
                }
            });
            
            // Basculer le menu actuel
            dropdown.classList.toggle('active');
            dropdown.style.display = dropdown.classList.contains('active') ? 'block' : 'none';
        });
    });

    // Fermer les menus d'actions en cliquant n'importe où sur la page
    document.addEventListener('click', function() {
        document.querySelectorAll('.actions-dropdown.active').forEach(menu => {
            menu.classList.remove('active');
            menu.style.display = 'none';
        });
    });

    // Tri des colonnes du tableau
    document.querySelectorAll('.data-table .sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            const currentUrl = new URL(window.location);
            const currentSort = currentUrl.searchParams.get('sort');
            const currentDirection = currentUrl.searchParams.get('direction');
            let newDirection = 'asc';
            
            if (currentSort === sortBy && currentDirection === 'asc') {
                newDirection = 'desc';
            }
            
            currentUrl.searchParams.set('sort', sortBy);
            currentUrl.searchParams.set('direction', newDirection);
            
            window.location = currentUrl.toString();
        });
    });
});
</script>
@endpush