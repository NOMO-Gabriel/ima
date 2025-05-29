@extends('layouts.app')

@section('title', 'Inscription confirmée - ' . $registration->student->user->full_name)

@section('content')
<div class="confirmation-container">
    <!-- En-tête de confirmation -->
    <div class="confirmation-header">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="confirmation-title">Inscription finalisée avec succès !</h1>
        <p class="confirmation-subtitle">
            L'inscription de <strong>{{ $registration->student->user->full_name }}</strong>
            a été traitée et son compte est maintenant actif.
        </p>
    </div>

    <!-- Détails de l'inscription -->
    <div class="registration-details">
        <!-- Informations de l'élève -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-graduate"></i>Informations de l'élève
                </h2>
                <div class="status-indicator success">
                    <i class="fas fa-check-circle"></i>Compte activé
                </div>
            </div>
            <div class="card-body">
                <div class="student-overview">
                    <div class="student-photo">
                        <img src="{{ $registration->student->user->profile_photo_url }}"
                             alt="{{ $registration->student->user->full_name }}"
                             class="avatar-large">
                        <div class="status-badge success">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="student-info">
                        <h3 class="student-name">{{ $registration->student->user->full_name }}</h3>
                        <div class="student-details-grid">
                            <div class="detail-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $registration->student->user->email }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-phone-alt"></i>
                                <span>{{ $registration->student->user->phone_number ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-school"></i>
                                <span>{{ $registration->student->establishment ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-building"></i>
                                <span>{{ $registration->center->name }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $registration->student->user->city ?? 'Non renseigné' }}</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Inscrit le {{ $registration->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formations inscrites -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-graduation-cap"></i>Formations inscrites
                </h2>
                <div class="formations-count">
                    {{ $registration->formations->count() }} formation(s)
                </div>
            </div>
            <div class="card-body">
                <div class="formations-list">
                    @foreach($registration->formations as $formation)
                        <div class="formation-item">
                            <div class="formation-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="formation-details">
                                <h4 class="formation-name">{{ $formation->name }}</h4>
                                <div class="formation-meta">
                                    @if($formation->hours)
                                        <span class="meta-badge">
                                            <i class="fas fa-clock"></i>{{ $formation->hours }}h
                                        </span>
                                    @endif
                                    @if($formation->phase)
                                        <span class="meta-badge">
                                            <i class="fas fa-calendar-check"></i>{{ $formation->phase->description }}
                                        </span>
                                    @endif
                                </div>
                                @if($formation->description)
                                    <p class="formation-description">{{ $formation->description }}</p>
                                @endif
                            </div>
                            @if($formation->price)
                                <div class="formation-price">
                                    {{ number_format($formation->price, 0, ',', ' ') }} FCFA
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Informations financières -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-credit-card"></i>Informations financières
                </h2>
                <div class="receipt-number">
                    Reçu N° {{ $registration->receipt_number }}
                </div>
            </div>
            <div class="card-body">
                <div class="financial-grid">
                    <div class="financial-summary">
                        <div class="summary-item large">
                            <div class="summary-label">Montant total du contrat</div>
                            <div class="summary-value highlight">
                                {{ number_format($registration->contract, 0, ',', ' ') }} FCFA
                            </div>
                        </div>

                        <div class="payment-details">
                            <div class="summary-item">
                                <div class="summary-label">Montant initial reçu</div>
                                <div class="summary-value success">
                                    {{ number_format($registration->installments->sum('amount'), 0, ',', ' ') }} FCFA
                                </div>
                            </div>

                            <div class="summary-item">
                                <div class="summary-label">Montant restant</div>
                                <div class="summary-value {{ ($registration->contract - $registration->installments->sum('amount')) > 0 ? 'warning' : 'success' }}">
                                    {{ number_format($registration->contract - $registration->installments->sum('amount'), 0, ',', ' ') }} FCFA
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-timeline">
                        <h4 class="timeline-title">Historique des paiements</h4>
                        <div class="timeline">
                            @foreach($registration->installments as $installment)
                                <div class="timeline-item">
                                    <div class="timeline-marker success">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-amount">
                                            {{ number_format($installment->amount, 0, ',', ' ') }} FCFA
                                        </div>
                                        <div class="timeline-date">
                                            {{ $installment->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($registration->contract - $registration->installments->sum('amount') > 0)
                                <div class="timeline-item pending">
                                    <div class="timeline-marker pending">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-amount">
                                            {{ number_format($registration->contract - $registration->installments->sum('amount'), 0, ',', ' ') }} FCFA
                                        </div>
                                        <div class="timeline-date">À venir</div>
                                        <div class="timeline-method">Solde restant</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prochaines étapes -->
        <div class="card next-steps-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-list-ol"></i>Prochaines étapes
                </h2>
            </div>
            <div class="card-body">
                <div class="steps-list">
                    <div class="step-item completed">
                        <div class="step-marker">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="step-content">
                            <h4 class="step-title">Inscription validée</h4>
                            <p class="step-description">Le compte élève est activé et l'inscription est confirmée.</p>
                        </div>
                    </div>

                    <div class="step-item next">
                        <div class="step-marker">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="step-content">
                            <h4 class="step-title">Notification envoyée</h4>
                            <p class="step-description">
                                Un email de confirmation a été envoyé à {{ $registration->student->user->email }}
                                avec les détails de l'inscription et les informations de connexion.
                            </p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-marker">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="step-content">
                            <h4 class="step-title">Planning des cours</h4>
                            <p class="step-description">
                                L'élève recevra son planning de cours et pourra accéder à son espace personnel
                                pour suivre ses formations.
                            </p>
                        </div>
                    </div>

                    <div class="step-item">
                        <div class="step-marker">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="step-content">
                            <h4 class="step-title">Paiements suivants</h4>
                            <p class="step-description">
                                @if($registration->contract - $registration->installments->sum('amount') > 0)
                                    Le solde restant de {{ number_format($registration->contract - $registration->installments->sum('amount'), 0, ',', ' ') }} FCFA
                                    sera à régler selon l'échéancier convenu.
                                @else
                                    Le paiement est intégralement réglé. Aucun versement supplémentaire n'est requis.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="actions-section">
        <div class="primary-actions">
            <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}"
               class="btn btn-primary">
                <i class="fas fa-arrow-left"></i>Retour aux inscriptions en attente
            </a>

            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print"></i>Imprimer le récapitulatif
            </button>
        </div>

        <div class="secondary-actions">
            <a href="{{ route('admin.finance.students.completed', ['locale' => app()->getLocale()]) }}"
               class="btn btn-light">
                <i class="fas fa-list"></i>Voir toutes les inscriptions
            </a>

            <a href="{{ route('admin.users.show', ['locale' => app()->getLocale(), 'user' => $registration->student->user]) }}"
               class="btn btn-light">
                <i class="fas fa-user"></i>Profil de l'élève
            </a>
        </div>
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
    --border-color: #E2E8F0;
    --success: #34D399;
    --success-light: rgba(52, 211, 153, 0.1);
    --success-dark: #22c55e;
    --warning: #FBBF24;
    --warning-light: rgba(251, 191, 36, 0.1);
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

.confirmation-container {
    padding: var(--spacing-xl);
    max-width: 1200px;
    margin: 0 auto;
}

/* Header de confirmation */
.confirmation-header {
    text-align: center;
    margin-bottom: var(--spacing-xl);
    padding: var(--spacing-xl);
    background: linear-gradient(135deg, var(--success-light) 0%, var(--primary-light) 100%);
    border-radius: var(--border-radius);
    border: 1px solid var(--success);
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto var(--spacing-lg);
    background-color: var(--success);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: var(--shadow-lg);
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.confirmation-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--success-dark);
    margin: 0 0 var(--spacing-md) 0;
}

.confirmation-subtitle {
    font-size: 1.125rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.6;
}

/* Cards */
.card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: var(--spacing-lg);
    overflow: hidden;
}

.card-header {
    padding: var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
    background-color: var(--section-bg);
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.card-body {
    padding: var(--spacing-lg);
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    font-weight: 600;
}

.status-indicator.success {
    background-color: var(--success-light);
    color: var(--success-dark);
}

.formations-count, .receipt-number {
    background-color: var(--primary-light);
    color: var(--primary-dark);
    padding: 0.375rem 0.75rem;
    border-radius: var(--border-radius);
    font-size: 0.875rem;
    font-weight: 600;
}

/* Student overview */
.student-overview {
    display: flex;
    gap: var(--spacing-lg);
    align-items: flex-start;
}

.student-photo {
    position: relative;
    flex-shrink: 0;
}

.avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid var(--success-light);
    box-shadow: var(--shadow-md);
}

.status-badge {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid var(--card-bg);
    font-size: 0.875rem;
}

.status-badge.success {
    background-color: var(--success);
    color: white;
}

.student-name {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 var(--spacing-md) 0;
    color: var(--text-primary);
}

.student-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-sm);
}

.detail-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
    padding: var(--spacing-sm);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
}

.detail-item i {
    color: var(--primary);
    width: 18px;
    flex-shrink: 0;
}

/* Formations list */
.formations-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

.formation-item {
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-md);
    padding: var(--spacing-lg);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
    border-left: 4px solid var(--primary);
}

