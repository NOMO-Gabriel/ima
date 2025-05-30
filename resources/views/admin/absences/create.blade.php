@extends('layouts.app')

@section('title', 'Saisie des Absences')

@section('content')
<div class="shadow-lg rounded-xl p-6 mb-8 w-full"
     :class="darkMode ? 'bg-[#334155] border border-[#475569]' : 'bg-white border border-[#E2E8F0]'">

    <h1 class="text-2xl font-bold mb-6" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">Saisie des Absences</h1>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
            <p>{{ session('info') }}</p>
        </div>
    @endif
     @if(session('warning'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
            <p>{{ session('warning') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulaire de sélection --}}
    <form method="GET" action="{{ route('admin.absences.loadStudents', ['locale' => app()->getLocale()]) }}" id="filterForm" class="mb-8 p-4 rounded-lg"
          :class="darkMode ? 'bg-gray-700' : 'bg-gray-50'">
        {{-- Les paramètres en session sont déjà gérés par le contrôleur pour re-populer.
             Ici, on les utilise pour pré-remplir les champs. --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 items-end">
            <div>
                <label for="center_id" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Centre</label>
                <select name="center_id" id="center_id" required class="mt-1 block w-full input-field filter-input">
                    <option value="">Sélectionner</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}" {{ (string)$selectedCenterId === (string)$center->id ? 'selected' : '' }}>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="day_name" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Jour</label>
                <select name="day_name" id="day_name" required class="mt-1 block w-full input-field filter-input">
                    <option value="">Sélectionner</option>
                    @foreach($daysOfWeek as $dayKey => $dayValue)
                        <option value="{{ $dayKey }}" {{ $selectedDayKey === $dayKey ? 'selected' : '' }}>
                            {{ $dayValue }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="time" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Heure</label>
                <select name="time" id="time" required class="mt-1 block w-full input-field filter-input">
                    <option value="">Sélectionner</option>
                    @foreach($fixedTimes as $timeOption)
                        <option value="{{ $timeOption }}" {{ $selectedTime === $timeOption ? 'selected' : '' }}>
                            {{ $timeOption }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="room_id" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Salle</label>
                <select name="room_id" id="room_id" required class="mt-1 block w-full input-field filter-input">
                    <option value="">Sélectionner</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ (string)$selectedRoomId === (string)$room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="formation_id_for_creation" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Formation (si création)</label>
                <select name="formation_id_for_creation" id="formation_id_for_creation" required class="mt-1 block w-full input-field filter-input">
                    <option value="">Sélectionner</option>
                    @foreach($formations as $formation)
                        <option value="{{ $formation->id }}" {{ (string)$selectedFormationIdForCreation === (string)$formation->id ? 'selected' : '' }}>
                            {{ $formation->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" id="loadSlotBtn"
                        class="w-full bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-semibold py-2 px-4 rounded-md shadow-sm filter-submit">
                    Charger / Créer Créneau
                </button>
            </div>
        </div>
         @if($timetableWeekStartDateInfo)
            <p class="mt-2 text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                (Info: Recherche sur l'emploi du temps commençant le {{ Carbon\Carbon::parse($timetableWeekStartDateInfo)->isoFormat('LL') }})
            </p>
        @endif
    </form>

    {{-- Affichage des étudiants et formulaire d'absences --}}
    @if($slot)
        <div class="my-8 p-4 rounded-lg" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
            <h2 class="text-xl font-semibold mb-2" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                @if($slotJustCreated)
                    <span class="text-green-500">[NOUVEAU]</span>
                @endif
                Créneau : {{ $slot->formation->name }} - {{ $slot->course?->title ?: 'Cours non spécifié' }}
            </h2>
            <p class="text-sm mb-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                Jour : {{ $slot->week_day }} |
                Heure : {{ Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ Carbon\Carbon::parse($slot->end_time)->format('H:i') }} |
                Salle : {{ $slot->room->name }}
            </p>
            @if($slot->teacher)
            <p class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                Professeur : {{ $slot->teacher->first_name }} {{ $slot->teacher->last_name }}
            </p>
            @endif
             <p class="text-xs" :class="darkMode ? 'text-gray-500' : 'text-gray-600'">
                (Emploi du temps semaine du: {{ Carbon\Carbon::parse($slot->timetable->week_start_date)->isoFormat('LL') }})
            </p>
        </div>

        @if($students->count() > 0)
            <form method="POST" action="{{ route('admin.absences.store', ['locale' => app()->getLocale()]) }}" id="absencesForm">
                @csrf
                <input type="hidden" name="slot_id" value="{{ $slot->id }}">

                <div class="flex justify-between items-center mb-4">
                    <p :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                        Total étudiants : <span class="font-bold">{{ $students->count() }}</span>
                    </p>
                    <p :class="darkMode ? 'text-gray-300' : 'text-gray-700'" id="stats-presence">
                        Présents : <span class="font-bold present-count">{{ $students->count() - $existingAbsencesStudentIds->count() }}</span> |
                        Absents : <span class="font-bold absent-count">{{ $existingAbsencesStudentIds->count() }}</span>
                    </p>
                </div>

                <div class="overflow-x-auto rounded-lg border" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <table class="min-w-full divide-y" :class="darkMode ? 'divide-gray-600' : 'divide-gray-200'">
                        <thead :class="darkMode ? 'bg-gray-700' : 'bg-gray-50'">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Étudiant
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Marquer Absent
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" :class="darkMode ? 'bg-gray-800 divide-gray-600' : 'bg-white divide-gray-200'">
                            @foreach($students as $student)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                            {{ $student->user->first_name ?? 'N/A' }} {{ $student->user->last_name ?? '' }}
                                        </div>
                                        <div class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $student->user->email ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        {{-- Attention: $student->id ici est l'ID de la table 'students'.
                                             La table 'absences' attend 'student_id' qui est un 'user_id'.
                                             Donc value="{{ $student->user_id }}" ou value="{{ $student->user->id }}" --}}
                                        <input type="checkbox" name="absent_students[]" value="{{ $student->user->id }}"
                                               class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500 student-checkbox"
                                               {{ $existingAbsencesStudentIds->contains($student->user->id) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" id="editAbsencesBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md shadow-sm {{ !$isLocked ? 'hidden' : '' }}">
                        Modifier Absences
                    </button>
                    <button type="submit" id="saveAbsencesBtn"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-md shadow-sm {{ $isLocked ? 'hidden' : '' }}">
                        Enregistrer Absences
                    </button>
                </div>
            </form>
        @else
             @if($slot)
                <p class="text-center py-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    Aucun étudiant n'est actuellement inscrit à la formation "{{ $slot->formation->name }}" pour ce créneau.
                </p>
            @endif
        @endif

    @elseif(request()->has('center_id') && request()->has('day_name') && request()->has('time') && request()->has('room_id'))
        <p class="text-center py-10 text-lg" :class="darkMode ? 'text-yellow-400' : 'text-yellow-600'">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Aucun créneau n'a été trouvé et la création automatique a échoué ou n'a pas été tentée.
            Vérifiez les sélections et que l'emploi du temps est correctement configuré.
        </p>
        @if($timetableWeekStartDateInfo)
            <p class="text-center text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                (Recherche effectuée sur l'emploi du temps démarrant le {{ Carbon\Carbon::parse($timetableWeekStartDateInfo)->isoFormat('LL') }})
            </p>
        @endif
    @else
         <p class="text-center py-10 text-lg" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
            Veuillez sélectionner tous les champs requis pour charger ou créer un créneau.
        </p>
    @endif
</div>
@endsection

@push('styles')
<style>
    .input-field {
        @apply rounded-md shadow-sm p-2;
    }
    .dark .input-field {
         @apply bg-gray-600 border-gray-500 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500;
    }
    .light .input-field {
         @apply border-gray-300 focus:border-indigo-500 focus:ring-indigo-500;
    }
    /* Style pour les éléments désactivés en mode verrouillé */
    .input-field:disabled, .student-checkbox:disabled, .filter-submit:disabled {
        @apply bg-gray-200 cursor-not-allowed;
    }
    .dark .input-field:disabled, .dark .student-checkbox:disabled, .dark .filter-submit:disabled {
         @apply bg-gray-500 text-gray-400 cursor-not-allowed;
    }
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isLocked = @json($isLocked ?? false);
    const slotLoaded = @json(!!$slot); // Vrai si $slot n'est pas null

    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const saveAbsencesBtn = document.getElementById('saveAbsencesBtn');
    const editAbsencesBtn = document.getElementById('editAbsencesBtn');
    const filterInputs = document.querySelectorAll('#filterForm .filter-input');
    const loadSlotBtn = document.getElementById('loadSlotBtn');

    // Script pour les stats de présence (inchangé)
    const totalStudents = {{ isset($students) && $students ? $students->count() : 0 }};
    const presentCountEl = document.querySelector('.present-count');
    const absentCountEl = document.querySelector('.absent-count');

    function updateStats() {
        if (!presentCountEl || !absentCountEl || totalStudents === 0) {
             if(presentCountEl) presentCountEl.textContent = '0';
             if(absentCountEl) absentCountEl.textContent = '0';
            return;
        }
        let absentCount = 0;
        studentCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                absentCount++;
            }
        });
        let presentCount = totalStudents - absentCount;
        presentCountEl.textContent = presentCount;
        absentCountEl.textContent = absentCount;
    }

    studentCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateStats);
    });
    if (totalStudents > 0 && presentCountEl && absentCountEl) {
        updateStats();
    }
    // Fin script stats

    // Logique de verrouillage/déverrouillage
    function setFormState(locked) {
        studentCheckboxes.forEach(checkbox => checkbox.disabled = locked);

        if (saveAbsencesBtn) {
            saveAbsencesBtn.classList.toggle('hidden', locked);
            // saveAbsencesBtn.disabled = locked; // Alternativement, désactiver au lieu de cacher
        }
        if (editAbsencesBtn) {
            editAbsencesBtn.classList.toggle('hidden', !locked);
        }

        // Optionnel: verrouiller aussi le formulaire de filtre
        // filterInputs.forEach(input => input.disabled = locked);
        // if (loadSlotBtn) loadSlotBtn.disabled = locked;
    }

    if (slotLoaded && isLocked) {
        setFormState(true);
    } else if (slotLoaded) {
        setFormState(false); // S'assurer que c'est déverrouillé si un slot est chargé mais pas isLocked
    }


    if (editAbsencesBtn) {
        editAbsencesBtn.addEventListener('click', function() {
            setFormState(false);
            // Pas besoin de changer $isLocked ici, c'est juste pour l'état initial de la page
            // Si on voulait que ça persiste après un rechargement (sans sauvegarder), il faudrait une requête AJAX ou changer un paramètre d'URL
        });
    }

    // Si l'utilisateur modifie les filtres du haut, on s'attend à ce qu'il recharge le créneau.
    // Dans ce cas, l'état `isLocked` sera réévalué par le serveur.
    // Aucune action spécifique n'est nécessaire ici pour "déverrouiller" lors du changement de filtre,
    // car la soumission du formulaire de filtre rechargera la page.
});
</script>
@endpush
