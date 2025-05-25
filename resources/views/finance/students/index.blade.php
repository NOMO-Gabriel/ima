@extends('layouts.app')

@section('title', 'Gestion Financière des Élèves')
@section('page_title', 'Gestion Financière des Élèves')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de Bord</a></li>
    <li class="breadcrumb-item"><span>Finance</span></li>
    <li class="breadcrumb-item active" aria-current="page">Élèves</li>
@endsection

@section('content')
    <div class="users-dashboard">
        <div class="card filter-card mb-4">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-filter me-2"></i>Filtres</h2>
                <button class="btn btn-icon filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse" aria-expanded="true" aria-controls="filtersCollapse">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="collapse show" id="filtersCollapse">
                <div class="card-body">
                    <form action="{{ route('finance.students.index', ['locale' => app()->getLocale()]) }}" method="GET" id="filterFormStudentFinance">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="status" class="form-label"><i class="fas fa-user-shield me-1"></i>Statut</label>
                                <select id="status" name="status" class="form-select form-select-sm">
                                    <option value="">Tous les statuts</option>
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @can('finance.student.filter.by_city')
                                <div class="col-md-3">
                                    <label for="city_id_filter" class="form-label"><i class="fas fa-city me-1"></i>Ville</label>
                                    <select id="city_id_filter" name="city_id" class="form-select form-select-sm">
                                        <option value="">Toutes les villes</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan

                            @can('finance.student.filter.by_center')
                                <div class="col-md-3">
                                    <label for="center_id_filter" class="form-label"><i class="fas fa-school me-1"></i>Centre</label>
                                    <select id="center_id_filter" name="center_id" class="form-select form-select-sm">
                                        <option value="">Tous les centres</option>
                                        {{-- $centersForFilter est déjà scopé dans le contrôleur --}}
                                        @foreach($centersForFilter as $center)
                                            <option value="{{ $center->id }}" data-city="{{ $center->city_id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                                {{ $center->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan

                            <div class="col-md-3"> {{-- La recherche est toujours dispo si on a finance.student.view --}}
                                <label for="search" class="form-label"><i class="fas fa-search me-1"></i>Recherche</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nom, email, matricule...">
                                    @if(request('search'))
                                    <button type="button" class="btn btn-outline-secondary search-clear-btn" onclick="document.getElementById('search').value=''; this.form.submit();">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 text-end">
                            <a href="{{ route('finance.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-sm btn-light"><i class="fas fa-redo-alt me-1"></i> Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card data-card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-users me-2"></i>Liste des Élèves ({{ $students->total() }})</h2>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table users-table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                @php
                                    $sortLink = function($field, $displayName) use ($request) {
                                        $currentSort = $request->input('sort');
                                        $currentDirection = $request->input('direction', 'asc');
                                        $direction = ($currentSort === $field && $currentDirection === 'asc') ? 'desc' : 'asc';
                                        $icon = 'fas fa-sort';
                                        if ($currentSort === $field) {
                                            $icon = $currentDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                                        }
                                        $queryParams = array_merge($request->except('page'), ['sort' => $field, 'direction' => $direction]);
                                        return '<a href="'.route('finance.students.index', $queryParams).'" class="sortable-header text-decoration-none">'.$displayName.' <i class="'.$icon.' ms-1"></i></a>';
                                    };
                                @endphp
                                <th style="width:20%">{!! $sortLink('users.last_name', 'Nom & Prénom') !!}</th>
                                <th style="width:15%">Contact</th>
                                <th style="width:10%">{!! $sortLink('city_name', 'Ville') !!}</th>
                                <th style="width:15%">{!! $sortLink('center_name', 'Centre') !!}</th>
                                <th style="width:15%" class="text-center">{!! $sortLink('users.status', 'Statut') !!}</th>
                                <th style="width:15%">Formation & Concours</th>
                                <th style="width:10%; text-align: right;">Contrat</th>
                                <th style="width:5%" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $student->profile_photo_url }}" alt="{{ $student->first_name }}" class="avatar rounded-circle me-2" style="width:32px; height:32px;">
                                            <div>
                                                <div class="fw-bold">{{ $student->last_name }} {{ $student->first_name }}</div>
                                                <small class="text-muted">{{ $student->student_data['matricule'] ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div><i class="fas fa-envelope text-muted me-1"></i> {{ $student->email }}</div>
                                            <div><i class="fas fa-phone-alt text-muted me-1"></i> {{ $student->phone_number }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $student->city->name ?? 'N/A' }}</td>
                                    <td>{{ $student->center->name ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        @php $statusInfo = \App\Models\User::getStudentStatusInfo($student->status); @endphp
                                        <span class="badge status-badge-sm {{ $statusInfo['class'] }}">
                                            <i class="fas fa-{{ $statusInfo['icon'] }} me-1"></i>
                                            {{ $statusInfo['text'] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!empty($student->student_data['contract']['formation']['name']))
                                            <div class="fw-medium small">{{ Str::limit($student->student_data['contract']['formation']['name'], 30) }}</div>
                                        @endif
                                        @if(!empty($student->student_data['entrance_exams']))
                                            <div class="text-muted small">
                                                @foreach(collect($student->student_data['entrance_exams'])->pluck('name')->take(2) as $examName)
                                                    {{ Str::limit($examName, 20) }}@if(!$loop->last), @endif
                                                @endforeach
                                                @if(count($student->student_data['entrance_exams']) > 2)
                                                    ...
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end text-nowrap">
                                        @if(isset($student->student_data['contract']['amount']))
                                            <span class="fw-bold">{{ number_format($student->student_data['contract']['amount'], 0, ',', ' ') }}</span>
                                            <small class="text-muted">FCFA</small>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $currentUser = Auth::user();
                                            // Le PCA peut tout éditer.
                                            // Resp Financier peut éditer contrat de son centre.
                                            // Tout user avec edit.details peut éditer les détails.
                                            $canShowEditButton = $currentUser->hasRole('pca') ||
                                                                 $currentUser->can('finance.student.edit.details') ||
                                                                 ($currentUser->can('finance.student.edit.contract') && $currentUser->hasRole('resp-financier') && $currentUser->center_id === $student->center_id);
                                        @endphp

                                        @if($canShowEditButton)
                                            <a href="{{ route('finance.students.editFinancials', ['locale' => app()->getLocale(), 'student' => $student->id]) }}" class="btn btn-sm btn-outline-primary btn-icon" title="Modifier les infos financières">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.users.show', ['locale' => app()->getLocale(), 'user' => $student->id]) }}" class="btn btn-sm btn-outline-secondary btn-icon" title="Voir profil complet">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="text-center p-5">
                                            <div class="display-4 text-muted mb-3"><i class="fas fa-users"></i></div>
                                            <h4>Aucun élève trouvé</h4>
                                            <p class="text-muted">Veuillez ajuster vos filtres ou vérifier les inscriptions.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($students->hasPages())
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <div class="pagination-info text-muted small">
                        Affichage de <span>{{ $students->firstItem() ?? 0 }}</span> à <span>{{ $students->lastItem() ?? 0 }}</span> sur <span>{{ $students->total() }}</span> élèves
                    </div>
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    {{-- Styles de la vue précédente --}}
    <style>
        .status-badge-sm { padding: 0.2em 0.5em; font-size: 0.75rem; font-weight: 500; border-radius: 0.25rem; display: inline-flex; align-items: center; }
        .status-badge-sm.success { background-color: var(--success-light); color: var(--success); }
        .status-badge-sm.warning { background-color: var(--warning-light); color: var(--warning); }
        .status-badge-sm.info { background-color: var(--info-light); color: var(--info); }
        .status-badge-sm.danger { background-color: var(--danger-light); color: var(--danger); }
        .status-badge-sm.secondary { background-color: var(--secondary-light); color: var(--secondary); }
        .status-badge-sm.dark { background-color: rgba(30, 41, 59, 0.1); color: rgb(71, 85, 105); }
        .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }
        .form-select-sm, .input-group-sm > .form-control, .input-group-sm > .input-group-text, .input-group-sm > .btn { font-size: 0.875rem; }
        .pagination { margin-bottom: 0; }
    </style>
@endpush

@push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterToggle = document.querySelector('.filter-toggle');
        if (filterToggle) {
            const filtersCollapseEl = document.getElementById('filtersCollapse');
            const filtersCollapse = new bootstrap.Collapse(filtersCollapseEl, { toggle: false });
            
            filterToggle.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (filtersCollapseEl.classList.contains('show')) { // If it's about to hide
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                } else { // If it's about to show
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
            // Initial icon state
            if (filtersCollapseEl.classList.contains('show')) {
                filterToggle.querySelector('i').classList.remove('fa-chevron-down');
                filterToggle.querySelector('i').classList.add('fa-chevron-up');
            } else {
                filterToggle.querySelector('i').classList.remove('fa-chevron-up');
                filterToggle.querySelector('i').classList.add('fa-chevron-down');
            }
        }

        const cityFilter = document.getElementById('city_id_filter');
        const centerFilter = document.getElementById('center_id_filter');

        @can('finance.student.filter.by_city') // Le script n'est pertinent que si le filtre de ville est là
            if (cityFilter && centerFilter) { // S'assurer que les deux filtres sont présents
                const allCenterOptions = Array.from(centerFilter.options).filter(opt => opt.value !== "");

                const updateCentersForCity = () => {
                    const selectedCityId = cityFilter.value;
                    const currentCenterVal = centerFilter.value; // Garder la valeur sélectionnée actuelle
                    
                    // Vider le select des centres, en gardant la première option (placeholder)
                    while (centerFilter.options.length > 1) {
                        centerFilter.remove(1);
                    }
                    centerFilter.value = ""; // Réinitialiser la sélection

                    if (selectedCityId) {
                        allCenterOptions.forEach(option => {
                            if (option.dataset.city === selectedCityId) {
                                centerFilter.appendChild(option.cloneNode(true));
                            }
                        });
                    } else { // Si aucune ville sélectionnée, réafficher tous les centres (si l'utilisateur peut les voir)
                         @if(Auth::user()->can('finance.student.filter.by_city')) // Seuls ceux qui peuvent voir toutes les villes devraient voir tous les centres si aucune ville n'est spécifiée
                            allCenterOptions.forEach(option => centerFilter.appendChild(option.cloneNode(true)));
                         @endif
                    }
                    // Essayer de restaurer la sélection du centre si elle est valide pour la nouvelle liste
                    if (centerFilter.querySelector(`option[value="${currentCenterVal}"]`)) {
                        centerFilter.value = currentCenterVal;
                    }
                };
                cityFilter.addEventListener('change', updateCentersForCity);
                if (cityFilter.value || "{{ request('city_id') }}") { // Exécuter au chargement si une ville est déjà sélectionnée
                     updateCentersForCity();
                     @if(request('center_id'))
                        centerFilter.value = "{{ request('center_id') }}"; // Restaurer la sélection du centre si elle existait
                     @endif
                }
            }
        @endcan
    });
    </script>
@endpush