.formation-icon {
    width: 48px;
    height: 48px;
    background-color: var(--primary-light);
    color: var(--primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.formation-details {
    flex: 1;
}

.formation-name {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0 0 var(--spacing-sm) 0;
}

.formation-meta {
    display: flex;
    gap: var(--spacing-sm);
    margin-bottom: var(--spacing-sm);
}

.meta-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    background-color: var(--primary-light);
    color: var(--primary-dark);
    border-radius: var(--border-radius);
    font-size: 0.75rem;
    font-weight: 500;
}

.formation-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.4;
}

.formation-price {
    font-size: 1rem;
    font-weight: 600;
    color: var(--success-dark);
    background-color: var(--success-light);
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    text-align: center;
    flex-shrink: 0;
}

/* Financial grid */
.financial-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-xl);
}

.financial-summary {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-item.large {
    padding: var(--spacing-lg);
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--success-light) 100%);
    border-radius: var(--border-radius);
    border: 1px solid var(--primary);
    text-align: center;
}

.summary-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.summary-value.highlight {
    font-size: 2rem;
    color: var(--primary-dark);
}

.summary-value.success {
    color: var(--success-dark);
}

.summary-value.warning {
    color: var(--warning);
}

.payment-details {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
}

/* Payment timeline */
.timeline-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 var(--spacing-lg) 0;
    color: var(--text-primary);
}

