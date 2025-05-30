@extends('layouts.app')

@section('title', 'Gestion des Absences')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors"
                   :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Gestion des Absences</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
        <!-- En-tête avec titre -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Gestion des Absences
            </h1>
        </div>

        <!-- Messages d'alerte -->
        <x-flash-message />

        <!-- Formulaire de sélection -->
        <div class="rounded-lg p-6 mb-6 transition-colors" :class="darkMode ? 'bg-[#2C3E50] border border-[#475569]' : 'bg-gray-50 border border-gray-200'">
            <h2 class="text-lg font-semibold mb-4 flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                </svg>
                Sélection du créneau
            </h2>

            <form id="absence-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Sélection du centre -->
                    <div>
                        <label for="center_id" class="block text-sm font-medium mb-2 transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Centre
                        </label>
                        <select id="center_id" name="center_id" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Sélectionner un centre</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}">{{ $center->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection du jour -->
                    <div>
                        <label for="week_day" class="block text-sm font-medium mb-2 transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Jour de la semaine
                        </label>
                        <select id="week_day" name="week_day" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Sélectionner un jour</option>
                            @foreach($weekDays as $key => $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection de l'heure -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium mb-2 transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Heure de début
                        </label>
                        <select id="start_time" name="start_time" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Sélectionner une heure</option>
                            @foreach($timeSlots as $time => $display)
                                <option value="{{ $time }}">{{ $display }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sélection de la salle -->
                    <div>
                        <label for="room_id" class="block text-sm font-medium mb-2 transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Salle
                        </label>
                        <select id="room_id" name="room_id" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Sélectionner une salle</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="button" id="load-students"
                            class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Charger les élèves
                    </button>
                </div>
            </form>
        </div>

        <!-- Section des élèves -->
        <div id="students-section" style="display: none;">
            <div class="rounded-lg border transition-colors" :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors" :class="darkMode ? 'border-[#475569] bg-[#334155]' : 'border-gray-200 bg-gray-50'">
                    <h2 class="text-lg font-semibold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        Liste des élèves
                    </h2>
                    <div id="formation-info" class="mt-2 text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'"></div>
                </div>

                <form id="students-form" method="POST" action="{{ route('admin.absences.store', ['locale' => app()->getLocale()]) }}">
                    @csrf
                    <input type="hidden" id="slot_id" name="slot_id" value="">

                    <div class="p-6">
                        <div id="students-list" class="space-y-3"></div>

                        <div class="mt-6 pt-4 border-t transition-colors" :class="darkMode ? 'border-[#475569]' : 'border-gray-200'">
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-[#28a745] hover:bg-[#1e7e34] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Enregistrer les absences
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- État vide quand aucun élève n'est trouvé -->
        <div id="no-students-section" class="p-8 text-center rounded-lg border transition-colors hidden"
             :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-white' : 'bg-white border-gray-200'">
            <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-16 w-16 mb-4 transition-colors"
                     :class="darkMode ? 'text-gray-500' : 'text-gray-400'"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <p class="text-xl font-medium mb-2 transition-colors"
                   :class="darkMode ? 'text-white' : 'text-gray-800'">
                    Aucun élève trouvé
                </p>
                <p class="mb-6 transition-colors"
                   :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                    Aucun élève n'est inscrit à ce créneau ou le slot n'existe pas
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Styles pour les checkboxes personnalisées */
    .student-checkbox {
        position: relative;
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .student-checkbox:hover {
        transform: translateY(-1px);
        shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .student-checkbox input[type="checkbox"] {
        margin-right: 12px;
        width: 18px;
        height: 18px;
        accent-color: #dc3545;
    }

    .student-info {
        flex: 1;
    }

    .student-name {
        font-weight: 600;
        margin-bottom: 2px;
    }

    .student-email {
        font-size: 0.875rem;
        opacity: 0.7;
    }

    /* Animation pour l'apparition des éléments */
    .fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Configuration CSRF pour les requêtes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Charger les salles lorsque le centre change
        $('#center_id').change(function() {
            var centerId = $(this).val();
            $('#room_id').html('<option value="">Sélectionner une salle</option>');
            $('#students-section').hide();
            $('#no-students-section').addClass('hidden');

            if (centerId) {
                $.get('{{ route("admin.absences.rooms", ['locale' => app()->getLocale()]) }}', { center_id: centerId })
                    .done(function(data) {
                        $.each(data, function(index, room) {
                            $('#room_id').append('<option value="' + room.id + '">' + room.name + '</option>');
                        });
                    })
                    .fail(function() {
                        alert('Erreur lors du chargement des salles');
                    });
            }
        });

        // Charger les élèves
        $('#load-students').click(function() {
            var formData = {
                center_id: $('#center_id').val(),
                week_day: $('#week_day').val(),
                start_time: $('#start_time').val(),
                room_id: $('#room_id').val()
            };

            // Vérifier que tous les champs sont remplis
            if (!formData.center_id || !formData.week_day || !formData.start_time || !formData.room_id) {
                alert('Veuillez sélectionner tous les champs');
                return;
            }

            // Afficher un indicateur de chargement
            $(this).prop('disabled', true).html(
                '<svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">' +
                '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>' +
                '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>' +
                '</svg>Chargement...'
            );

            $.get('{{ route("admin.absences.students", ['locale' => app()->getLocale()]) }}', formData)
                .done(function(data) {
                    if (data.students.length === 0) {
                        $('#students-section').hide();
                        $('#no-students-section').removeClass('hidden').addClass('fade-in');
                        return;
                    }

                    // Masquer le message d'absence d'élèves
                    $('#no-students-section').addClass('hidden');

                    // Afficher les informations de la formation
                    $('#formation-info').text('Formation: ' + data.formation_name);
                    $('#slot_id').val(data.slot_id);

                    // Générer la liste des élèves avec un design amélioré
                    var studentsHtml = '';
                    $.each(data.students, function(index, student) {
                        var checked = student.is_absent ? 'checked' : '';
                        var bgClass = student.is_absent ?
                            (window.darkMode ? 'bg-red-900/20 border-red-700' : 'bg-red-50 border-red-200') :
                            (window.darkMode ? 'bg-[#334155] border-[#475569]' : 'bg-white border-gray-200');

                        studentsHtml +=
                            '<div class="student-checkbox border transition-colors ' + bgClass + '">' +
                                '<input type="checkbox" name="absent_students[]" value="' + student.id + '" ' + checked + ' ' +
                                       'class="form-checkbox">' +
                                '<div class="student-info">' +
                                    '<div class="student-name transition-colors" ' +
                                         ':class="darkMode ? \'text-white\' : \'text-gray-900\'">' + student.name + '</div>' +
                                    '<div class="student-email transition-colors" ' +
                                         ':class="darkMode ? \'text-gray-300\' : \'text-gray-600\'">' + student.email + '</div>' +
                                '</div>' +
                                '<div class="text-sm font-medium px-3 py-1 rounded-full transition-colors" ' +
                                     ':class="' + (student.is_absent ?
                                        '"bg-red-100 text-red-800"' :
                                        '"bg-green-100 text-green-800"') + '">' +
                                    (student.is_absent ? 'Absent' : 'Présent') +
                                '</div>' +
                            '</div>';
                    });

                    $('#students-list').html(studentsHtml).addClass('fade-in');
                    $('#students-section').show();

                    // Gérer le changement d'état des checkboxes
                    $('input[name="absent_students[]"]').change(function() {
                        var container = $(this).closest('.student-checkbox');
                        var statusBadge = container.find('.text-sm.font-medium');

                        if ($(this).is(':checked')) {
                            container.removeClass('bg-white bg-[#334155] border-gray-200 border-[#475569]')
                                   .addClass('bg-red-50 border-red-200');
                            statusBadge.removeClass('bg-green-100 text-green-800')
                                      .addClass('bg-red-100 text-red-800')
                                      .text('Absent');
                        } else {
                            container.removeClass('bg-red-50 border-red-200')
                                   .addClass(window.darkMode ? 'bg-[#334155] border-[#475569]' : 'bg-white border-gray-200');
                            statusBadge.removeClass('bg-red-100 text-red-800')
                                      .addClass('bg-green-100 text-green-800')
                                      .text('Présent');
                        }
                    });
                })
                .fail(function(xhr) {
                    alert('Erreur lors du chargement des élèves: ' + xhr.responseText);
                    $('#students-section').hide();
                    $('#no-students-section').removeClass('hidden');
                })
                .always(function() {
                    // Restaurer le bouton
                    $('#load-students').prop('disabled', false).html(
                        '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>' +
                        '</svg>Charger les élèves'
                    );
                });
        });

        // Réinitialiser la section des élèves quand on change les paramètres
        $('#center_id, #week_day, #start_time, #room_id').change(function() {
            $('#students-section').hide();
            $('#no-students-section').addClass('hidden');
        });

        // Animation d'entrée pour les éléments du formulaire
        $('.grid > div').each(function(index) {
            $(this).css({
                'opacity': '0',
                'transform': 'translateY(20px)'
            });

            setTimeout(() => {
                $(this).css({
                    'transition': 'all 0.3s ease-out',
                    'opacity': '1',
                    'transform': 'translateY(0)'
                });
            }, index * 100);
        });
    });
</script>
@endpush
