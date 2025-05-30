@extends('layouts.app')

@section('title', 'Gestion des Enseignants')

@section('content')
<div class="teachers-management">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Enseignants</span>
            </div>
            <h1 class="page-title">Gestion des Enseignants</h1>
            <p class="page-description">Gérez tous les enseignants du système</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                <span>Ajouter un enseignant</span>
            </a>
        </div>
    </div>

    <!-- Métriques -->
    <div class="metrics-grid">
        <div class="metric-card primary">
            <div class="metric-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="metric-label">Total Enseignants</div>
            </div>
        </div>
        <div class="metric-card success">
            <div class="metric-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ $stats['active'] ?? 0 }}</div>
                <div class="metric-label">Enseignants Actifs</div>
            </div>
        </div>
        <div class="metric-card info">
            <div class="metric-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ count($academies) }}</div>
                <div class="metric-label">Académies</div>
            </div>
        </div>
        <div class="metric-card warning">
            <div class="metric-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="metric-content">
                <div class="metric-value">{{ count($departments) }}</div>
                <div class="metric-label">Départements</div>
            </div>
        </div>
    </div>

    <!-- Section des filtres -->
    <div class="filters-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-filter"></i>
                Filtres et Recherche
            </h2>
        </div>
        
        <div class="section-content">
            <form action="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" method="GET" class="filters-form">
                <div class="filters-grid">
                    <!-- Recherche principale -->
                    <div class="filter-group primary">
                        <label class="filter-label">
                            <i class="fas fa-search"></i>
                            Recherche générale
                        </label>
                        <div class="search-input-group">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nom, email, téléphone, matricule..." 
                                   class="form-input">
                            <i class="search-icon fas fa-search"></i>
                        </div>
                    </div>

                    <!-- Matricule spécifique -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-id-badge"></i>
                            Matricule
                        </label>
                        <input type="text" 
                               name="matricule_filter" 
                               value="{{ request('matricule_filter') }}" 
                               placeholder="Matricule précis..."
                               class="form-input">
                    </div>

                    <!-- Statut -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-flag"></i>
                            Statut
                        </label>
                        <select name="status" class="form-select">
                            <option value="">Tous les statuts</option>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Genre -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-venus-mars"></i>
                            Genre
                        </label>
                        <select name="gender" class="form-select">
                            <option value="">Tous les genres</option>
                            @foreach($genders as $value => $label)
                                <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ville -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-city"></i>
                            Ville d'affectation
                        </label>
                        <select name="city_id" class="form-select">
                            <option value="">Toutes les villes</option>
                            @foreach($cities as $id => $name)
                                <option value="{{ $id }}" {{ request('city_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Académie -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-graduation-cap"></i>
                            Académie
                        </label>
                        <select name="academy_id" class="form-select">
                            <option value="">Toutes les académies</option>
                            @foreach($academies as $id => $name)
                                <option value="{{ $id }}" {{ request('academy_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Département -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-building"></i>
                            Département
                        </label>
                        <select name="department_id" class="form-select">
                            <option value="">Tous les départements</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ request('department_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filters-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Rechercher
                    </button>
                    <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        Effacer
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Section des données -->
    <div class="data-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-users"></i>
                Liste des Enseignants
                <span class="section-badge">{{ $teacherUsers->total() }}</span>
            </h2>
            <div class="section-actions">
                <div class="view-switcher">
                    <button type="button" class="view-btn active" data-view="table" title="Vue tableau">
                        <i class="fas fa-table"></i>
                    </button>
                    <button type="button" class="view-btn" data-view="grid" title="Vue grille">
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
                                <th class="sortable" data-sort="first_name">
                                    Enseignant
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th>Contact</th>
                                <th>Profil Professionnel</th>
                                <th class="sortable" data-sort="status">
                                    Statut
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="actions-col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teacherUsers as $teacherUser)
                                <tr class="table-row">
                                    <td class="user-cell">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}">
                                                <div class="status-indicator {{ $teacherUser->status }}"></div>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">
                                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}">
                                                        {{ $teacherUser->full_name }}
                                                    </a>
                                                </div>
                                                <div class="user-meta">
                                                    @if($teacherUser->teacherProfile && $teacherUser->teacherProfile->matricule)
                                                        <span class="meta-item">
                                                            <i class="fas fa-id-badge"></i>
                                                            Mat: {{ $teacherUser->teacherProfile->matricule }}
                                                        </span>
                                                    @endif
                                                    @if($teacherUser->gender_label)
                                                        <span class="meta-item">
                                                            <i class="fas fa-venus-mars"></i>
                                                            {{ $teacherUser->gender_label }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="contact-cell">
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <a href="mailto:{{ $teacherUser->email }}">{{ $teacherUser->email }}</a>
                                            </div>
                                            @if($teacherUser->phone_number)
                                                <div class="contact-item">
                                                    <i class="fas fa-phone"></i>
                                                    <a href="tel:{{ $teacherUser->phone_number }}">{{ $teacherUser->phone_number }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="profile-cell">
                                        @if($teacherUser->teacherProfile)
                                            <div class="profile-info">
                                                @if($teacherUser->teacherProfile->academy)
                                                    <div class="profile-item">
                                                        <i class="fas fa-graduation-cap"></i>
                                                        <span>{{ $teacherUser->teacherProfile->academy->name }}</span>
                                                    </div>
                                                @endif
                                                @if($teacherUser->teacherProfile->department_id && $teacherUser->teacherProfile->department)
                                                    <div class="profile-item">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $teacherUser->teacherProfile->department->name ?? $teacherUser->teacherProfile->department }}</span>
                                                    </div>
                                                @endif
                                                @if($teacherUser->teacherProfile->city)
                                                    <div class="profile-item">
                                                        <i class="fas fa-city"></i>
                                                        <span>{{ $teacherUser->teacherProfile->city->name }}</span>
                                                    </div>
                                                @endif
                                                @if($teacherUser->teacherProfile->profession)
                                                    <div class="profile-item">
                                                        <i class="fas fa-briefcase"></i>
                                                        <span>{{ $teacherUser->teacherProfile->profession }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="no-data">Profil incomplet</span>
                                        @endif
                                    </td>
                                    <td class="status-cell">
                                        @php
                                            $statusClass = 'secondary';
                                            if ($teacherUser->status === 'active') $statusClass = 'success';
                                            elseif ($teacherUser->status === 'suspended') $statusClass = 'danger';
                                            elseif ($teacherUser->status === 'pending_validation') $statusClass = 'warning';
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $teacherUser->status_label }}
                                        </span>
                                    </td>
                                    <td class="actions-cell">
                                        <div class="actions-menu">
                                            <button type="button" class="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="actions-dropdown">
                                                <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="action-item">
                                                    <i class="fas fa-eye"></i>
                                                    Voir le profil
                                                </a>
                                                <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="action-item">
                                                    <i class="fas fa-edit"></i>
                                                    Modifier
                                                </a>
                                                @if(Auth::id() !== $teacherUser->id)
                                                    <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-item delete">
                                                            <i class="fas fa-trash"></i>
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <div class="empty-content">
                                            <div class="empty-icon">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </div>
                                            <h3 class="empty-title">Aucun enseignant trouvé</h3>
                                            <p class="empty-text">Aucun enseignant ne correspond à vos critères de recherche.</p>
                                            <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                                                <i class="fas fa-sync-alt"></i>
                                                Réinitialiser les filtres
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
                <div class="teachers-grid">
                    @forelse($teacherUsers as $teacherUser)
                        <div class="teacher-card">
                            <div class="card-header">
                                <div class="user-avatar">
                                    <img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}">
                                    <div class="status-indicator {{ $teacherUser->status }}"></div>
                                </div>
                                <div class="card-actions">
                                    <div class="actions-menu">
                                        <button type="button" class="actions-trigger">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="actions-dropdown">
                                            <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="action-item">
                                                <i class="fas fa-eye"></i>
                                                Voir
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="action-item">
                                                <i class="fas fa-edit"></i>
                                                Modifier
                                            </a>
                                            @if(Auth::id() !== $teacherUser->id)
                                                <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-item delete">
                                                        <i class="fas fa-trash"></i>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="teacher-name">
                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}">
                                        {{ $teacherUser->full_name }}
                                    </a>
                                </h3>
                                <div class="teacher-meta">
                                    @if($teacherUser->teacherProfile && $teacherUser->teacherProfile->matricule)
                                        <div class="meta-item">
                                            <i class="fas fa-id-badge"></i>
                                            Mat: {{ $teacherUser->teacherProfile->matricule }}
                                        </div>
                                    @endif
                                    @if($teacherUser->teacherProfile && $teacherUser->teacherProfile->profession)
                                        <div class="meta-item">
                                            <i class="fas fa-briefcase"></i>
                                            {{ $teacherUser->teacherProfile->profession }}
                                        </div>
                                    @endif
                                </div>
                                <div class="teacher-contacts">
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <span>{{ $teacherUser->email }}</span>
                                    </div>
                                    @if($teacherUser->phone_number)
                                        <div class="contact-item">
                                            <i class="fas fa-phone"></i>
                                            <span>{{ $teacherUser->phone_number }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer">
                                @php
                                    $statusClass = 'secondary';
                                    if ($teacherUser->status === 'active') $statusClass = 'success';
                                    elseif ($teacherUser->status === 'suspended') $statusClass = 'danger';
                                    elseif ($teacherUser->status === 'pending_validation') $statusClass = 'warning';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $teacherUser->status_label }}
                                </span>
                                <div class="card-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $teacherUser->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-grid">
                            <div class="empty-content">
                                <div class="empty-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <h3 class="empty-title">Aucun enseignant trouvé</h3>
                                <p class="empty-text">Aucun enseignant ne correspond à vos critères de recherche.</p>
                                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
                                    <i class="fas fa-sync-alt"></i>
                                    Réinitialiser les filtres
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($teacherUsers->hasPages())
            <div class="section-footer">
                <div class="pagination-info">
                    <span>Affichage de {{ $teacherUsers->firstItem() ?? 0 }} à {{ $teacherUsers->lastItem() ?? 0 }} sur {{ $teacherUsers->total() }} enseignants</span>
                </div>
                <div class="pagination-controls">
                    {{ $teacherUsers->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="toast-notification success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="toast-notification error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif
@endsection

@push('styles')
<style>
/* Variables CSS */
:root {
    --primary-color: #4e73df;
    --primary-dark: #3d56c4;
    --success-color: #1cc88a;
    --danger-color: #e74a3b;
    --warning-color: #f6c23e;
    --info-color: #36b9cc;
    --secondary-color: #858796;
    --light-color: #f8f9fc;
    --dark-color: #5a5c69;
    --border-color: #e3e6f0;
    --shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
    --border-radius: 0.35rem;
    --transition: all 0.3s ease;
}

/* Reset et base */
.teachers-management {
    padding: 1.5rem;
    background-color: #f8f9fc;
    min-height: 100vh;
}

/* En-tête de page */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.header-content .breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary-color);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.breadcrumb a {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb i {
    font-size: 0.75rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 400;
    color: var(--dark-color);
    margin: 0 0 0.5rem 0;
}

.page-description {
    color: var(--secondary-color);
    margin: 0;
}

.header-actions .btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Métriques */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: white;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: var(--transition);
}

.metric-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.metric-card.primary { border-left: 4px solid var(--primary-color); }
.metric-card.success { border-left: 4px solid var(--success-color); }
.metric-card.info { border-left: 4px solid var(--info-color); }
.metric-card.warning { border-left: 4px solid var(--warning-color); }

.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.metric-card.primary .metric-icon { background: var(--primary-color); }
.metric-card.success .metric-icon { background: var(--success-color); }
.metric-card.info .metric-icon { background: var(--info-color); }
.metric-card.warning .metric-icon { background: var(--warning-color); }

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    line-height: 1;
}

.metric-label {
    color: var(--secondary-color);
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Sections */
.filters-section,
.data-section {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
    overflow: hidden;
}

.section-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.section-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.section-content {
    padding: 2rem;
}

/* Filtres */
.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.filter-group.primary {
    grid-column: 1 / -1;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.filter-label i {
    color: var(--primary-color);
    width: 16px;
}

.search-input-group {
    position: relative;
}

.search-input-group .search-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--secondary-color);
    pointer-events: none;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    transition: var(--transition);
    background: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.search-input-group .form-input {
    padding-right: 3rem;
}

.filters-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

/* Boutons */
.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--border-radius);
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
    cursor: pointer;
    font-size: 0.875rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #2c44a0 100%);
    transform: translateY(-1px);
    box-shadow: 0 0.5rem 1rem rgba(78, 115, 223, 0.3);
}