.timeline {
    position: relative;
    padding-left: var(--spacing-lg);
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: var(--border-color);
}

.timeline-item {
    position: relative;
    margin-bottom: var(--spacing-lg);
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    border: 3px solid var(--card-bg);
    box-shadow: var(--shadow);
}

.timeline-marker.success {
    background-color: var(--success);
    color: white;
}

.timeline-marker.pending {
    background-color: var(--warning);
    color: white;
}

.timeline-content {
    padding: var(--spacing-sm) 0;
}

.timeline-amount {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--success-dark);
    margin-bottom: 0.25rem;
}

.timeline-item.pending .timeline-amount {
    color: var(--warning);
}

.timeline-date {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.timeline-method {
    font-size: 0.75rem;
    color: var(--text-secondary);
    background-color: var(--section-bg);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius);
    display: inline-block;
}

/* Next steps */
.next-steps-card {
    background: linear-gradient(135deg, var(--card-bg) 0%, var(--info-light) 100%);
    border: 1px solid var(--info);
}

.steps-list {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
}

.step-item {
    display: flex;
    gap: var(--spacing-md);
    padding: var(--spacing-lg);
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    border-left: 4px solid var(--border-color);
    transition: all 0.3s ease;
}

.step-item.completed {
    border-left-color: var(--success);
    background-color: var(--success-light);
}

.step-item.next {
    border-left-color: var(--primary);
    background-color: var(--primary-light);
}

.step-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    background-color: var(--section-bg);
    color: var(--text-secondary);
}

.step-item.completed .step-marker {
    background-color: var(--success);
    color: white;
}

.step-item.next .step-marker {
    background-color: var(--primary);
    color: white;
}

.step-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.step-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.4;
}

/* Actions section */
.actions-section {
    display: flex;
    flex-direction: column;
    gap: var(--spacing-lg);
    margin-top: var(--spacing-xl);
    padding: var(--spacing-xl);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
}

.primary-actions, .secondary-actions {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
}

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
    background-color: var(--success-dark);
    box-shadow: var(--shadow-md);
}

.btn-light {
    background-color: var(--card-bg);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-light:hover {
    background-color: var(--section-bg);
    box-shadow: var(--shadow);
}

/* Print styles */
@media print {
    .actions-section {
        display: none;
    }

    .confirmation-container {
        padding: 0;
    }

    .card {
        box-shadow: none;
        border: 1px solid var(--border-color);
        margin-bottom: var(--spacing-md);
    }

    .success-icon {
        animation: none;
    }
}

/* Responsive design */
@media (max-width: 768px) {
    .confirmation-container {
        padding: var(--spacing-lg);
    }

    .confirmation-header {
        padding: var(--spacing-lg);
    }

    .success-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }

    .confirmation-title {
        font-size: 1.5rem;
    }

    .student-overview {
        flex-direction: column;
        text-align: center;
    }

    .financial-grid {
        grid-template-columns: 1fr;
    }

    .primary-actions, .secondary-actions {
        flex-direction: column;
    }

    .btn {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .student-details-grid {
        grid-template-columns: 1fr;
    }

    .formation-item {
        flex-direction: column;
        text-align: center;
    }

    .formation-price {
        align-self: center;
    }

    .actions-section {
        padding: var(--spacing-lg);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les éléments
    const animateElements = document.querySelectorAll('.card, .step-item');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // Animation séquentielle pour les étapes
    const steps = document.querySelectorAll('.step-item');
    steps.forEach((step, index) => {
        setTimeout(() => {
            step.style.opacity = '1';
            step.style.transform = 'translateY(0)';
        }, index * 200);
    });
});
</script>
@endpush
@endsection
