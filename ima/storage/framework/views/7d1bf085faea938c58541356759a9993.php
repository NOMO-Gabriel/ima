<?php $__env->startSection('title', 'Tableau de Bord'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Section de bienvenue -->
    <div class="welcome-section bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row justify-between items-center">
        <div class="welcome-text mb-4 md:mb-0 text-center md:text-left">
            <h2 class="text-2xl font-bold mb-2">Bienvenue sur IMA Dashboard, <?php echo e(Auth::user()->first_name); ?></h2>
            <p class="text-gray-600 max-w-2xl">
                Gérez efficacement votre personnel et vos services éducatifs. Suivez vos indicateurs en temps réel
                et optimisez le fonctionnement de votre institution.
            </p>
        </div>
        <div class="welcome-actions flex gap-3 flex-wrap justify-center">
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                <i class="fas fa-calendar-plus mr-2"></i> Planifier un cours
            </a>
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-all transform hover:-translate-y-1">
                <i class="fas fa-user-plus mr-2"></i> Ajouter un enseignant
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl mr-4">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">1,254</h3>
                <p class="text-gray-600">Élèves inscrits</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl mr-4">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">58</h3>
                <p class="text-gray-600">Enseignants actifs</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl mr-4">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">124</h3>
                <p class="text-gray-600">Cours planifiés aujourd'hui</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xl mr-4">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">3.4M</h3>
                <p class="text-gray-600">Revenus ce mois (FCFA)</p>
            </div>
        </div>
    </div>

    <!-- Indicateurs de progrès -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <h4 class="font-medium text-gray-800">Préparation aux Concours</h4>
                <span class="text-blue-600 font-medium">75%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full mb-2">
                <div class="h-2 bg-blue-600 rounded-full" style="width: 75%"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Objectif: 85%</span>
                <span>+5% ce mois</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <h4 class="font-medium text-gray-800">Taux de réussite ENS</h4>
                <span class="text-green-600 font-medium">68%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full mb-2">
                <div class="h-2 bg-green-600 rounded-full" style="width: 68%"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Objectif: 70%</span>
                <span>+2% cette année</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="flex justify-between items-start mb-4">
                <h4 class="font-medium text-gray-800">Satisfaction des élèves</h4>
                <span class="text-yellow-600 font-medium">92%</span>
            </div>
            <div class="h-2 bg-gray-200 rounded-full mb-2">
                <div class="h-2 bg-yellow-600 rounded-full" style="width: 92%"></div>
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Objectif: 95%</span>
                <span>+3% ce trimestre</span>
            </div>
        </div>
    </div>

    Cours récents
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Cours récents</h3>
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                Voir tout <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Enseignant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Horaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Mathématiques</td>
                            <td class="px-6 py-4 whitespace-nowrap">Terminale D</td>
                            <td class="px-6 py-4 whitespace-nowrap">Dr. Jean Kamga</td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e(now()->format('d M')); ?>, 10:00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terminé</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Physique-Chimie</td>
                            <td class="px-6 py-4 whitespace-nowrap">Première C</td>
                            <td class="px-6 py-4 whitespace-nowrap">Prof. Sophie Mbarga</td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e(now()->format('d M')); ?>, 13:30</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terminé</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">Sciences de la Vie</td>
                            <td class="px-6 py-4 whitespace-nowrap">Seconde A</td>
                            <td class="px-6 py-4 whitespace-nowrap">Dr. Patrice Ndong</td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e(now()->format('d M')); ?>, 15:00</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En cours</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Activités récentes -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Activités récentes</h3>
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                Voir tout <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="bg-white rounded-lg shadow">
            <ul class="divide-y divide-gray-200">
                <li class="p-4 flex">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-4 flex-shrink-0">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">Nouvel élève inscrit</div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Mbarga David inscrit en Terminale C</span>
                            <span class="text-gray-500">Il y a 20 minutes</span>
                        </div>
                    </div>
                </li>
                <li class="p-4 flex">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mr-4 flex-shrink-0">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">Paiement reçu</div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">125,000 FCFA reçus pour frais de scolarité</span>
                            <span class="text-gray-500">Il y a 1 heure</span>
                        </div>
                    </div>
                </li>
                <li class="p-4 flex">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 mr-4 flex-shrink-0">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">Cours reprogrammé</div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Cours de Mathématiques Terminale D déplacé au 17 Mars</span>
                            <span class="text-gray-500">Il y a 3 heures</span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="mb-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Actions rapides</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl mx-auto mb-4">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Ajouter un élève</h4>
                <p class="text-sm text-gray-600">Enregistrer un nouvel élève dans le système</p>
            </a>

            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl mx-auto mb-4">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Ajouter un enseignant</h4>
                <p class="text-sm text-gray-600">Enregistrer un nouvel enseignant</p>
            </a>

            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl mx-auto mb-4">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Planifier un cours</h4>
                <p class="text-sm text-gray-600">Programmer un nouveau cours</p>
            </a>

            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xl mx-auto mb-4">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Générer un rapport</h4>
                <p class="text-sm text-gray-600">Créer un rapport personnalisé</p>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .welcome-section {
        background-image: linear-gradient(to right, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.9) 100%), url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/admin/dashboard.complete.blade.php ENDPATH**/ ?>