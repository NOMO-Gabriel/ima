@if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    <div class="flash-messages mb-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow-sm flex items-start alert-success" role="alert">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
                <button class="ml-auto flex-shrink-0 text-gray-500 hover:text-gray-700 alert-close" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow-sm flex items-start alert-error" role="alert">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
                <button class="ml-auto flex-shrink-0 text-gray-500 hover:text-gray-700 alert-close" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-md shadow-sm flex items-start alert-warning" role="alert">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="font-medium">{{ session('warning') }}</p>
                </div>
                <button class="ml-auto flex-shrink-0 text-gray-500 hover:text-gray-700 alert-close" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded-md shadow-sm flex items-start alert-info" role="alert">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-lg"></i>
                </div>
                <div class="ml-3 flex-1">
                    <p class="font-medium">{{ session('info') }}</p>
                </div>
                <button class="ml-auto flex-shrink-0 text-gray-500 hover:text-gray-700 alert-close" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des boutons de fermeture des alertes
            const alertCloseButtons = document.querySelectorAll('.alert-close');
            alertCloseButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const alert = this.closest('[role="alert"]');
                    if (alert) {
                        alert.style.transition = 'all 0.3s ease-out';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            alert.remove();
                        }, 300);
                    }
                });
            });

            // Auto-dismiss après 7 secondes pour les messages de succès
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 7000);
            });
        });
    </script>
@endif
