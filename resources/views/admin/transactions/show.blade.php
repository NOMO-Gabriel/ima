@extends('layouts.app')

@section('title', 'Détails Transaction #' . $transaction->id)

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
                    <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2 dark:text-gray-400 dark:hover:text-white">Transactions</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Détails #{{ $transaction->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8 dark:bg-gray-800">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-white flex items-center">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                Détails de la Transaction #{{ $transaction->id }}
            </h1>
             <div class="flex space-x-2">
                <a href="{{ route('admin.transactions.edit', ['locale' => app()->getLocale(), 'transaction' => $transaction]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 font-medium rounded-lg text-sm transition-colors duration-200">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <!-- Overview -->
        <div class="mb-8 p-6 rounded-lg
            @if($transaction->reason->direction == 'IN') bg-green-50 border-l-4 border-green-500 dark:bg-green-900 dark:border-green-700
            @else bg-red-50 border-l-4 border-red-500 dark:bg-red-900 dark:border-red-700 @endif">
            <div class="flex flex-col md:flex-row justify-between items-start">
                <div>
                    <span class="text-sm font-semibold
                        @if($transaction->reason->direction == 'IN') text-green-700 dark:text-green-300
                        @else text-red-700 dark:text-red-300 @endif">
                        {{ $transaction->reason->direction == 'IN' ? 'Entrée' : 'Sortie' }} - {{ $transaction->reason->label }}
                    </span>
                    <h2 class="text-3xl font-bold
                        @if($transaction->reason->direction == 'IN') text-green-600 dark:text-green-400
                        @else text-red-600 dark:text-red-400 @endif mt-1">
                        {{ $transaction->reason->direction == 'IN' ? '+' : '-' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                    </h2>
                </div>
                <div class="mt-4 md:mt-0 md:text-right">
                    @if($transaction->valid)
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                            Valide
                        </span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-200">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.216 3.031-1.742 3.031H4.42c-1.526 0-2.493-1.697-1.743-3.031l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1.75-3.75a.75.75 0 00-1.5 0v3.5a.75.75 0 001.5 0v-3.5z" clip-rule="evenodd" /></svg>
                            Invalide
                        </span>
                    @endif
                     <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        ID: #{{ $transaction->id }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">Informations Générales</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date de création:</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $transaction->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dernière modification:</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $transaction->updated_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">Parties Prenantes</h3>
                <dl class="space-y-3">
                     <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Créé par:</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            @if($transaction->creator)
                                {{ $transaction->creator->first_name }} {{ $transaction->creator->last_name }}
                                <span class="text-gray-500 dark:text-gray-400">({{ $transaction->creator->email }})</span>
                            @else
                                <span class="italic">Inconnu</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bénéficiaire:</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            @if($transaction->receiver)
                                {{ $transaction->receiver->first_name }} {{ $transaction->receiver->last_name }}
                                <span class="text-gray-500 dark:text-gray-400">({{ $transaction->receiver->email }})</span>
                            @else
                                <span class="italic">Aucun</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Centre:</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">
                            @if($transaction->center)
                                {{ $transaction->center->name }}
                            @else
                                <span class="italic">Aucun</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($transaction->description)
        <div>
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">Description</h3>
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $transaction->description }}</p>
            </div>
        </div>
        @endif

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button type="button"
                    onclick="showDeleteModal({{ $transaction->id }}, '{{ $transaction->reason->direction == 'IN' ? '+' : '-' }}{{ number_format($transaction->amount, 0, ',', ' ') }} FCFA', '{{ $transaction->reason->label }}')"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Supprimer la Transaction
            </button>
        </div>
    </div>

    <!-- Modal de suppression (identique à celui de l'index) -->
    <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
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

@push('scripts')
<script>
    // Modal de suppression (identique à celui de l'index)
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const transactionDetailsModal = document.getElementById('transaction-details-modal');

    function showDeleteModal(transactionId, amount, reason) {
        const baseUrl = "{{ url('/') }}/{{ app()->getLocale() }}/admin/transactions";
        deleteForm.action = `${baseUrl}/${transactionId}`;
        transactionDetailsModal.innerHTML = `<strong>ID:</strong> #${transactionId}<br><strong>Montant:</strong> ${amount}<br><strong>Raison:</strong> ${reason}`;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

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
