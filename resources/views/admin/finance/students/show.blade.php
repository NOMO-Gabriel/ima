@extends('layouts.app')

@section('title', 'Détails de l\'élève - ' . $student->full_name)

@section('content')
<div class="student-details-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}">
                    Inscriptions en attente
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Détails de l'élève</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-user-graduate"></i>
                Dossier de {{ $student->full_name }}
            </h1>
            <p class="page-description">
                Consultez toutes les informations de l'élève avant de procéder à la finalisation de son inscription.
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>Retour à la liste
            </a>
            <a href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student]) }}" class="btn btn-success">
                <i class="fas fa-check-circle"></i>Finaliser l'inscription
            </a>
        </div>
    </div>

    <!-- Informations principales de l'élève -->
    <div class="student-profile-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-id-card"></i>Profil de l'élève
            </h2>
            <div class="status-section">
                <span class="status-badge warning">
                    <i class="fas fa-hourglass-half"></i>En attente de validation
                </span>
                <div class="registration-date">
                    <i class="far fa-calendar-alt"></i>
                    Inscrit le {{ $student->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="profile-overview">
                <div class="profile-photo">
                    <img src="{{ $student->profile_photo_url }}" alt="{{ $student->full_name }}" class="avatar-xl">
                    <div class="photo-overlay">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
                <div class="profile-info">
                    <h3 class="student-full-name">{{ $student->full_name }}</h3>
                    <div class="student-meta">
                        <div class="meta-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $student->email }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $student->city ?? 'Non spécifiée' }}</span>
                        </div>
                    </div>
                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-value">{{ $student->created_at->diffInDays() }}</span>
                            <span class="stat-label">Jours d'attente</span>
                        </div>
                        @if($student->last_login_at)
                            <div class="stat-item">
                                <span class="stat-value">{{ $student->last_login_at->format('d/m') }}</span>
                                <span class="stat-label">Dernière connexion</span>
                            </div>
                        @else
                            <div class="stat-item">
                                <span class="stat-value">---</span>
                                <span class="stat-label">Jamais connecté</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="details-grid">
        <!-- Informations personnelles -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>Informations personnelles
                </h3>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-signature"></i>Prénom
                        </div>
                        <div class="info-value">{{ $student->first_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-signature"></i>Nom de famille
                        </div>
                        <div class="info-value">{{ $student->last_name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-envelope"></i>Adresse email
                        </div>
                        <div class="info-value">{{ $student->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-phone-alt"></i>Téléphone personnel
                        </div>
                        <div class="info-value">{{ $student->phone_number ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>Ville de résidence
                        </div>
                        <div class="info-value">{{ $student->city ?? 'Non spécifiée' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations académiques -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-graduation-cap"></i>Informations académiques
                </h3>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-school"></i>Établissement actuel
                        </div>
                        <div class="info-value">{{ $student->student->establishment ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-building"></i>Centre souhaité
                        </div>
                        <div class="info-value">
                            @if($student->student->center)
                                {{ $student->student->center->name }}
                                @if($student->student->center->location)
                                    <span class="text-muted">- {{ $student->student->center->location }}</span>
                                @endif
                            @else
                                <span class="text-muted">Non spécifié</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>Niveau d'études
                        </div>
                        <div class="info-value">
                            <span class="level-badge">{{ $student->student->level ?? 'Non spécifié' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact d'urgence -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-friends"></i>Contact d'urgence
                </h3>
            </div>
            <div class="card-body">
                <div class="info-list">
                    @if($student->student->parent_phone_number)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-phone"></i>Téléphone parent/tuteur
                            </div>
                            <div class="info-value">{{ $student->student->parent_phone_number }}</div>
                        </div>
                    @endif
                    @if($student->student->emergency_contact_name)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-user"></i>Nom du contact
                            </div>
                            <div class="info-value">{{ $student->student->emergency_contact_name }}</div>
                        </div>
                    @endif
                    @if($student->student->emergency_contact_phone)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-phone-alt"></i>Téléphone d'urgence
                            </div>
                            <div class="info-value">{{ $student->student->emergency_contact_phone }}</div>
                        </div>
                    @endif
                    @if(!$student->student->parent_phone_number && !$student->student->emergency_contact_name && !$student->student->emergency_contact_phone)
                        <div class="no-data">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            <span>Aucun contact d'urgence renseigné</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Informations techniques -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-cog"></i>Informations du compte
                </h3>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-plus"></i>Date d'inscription
                        </div>
                        <div class="info-value">
                            {{ $student->created_at->format('d/m/Y à H:i') }}
                            <span class="text-muted">({{ $student->created_at->diffForHumans() }})</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-sync-alt"></i>Dernière mise à jour
                        </div>
                        <div class="info-value">
                            {{ $student->updated_at->format('d/m/Y à H:i') }}
                            <span class="text-muted">({{ $student->updated_at->diffForHumans() }})</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-sign-in-alt"></i>Dernière connexion
                        </div>
                        <div class="info-value">
                            @if($student->last_login_at)
                                {{ $student->last_login_at->format('d/m/Y à H:i') }}
                                <span class="text-muted">({{ $student->last_login_at->diffForHumans() }})</span>
                            @else
                                <span class="text-muted">Jamais connecté</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-user-tag"></i>Type de compte
                        </div>
                        <div class="info-value">
                            <span class="account-type-badge">{{ ucfirst($student->account_type) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="action-cards">
        <div class="action-card finalize">
            <div class="action-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">Finaliser l'inscription</h4>
                <p class="action-description">Procéder à la validation complète du dossier avec choix des formations et modalités de paiement.</p>
                <a href="{{ route('admin.finance.students.finalize', ['locale' => app()->getLocale(), 'student' => $student]) }}" class="action-button btn btn-success">
                    <i class="fas fa-arrow-right"></i>Finaliser maintenant
                </a>
            </div>
        </div>

        <div class="action-card contact">
            <div class="action-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">Contacter l'élève</h4>
                <p class="action-description">Envoyer un email à l'élève pour demander des informations complémentaires si nécessaire.</p>
                <a href="mailto:{{ $student->email }}" class="action-button btn btn-primary">
                    <i class="fas fa-paper-plane"></i>Envoyer un email
                </a>
            </div>
        </div>

        <div class="action-card reject">
            <div class="action-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="action-content">
                <h4 class="action-title">Rejeter l'inscription</h4>
                <p class="action-description">Si le dossier ne répond pas aux critères, vous pouvez rejeter l'inscription avec motif.</p>
                <button type="button" class="action-button btn btn-danger" onclick="showRejectModal({{ $student->id }})">
                    <i class="fas fa-ban"></i>Rejeter le dossier
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-times-circle text-danger"></i>
                Rejeter l'inscription de {{ $student->full_name }}
            </h3>
            <button type="button" class="modal-close" onclick="closeRejectModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="rejectForm" method="POST" action="{{ route('admin.finance.students.reject', ['locale' => app()->getLocale(), 'student' => $student]) }}">
            @csrf
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Attention :</strong> Cette action est irréversible. L'élève sera automatiquement notifié par email avec la raison du rejet.
                    </div>
                </div>
                
                <div class="student-summary">
                    <h4>Récapitulatif du dossier à rejeter :</h4>
                    <ul>
                        <li><strong>Nom :</strong> {{ $student->full_name }}</li>
                        <li><strong>Email :</strong> {{ $student->email }}</li>
                        <li><strong>Date d'inscription :</strong> {{ $student->created_at->format('d/m/Y') }}</li>
                        <li><strong>Établissement :</strong> {{ $student->student->establishment ?? 'Non renseigné' }}</li>
                    </ul>
                </div>

                <div class="form-group">
                    <label for="rejection_reason" class="form-label required">
                        <i class="fas fa-comment-alt"></i>Motif détaillé du rejet
                    </label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="5" 
                              class="form-control" 
                              placeholder="Expliquez clairement et de manière constructive pourquoi cette inscription est rejetée. Cette information sera transmise à l'élève."
                              required maxlength="1000"></textarea>
                    <div class="form-help">
                        <i class="fas fa-info-circle"></i>
                        Soyez précis et professionnel. Ce message sera envoyé directement à l'élève.
                    </div>
                    <div class="char-counter">
                        <span id="charCount">0</span>/1000 caractères
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
:root {
    --primary: #4CA3DD;
    --primary-dark: #2A7AB8;
    --primary-light: rgba(76, 163, 221, 0.1);
    --body-bg: #F8FAFC;
    --card-bg: #FFFFFF;
    --section-bg: #EEF2F7;
    --text-primary: #1E293B;
    --text-secondary: #64748B;
    --text-muted: #94A3B8;
    --border-color: #E2E8F0;
    --success: #34D399;
    --success-light: rgba(52, 211, 153, 0.1);
    --warning: #FBBF24;
    --warning-light: rgba(251, 191, 36, 0.1);
    --danger: #F87171;
    --danger-light: rgba(248, 113, 113, 0.1);
    --info: #60A5FA;
    --info-light: rgba(96, 165, 250, 0.1);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
    --border-radius: 0.5rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
}

body {
    background-color: var(--body-bg);
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.student-details-container {
    padding: var(--spacing-lg);
    max-width: 1400px;
    margin: 0 auto;
}

/* Page header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--spacing-xl);
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
    font-size: 1.875rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.page-description {
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
}

.header-actions {
    display: flex;
    gap: var(--spacing-md);
}

/* Profile card */
.student-profile-card {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--card-bg) 100%);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    margin-bottom: var(--spacing-xl);
    border: 1px solid var(--primary);
}

.card-header {
    padding: var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.status-section {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: var(--border-radius);
    white-space: nowrap;
}

.status-badge.warning {
    background-color: var(--warning-light);
    color: var(--warning);
}

.registration-date {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--text-secondary);
}

.profile-overview {
    display: flex;
    gap: var(--spacing-xl);
    align-items: flex-start;
    padding: var(--spacing-lg);
}

.profile-photo {
    position: relative;
    flex-shrink: 0;
}

.avatar-xl {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--primary-light);
    box-shadow: var(--shadow-lg);
}

.photo-overlay {
    position: absolute;
    bottom: -5px;
    right: -5px;
    width: 40px;
    height: 40px;
    background-color: var(--primary);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    border: 4px solid var(--card-bg);
}

.profile-info {
    flex: 1;
}

.student-full-name {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 var(--spacing-md) 0;
    color: var(--text-primary);
}

.student-meta {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: var(--spacing-lg);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    font-size: 1rem;
}

.meta-item i {
    color: var(--primary);
    width: 20px;
    flex-shrink: 0;
}

.profile-stats {
    display: flex;
    gap: var(--spacing-xl);
}

.stat-item {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Details grid */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-xl);
}

.card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.card-body {
    padding: var(--spacing-lg);
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: var(--spacing-md);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
    transition: background-color 0.2s;
}

.info-row:hover {
    background-color: var(--primary-light);
}

.info-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: var(--text-secondary);
    flex-shrink: 0;
    min-width: 150px;
}

.info-label i {
    color: var(--primary);
    width: 16px;
}

.info-value {
    text-align: right;
    font-weight: 500;
    flex: 1;
}

.text-muted {
    color: var(--text-muted);
    font-size: 0.875rem;
}

.level-badge, .account-type-badge {
    background-color: var(--info-light);
    color: var(--info);
    padding: 0.25rem 0.75rem;
    border-radius: var(--border-radius);
    font-size: 0.8125rem;
    font-weight: 600;
}

.no-data {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-md);
    background-color: var(--warning-light);
    border-radius: var(--border-radius);
    color: var(--warning);
    font-style: italic;
}

/* Action cards */
.action-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-lg);
}

.action-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: var(--spacing-lg);
    display: flex;
    gap: var(--spacing-lg);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.action-card.finalize {
    border-left: 4px solid var(--success);
}

.action-card.contact {
    border-left: 4px solid var(--primary);
}

.action-card.reject {
    border-left: 4px solid var(--danger);
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.action-card.finalize .action-icon {
    background-color: var(--success-light);
    color: var(--success);
}

.action-card.contact .action-icon {
    background-color: var(--primary-light);
    color: var(--primary);
}

.action-card.reject .action-icon {
    background-color: var(--danger-light);
    color: var(--danger);
}

.action-content {
    flex: 1;
}

.action-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
}

.action-description {
    color: var(--text-secondary);
    margin: 0 0 var(--spacing-lg) 0;
    line-height: 1.5;
}

.action-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
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
    box-shadow: var(--shadow-md);
}

.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover {
    background-color: #22c55e;
    box-shadow: var(--shadow-md);
}

.btn-danger {
    background-color: var(--danger);
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
    box-shadow: var(--shadow-md);
}

.btn-light {
    background-color: var(--section-bg);
    color: var(--text-primary);
}

.btn-light:hover {
    background-color: var(--border-color);
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
    backdrop-filter: blur(4px);
}

.modal-content {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s;
}

.modal-close:hover {
    background-color: var(--danger-light);
    color: var(--danger);
}

.modal-body {
    padding: var(--spacing-lg);
}

.modal-footer {
    padding: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-md);
}

.alert {
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-lg);
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-md);
}

.alert-warning {
    background-color: var(--warning-light);
    color: var(--warning);
    border: 1px solid var(--warning);
}

.alert i {
    flex-shrink: 0;
    font-size: 1.25rem;
}

.student-summary {
    background-color: var(--section-bg);
    padding: var(--spacing-lg);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-lg);
}

.student-summary h4 {
    margin: 0 0 var(--spacing-md) 0;
    font-size: 1rem;
    font-weight: 600;
}

.student-summary ul {
    margin: 0;
    padding-left: var(--spacing-lg);
}

.student-summary li {
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.form-group {
    margin-bottom: var(--spacing-lg);
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    font-weight: 500;
    color: var(--text-primary);
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.875rem;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
    resize: vertical;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-help {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    margin-top: 0.5rem;
    font-size: 0.8125rem;
    color: var(--text-secondary);
    line-height: 1.4;
}

.form-help i {
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.char-counter {
    text-align: right;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Responsive design */
@media (max-width: 1024px) {
    .details-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
    
    .profile-overview {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-stats {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .student-details-container {
        padding: var(--spacing-md);
    }
    
    .page-header {
        flex-direction: column;
        gap: var(--spacing-lg);
    }
    
    .header-actions {
        width: 100%;
        justify-content: flex-start;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .action-cards {
        grid-template-columns: 1fr;
    }
    
    .action-card {
        flex-direction: column;
        text-align: center;
    }
    
    .student-meta {
        align-items: flex-start;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .info-label {
        min-width: auto;
    }
    
    .info-value {
        text-align: left;
    }
}

@media (max-width: 576px) {
    .student-full-name {
        font-size: 1.5rem;
    }
    
    .profile-stats {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    
    .modal-content {
        width: 95%;
        margin: var(--spacing-md);
    }
    
    .modal-footer {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
}

/* Print styles */
@media print {
    .header-actions,
    .action-cards,
    .modal-overlay {
        display: none;
    }
    
    .student-details-container {
        padding: 0;
    }
    
    .card {
        box-shadow: none;
        border: 1px solid var(--border-color);
        margin-bottom: var(--spacing-md);
    }
}

/* Dark mode support (if needed) */
@media (prefers-color-scheme: dark) {
    .dark-mode {
        --body-bg: #1E293B;
        --card-bg: #2C3E50;
        --section-bg: #334155;
        --text-primary: #F1F5F9;
        --text-secondary: #94A3B8;
        --text-muted: #64748B;
        --border-color: #475569;
    }
}

/* Loading animation for slow connections */
.card {
    opacity: 0;
    animation: fadeInUp 0.6s ease-out forwards;
}

.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effects for interactive elements */
.info-row {
    cursor: default;
}

.meta-item:hover i {
    transform: scale(1.1);
    transition: transform 0.2s;
}

.action-card:hover .action-icon {
    transform: scale(1.05);
    transition: transform 0.3s;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du modal de rejet
    const modal = document.getElementById('rejectModal');
    const textarea = document.getElementById('rejection_reason');
    const charCount = document.getElementById('charCount');
    
    // Compteur de caractères
    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;
            
            // Changer la couleur selon le nombre de caractères
            if (count > 800) {
                charCount.style.color = 'var(--danger)';
            } else if (count > 600) {
                charCount.style.color = 'var(--warning)';
            } else {
                charCount.style.color = 'var(--text-secondary)';
            }
        });
    }
    
    // Animation d'entrée pour les cartes
    const cards = document.querySelectorAll('.card, .action-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => {
        observer.observe(card);
    });
    
    // Copier les informations dans le presse-papiers
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const text = this.getAttribute('data-copy');
            navigator.clipboard.writeText(text).then(() => {
                // Afficher une notification de succès
                showToast('Informations copiées dans le presse-papiers', 'success');
            });
        });
    });
    
    // Fonction pour afficher des notifications toast
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
        `;
        
        // Ajouter le style du toast
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            border: 1px solid var(--${type === 'success' ? 'success' : 'info'});
            border-radius: var(--border-radius);
            padding: 1rem;
            box-shadow: var(--shadow-lg);
            z-index: 1100;
            animation: slideInRight 0.3s ease-out;
        `;
        
        document.body.appendChild(toast);
        
        // Supprimer le toast après 3 secondes
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease-out';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Ajouter les animations CSS pour les toasts
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .toast-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .toast-success { border-color: var(--success); }
        .toast-success i { color: var(--success); }
    `;
    document.head.appendChild(style);
});

// Fonctions globales pour le modal
function showRejectModal(studentId) {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'flex';
    
    // Focus sur le textarea
    setTimeout(() => {
        document.getElementById('rejection_reason').focus();
    }, 100);
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const textarea = document.getElementById('rejection_reason');
    
    modal.style.display = 'none';
    textarea.value = '';
    
    // Réinitialiser le compteur de caractères
    const charCount = document.getElementById('charCount');
    if (charCount) {
        charCount.textContent = '0';
        charCount.style.color = 'var(--text-secondary)';
    }
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

// Validation du formulaire de rejet
document.getElementById('rejectForm')?.addEventListener('submit', function(e) {
    const textarea = document.getElementById('rejection_reason');
    const message = textarea.value.trim();
    
    if (message.length < 20) {
        e.preventDefault();
        alert('Le motif de rejet doit contenir au moins 20 caractères pour être suffisamment explicatif.');
        textarea.focus();
        return false;
    }
    
    // Confirmation finale
    if (!confirm('Êtes-vous vraiment sûr de vouloir rejeter définitivement cette inscription ?')) {
        e.preventDefault();
        return false;
    }
});
</script>
@endpush
@endsection