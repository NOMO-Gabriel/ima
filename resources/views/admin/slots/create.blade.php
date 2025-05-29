@extends('layouts.app')

@section('title', 'Planifier un créneau')

@section('content')
<div class="planning-dashboard">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}">Planning</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $timetable->week_start_date->toDateString()]) }}">
                    {{ $center->name }}
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Nouveau créneau</span>
            </div>
            <h1 class="page-title">Planifier un créneau</h1>
            <p class="page-description">Ajouter un nouveau cours à l'emploi du temps</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $timetable->week_start_date->toDateString()]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>
                <span>Retour au planning</span>
            </a>
        </div>
    </div>

    <!-- Informations du créneau -->
    <div class="card info-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-info-circle"></i>Informations du créneau
            </h2>
        </div>
        <div class="card-body">
            <div class="slot-info-grid">
                <div class="info-item">
                    <div class="info-icon center">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Centre</span>
                        <span class="info-value">{{ $center->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon formation">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Formation</span>
                        <span class="info-value">{{ $formation->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon room">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Salle</span>
                        <span class="info-value">{{ $room->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon time">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Créneau</span>
                        <span class="info-value">
                            {{ ucfirst($slotData['week_day']) }}
                            {{ \Carbon\Carbon::parse($slotData['start_time'])->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($slotData['end_time'])->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de planification -->
    <div class="card form-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-calendar-plus"></i>Détails du cours
            </h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.slots.store', ['locale' => app()->getLocale()]) }}" id="slotForm">
                @csrf

                <!-- Champs cachés pour les données du créneau -->
                @foreach($slotData as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <div class="form-grid">
                    <div class="form-group">
                        <label for="course_id" class="form-label">
                            <i class="fas fa-book"></i>Cours
                        </label>
                        <div class="select-wrapper">
                            <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                <option value="">-- Sélectionner un cours --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('course_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Choisissez le cours à enseigner pendant ce créneau</div>
                    </div>

                    <div class="form-group">
                        <label for="teacher_id" class="form-label">
                            <i class="fas fa-chalkboard-teacher"></i>Professeur
                        </label>
                        <div class="select-wrapper">
                            <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                                <option value="">-- Sélectionner un professeur --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('teacher_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="form-help">Assignez un professeur à ce créneau</div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $timetable->week_start_date->toDateString()]) }}" class="btn btn-light">
                        <i class="fas fa-times"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>Planifier le créneau
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Aide contextuelle -->
    <div class="card help-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-lightbulb"></i>Aide
            </h3>
        </div>
        <div class="card-body">
            <div class="help-content">
                <div class="help-item">
                    <h4><i class="fas fa-info-circle text-info"></i> Cours optionnel</h4>
                    <p>Vous pouvez créer le créneau sans assigner de cours spécifique. Il pourra être défini plus tard.</p>
                </div>
                <div class="help-item">
                    <h4><i class="fas fa-user-check text-success"></i> Professeur optionnel</h4>
                    <p>De même, l'assignation d'un professeur peut être faite ultérieurement selon les disponibilités.</p>
                </div>
                <div class="help-item">
                    <h4><i class="fas fa-edit text-warning"></i> Modification possible</h4>
                    <p>Une fois créé, le créneau pourra être modifié ou supprimé depuis le planning principal.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Variables CSS */
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

.planning-dashboard {
    padding: var(--spacing-lg);
    max-width: 1200px;
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

/* Informations du créneau */
.slot-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

.info-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.info-icon.center {
    background-color: var(--primary-light);
    color: var(--primary);
}

.info-icon.formation {
    background-color: var(--success-light);
    color: var(--success);
}

.info-icon.room {
    background-color: var(--warning-light);
    color: var(--warning);
}

.info-icon.time {
    background-color: var(--info-light);
    color: var(--info);
}

.info-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-primary);
}

/* Formulaire */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

.form-group {
    margin-bottom: var(--spacing-md);
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.form-control.is-invalid {
    border-color: var(--danger);
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

.form-error {
    color: var(--danger);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-help {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
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

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
}

/* Aide contextuelle */
.help-content {
    display: grid;
    gap: var(--spacing-md);
}

.help-item h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-item p {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .planning-dashboard {
        padding: var(--spacing-md);
    }

    .page-header {
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .slot-info-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: var(--spacing-md);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le premier champ
    const courseSelect = document.getElementById('course_id');
    if (courseSelect) {
        courseSelect.focus();
    }

    // Validation du formulaire
    const form = document.getElementById('slotForm');
    form.addEventListener('submit', function(e) {
        const courseId = document.getElementById('course_id').value;
        const teacherId = document.getElementById('teacher_id').value;

        // Vérifier qu'au moins un champ est rempli
        if (!courseId && !teacherId) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins un cours ou un professeur pour planifier ce créneau.');
            return false;
        }
    });

    // Animation des select au changement
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = 'var(--success)';
                setTimeout(() => {
                    this.style.borderColor = '';
                }, 1000);
            }
        });
    });
});
</script>
@endpush
@endsection
