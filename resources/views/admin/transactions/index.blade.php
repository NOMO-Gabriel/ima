@extends('layouts.app')

@section('title', 'Gestion des Transactions')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD] dark:text-gray-400 dark:hover:text-white">
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
                    <span class="ml-1 text-sm font-medium text-gray-700 md:ml-2 dark:text-gray-400">Finance</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Transactions</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8 dark:bg-gray-800">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-white flex items-center">
                <svg class="h-8 w-8 mr-2 text-[#4CA3DD]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                </svg>
                Gestion des Transactions
            </h1>
            <a href="{{ route('admin.transactions.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle Transaction
            </a>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 text-sm text-green-800 border-l-4 border-green-500 bg-green-50 dark:bg-gray-700 dark:text-green-400 rounded-md fade-in-down" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-700 dark:text-green-400 dark:hover:bg-gray-600" data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Section des statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Statistique 1: Total Entrées -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-5 shadow-sm border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center text-green-500 dark:text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Entrées</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($stats['total_in'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Total des entrées valides</p>
                </div>
                <div class="h-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 2: Total Sorties -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-5 shadow-sm border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-red-500 dark:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sorties</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($stats['total_out'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Total des sorties valides</p>
                </div>
                <div class="h-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                    <div class="h-full bg-red-500" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 3: Solde -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-5 shadow-sm border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full {{ $stats['balance'] >= 0 ? 'bg-blue-100 dark:bg-blue-900 text-blue-500 dark:text-blue-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-500 dark:text-yellow-300' }} flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Solde</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold {{ $stats['balance'] >= 0 ? 'text-gray-800 dark:text-white' : 'text-red-600 dark:text-red-400' }}">{{ number_format($stats['balance'], 0, ',', ' ') }} FCFA</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Solde actuel</p>
                </div>
                @php
                    $totalAbs = abs($stats['total_in']) + abs($stats['total_out']);
                    $balancePercentage = $totalAbs > 0 ? (abs($stats['balance']) / $totalAbs) * 100 : 50;
                    if ($stats['balance'] < 0) $balancePercentage = min($balancePercentage, 100); else $balancePercentage = min(50 + $balancePercentage/2, 100) ;
                @endphp
                <div class="h-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                    <div class="h-full {{ $stats['balance'] >= 0 ? 'bg-blue-500' : 'bg-yellow-500' }}" style="width: {{ $balancePercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 4: Total Transactions -->
            <div class="bg-white dark:bg-gray-700 rounded-lg p-5 shadow-sm border border-gray-200 dark:border-gray-600 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-500 dark:text-indigo-300">
                         <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Volume</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $transactions->total() }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Transactions enregistrées</p>
                </div>
                <div class="h-2 w-full bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <form action="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" method="GET">
            <div class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                    <div class="lg:col-span-2">
                        <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rechercher par description</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" id="search" name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD]" placeholder="Description...">
                        </div>
                    </div>
                    <div>
                        <label for="direction_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Direction</label>
                        <select name="direction" id="direction_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD]">
                            <option value="">Toutes</option>
                            <option value="IN" {{ request('direction') == 'IN' ? 'selected' : '' }}>Entrée</option>
                            <option value="OUT" {{ request('direction') == 'OUT' ? 'selected' : '' }}>Sortie</option>
                        </select>
                    </div>
                    <div>
                        <label for="reason_id_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison</label>
                        <select name="reason_id" id="reason_id_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD]">
                            <option value="">Toutes les raisons</option>
                            @foreach ($reasons as $reason)
                                <option value="{{ $reason->id }}" {{ request('reason_id') == $reason->id ? 'selected' : '' }}>
                                    {{ $reason->label }} ({{$reason->direction}})
                                </option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label for="center_id_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Centre</label>
                        <select name="center_id" id="center_id_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD]">
                            <option value="">Tous les centres</option>
                             @foreach ($centers as $center)
                                <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="valid_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Statut</label>
                        <select name="valid" id="valid_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD]">
                            <option value="">Tous</option>
                            <option value="1" {{ request('valid') == '1' ? 'selected' : '' }}>Valide</option>
                            <option value="0" {{ request('valid') == '0' && request('valid') !== null ? 'selected' : '' }}>Invalide</option>
                        </select>
                    </div>
                    <div class="lg:col-span-5 flex justify-end space-x-2 mt-4 md:mt-0">
                         <button type="submit" class="px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                            Filtrer
                        </button>
                        <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg text-sm dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m-15.357-2a8.001 8.001 0 0015.357 2M9 15h4.581" /></svg>
                            Réinitialiser
                        </a>
                        <a href="{{ route('admin.transactions.export', array_merge(request()->query(), ['locale' => app()->getLocale()])) }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg text-sm">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Exporter CSV
                        </a>
                    </div>
                </div>
            </div>
        </form>


        <!-- Tableau des transactions -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        ID / Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Raison & Direction
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Montant
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Bénéficiaire / Centre
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">#{{ $transaction->id }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $transaction->reason->label }}</div>
                            @if($transaction->reason->direction == 'IN')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    Entrée
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    Sortie
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->reason->direction == 'IN' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $transaction->reason->direction == 'IN' ? '+' : '-' }} {{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->receiver)
                                <div class="text-sm text-gray-900 dark:text-white">{{ $transaction->receiver->first_name }} {{ $transaction->receiver->last_name }}</div>
                            @else
                                <div class="text-sm text-gray-500 dark:text-gray-400">-</div>
                            @endif
                            @if($transaction->center)
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->center->name }}</div>
                            @else
                                <div class="text-sm text-gray-500 dark:text-gray-400">-</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->valid)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    Valide
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                    Invalide
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.transactions.show', ['locale' => app()->getLocale(), 'transaction' => $transaction->id]) }}"
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150 p-1 rounded hover:bg-blue-100 dark:hover:bg-gray-700"
                                   title="Voir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.transactions.edit', ['locale' => app()->getLocale(), 'transaction' => $transaction->id]) }}"
                                   class="text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150 p-1 rounded hover:bg-yellow-100 dark:hover:bg-gray-700"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button"
                                        onclick="showDeleteModal({{ $transaction->id }}, '{{ $transaction->reason->direction == 'IN' ? '+' : '-' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA', '{{ $transaction->reason->label }}')"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150 p-1 rounded hover:bg-red-100 dark:hover:bg-gray-700"
                                        title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <p class="text-lg font-medium">Aucune transaction trouvée</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter une transaction ou ajustez vos filtres.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
         @if($transactions->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-1 py-1 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                <div class="pagination-info mb-4 sm:mb-0 text-sm text-gray-700 dark:text-gray-400">
                    Affichage de <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->firstItem() ?? 0 }}</span>
                    à <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->lastItem() ?? 0 }}</span>
                    sur <span class="font-semibold text-gray-900 dark:text-white">{{ $transactions->total() }}</span> transactions
                </div>
                <div class="pagination-controls">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de suppression -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <button type="button" onclick="closeDeleteModal()" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Fermer</span>
                </button>
                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <p class="mb-4 text-gray-500 dark:text-gray-300">Êtes-vous sûr de vouloir supprimer cette transaction ?</p>
                <div id="transaction-details-modal" class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Details will be injected here by JS -->
                </div>
                <form id="deleteForm" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center items-center space-x-4">
                        <button type="button" onclick="closeDeleteModal()" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Annuler
                        </button>
                        <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            Oui, supprimer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* Styles pour la pagination si non gérés par Tailwind Pagination */
        .pagination-info {
            font-size: 0.875rem; /* text-sm */
        }
        .pagination-info span {
            font-weight: 600; /* font-semibold */
        }
         /* Animation pour les alertes */
        .fade-in-down {
            animation: fadeInDown 0.5s ease-out forwards;
        }
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-dismiss pour les alertes
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                const closeBtn = alert.querySelector('[data-dismiss-target]');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => alert.remove(), 500);
                    });
                }
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => { if (alert && alert.parentNode) alert.remove(); }, 500);
                    }
                }, 8000);
            });
        });

        // Modal de suppression
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const transactionDetailsModal = document.getElementById('transaction-details-modal');

        function showDeleteModal(transactionId, amount, reason) {
            const baseUrl = "{{ url('/') }}/{{ app()->getLocale() }}/admin/transactions";
            deleteForm.action = `${baseUrl}/${transactionId}`;
            transactionDetailsModal.innerHTML = `<strong>ID:</strong> #${transactionId}<br><strong>Montant:</strong> ${amount}<br><strong>Raison:</strong> ${reason}`;
            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex'); // Use flex to center it
        }

        function closeDeleteModal() {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }

        // Fermer le modal en cliquant à l'extérieur ou avec Escape
        document.addEventListener('click', function(event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
    </script>
@endpush
