@props(['user', 'size' => 'md'])

@php
    $sizes = [
        'xs' => 'h-8 w-8',
        'sm' => 'h-10 w-10',
        'md' => 'h-12 w-12',
        'lg' => 'h-16 w-16',
        'xl' => 'h-24 w-24'
    ];
@endphp

<img 
    {{ $attributes->merge(['class' => "rounded-full object-cover {$sizes[$size]}"]) }}
    src="{{ $user->profile_photo_url }}"
    alt="{{ $user->full_name }}"
>