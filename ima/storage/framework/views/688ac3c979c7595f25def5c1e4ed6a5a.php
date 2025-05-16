<form id="delete-photo-form" method="POST" action="<?php echo e(route('profile.photo.destroy', ['locale' => app()->getLocale()])); ?>" class="hidden">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>
<?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/profile/partials/update-profile-photo-form.blade.php ENDPATH**/ ?>