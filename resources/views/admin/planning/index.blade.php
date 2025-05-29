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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-150"
                       :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-[#4CA3DD]'">
                        Emplois du temps
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-150"
                       :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-[#4CA3DD]'">
                        {{ $center->name }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $formation->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Conteneur principal -->
    <div class="shadow-lg rounded-xl p-6 mb-8 transition-all duration-150"
         :class="darkMode ? 'bg-[#334155] border border-[#475569]' : 'bg-white border border-[#E2E8F0]'">

        <!-- En-tête avec informations du centre et de la formation -->
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
                            {{ $formation->name }}
                        </h1>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'">
                            Centre {{ $center->name }} • Semaine du {{ $weekStartDate->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <!-- Badge du nombre de salles -->
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                     :class="darkMode ? 'bg-[#34D399]/20 text-[#34D399]' : 'bg-[#34D399]/10 text-[#059669]'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $formationRooms->count() }} salle{{ $formationRooms->count() > 1 ? 's' : '' }}
                </div>
            </div>
        </div>

        <!-- Sélection de formation et navigation -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Sélecteur de formation -->
            <div>
                <form method="GET" action="{{ route('admin.planning.index', app()->getLocale()) }}">
                    <label for="formation_id" class="block text-sm font-semibold mb-3 transition-colors duration-150"
                           :class="darkMode ? 'text-[#F1F5F9]' : 'text-[#1E293B]'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Changer de formation
                    </label>
                    <div class="flex space-x-3">
                        <div class="relative flex-1">
                            <select name="formation_id" id="formation_id"
                                    class="w-full pl-10 pr-10 py-3 rounded-lg border-2 focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-150 appearance-none"
                                    :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-[#F1F5F9]' : 'bg-[#F8FAFC] border-[#E2E8F0] text-[#1E293B]'"
                                    required>
                                @foreach (\App\Models\Formation::whereHas('rooms', function($query) use ($center) { $query->where('center_id', $center->id); })->get() as $f)
                                    <option value="{{ $f->id }}" {{ $formation->id === $f->id ? 'selected' : '' }}>
                                        {{ $f->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5" :class="darkMode ? 'text-[#94A3B8]' : 'text-[#64748B]'" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <button type="submit"
                                class="px-4 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="center_id" value="{{ $center->id }}">
                    <input type="hidden" name="week_start_date" value="{{ $weekStartDate->toDateString() }}">
                </form>
            </div>

            <!-- Navigation des semaines -->
            <div class="flex justify-center lg:justify-end items-end">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'week_start_date' => $prevWeek, 'center_id' => $center->id, 'formation_id' => $formation->id]) }}"
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

                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'week_start_date' => $nextWeek, 'center_id' => $center->id, 'formation_id' => $formation->id]) }}"
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

        <!-- Informations sur les salles de la formation -->
        <div class="mb-6 p-4 rounded-lg transition-colors duration-150"
             :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
            <h3 class="text-sm font-semibold mb-3 transition-colors duration-150"
                :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-700'">
                Salles de la formation {{ $formation->name }} :
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($formationRooms as $room)
                    <div class="flex items-center space-x-2 px-3 py-2 rounded-lg transition-colors duration-150"
                         :class="darkMode ? 'bg-[#334155] text-[#F1F5F9]' : 'bg-white text-gray-700 shadow-sm'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium">{{ $room->name }}</span>
                    </div>
                @endforeach
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
                    L'emploi du temps pour cette formation n'a pas encore été créé pour cette semaine.
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
                        <th colspan="{{ $formationRooms->count() }}"
                            class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wider border-r transition-colors duration-150"
                            :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                            {{ $formation->name }}
                        </th>
                    </tr>
                    <tr class="transition-colors duration-150"
                        :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                        @foreach ($formationRooms as $room)
                            <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider border-r transition-colors duration-150"
                                :class="darkMode ? 'text-[#F1F5F9] border-[#64748B]' : 'text-white bg-[#4CA3DD] border-gray-200'">
                                {{ $room->name }}
                            </th>
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

                                @foreach ($formationRooms as $room)
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
            .overflow-x-auto {
                overflow-x: scroll;
            }
        }
    </style>
@endpush