.btn-secondary {
    background: var(--secondary-color);
    color: white;
}

.btn-secondary:hover {
    background: #6c757d;
    transform: translateY(-1px);
}

/* Vue switcher */
.view-switcher {
    display: flex;
    background: var(--light-color);
    border-radius: var(--border-radius);
    padding: 0.25rem;
}

.view-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: transparent;
    color: var(--secondary-color);
    border-radius: calc(var(--border-radius) - 0.25rem);
    transition: var(--transition);
    cursor: pointer;
}

.view-btn.active,
.view-btn:hover {
    background: white;
    color: var(--primary-color);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Table */
.table-container {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.data-table th {
    background: var(--light-color);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--dark-color);
    border-bottom: 2px solid var(--border-color);
    white-space: nowrap;
}

.data-table th.sortable {
    cursor: pointer;
    user-select: none;
    transition: var(--transition);
}

.data-table th.sortable:hover {
    background: #e8eaed;
}

.data-table th.sortable i {
    margin-left: 0.5rem;
    color: var(--secondary-color);
}

.data-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.table-row:hover {
    background: var(--light-color);
}

/* Cellules utilisateur */
.user-cell .user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    position: relative;
    flex-shrink: 0;
}

.user-avatar img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border-color);
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.active { background: var(--success-color); }
.status-indicator.suspended { background: var(--danger-color); }
.status-indicator.pending_validation { background: var(--warning-color); }

