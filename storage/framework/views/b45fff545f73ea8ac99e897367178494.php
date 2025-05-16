<?php $__env->startSection('title', 'Ajouter un Utilisateur'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Ajouter un Utilisateur</h1>
            <p class="mt-1 text-sm text-gray-600">Créez un nouvel utilisateur et attribuez-lui des rôles.</p>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <form action="<?php echo e(route('admin.users.store', ['locale' => app()->getLocale()])); ?>" method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Informations personnelles -->
                        <div class="sm:col-span-3">
                            <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="first_name" id="first_name" value="<?php echo e(old('first_name')); ?>" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name')); ?>" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="text" name="phone_number" id="phone_number" value="<?php echo e(old('phone_number')); ?>" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                            <div class="mt-1">
                                <input type="text" name="city" id="city" value="<?php echo e(old('city')); ?>"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                            <div class="mt-1">
                                <input type="text" name="address" id="address" value="<?php echo e(old('address')); ?>"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Mot de passe -->
                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="password" id="password" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <!-- Statut et rôles -->
                        <div class="sm:col-span-3">
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut <span class="text-red-500">*</span></label>
                            <div class="mt-1">
                                <select id="status" name="status" required
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="pending_validation" <?php echo e(old('status') == 'pending_validation' ? 'selected' : ''); ?>>En attente de validation</option>
                                    <option value="pending_finalization" <?php echo e(old('status') == 'pending_finalization' ? 'selected' : ''); ?>>En attente de finalisation</option>
                                    <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Actif</option>
                                    <option value="suspended" <?php echo e(old('status') == 'suspended' ? 'selected' : ''); ?>>Suspendu</option>
                                </select>
                            </div>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rôles <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php $__currentLoopData = $roles->chunk(ceil($roles->count() / 3)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex items-start mb-2">
                                                <div class="flex items-center h-5">
                                                    <input id="role_<?php echo e($role->id); ?>" name="roles[]" type="checkbox" value="<?php echo e($role->name); ?>"
                                                        <?php echo e(in_array($role->name, old('roles', [])) ? 'checked' : ''); ?>

                                                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="role_<?php echo e($role->id); ?>" class="font-medium text-gray-700"><?php echo e($role->name); ?></label>
                                                    <?php if($role->description): ?>
                                                        <p class="text-gray-500"><?php echo e($role->description); ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['roles'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                        <a href="<?php echo e(route('admin.users.index')); ?>"
                            class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/jordan/PROJECTS/ima/resources/views/admin/users/create.blade.php ENDPATH**/ ?>