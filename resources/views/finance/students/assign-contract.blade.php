@extends('layouts.app')

@section('title', 'Assigner concours et tarification')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <a href="{{ route('finance.students.pending-contract', ['locale' => app()->getLocale()]) }}" 
           class="text-blue-600 hover:text-blue-800">
            ← Retour à la liste
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h1 class="text-xl font-bold text-gray-900">
                Assigner concours et tarification à {{ $student->full_name }}
            </h1>
            <p class="text-sm text-gray-600 mt-1">
                Email: {{ $student->email }} • Téléphone: {{ $student->phone_number }}
            </p>
        </div>

        <form method="POST" action="{{ route('finance.students.assign-contract', ['locale' => app()->getLocale(), 'student' => $student]) }}" class="p-6">
            @csrf

            <!-- Sélection des concours d'entrée -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Concours d'entrée souhaités <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($entranceExams as $exam)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="exam_{{ $exam->id }}" 
                                   name="entrance_exams[]" 
                                   value="{{ $exam->id }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="exam_{{ $exam->id }}" class="ml-2 text-sm text-gray-700">
                                {{ $exam->name }} ({{ $exam->code }})
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('entrance_exams')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Formation choisie -->
            <div class="mb-6">
                <label for="formation_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Formation <span class="text-red-500">*</span>
                </label>
                <select id="formation_id" name="formation_id" 
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Sélectionnez une formation</option>
                    @foreach($formations as $formation)
                        <option value="{{ $formation->id }}" 
                                data-price="{{ $formation->price ?? 0 }}"
                                {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                            {{ $formation->name }} 
                            @if($formation->price) - {{ number_format($formation->price, 0, ',', ' ') }} FCFA @endif
                        </option>
                    @endforeach
                </select>
                @error('formation_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Contrat de paiement -->
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">💰 Contrat de paiement</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Montant à payer -->
                    <div>
                        <label for="contract_amount" class="block text-sm font-medium text-gray-700 mb-1">
                            Montant à payer (FCFA) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="contract_amount" 
                               name="contract_amount" 
                               min="0" 
                               step="1000"
                               value="{{ old('contract_amount') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               required>
                        <p class="text-xs text-gray-500 mt-1">Le montant que l'élève devra payer pour ses formations</p>
                        @error('contract_amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mode de paiement -->
                    <div>
                        <label for="payment_schedule" class="block text-sm font-medium text-gray-700 mb-1">
                            Mode de paiement <span class="text-red-500">*</span>
                        </label>
                        <select id="payment_schedule" name="payment_schedule" 
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Comment l'élève va payer</option>
                            <option value="monthly" {{ old('payment_schedule') == 'monthly' ? 'selected' : '' }}>
                                Paiement mensuel
                            </option>
                            <option value="quarterly" {{ old('payment_schedule') == 'quarterly' ? 'selected' : '' }}>
                                Paiement trimestriel
                            </option>
                            <option value="semester" {{ old('payment_schedule') == 'semester' ? 'selected' : '' }}>
                                Paiement semestriel
                            </option>
                            <option value="annual" {{ old('payment_schedule') == 'annual' ? 'selected' : '' }}>
                                Paiement annuel
                            </option>
                            <option value="one_time" {{ old('payment_schedule') == 'one_time' ? 'selected' : '' }}>
                                Paiement unique
                            </option>
                        </select>
                        @error('payment_schedule')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Période de formation -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Début de la formation <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               required>
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Fin de la formation <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date') }}"
                               class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                               required>
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Calcul automatique des versements -->
                <div id="payment-breakdown" class="mt-4 p-3 bg-white rounded border hidden">
                    <h4 class="font-medium text-gray-900 mb-2">💡 Répartition des paiements</h4>
                    <div id="payment-details" class="text-sm text-gray-600"></div>
                </div>

                <!-- Notes spéciales -->
                <div class="mt-4">
                    <label for="special_conditions" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes ou conditions particulières (optionnel)
                    </label>
                    <textarea id="special_conditions" 
                              name="special_conditions" 
                              rows="2"
                              maxlength="500"
                              placeholder="Ex: Réduction accordée, délai de paiement spécial..."
                              class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('special_conditions') }}</textarea>
                    @error('special_conditions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Résumé avant validation -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">📋 Résumé</h3>
                <p class="text-sm text-gray-600">
                    Une fois validé, l'élève recevra un email avec ses concours assignés et les détails de paiement de sa formation.
                    Son compte sera automatiquement activé et il pourra se connecter.
                </p>
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('finance.students.pending-contract', ['locale' => app()->getLocale()]) }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700"
                        onclick="return confirm('Confirmer l\'assignation des concours et du contrat de paiement ? L\'élève sera automatiquement notifié et son compte sera activé.')">
                    ✅ Confirmer et activer le compte
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-fill amount when formation is selected
document.getElementById('formation_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    
    if (price && price > 0) {
        document.getElementById('contract_amount').value = price;
        calculatePaymentBreakdown();
    }
});

// Auto-update end date when start date changes
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDate = new Date(startDate);
    endDate.setFullYear(startDate.getFullYear() + 1); // Add 1 year by default
    
    document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
    document.getElementById('end_date').min = this.value;
    calculatePaymentBreakdown();
});

// Calculate payment breakdown
function calculatePaymentBreakdown() {
    const amount = parseFloat(document.getElementById('contract_amount').value) || 0;
    const schedule = document.getElementById('payment_schedule').value;
    const breakdownDiv = document.getElementById('payment-breakdown');
    const detailsDiv = document.getElementById('payment-details');
    
    if (amount > 0 && schedule) {
        let installments = 1;
        let frequency = '';
        
        switch (schedule) {
            case 'monthly':
                installments = 12;
                frequency = 'par mois';
                break;
            case 'quarterly':
                installments = 4;
                frequency = 'par trimestre';
                break;
            case 'semester':
                installments = 2;
                frequency = 'par semestre';
                break;
            case 'annual':
                installments = 1;
                frequency = 'par an';
                break;
            case 'one_time':
                installments = 1;
                frequency = 'en une fois';
                break;
        }
        
        const amountPerInstallment = Math.ceil(amount / installments);
        
        detailsDiv.innerHTML = `
            <strong>${installments} versement(s)</strong> de 
            <strong>${amountPerInstallment.toLocaleString()} FCFA</strong> ${frequency}
        `;
        
        breakdownDiv.classList.remove('hidden');
    } else {
        breakdownDiv.classList.add('hidden');
    }
}

// Add event listeners for real-time calculation
document.getElementById('contract_amount').addEventListener('input', calculatePaymentBreakdown);
document.getElementById('payment_schedule').addEventListener('change', calculatePaymentBreakdown);

// Validate that at least one exam is selected
document.querySelector('form').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[name="entrance_exams[]"]:checked');
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Veuillez sélectionner au moins un concours d\'entrée.');
        return false;
    }
});
</script>
@endpush
@endsection