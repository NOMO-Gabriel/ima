@extends('layouts.app')

@section('title', 'Élèves en attente de validation financière')

@section('content')
<div class="finance-dashboard">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="#">Finance</a>
                <i class="fas fa-chevron-right"></i>
                <span>Inscriptions en attente</span>
            </div>
            <h1 class="page-title">Validation des inscriptions</h1>
            <p class="page-description">Validez et finalisez les inscriptions des nouveaux élèves</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.finance.students.completed', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                <i class="fas fa-check-circle"></i>
                <span>Inscriptions terminées</span>
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-icon warning">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ $stats['total_pending'] }}</h3>
                <p class="stats-label">En attente de validation</p>
            </div>
            <div class="stats-trend">
                <div class="progress-bar warning" style="width: 100%"></div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon info">
                <i class="fas fa-file-contract"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ $stats['pending_contract'] }}</h3>
                <p class="stats-label">En attente de contrat</p>
            </div>
            <div class="stats-trend">
                <div class="progress-bar info" style="width: 75%"></div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ $stats['validated_today'] }}</h3>
                <p class="stats-label">Validés aujourd'hui</p>
            </div>
            <div class="stats-trend">
                <div class="progress-bar success" style="width: 60%"></div>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon danger">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ $stats['rejected_total'] }}</h3>
                <p class="stats-label">Inscriptions rejetées</p>
            </div>
            <div class="stats-trend">
                <div class="progress-bar danger" style="width: 25%"></div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card filter-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-filter"></i>Filtres de recherche
            </h2>
            <button class="btn btn-icon filter-toggle" type="button">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
        <div class="card-body filter-body">
            <form action="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" method="GET" id="filterForm">
                <div class="filter-grid">
                    <div class="form-group">
                        <label for="search">
                            <i class="fas fa-search"></i>Recherche générale
                        </label>
                        <div class="search-wrapper">
                            <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                   class="form-control" placeholder="Nom, email, téléphone, établissement...">
                            <button type="button" class="search-clear" {{ request('search') ? '' : 'style=display:none' }}>
                                <i class="fas fa-times"></i>
                            </button>
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="city">
                            <i class="fas fa-map-marker-alt"></i>Ville
                        </label>
                        <div class="select-wrapper">
                            <select id="city" name="city" class="form-control">
                                <option value="">Toutes les villes</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="establishment">
                            <i class="fas fa-school"></i>Établissement
                        </label>
                        <div class="select-wrapper">
                            <select id="establishment" name="establishment" class="form-control">
                                <option value="">Tous les établissements</option>
                                @foreach($establishments as $establishment)
                                    <option value="{{ $establishment }}" {{ request('establishment') == $establishment ? 'selected' : '' }}>
                                        {{ $establishment }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Appliquer les filtres
                    </button>
                    <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                        <i class="fas fa-redo-alt"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des élèves -->
    <div class="card data-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-users"></i>Élèves en attente ({{ $pendingStudents->total() }})
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
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-download"></i> Exporter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv text-primary"></i>CSV</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success"></i>Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($pendingStudents->count() > 0)
                <!-- Vue tableau -->
                <div class="table-view">
                    <div class="table-responsive">
                        <table class="table students-table">
                            <thead>
                                <tr>
                                    <th class="sortable" data-sort="first_name">
                                        <span>Élève</span>
                                        <i class="fas fa-sort"></i>
                                    </th>
                                    <th>Contact & Établissement</th>
                                    <th>Localisation</th>
                                    <th class="sortable" data-sort="created_at">
                                        <span>Date d'inscription</span>
                                        <i class="fas fa-sort"></i>
                                    </th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingStudents as $student)
                                    <tr>
                                        <td>
                                            <div class="student-info">
                                                <div class="student-avatar">
                                                    <img src="{{ $student->profile_photo_url }}" alt="{{ $student->first_name }}" class="avatar">
                                                    <span class="status-indicator warning">
                                                        <i class="fas fa-hourglass-half"></i>
                                                    </span>
                                                </div>
                                                <div class="student-details">
                                                    <div class="student-name">{{ $student->full_name }}</div>
                                                    <div class="student-info-badges">
                                                        <span class="badge warning-badge">
                                                            <i class="fas fa-hourglass-half"></i>En attente
                                                        </span>
                                                        @if($student->student->parent_phone_number)
                                                            <span class="badge info-badge">
                                                                <i class="fas fa-user-friends"></i>Contact parent
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="contact-info">
                                                <div class="contact-item primary">
                                                    <i class="fas fa-envelope"></i>
                                                    <span>{{ $student->email }}</span>
                                                </div>
                                                <div class="contact-item">
                                                    <i class="fas fa-phone-alt"></i>
                                                    <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                                                </div>
                                                @if($student->student->establishment)
                                                    <div class="contact-item">
                                                        <i class="fas fa-school"></i>
                                                        <span>{{ $student->student->establishment }}</span>
                                                    </div>
                                                @endif
                                                @if($student->student->parent_phone_number)
                                                    <div class="contact-item secondary">
                                                        <i class="fas fa-user-friends"></i>
                                                        <span>Parent: {{ $student->student->parent_phone_number }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="location-info">
                                                <div class="location-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $student->city ?? 'Non spécifié' }}</span>
                                                </div>
                                                @if($student->student->center)
                                                    <div class="location-item">
                                                        <i class="fas fa-building"></i>
                                                        <span>{{ $student->student->center->name }}</span>
                                                    </div>
                                                @else
                                                    <div class="location-item muted">
                                                        <i class="fas fa-question-circle"></i>
                                                        <span>Centre non spécifié</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <div class="date-primary">
                                                    <i class="far fa-calendar-alt"></i>
                                                    {{ $student->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="date-secondary">
                                                    {{ $student->created_at->format('H:i') }} • 
                                                    {{ $student->created_at->diffForHumans() }}
                                                </div>
                                                @if($student->created_at->isToday())
                                                    <div class="date-badge today">
                                                        <i class="fas fa-star"></i>Aujourd'hui
                                                    </div>
                                                @elseif($student->created_at->isYesterday())
                                                    <div class="date-badge recent">
                                                        <i class="fas fa-clock"></i>Hier
                                                    </div>
                                                @elseif($student->created_at->diffInDays() <= 7)
                                                    <div class="date-badge recent">
                                                        <i class="fas fa-clock"></i>Cette semaine
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.finance.students.show', ['locale' => app()->getLocale(), 'student' => $student]) }}" 
                                                   class="btn-action view" title="Voir les détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student]) }}" 
                                                   class="btn-action finalize" title="Finaliser l'inscription">
                                                    <i class="fas fa-check-circle"></i>
                                                </a>
                                                <button type="button" class="btn-action reject" 
                                                        onclick="showRejectModal({{ $student->id }})" 
                                                        title="Rejeter l'inscription">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Vue cartes -->
                <div class="card-view" style="display: none;">
                    <div class="students-cards">
                        @foreach($pendingStudents as $student)
                            <div class="student-card">
                                <div class="student-card-header">
                                    <div class="student-card-avatar">
                                        <img src="{{ $student->profile_photo_url }}" alt="{{ $student->first_name }}">
                                        <span class="status-indicator warning">
                                            <i class="fas fa-hourglass-half"></i>
                                        </span>
                                    </div>
                                    <div class="student-card-info">
                                        <h3 class="student-card-name">{{ $student->full_name }}</h3>
                                        <div class="student-card-badges">
                                            <span class="badge warning-badge small">
                                                <i class="fas fa-hourglass-half"></i>En attente
                                            </span>
                                        </div>
                                    </div>
                                    <div class="student-card-menu">
                                        <div class="dropdown">
                                            <button class="btn-menu" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.finance.students.show', ['locale' => app()->getLocale(), 'student' => $student]) }}">
                                                        <i class="fas fa-eye text-info"></i>Voir les détails
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student]) }}">
                                                        <i class="fas fa-check-circle text-success"></i>Finaliser l'inscription
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button class="dropdown-item text-danger" onclick="showRejectModal({{ $student->id }})">
                                                        <i class="fas fa-times-circle"></i>Rejeter l'inscription
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
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
                                    @if($student->student->establishment)
                                        <div class="student-card-detail">
                                            <i class="fas fa-school"></i>
                                            <span>{{ $student->student->establishment }}</span>
                                        </div>
                                    @endif
                                    <div class="student-card-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $student->city ?? 'Non spécifié' }}</span>
                                    </div>
                                    @if($student->student->center)
                                        <div class="student-card-detail">
                                            <i class="fas fa-building"></i>
                                            <span>{{ $student->student->center->name }}</span>
                                        </div>
                                    @endif
                                    <div class="student-card-detail">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Inscrit le {{ $student->created_at->format('d/m/Y à H:i') }}</span>
                                    </div>
                                </div>
                                <div class="student-card-footer">
                                    <a href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student]) }}" 
                                       class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle"></i>Finaliser
                                    </a>
                                    <a href="{{ route('admin.finance.students.show', ['locale' => app()->getLocale(), 'student' => $student]) }}" 
                                       class="btn btn-light btn-sm">
                                        <i class="fas fa-eye"></i>Détails
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h4>Aucun élève en attente</h4>
                    <p>Tous les élèves ont été traités ou aucune nouvelle inscription n'est en attente de validation.</p>
                    <div class="empty-actions">
                        <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                            <i class="fas fa-filter"></i>Réinitialiser les filtres
                        </a>
                        <a href="{{ route('admin.finance.students.completed', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                            <i class="fas fa-check-circle"></i>Voir les inscriptions terminées
                        </a>
                    </div>
                </div>
            @endif
        </div>

        @if($pendingStudents->hasPages())
            <div class="card-footer">
                <div class="pagination-info">
                    Affichage de <span>{{ $pendingStudents->firstItem() ?? 0 }}</span> à 
                    <span>{{ $pendingStudents->lastItem() ?? 0 }}</span> sur 
                    <span>{{ $pendingStudents->total() }}</span> élèves
                </div>
                <div class="pagination-controls">
                    {{ $pendingStudents->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-times-circle text-danger"></i>
                Rejeter l'inscription
            </h3>
            <button type="button" class="modal-close" onclick="closeRejectModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Attention :</strong> Cette action est irréversible. L'élève sera notifié par email de la raison du rejet.
                </div>
                <div class="form-group">
                    <label for="rejection_reason" class="form-label required">
                        <i class="fas fa-comment-alt"></i>Raison du rejet
                    </label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                              class="form-control" 
                              placeholder="Expliquez clairement pourquoi cette inscription est rejetée..."
                              required maxlength="1000"></textarea>
                    <div class="form-help">
                        Cette raison sera communiquée à l'élève par email. Soyez précis et constructif.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="closeRejectModal()">
                    <i class="fas fa-times"></i>Annuler
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times-circle"></i>Confirmer le rejet
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
/* Styles basés sur la version précédente avec quelques améliorations */
:root {
    --primary: #4CA3DD;
    --primary-dark: #2A7AB8;
    --primary-light: rgba(76, 163, 221, 0.1);
    --body-bg: #F8FAFC;
    --card-bg: #FFFFFF;
    --section-bg: #EEF2F7;
    --text-primary: #1E293B;
    --text-secondary: #64748B;
    --border-color: #E2E8F0;
    --success: #34D399;
    --success-light: rgba(52, 211, 153, 0.1);
    --info: #60A5FA;
    --info-light: rgba(96, 165, 250, 0.1);
    --warning: #FBBF24;
    --warning-light: rgba(251, 191, 36, 0.1);
    --danger: #F87171;
    --danger-light: rgba(248, 113, 113, 0.1);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --border-radius: 0.5rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
}

body {
    background-color: var(--body-bg);
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.finance-dashboard {
    padding: var(--spacing-lg);
    max-width: 1600px;
    margin: 0 auto;
}

/* Page header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--spacing-lg);
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-sm);
}

.breadcrumb a {
    color: var(--text-secondary);
    text-decoration: none;
}

.breadcrumb a:hover {
    color: var(--primary);
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.page-description {
    color: var(--text-secondary);
    margin: 0;
}

/* Stats cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-lg);
}

.stats-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    padding: var(--spacing-md);
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: var(--spacing-sm);
}

.stats-icon.warning {
    background-color: var(--warning-light);
    color: var(--warning);
}

.stats-icon.info {
    background-color: var(--info-light);
    color: var(--info);
}

.stats-icon.success {
    background-color: var(--success-light);
    color: var(--success);
}

.stats-icon.danger {
    background-color: var(--danger-light);
    color: var(--danger);
}

.stats-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.stats-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin: 0;
}

.progress-bar {
    height: 4px;
    border-radius: 2px;
    margin-top: auto;
}

.progress-bar.warning {
    background-color: var(--warning);
}

.progress-bar.info {
    background-color: var(--info);
}

.progress-bar.success {
    background-color: var(--success);
}

.progress-bar.danger {
    background-color: var(--danger);
}

/* Cards */
.card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: var(--spacing-lg);
}

.card-header {
    padding: var(--spacing-md) var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.card-body {
    padding: var(--spacing-lg);
}

.card-footer {
    padding: var(--spacing-md) var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border-color);
}

/* Filter form */
.filter-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--spacing-md);
}