.user-name a {
    font-weight: 600;
    color: var(--dark-color);
    text-decoration: none;
}

.user-name a:hover {
    color: var(--primary-color);
}

.user-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 0.25rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--secondary-color);
}

.meta-item i {
    width: 12px;
}

/* Cellules contact */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.contact-item i {
    width: 16px;
    color: var(--secondary-color);
}

.contact-item a {
    color: var(--dark-color);
    text-decoration: none;
}

.contact-item a:hover {
    color: var(--primary-color);
}

/* Cellules profil */
.profile-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.profile-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
}

.profile-item i {
    width: 16px;
    color: var(--secondary-color);
}

.no-data {
    color: var(--secondary-color);
    font-style: italic;
    font-size: 0.875rem;
}

/* Status badges */
.status-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.success {
    background: rgba(28, 200, 138, 0.1);
    color: var(--success-color);
    border: 1px solid rgba(28, 200, 138, 0.2);
}

.status-badge.danger {
    background: rgba(231, 74, 59, 0.1);
    color: var(--danger-color);
    border: 1px solid rgba(231, 74, 59, 0.2);
}

.status-badge.warning {
    background: rgba(246, 194, 62, 0.1);
    color: #d69e2e;
    border: 1px solid rgba(246, 194, 62, 0.2);
}

