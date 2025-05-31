@extends('layouts.app')

@section('title', 'Historique des actions')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Historique des actions</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
        <!-- En-tête avec titre -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /> <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /> {/* Combined clock and list-alt for history */}
                </svg>
                Historique des actions
            </h1>
            <span class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $histories->total() }} entrées au total</span>
        </div>

        <!-- Messages d'alerte -->
        <x-flash-message />

        <!-- Filtres -->
        <div class="mb-6 p-4 rounded-lg" :class="darkMode ? 'bg-[#2C3E50] border border-[#475569]' : 'bg-gray-50 border border-gray-200'">
            <form method="GET" action="{{ route('admin.history.index', ['locale' => app()->getLocale()]) }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <div>
                        <label for="action" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Action</label>
                        <select name="action" id="action"
                                class="w-full border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Toutes les actions</option>
                            @foreach($actions as $actionValue)
                                <option value="{{ $actionValue }}" {{ request('action') == $actionValue ? 'selected' : '' }}>
                                    {{ ucfirst($actionValue) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="subject_type" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Type d'entité</label>
                        <select name="subject_type" id="subject_type"
                                class="w-full border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Tous les types</option>
                            @foreach($subjectTypes as $type)
                                <option value="{{ $type }}" {{ request('subject_type') == $type ? 'selected' : '' }}>
                                    {{ class_basename($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Du</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                               class="w-full border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                               :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-200 placeholder-gray-400 appearance-none date-input-dark' : 'bg-white border-gray-300 text-gray-900'">
                    </div>
                    <div>
                        <label for="date_to" class="block mb-2 text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Au</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="w-full border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                               :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-200 placeholder-gray-400 date-input-dark' : 'bg-white border-gray-300 text-gray-900'">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.history.index', ['locale' => app()->getLocale()]) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2.5 border font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md"
                           :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 hover:border-gray-500' : 'border-gray-300 text-gray-700 hover:bg-gray-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0115.357-2m0 0H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tableau des historiques -->
        @if($histories->isEmpty())
            <div class="p-8 text-center rounded-lg border transition-colors"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-gray-300' : 'bg-gray-50 border-gray-200 text-gray-600'">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /> <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <p class="text-xl font-medium mb-2" :class="darkMode ? 'text-white' : 'text-gray-800'">
                        Aucun historique trouvé
                    </p>
                    <p>Aucun historique ne correspond aux filtres sélectionnés. Essayez d'ajuster vos critères de recherche.</p>
                </div>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border transition-colors"
                 :class="darkMode ? 'border-[#475569]' : 'border-gray-200'">
                <table class="min-w-full divide-y transition-colors"
                       :class="darkMode ? 'divide-[#475569]' : 'divide-gray-200'">
                    <thead class="transition-colors" :class="darkMode ? 'bg-[#2C3E50]' : 'bg-gray-50'">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Utilisateur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Action</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Entité</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Description</th>
                        <th scope="col" class.="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">IP</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y transition-colors"
                           :class="darkMode ? 'bg-[#1E293B] divide-[#475569]' : 'bg-white divide-gray-200'">
                    @foreach($histories as $history)
                        <tr class="transition-colors duration-150" :class="darkMode ? 'hover:bg-[#2C3E50]' : 'hover:bg-gray-50'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                    {{ $history->created_at->format('d/m/Y H:i:s') }}
                                </div>
                                <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    {{ $history->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($history->user)
                                    <div class="text-sm font-medium" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">{{ $history->user->name }}</div>
                                    <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $history->user->email }}</div>
                                @else
                                    <span class="text-sm" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">Utilisateur supprimé</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $badgeClass = match(strtolower($history->action)) {
                                        'created' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                        'updated' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                        'deleted' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                        'validated' => 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300',
                                        'suspended' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                        'rejected' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
                                        'archived' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        default => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300'
                                    };
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                    {{ ucfirst($history->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">{{ class_basename($history->subject_type) }}</div>
                                <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">ID: {{ $history->subject_id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-normal max-w-xs">
                                <div class="text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    @if($history->description)
                                        {{ Str::limit($history->description, 70) }}
                                    @else
                                        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">Aucune description</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $history->ip_address }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <a href="{{ route('admin.history.show', ['locale' => app()->getLocale(), 'history' => $history]) }}"
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md shadow-sm transition-colors"
                                   :class="darkMode ? 'text-[#4CA3DD] bg-transparent hover:bg-[#4CA3DD]/20 border-[#4CA3DD]/50' : 'text-[#2A7AB8] bg-transparent hover:bg-[#4CA3DD]/20 border-[#4CA3DD]/70'"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination -->
        @if($histories->hasPages())
            <div class="mt-6">
                {{ $histories->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
<style>
    /* Style for dark mode date picker icon */
    .date-input-dark::-webkit-calendar-picker-indicator {
        filter: invert(0.8) brightness(0.8) sepia(0.3) saturate(5) hue-rotate(180deg);
    }
    /* Ensure pagination links match the theme */
    .pagination { /* Assuming default Laravel pagination generates this class */
        /* Add Tailwind styles if needed, or ensure Laravel is configured for Tailwind pagination views */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation d'entrée pour les lignes du tableau (optional, but nice)
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px)';
            setTimeout(() => {
                row.style.transition = 'all 0.3s ease-out';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, index * 30); // Stagger animation
        });
    });
</script>
@endpush