@props([
    'variant' => 'default', // 'default', 'solid', 'interactive', 'gradient'
    'padding' => 'default', // 'default' (p-6), 'sm' (p-4), 'lg' (p-8), 'none' (p-0)
])

@php
    $paddingClasses = match($padding) {
        'none' => '',
        'sm' => 'p-4',
        'lg' => 'p-8',
        default => 'p-6',
    };

    $variantClasses = match($variant) {
        'solid' => 'mica-card-solid',
        'interactive' => 'mica-card cursor-pointer hover:scale-[1.01] transition-all',
        'gradient' => 'mica-card relative overflow-hidden',
        default => 'mica-card',
    };
@endphp

<div {{ $attributes->merge(['class' => "{$variantClasses} rounded-2xl {$paddingClasses}"]) }}>
    {{ $slot }}
</div>