.status-badge.secondary {
    background: rgba(133, 135, 150, 0.1);
    color: var(--secondary-color);
    border: 1px solid rgba(133, 135, 150, 0.2);
}

/* Actions */
.actions-menu {
    position: relative;
}

.actions-trigger {
    background: none;
    border: none;
    padding: 0.5rem;
    color: var(--secondary-color);
    cursor: pointer;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.actions-trigger:hover {
    background: var(--light-color);
    color: var(--primary-color);
}

.actions-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    z-index: 1000;
    min-width: 160px;
    display: none;
}

.actions-dropdown.active {
    display: block;
}

.action-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: var(--dark-color);
    text-decoration: none;
    font-size: 0.875rem;
    transition: var(--transition);
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
}

.action-item:hover {
    background: var(--light-color);
    color: var(--primary-color);
}

.action-item.delete:hover {
    background: rgba(231, 74, 59, 0.1);
    color: var(--danger-color);
}

.action-item i {
    width: 16px;
}

/* Vue grille */
.teachers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.teacher-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    overflow: hidden;
    transition: var(--transition);
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.teacher-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.teacher-card .card-header {
    padding: 1.25rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--light-color);
}

.teacher-card .card-body {
    padding: 1.25rem;
}

.teacher-name {
    margin: 0 0 1rem 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.teacher-name a {
    color: var(--dark-color);
    text-decoration: none;
}

.teacher-name a:hover {
    color: var(--primary-color);
}

.teacher-meta {
    margin-bottom: 1rem;
}

.teacher-meta .meta-item {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    color: var(--secondary-color);
}

.teacher-contacts .contact-item {
    margin-bottom: 0.5rem;
}

.teacher-card .card-footer {
    padding: 1rem 1.25rem;
    background: var(--light-color);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary-color);
    font-size: 0.875rem;
}

/* Empty states */
.empty-state,
.empty-state-grid {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--secondary-color);
}

.empty-state-grid {
    grid-column: 1 / -1;
}

.empty-icon {
    font-size: 4rem;
    color: var(--border-color);
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.empty-text {
    margin-bottom: 1.5rem;
}

/* Pagination */
.section-footer {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--light-color);
}

.pagination-info {
    color: var(--secondary-color);
    font-size: 0.875rem;
}

/* Toast notifications */
.toast-notification {
    position: fixed;
    top: 2rem;
    right: 2rem;
    padding: 1rem 1.5rem;
    border-radius: var(--border-radius);
    color: white;
    font-weight: 600;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    animation: slideInRight 0.3s ease;
}

.toast-notification.success {
    background: var(--success-color);
}