.form-group {
    margin-bottom: var(--spacing-md);
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.25rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.form-control {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.875rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.select-wrapper {
    position: relative;
}

.select-wrapper select {
    appearance: none;
    padding-right: 2rem;
}

.select-wrapper i {
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-secondary);
}

.search-wrapper {
    position: relative;
}

.search-wrapper input {
    padding-right: 4rem;
}

.search-clear, .search-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-clear {
    right: 2.5rem;
    color: var(--text-secondary);
    width: 1.5rem;
    height: 1.5rem;
}

.search-button {
    right: 0.5rem;
    color: var(--primary);
    width: 2rem;
    height: 2rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    text-decoration: none;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

.btn-light {
    background-color: var(--section-bg);
    color: var(--text-primary);
}

.btn-light:hover {
    background-color: var(--border-color);
}

.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover {
    background-color: #22c55e;
}

.btn-danger {
    background-color: var(--danger);
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
}

.btn-icon {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}

.filter-actions {
    display: flex;
    gap: var(--spacing-md);
    margin-top: var(--spacing-md);
    justify-content: flex-end;
}

/* View switcher */
.view-actions {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.view-switcher {
    display: flex;
    border-radius: var(--border-radius);
    overflow: hidden;
    margin-right: var(--spacing-sm);
}

.view-switcher .btn {
    border-radius: 0;
    background-color: var(--section-bg);
}

.view-switcher .btn.active {
    background-color: var(--primary);
    color: white;
}

/* Table */
.students-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.students-table th {
    text-align: left;
    padding: var(--spacing-sm) var(--spacing-md);
    background-color: var(--section-bg);
    color: var(--text-secondary);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border-color);
}

.students-table th.sortable {
    cursor: pointer;
    user-select: none;
}

.students-table th.sortable:hover {
    background-color: var(--primary-light);
}

.students-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.students-table tr:hover td {
    background-color: var(--primary-light);
}

/* Student info */
.student-info {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
}

.student-avatar {
    position: relative;
    flex-shrink: 0;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--card-bg);
    box-shadow: var(--shadow);
}

.status-indicator {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.625rem;
    border: 2px solid var(--card-bg);
}

.status-indicator.warning {
    background-color: var(--warning);
    color: white;
}

.student-name {
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.student-info-badges {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: var(--border-radius);
}

.badge.small {
    padding: 0.0625rem 0.375rem;
    font-size: 0.6875rem;
}

.warning-badge {
    background-color: var(--warning-light);
    color: var(--warning);
}

.info-badge {
    background-color: var(--info-light);
    color: var(--info);
}

/* Contact info */
.contact-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
}

.contact-item.primary {
    font-weight: 500;
}

.contact-item.secondary {
    color: var(--text-secondary);
    font-size: 0.8125rem;
}

.contact-item i {
    color: var(--text-secondary);
    width: 16px;
}

.contact-item.primary i {
    color: var(--primary);
}

/* Location info */
.location-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.location-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
}

