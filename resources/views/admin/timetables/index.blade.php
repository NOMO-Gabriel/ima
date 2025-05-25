@extends('layouts.app')

@section('title', 'Emploi du Temps')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-150"
                   :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Emploi du Temps</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Conteneur principal -->
    <div class="shadow-lg rounded-xl p-6 mb-8 transition-all duration-150"
         :class="darkMode ? 'bg-[#334155] border border-[#475569]' : 'bg-white border border-[#E2E8F0]'">

        <!-- En-tête avec informations du centre -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-colors duration-150"
                         :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold transition-colors duration-150"
                            :class="darkMode ? 'text-[#F1F5F9]' : 'text-[#1E293B]'">
                            Emploi du temps
                        </h1>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'">
                            Centre {{ $center->name }} • Semaine du {{ $weekStartDate->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sélection du centre et navigation -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Sélecteur de centre -->
            <div class="lg:col-span-1">
                <form method="GET" action="{{ route('admin.timetables.index', app()->getLocale()) }}">
                    <label for="center_id" class="block text-sm font-semibold mb-3 transition-colors duration-150"
                           :class="darkMode ? 'text-[#F1F5F9]' : 'text-[#1E293B]'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Changer de centre
                    </label>
                    <div class="relative">
                        <select name="center_id" id="center_id"
                                class="w-full pl-10 pr-10 py-3 rounded-lg border-2 focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-150 appearance-none"
                                :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-[#F1F5F9]' : 'bg-[#F8FAFC] border-[#E2E8F0] text-[#1E293B]'"
                                required onchange="this.form.submit()">
                            @foreach (\App\Models\Center::all() as $c)
                                <option value="{{ $c->id }}" {{ $center->id === $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5" :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <input type="hidden" name="week_start_date" value="{{ $weekStartDate->toDateString() }}">
                </form>
            </div>

            <!-- Navigation des semaines -->
            <div class="lg:col-span-2 flex justify-center lg:justify-end items-end">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $prevWeek, 'center_id' => $center->id]) }}"
                       class="inline-flex items-center px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 bg-[#4CA3DD] text-white hover:bg-[#2A7AB8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span class="hidden sm:inline">Semaine précédente</span>
                        <span class="sm:hidden">Précédente</span>
                    </a>

                    <div class="px-4 py-2 rounded-lg text-center transition-colors duration-150"
                         :class="darkMode ? 'bg-[#2C3E50] text-[#F1F5F9]' : 'bg-[#EEF2F7] text-[#1E293B]'">
                        <div class="text-sm font-medium">{{ $weekStartDate->format('d M') }} - {{ $weekStartDate->copy()->addDays(6)->format('d M Y') }}</div>
                    </div>

                    <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'week_start_date' => $nextWeek, 'center_id' => $center->id]) }}"
                       class="inline-flex items-center px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 bg-[#4CA3DD] text-white hover:bg-[#2A7AB8]">
                        <span class="hidden sm:inline">Semaine suivante</span>
                        <span class="sm:hidden">Suivante</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        @php
            use Illuminate\Support\Str;

            // Vérification de l'existence du timetable
            if (!$timetable) {
                $slots = collect();
            } else {
                $slots = $timetable->slots;
            }
            $slotsByDay = $slots->groupBy('week_day');

            // Générer les couleurs pour les professeurs
            $teachers = $slots->pluck('teacher')->filter()->unique('id');
            $teacherColors = [];
            $colors = [
                '#4CA3DD', '#34D399', '#FBBF24', '#F87171', '#A78BFA',
                '#FB7185', '#34D4EA', '#FACC15', '#F97316', '#84CC16',
                '#EF4444', '#8B5CF6', '#06B6D4', '#10B981', '#F59E0B'
            ];

            foreach ($teachers as $index => $teacher) {
                if ($teacher) {
                    $teacherColors[$teacher->id] = $colors[$index % count($colors)];
                }
            }
        @endphp

            <!-- Légende des professeurs -->
        @if(count($teacherColors) > 0)
            <div class="mb-6 p-4 rounded-lg transition-colors duration-150"
                 :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                <h3 class="text-sm font-semibold mb-3 transition-colors duration-150"
                    :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-700'">
                    Légende des professeurs :
                </h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($teacherColors as $teacherId => $color)
                        @php $teacher = $teachers->firstWhere('id', $teacherId); @endphp
                        @if($teacher)
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $color }};"></div>
                                <span class="text-sm transition-colors duration-150"
                                      :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-700'">
                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                        </span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @if(!$timetable)
            <!-- Message si aucun emploi du temps n'existe -->
            <div class="text-center py-12 rounded-lg transition-colors duration-150"
                 :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 transition-colors duration-150"
                     :class="darkMode ? 'text-[#64748B]' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2 transition-colors duration-150"
                    :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-900'">
                    Aucun emploi du temps configuré
                </h3>
                <p class="transition-colors duration-150"
                   :class="darkMode ? 'text-[#94A3B8]' : 'text-gray-600'">
                    L'emploi du temps pour cette semaine n'a pas encore été créé pour ce centre.
                </p>
            </div>
        @else
            <!-- Emploi du temps -->
            <div class="overflow-x-auto rounded-lg border transition-colors duration-150"
                 :class="darkMode ? 'border-[#475569]' : 'border-gray-200'">

                <table class="min-w-full table-fixed">
                    <thead>
                    <tr class="transition-colors duration-150"
                        :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                        <th rowspan="2" class="w-32 px-4 py-3 text-center text-xs font-bold uppercase tracking-wider border-r transition-colors duration-150"
                            :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                            Jour
                        </th>
                        <th rowspan="2" class="w-28 px-4 py-3 text-center text-xs font-bold uppercase tracking-wider border-r transition-colors duration-150"
                            :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                            Horaire
                        </th>
                        @foreach ($formations as $formation)
                            <th colspan="{{ $formation->rooms->count() ?: 1 }}"
                                class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider border-r transition-colors duration-150"
                                :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                                {{ $formation->name }}
                            </th>
                        @endforeach
                    </tr>
                    <tr class="transition-colors duration-150"
                        :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                        @foreach ($formations as $formation)
                            @if($formation->rooms && $formation->rooms->count() > 0)
                                @foreach ($formation->rooms as $room)
                                    <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider border-r transition-colors duration-150"
                                        :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                                        {{ $room->name }}
                                    </th>
                                @endforeach
                            @else
                                <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider border-r transition-colors duration-150"
                                    :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                                    Salle principale
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="divide-y transition-colors duration-150"
                           :class="darkMode ? 'bg-[#334155] divide-[#475569]' : 'bg-white divide-gray-200'">
                    @foreach ($days as $dayIndex => $day)
                        @foreach ($periods as $periodIndex => $period)
                            <tr class="transition-colors duration-150"
                                :class="darkMode ? 'hover:bg-[#475569]' : 'hover:bg-gray-50'">
                                @if ($periodIndex === 0)
                                    <td rowspan="{{ count($periods) }}"
                                        class="px-4 py-6 text-center font-bold border-r transition-colors duration-150"
                                        :class="darkMode ? 'text-[#F1F5F9] border-[#64748B] bg-[#475569]' : 'text-gray-900 border-gray-200 bg-gray-100'">
                                        <div>{{ $day->locale('fr')->isoFormat('dddd') }}</div>
                                        <div class="text-xs font-normal opacity-75 mt-1">{{ $weekStartDate->copy()->addDays($dayIndex)->format('d/m') }}</div>
                                    </td>
                                @endif

                                <td class="px-4 py-6 text-center font-semibold border-r transition-colors duration-150"
                                    :class="darkMode ? 'text-[#F1F5F9] border-[#64748B] bg-[#475569]' : 'text-gray-900 border-gray-200 bg-gray-100'">
                                    <div class="text-sm">
                                        {{ \Carbon\Carbon::parse($period['start'])->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($period['end'])->format('H:i') }}
                                    </div>
                                </td>

                                @foreach ($formations as $formation)
                                    @if($formation->rooms && $formation->rooms->count() > 0)
                                        @foreach ($formation->rooms as $room)
                                            @php
                                                $slot = $timetable->slots->firstWhere(fn($s) =>
                                                    $s->week_day === $dayNames[$dayIndex] &&
                                                    $s->start_time === $period['start'] &&
                                                    $s->formation_id === $formation->id &&
                                                    $s->room_id === $room->id
                                                );
                                            @endphp
                                            <td class="px-2 py-3 text-center border-r transition-all duration-150 h-24"
                                                :class="darkMode ? 'border-[#64748B]' : 'border-gray-200'">
                                                @if ($slot)
                                                    <a href="{{ route('admin.slots.edit', ['locale' => app()->getLocale(), 'slot' => $slot]) }}"
                                                       class="block p-3 rounded-lg transition-all duration-200 hover:shadow-md hover:scale-105 cursor-pointer h-full"
                                                       style="background-color: {{ $teacherColors[$slot->teacher_id] ?? '#64748B' }}; color: white;">
                                                        <div class="space-y-1">
                                                            <div class="text-xs font-bold truncate">
                                                                {{ $slot->course->title ?? 'Cours' }}
                                                            </div>
                                                            <div class="text-xs opacity-90 truncate">
                                                                {{ $slot->teacher ? $slot->teacher->first_name . ' ' . $slot->teacher->last_name : 'Professeur' }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="#"
                                                       class="block p-3 rounded-lg border-2 border-dashed transition-all duration-200 hover:border-solid h-full flex items-center justify-center"
                                                       :class="darkMode ? 'border-[#64748B] hover:border-[#4CA3DD] hover:bg-[#475569] text-[#94A3B8]' : 'border-gray-300 hover:border-[#4CA3DD] hover:bg-gray-50 text-gray-500'">
                                                        <div class="text-xs">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                            </svg>
                                                            Ajouter
                                                        </div>
                                                    </a>
                                                @endif
                                            </td>
                                        @endforeach
                                    @else
                                        @php
                                            $slot = $timetable->slots->firstWhere(fn($s) =>
                                                $s->week_day === $dayNames[$dayIndex] &&
                                                $s->start_time === $period['start'] &&
                                                $s->formation_id === $formation->id
                                            );
                                        @endphp
                                        <td class="px-2 py-3 text-center border-r transition-all duration-150 h-24"
                                            :class="darkMode ? 'border-[#64748B]' : 'border-gray-200'">
                                            @if ($slot)
                                                <a href="{{ route('admin.slots.edit', ['locale' => app()->getLocale(), 'slot' => $slot]) }}"
                                                   class="block p-3 rounded-lg transition-all duration-200 hover:shadow-md hover:scale-105 cursor-pointer h-full"
                                                   style="background-color: {{ $teacherColors[$slot->teacher_id] ?? '#64748B' }}; color: white;">
                                                    <div class="space-y-1">
                                                        <div class="text-xs font-bold truncate">
                                                            {{ $slot->course->title ?? 'Cours' }}
                                                        </div>
                                                        <div class="text-xs opacity-90 truncate">
                                                            {{ $slot->teacher ? $slot->teacher->first_name . ' ' . $slot->teacher->last_name : 'Professeur' }}
                                                        </div>
                                                    </div>
                                                </a>
                                            @else
                                                <a href="#"
                                                   class="block p-3 rounded-lg border-2 border-dashed transition-all duration-200 hover:border-solid h-full flex items-center justify-center"
                                                   :class="darkMode ? 'border-[#64748B] hover:border-[#4CA3DD] hover:bg-[#475569] text-[#94A3B8]' : 'border-gray-300 hover:border-[#4CA3DD] hover:bg-gray-50 text-gray-500'">
                                                    <div class="text-xs">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        Ajouter
                                                    </div>
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Amélioration du scroll horizontal */
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E1 #F1F5F9;
        }

        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 4px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94A3B8;
        }

        /* Animation pour les créneaux */
        .slot-link {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slot-link:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .table-fixed {
                min-width: 800px;
            }

            .w-32 {
                width: 100px;
            }

            .w-28 {
                width: 80px;
            }
        }

        /* Animation de chargement */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #4CA3DD;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Tooltips pour les créneaux */
        .slot-tooltip {
            position: relative;
        }

        .slot-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1E293B;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 20;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .slot-tooltip:hover::before {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(100%);
            border: 6px solid transparent;
            border-top-color: #1E293B;
            z-index: 20;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du changement de centre avec overlay de chargement
            const centerSelect = document.getElementById('center_id');
            if (centerSelect) {
                centerSelect.addEventListener('change', function() {
                    showLoadingOverlay();
                });
            }

            function showLoadingOverlay() {
                const overlay = document.createElement('div');
                overlay.className = 'loading-overlay';
                overlay.innerHTML = '<div class="spinner"></div>';
                document.body.appendChild(overlay);
            }

            // Animation des créneaux au chargement
            const slots = document.querySelectorAll('[style*="background-color"]');
            slots.forEach((slot, index) => {
                slot.style.opacity = '0';
                slot.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    slot.style.transition = 'all 0.5s ease';
                    slot.style.opacity = '1';
                    slot.style.transform = 'scale(1)';
                }, index * 50);
            });

            // Gestion des raccourcis clavier
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey) {
                    switch(e.key) {
                        case 'ArrowLeft':
                            e.preventDefault();
                            const prevLink = document.querySelector('a[href*="week_start_date={{ $prevWeek }}"]');
                            if (prevLink) {
                                showLoadingOverlay();
                                prevLink.click();
                            }
                            break;
                        case 'ArrowRight':
                            e.preventDefault();
                            const nextLink = document.querySelector('a[href*="week_start_date={{ $nextWeek }}"]');
                            if (nextLink) {
                                showLoadingOverlay();
                                nextLink.click();
                            }
                            break;
                    }
                }
            });

            // Amélioration de l'accessibilité
            const focusableElements = document.querySelectorAll('a, button, select');
            focusableElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.style.outline = '2px solid #4CA3DD';
                    this.style.outlineOffset = '2px';
                });

                element.addEventListener('blur', function() {
                    this.style.outline = 'none';
                });
            });

            // Gestion du responsive - masquer certaines colonnes sur mobile
            function handleResize() {
                const isMobile = window.innerWidth < 768;
                const table = document.querySelector('table');

                if (table && isMobile) {
                    // Logique pour optimiser l'affichage mobile si nécessaire
                    table.style.fontSize = '12px';
                } else if (table) {
                    table.style.fontSize = '14px';
                }
            }

            window.addEventListener('resize', handleResize);
            handleResize();

            console.log('Emploi du temps chargé avec succès!');
        });
    </script>
@endpush
