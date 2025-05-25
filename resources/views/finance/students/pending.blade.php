@extends('layouts.app')

@section('title', 'Élèves en attente de validation')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Élèves en attente de validation</h1>
        <div class="flex space-x-2">
            <a href="{{ route('finance.students.pending-contract', ['locale' => app()->getLocale()]) }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Élèves en attente de contrat
            </a>
        </div>
    </div>

    @if($pendingStudents->count() > 0)
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @foreach($pendingStudents as $student)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full" src="{{ $student->profile_photo_url }}" alt="{{ $student->full_name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $student->full_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $student->email }} • {{ $student->phone_number }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Ville: {{ $student->city->name ?? 'Non spécifiée' }} • 
                                        Inscrit le: {{ $student->created_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    En attente
                                </span>
                                <button onclick="showStudentDetails({{ $student->id }})" 
                                        class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                    Voir détails
                                </button>
                                <form method="POST" action="{{ route('finance.students.validate', ['locale' => app()->getLocale(), 'user' => $student]) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700"
                                            onclick="return confirm('Êtes-vous sûr de vouloir valider cet élève ?')">
                                        Valider
                                    </button>
                                </form>
                                <button onclick="showRejectModal({{ $student->id }})" 
                                        class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                                    Rejeter
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-6">
            {{ $pendingStudents->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun élève en attente</h3>
            <p class="mt-1 text-sm text-gray-500">Tous les élèves ont été traités.</p>
        </div>
    @endif
</div>

<!-- Modal de rejet -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Rejeter l'élève</h3>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Raison du rejet
                    </label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="4" 
                              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Expliquez pourquoi vous rejetez cette inscription..."
                              required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()" 
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        Confirmer le rejet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showRejectModal(studentId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('/') }}/{{ app()->getLocale() }}/finance/students/${studentId}/reject`;
    modal.classList.remove('hidden');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    document.getElementById('rejection_reason').value = '';
}

function showStudentDetails(studentId) {
    // Rediriger vers la page de détails
    window.location.href = `{{ url('/') }}/{{ app()->getLocale() }}/finance/students/${studentId}`;
}

// Fermer le modal en cliquant à l'extérieur
window.onclick = function(event) {
    const modal = document.getElementById('rejectModal');
    if (event.target === modal) {
        closeRejectModal();
    }
}
</script>
@endpush
@endsection