.location-item.muted {
    color: var(--text-secondary);
    font-style: italic;
}

.location-item i {
    color: var(--text-secondary);
    width: 16px;
}

/* Date info */
.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-primary {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    font-size: 0.875rem;
}

.date-secondary {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.375rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--border-radius);
    margin-top: 0.25rem;
}

.date-badge.today {
    background-color: var(--success-light);
    color: var(--success);
}

.date-badge.recent {
    background-color: var(--info-light);
    color: var(--info);
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 0.25rem;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--border-radius);
    border: none;
    background-color: var(--section-bg);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.btn-action.view:hover {
    background-color: var(--info-light);
    color: var(--info);
}

.btn-action.finalize:hover {
    background-color: var(--success-light);
    color: var(--success);
}

.btn-action.reject:hover {
    background-color: var(--danger-light);
    color: var(--danger);
}

/* Card view */
.students-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: var(--spacing-md);
    padding: var(--spacing-md);
}

.student-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
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
    align-items: flex-start;
    gap: var(--spacing-md);
    border-bottom: 1px solid var(--border-color);
    background-color: var(--section-bg);
}

.student-card-avatar {
    position: relative;
    flex-shrink: 0;
}

.student-card-avatar img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--card-bg);
}

.student-card-info {
    flex: 1;
}

