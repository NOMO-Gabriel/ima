<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user', 'size' => 'md']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['user', 'size' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $sizes = [
        'xs' => 'h-8 w-8',
        'sm' => 'h-10 w-10',
        'md' => 'h-12 w-12',
        'lg' => 'h-16 w-16',
        'xl' => 'h-24 w-24'
    ];
?>

<img 
    <?php echo e($attributes->merge(['class' => "rounded-full object-cover {$sizes[$size]}"])); ?>

    src="<?php echo e($user->profile_photo_url); ?>"
    alt="<?php echo e($user->full_name); ?>"
><?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/components/profile-photo.blade.php ENDPATH**/ ?>