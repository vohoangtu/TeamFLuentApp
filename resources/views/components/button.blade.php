@props([
    'variant' => 'primary', // 'primary', 'secondary', 'danger', 'ghost'
    'size' => 'md',         // 'sm', 'md', 'lg'
    'href' => null,
    'type' => 'button',
])

@php
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs font-semibold rounded-lg',
        'lg' => 'px-6 py-3 text-sm font-bold rounded-2xl',
        default => 'px-4 py-2.5 text-xs font-bold rounded-xl',
    };

    $variantClasses = match($variant) {
        'secondary' => 'mica-pill hover:bg-slate-100 transition-all shadow-sm',
        'danger' => 'bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition-colors',
        'ghost' => 'hover:bg-slate-100 text-slate-700 transition-colors',
        default => 'glow-btn-primary text-white shadow-md hover:shadow-lg',
    };

    $baseClasses = "inline-flex items-center justify-center gap-2 cursor-pointer transition-all disabled:opacity-50 disabled:pointer-events-none {$sizeClasses} {$variantClasses}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        {{ $slot }}
    </button>
@endif