.student-card-name {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.student-card-badges {
    display: flex;
    gap: 0.25rem;
}

.student-card-menu {
    flex-shrink: 0;
}

.btn-menu {
    width: 32px;
    height: 32px;
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-menu:hover {
    background-color: var(--section-bg);
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
    padding: var(--spacing-sm) var(--spacing-md);
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-sm);
    background-color: var(--section-bg);
}

/* Empty state */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: var(--text-secondary);
    opacity: 0.3;
    margin-bottom: var(--spacing-md);
}

.empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 var(--spacing-sm) 0;
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 var(--spacing-lg) 0;
    max-width: 400px;
}

.empty-actions {
    display: flex;
    gap: var(--spacing-md);
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: var(--spacing-lg);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.modal-close {
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 1.25rem;
}

.modal-body {
    padding: var(--spacing-lg);
}

.modal-footer {
    padding: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-sm);
}

.alert {
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-sm);
}

.alert-warning {
    background-color: var(--warning-light);
    color: var(--warning);
    border: 1px solid var(--warning);
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 0.25rem;
}

.form-help {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

/* Pagination */
.pagination-info {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.pagination-info span {
    font-weight: 600;
    color: var(--text-primary);
}

/* Responsive */
@media (max-width: 768px) {
    .finance-dashboard {
        padding: var(--spacing-md);
    }
    
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .filter-grid {
        grid-template-columns: 1fr;
    }
    
    .page-header {
        flex-direction: column;
    }
    
    .header-actions {
        margin-top: var(--spacing-md);
        width: 100%;
    }
    
    .view-actions {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    
    .students-cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .students-table th:nth-child(3),
    .students-table td:nth-child(3) {
        display: none;
    }
    
    .filter-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
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
            localStorage.setItem('finance-students-view', 'table');
        });

        cardViewBtn.addEventListener('click', function() {
            tableView.style.display = 'none';
            cardView.style.display = 'block';
            cardViewBtn.classList.add('active');
            tableViewBtn.classList.remove('active');
            localStorage.setItem('finance-students-view', 'card');
        });

        // Restaurer la préférence d'affichage
        const savedView = localStorage.getItem('finance-students-view');
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
            if (filterBody.style.display === 'none') {
                filterBody.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
                localStorage.setItem('finance-filter-visible', 'true');
            } else {
                filterBody.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
                localStorage.setItem('finance-filter-visible', 'false');
            }
        });

        // Restaurer l'état des filtres
        const filtersVisible = localStorage.getItem('finance-filter-visible');
        if (filtersVisible === 'false') {
            filterBody.style.display = 'none';
            const icon = filterToggle.querySelector('i');
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }

    // Gestion du bouton de recherche clear
    const searchInput = document.getElementById('search');
    const searchClear = document.querySelector('.search-clear');

    if (searchInput && searchClear) {
        searchInput.addEventListener('input', function() {
            searchClear.style.display = this.value ? 'flex' : 'none';
        });

        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            this.style.display = 'none';
            searchInput.focus();
        });
    }

    // Gestion du tri des colonnes
    const sortableColumns = document.querySelectorAll('th.sortable');
    sortableColumns.forEach(column => {
        column.addEventListener('click', function() {
            const sortField = this.dataset.sort;
            let sortDirection = 'asc';

            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-sort-up')) {
                sortDirection = 'desc';
                icon.classList.remove('fa-sort', 'fa-sort-up');
                icon.classList.add('fa-sort-down');
            } else if (icon.classList.contains('fa-sort-down')) {
                sortDirection = '';
                icon.classList.remove('fa-sort-down');
                icon.classList.add('fa-sort');
            } else {
                icon.classList.remove('fa-sort');
                icon.classList.add('fa-sort-up');
            }

            // Réinitialiser les autres icônes
            sortableColumns.forEach(otherColumn => {
                if (otherColumn !== column) {
                    const otherIcon = otherColumn.querySelector('i');
                    otherIcon.className = 'fas fa-sort';
                }
            });

            // Construire l'URL avec les paramètres de tri
            const currentUrl = new URL(window.location);
            if (sortDirection) {
                currentUrl.searchParams.set('sort', sortField);
                currentUrl.searchParams.set('direction', sortDirection);
            } else {
                currentUrl.searchParams.delete('sort');
                currentUrl.searchParams.delete('direction');
            }

            window.location.href = currentUrl.toString();
        });
    });

    // Initialiser les icônes de tri
    const urlParams = new URLSearchParams(window.location.search);
    const sortField = urlParams.get('sort');
    const sortDirection = urlParams.get('direction');

    if (sortField && sortDirection) {
        const column = document.querySelector(`th.sortable[data-sort="${sortField}"]`);
        if (column) {
            const icon = column.querySelector('i');
            icon.classList.remove('fa-sort');
            if (sortDirection === 'asc') {
                icon.classList.add('fa-sort-up');
            } else {
                icon.classList.add('fa-sort-down');
            }
        }
    }
});

// Fonctions pour le modal de rejet
function showRejectModal(studentId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    const baseUrl = "{{ url('/') }}/{{ app()->getLocale() }}/finance/students";
    
    form.action = `${baseUrl}/${studentId}/reject`;
    modal.style.display = 'flex';
    
    setTimeout(() => {
        document.getElementById('rejection_reason').focus();
    }, 100);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const textarea = document.getElementById('rejection_reason');
    
    modal.style.display = 'none';
    textarea.value = '';
}

// Fermer le modal en cliquant à l'extérieur
document.addEventListener('click', function(event) {
    const modal = document.getElementById('rejectModal');
    if (event.target === modal) {
        closeRejectModal();
    }
});

// Fermer le modal avec Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRejectModal();
    }
});
</script>
@endpush
@endsection