@extends('layouts.app')

@section('title', 'Détail de l\'événement d\'historique')

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
             <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.history.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors md:ml-2"
                       :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                       Historique
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Détail</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- No specific permission check needed for viewing individual history items,
         assuming index access covers detail viewing. --}}

    <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
        <!-- En-tête avec titre et bouton retour -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Détail de l'événement d'historique
            </h1>
            <a href="{{ route('admin.history.index', ['locale' => app()->getLocale()]) }}"
               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium transition-colors duration-200 shadow-sm"
               :class="darkMode ? 'text-gray-300 bg-gray-700 hover:bg-gray-600 border-gray-600' : 'text-gray-700 bg-white hover:bg-gray-50'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Messages d'alerte -->
        <x-flash-message />

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column (Main Info, Changes) --}}
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations principales -->
                <div class="rounded-lg shadow-md p-5 transition-colors" :class="darkMode ? 'bg-[#2C3E50] border border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="border-b pb-4 mb-4 transition-colors" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">
                            Informations de l'action
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Date et heure :</strong><br>
                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                {{ $history->created_at->format('d/m/Y à H:i:s') }}
                            </span><br>
                            <span class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->created_at->diffForHumans() }}</span>
                        </div>
                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Action :</strong><br>
                            @php
                                $actionColorClass = match($history->action) {
                                    'created' => 'text-green-600 dark:text-green-400',
                                    'updated' => 'text-blue-600 dark:text-blue-400',
                                    'deleted' => 'text-red-600 dark:text-red-400',
                                    'validated' => 'text-green-600 dark:text-green-400',
                                    'suspended' => 'text-yellow-600 dark:text-yellow-400',
                                    'rejected' => 'text-red-600 dark:text-red-400',
                                    'archived' => 'text-gray-600 dark:text-gray-400',
                                    default => 'text-gray-600 dark:text-gray-400'
                                };
                            @endphp
                             <span class="text-sm font-semibold {{ $actionColorClass }}">
                                {{ ucfirst($history->action) }}
                            </span>
                        </div>
                         <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Entité concernée :</strong><br>
                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                {{ class_basename($history->subject_type) }} (ID: {{ $history->subject_id }})
                            </span>
                        </div>
                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Utilisateur :</strong><br>
                            @if($history->user)
                                <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                    {{ $history->user->name }}
                                </span><br>
                                <span class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->user->email }}</span>
                            @else
                                <span class="text-sm text-gray-500 italic transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Utilisateur supprimé ou inconnu</span>
                            @endif
                        </div>

                        @if($history->description)
                            <div class="mt-4 border-t pt-4 transition-colors" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                                <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Description :</strong><br>
                                <p class="text-sm mb-0 transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">{{ $history->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Changements détaillés -->
                @if($history->changes && !empty($history->changes))
                    <div class="rounded-lg shadow-md p-5 transition-colors" :class="darkMode ? 'bg-[#2C3E50] border border-[#475569]' : 'bg-white border border-gray-200'">
                         <div class="border-b pb-4 mb-4 transition-colors" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                            <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">
                                Détail des modifications
                            </h2>
                        </div>
                        <div>
                            @if(isset($history->changes['before']) || isset($history->changes['after']))
                                <!-- Format avant/après -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if(isset($history->changes['before']))
                                        <div class="col-span-1">
                                            <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-3">Avant :</h3>
                                            <div class="bg-gray-100 p-4 rounded-lg transition-colors overflow-x-auto" :class="darkMode ? 'bg-gray-700 text-gray-200' : 'bg-gray-100 text-gray-800'">
                                                @if(is_array($history->changes['before']))
                                                    @foreach($history->changes['before'] as $key => $value)
                                                        <div class="mb-2 last:mb-0">
                                                            <strong class="font-mono text-sm block transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $key }}:</strong>
                                                            @if(is_array($value) || is_object($value))
                                                                <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            @else
                                                                <span class="font-mono text-xs whitespace-pre-wrap break-all">{{ $value ?? 'null' }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                     <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ is_scalar($history->changes['before']) ? $history->changes['before'] : json_encode($history->changes['before'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if(isset($history->changes['after']))
                                        <div class="col-span-1">
                                            <h3 class="text-lg font-medium text-green-600 dark:text-green-400 mb-3">Après :</h3>
                                            <div class="bg-gray-100 p-4 rounded-lg transition-colors overflow-x-auto" :class="darkMode ? 'bg-gray-700 text-gray-200' : 'bg-gray-100 text-gray-800'">
                                                @if(is_array($history->changes['after']))
                                                    @foreach($history->changes['after'] as $key => $value)
                                                        <div class="mb-2 last:mb-0">
                                                            <strong class="font-mono text-sm block transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $key }}:</strong>
                                                            @if(is_array($value) || is_object($value))
                                                                <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                            @else
                                                                <span class="font-mono text-xs whitespace-pre-wrap break-all">{{ $value ?? 'null' }}</span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ is_scalar($history->changes['after']) ? $history->changes['after'] : json_encode($history->changes['after'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Format libre -->
                                <div class="bg-gray-100 p-4 rounded-lg transition-colors overflow-x-auto" :class="darkMode ? 'bg-gray-700 text-gray-200' : 'bg-gray-100 text-gray-800'">
                                    @if(is_array($history->changes))
                                        @foreach($history->changes as $key => $value)
                                             <div class="mb-2 last:mb-0">
                                                <strong class="font-mono text-sm block transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $key }}:</strong>
                                                @if(is_array($value) || is_object($value))
                                                    <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                @else
                                                    <span class="font-mono text-xs whitespace-pre-wrap break-all">{{ $value ?? 'null' }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <pre class="font-mono text-xs mb-0 whitespace-pre-wrap break-all">{{ json_encode($history->changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Right Column (Technical Info) --}}
            <div class="lg:col-span-1">
                <!-- Informations techniques -->
                 <div class="rounded-lg shadow-md p-5 transition-colors" :class="darkMode ? 'bg-[#2C3E50] border border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="border-b pb-4 mb-4 transition-colors" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">
                            Informations techniques
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">ID de l'historique :</strong><br>
                            <code class="font-mono text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->id }}</code>
                        </div>

                        @if($history->ip_address)
                            <div>
                                <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Adresse IP :</strong><br>
                                <code class="font-mono text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->ip_address }}</code>
                            </div>
                        @endif

                        @if($history->user_agent)
                            <div>
                                <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">User Agent :</strong><br>
                                <small class="text-xs font-mono transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->user_agent }}</small>
                            </div>
                        @endif

                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Type complet de l'entité :</strong><br>
                            <small class="text-xs font-mono transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $history->subject_type }}</small>
                        </div>

                        <div>
                            <strong class="font-bold transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Timestamps :</strong><br>
                            <small class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                Créé : {{ $history->created_at }}<br>
                                Modifié : {{ $history->updated_at }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        /* Add any specific styles here if needed, but most should be Tailwind classes */
        /* Ensure pre tag formatting for code/JSON blocks */
        pre {
             white-space: pre-wrap; /* Handles long lines */
             word-break: break-all; /* Breaks words if necessary */
        }
         .break-all {
            word-break: break-all;
        }
         .whitespace-pre-wrap {
             white-space: pre-wrap;
         }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-dismiss flash messages script (assuming your component handles this,
        // but keeping a placeholder if needed)
        document.addEventListener('DOMContentLoaded', function() {
             // If your x-flash-message component doesn't handle auto-dismiss, add it here
             // Example (using a timeout):
             // const flashMessage = document.getElementById('flash-message'); // Needs ID on component
             // if (flashMessage) {
             //     setTimeout(() => {
             //         flashMessage.remove();
             //     }, 5000); // Remove after 5 seconds
             // }
        });
    </script>
@endpush