.toast-notification.error {
    background: var(--danger-color);
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .teachers-management {
        padding: 1rem;
    }
    
    .page-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .metrics-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .filters-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .filter-group.primary {
        grid-column: 1;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .section-content {
        padding: 1rem;
    }
    
    .data-table th,
    .data-table td {
        padding: 0.5rem;
    }
    
    .teachers-grid {
        grid-template-columns: 1fr;
    }
    
    .section-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .toast-notification {
        right: 1rem;
        left: 1rem;
        width: auto;
    }
}

@media (max-width: 480px) {
    .user-meta {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .contact-info,
    .profile-info {
        gap: 0.25rem;
    }
    
    .contact-item,
    .profile-item {
        font-size: 0.75rem;
    }
    
    .teacher-card .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}

/* Print styles */
@media print {
    .page-header,
    .filters-section,
    .section-header,
    .actions-cell,
    .card-actions,
    .view-switcher,
    .pagination-controls {
        display: none;
    }
    
    .teachers-management {
        padding: 0;
    }
    
    .data-section {
        box-shadow: none;
        border: 1px solid #000;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement de vue (table/grille)
    const viewButtons = document.querySelectorAll('.view-btn');
    const tableView = document.querySelector('.table-view');
    const gridView = document.querySelector('.grid-view');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            
            // Mise à jour des boutons actifs
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Basculement des vues
            if (view === 'table') {
                tableView.style.display = 'block';
                gridView.style.display = 'none';
            } else {
                tableView.style.display = 'none';
                gridView.style.display = 'block';
            }
            
            // Sauvegarde de la préférence
            localStorage.setItem('teachers-view-preference', view);
        });
    });
    
    // Restauration de la préférence de vue
    const savedView = localStorage.getItem('teachers-view-preference');
    if (savedView === 'grid') {
        const gridButton = document.querySelector('.view-btn[data-view="grid"]');
        if (gridButton) {
            gridButton.click();
        }
    }
    
    // Gestion des menus d'actions
    const actionTriggers = document.querySelectorAll('.actions-trigger');
    
    actionTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.nextElementSibling;
            
            // Fermer tous les autres menus
            document.querySelectorAll('.actions-dropdown.active').forEach(menu => {
                if (menu !== dropdown) {
                    menu.classList.remove('active');
                }
            });
            
            // Basculer le menu actuel
            dropdown.classList.toggle('active');
        });
    });
    
    // Fermer les menus en cliquant ailleurs
    document.addEventListener('click', function() {
        document.querySelectorAll('.actions-dropdown.active').forEach(menu => {
            menu.classList.remove('active');
        });
    });
    
    // Gestion du tri des colonnes
    const sortableHeaders = document.querySelectorAll('.data-table .sortable');
    
    sortableHeaders.forEach(header => {
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
            
            // Mise à jour de l'icône de tri
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-sort-' + (newDirection === 'asc' ? 'up' : 'down');
            }
            
            window.location = currentUrl.toString();
        });
    });
    
    // Confirmation de suppression
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est irréversible.')) {
                this.submit();
            }
        });
    });
    
    // Animation des métriques au chargement
    const metricValues = document.querySelectorAll('.metric-value');
    
    metricValues.forEach(metric => {
        const finalValue = parseInt(metric.textContent);
        let currentValue = 0;
        const increment = Math.ceil(finalValue / 50);
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            metric.textContent = currentValue;
        }, 30);
    });
    
    // Gestion des notifications toast
    const toastNotifications = document.querySelectorAll('.toast-notification');
    
    toastNotifications.forEach(toast => {
        // Auto-hide après 5 secondes
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease forwards';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
        
        // Fermeture au clic
        toast.addEventListener('click', function() {
            this.style.animation = 'slideOutRight 0.3s ease forwards';
            setTimeout(() => {
                this.remove();
            }, 300);
        });
    });
    
    // Recherche en temps réel (optionnel)
    const searchInput = document.querySelector('input[name="search"]');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Vous pouvez implémenter une recherche AJAX ici
                // pour une expérience plus fluide
            }, 500);
        });
    }
    
    // Indicateur de statut en temps réel
    const statusIndicators = document.querySelectorAll('.status-indicator');
    
    statusIndicators.forEach(indicator => {
        if (indicator.classList.contains('active')) {
            // Animation de pulsation pour les utilisateurs actifs
            setInterval(() => {
                indicator.style.animation = 'pulse 2s infinite';
            }, 100);
        }
    });
});

// Animation CSS pour le pulse
const pulseStyle = document.createElement('style');
pulseStyle.textContent = `
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}
`;
document.head.appendChild(pulseStyle);
</script>
@endpush