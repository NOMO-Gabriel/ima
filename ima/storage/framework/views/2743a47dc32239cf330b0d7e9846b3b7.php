<?php $__env->startSection('title', 'Détails de l\'utilisateur'); ?>

<?php $__env->startSection('content'); ?>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Profil de <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h1>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
            </a>
            <!-- <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.update.any')): ?>
            <a href="<?php echo e(route('admin.users.edit', ['locale' => app()->getLocale()], $user)); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a> -->
            <?php endif; ?>
            <?php if(auth()->id() !== $user->id): ?>
                <form action="<?php echo e(route('admin.users.destroy', ['locale' => app()->getLocale()], $user)); ?>" method="POST" class="inline-block">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-all " title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                        <i class="fas fa-trash mr-2"></i> Supprimer
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Messages de notification -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p><i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <p><i class="fas fa-exclamation-circle mr-2"></i> <?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?>

    <!-- Onglets -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <nav class="flex border-b border-gray-200">
            <button id="tab-profile" class="px-6 py-4 text-blue-600 border-b-2 border-blue-500 font-medium text-sm flex items-center">
                <i class="fas fa-user mr-2"></i> Profil
            </button>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.role.assign')): ?>
            <button id="tab-roles" class="px-6 py-4 text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 font-medium text-sm flex items-center">
                <i class="fas fa-user-tag mr-2"></i> Rôles et permissions
            </button>
            <?php endif; ?>
            <button id="tab-history" class="px-6 py-4 text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300 font-medium text-sm flex items-center">
                <i class="fas fa-history mr-2"></i> Historique
            </button>
        </nav>
    </div>

    <!-- Contenu de l'onglet Profil -->
    <div id="content-profile" class="bg-white rounded-lg shadow">
        <div class="p-6">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                    <div class="relative">
                        <img class="h-40 w-40 rounded-full object-cover border-4 border-gray-200" src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->first_name); ?>">
                        <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full
                            <?php if($user->status === 'active'): ?> bg-green-500 <?php else: ?> bg-gray-400 <?php endif; ?>"></div>
                    </div>
                </div>
                <div class="md:w-3/4 md:pl-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>Informations personnelles
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Nom complet:</span>
                                    <span class="text-sm text-gray-900 font-semibold"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Email:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->email); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Téléphone:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->phone_number ?? 'Non renseigné'); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Ville:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->city ?? 'Non renseigné'); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Adresse:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->address ?? 'Non renseigné'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                                <i class="fas fa-shield-alt mr-2 text-blue-500"></i>Informations du compte
                            </h3>
                            <div class="space-y-3">
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Statut:</span>
                                    <span>
                                        <?php
                                            $statusClasses = [
                                                'pending_validation' => 'bg-yellow-100 text-yellow-800',
                                                'pending_finalization' => 'bg-blue-100 text-blue-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'suspended' => 'bg-red-100 text-red-800',
                                                'rejected' => 'bg-gray-100 text-gray-800',
                                                'archived' => 'bg-gray-100 text-gray-800'
                                            ];

                                            $statusLabels = [
                                                'pending_validation' => 'En attente de validation',
                                                'pending_finalization' => 'En attente de finalisation',
                                                'active' => 'Actif',
                                                'suspended' => 'Suspendu',
                                                'rejected' => 'Rejeté',
                                                'archived' => 'Archivé'
                                            ];
                                        ?>
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusClasses[$user->status]); ?>">
                                            <?php echo e($statusLabels[$user->status]); ?>

                                        </span>
                                    </span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Rôles:</span>
                                    <span>
                                        <?php $__empty_1 = true; $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 mr-1">
                                                <?php echo e($role->name); ?>

                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <span class="text-sm text-gray-500 italic">Aucun rôle</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Dernière connexion:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais connecté'); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Créé le:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->created_at->format('d/m/Y')); ?></span>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-sm font-medium text-gray-500">Email vérifié:</span>
                                    <span class="text-sm text-gray-900"><?php echo e($user->email_verified_at ? $user->email_verified_at->format('d/m/Y') : 'Non vérifié'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu de l'onglet Rôles et permissions -->
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('user.role.assign')): ?>
    <div id="content-roles" class="hidden bg-white rounded-lg shadow mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">
                <i class="fas fa-user-shield mr-2 text-blue-500"></i>Gestion des rôles et permissions
            </h3>

            <form action="<?php echo e(route('admin.users.update-roles', $user)); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Statut du compte</h4>
                    <div class="flex items-center space-x-2">
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="pending_validation" <?php echo e($user->status === 'pending_validation' ? 'selected' : ''); ?>>En attente de validation</option>
                            <option value="pending_finalization" <?php echo e($user->status === 'pending_finalization' ? 'selected' : ''); ?>>En attente de finalisation</option>
                            <option value="active" <?php echo e($user->status === 'active' ? 'selected' : ''); ?>>Actif</option>
                            <option value="suspended" <?php echo e($user->status === 'suspended' ? 'selected' : ''); ?>>Suspendu</option>
                            <option value="rejected" <?php echo e($user->status === 'rejected' ? 'selected' : ''); ?>>Rejeté</option>
                            <option value="archived" <?php echo e($user->status === 'archived' ? 'selected' : ''); ?>>Archivé</option>
                        </select>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Le changement de statut peut affecter l'accès de l'utilisateur au système.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <h4 class="text-md font-medium text-gray-700 mb-4">Rôles</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white p-3 rounded-md border border-gray-200 hover:shadow-md transition-shadow">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="role_<?php echo e($role->id); ?>" name="roles[]" type="checkbox" value="<?php echo e($role->name); ?>"
                                            <?php echo e($user->roles->contains($role->id) ? 'checked' : ''); ?>

                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="role_<?php echo e($role->id); ?>" class="font-medium text-gray-700"><?php echo e($role->name); ?></label>
                                        <?php if($role->description): ?>
                                            <p class="text-gray-500"><?php echo e($role->description); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                    <h4 class="text-md font-medium text-gray-700 mb-2">Permissions directes</h4>
                    <p class="text-sm text-gray-500 mb-4">Ces permissions sont attribuées directement à l'utilisateur, indépendamment de ses rôles.</p>

                    <div class="bg-white p-4 rounded-md border border-gray-200 max-h-96 overflow-y-auto">
                        <?php $__currentLoopData = $permissionsByModule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-6">
                                <h5 class="text-md font-medium text-blue-600 mb-3 pb-1 border-b border-blue-100"><?php echo e($module); ?></h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-start hover:bg-gray-50 p-2 rounded-md transition-colors">
                                            <div class="flex items-center h-5">
                                                <input id="permission_<?php echo e($permission->id); ?>" name="permissions[]" type="checkbox" value="<?php echo e($permission->id); ?>"
                                                    <?php echo e($user->hasDirectPermission($permission->name) ? 'checked' : ''); ?>

                                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="permission_<?php echo e($permission->id); ?>" class="font-medium text-gray-700"><?php echo e($permission->name); ?></label>
                                                <p class="text-gray-500"><?php echo e($permission->description); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Bouton de sauvegarde -->
                <div class="flex items-center justify-end mt-6 gap-4">
                    <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <?php echo e(__('Annuler')); ?>

                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        <?php echo e(__('Enregistrer les modifications')); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Contenu de l'onglet Historique -->
    <div id="content-history" class="hidden bg-white rounded-lg shadow mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6 pb-2 border-b border-gray-200">
                <i class="fas fa-history mr-2 text-blue-500"></i>Historique des activités
            </h3>

            <div class="flex flex-col items-center justify-center py-12">
                <div class="rounded-full bg-blue-100 p-6 mb-4">
                    <i class="fas fa-clock text-blue-500 text-4xl"></i>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Fonctionnalité à venir</h3>
                <p class="text-gray-500 text-center max-w-md">
                    L'historique des activités sera bientôt disponible dans une prochaine mise à jour du système.
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts pour la gestion des onglets -->
    <?php $__env->startPush('scripts'); ?>
    <script>
        // Gestion des onglets
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[id^="tab-"]');
            const tabContents = document.querySelectorAll('[id^="content-"]');

            function activateTab(tabId) {
                // Masquer tous les contenus
                tabContents.forEach(content => content.classList.add('hidden'));

                // Réinitialiser tous les boutons d'onglet
                tabButtons.forEach(button => {
                    button.classList.remove('text-blue-600', 'border-blue-500');
                    button.classList.add('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                });

                // Activer l'onglet sélectionné
                document.getElementById('tab-' + tabId).classList.remove('text-gray-500', 'border-transparent', 'hover:text-gray-700', 'hover:border-gray-300');
                document.getElementById('tab-' + tabId).classList.add('text-blue-600', 'border-blue-500');

                // Afficher le contenu correspondant
                document.getElementById('content-' + tabId).classList.remove('hidden');
            }

            // Ajouter des écouteurs d'événements pour chaque onglet
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabId = button.id.replace('tab-', '');
                    activateTab(tabId);
                });
            });

            // Activer le premier onglet par défaut
            activateTab('profile');
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/admin/users/show.blade.php ENDPATH**/ ?>