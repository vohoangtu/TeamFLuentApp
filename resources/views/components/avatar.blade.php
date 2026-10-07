@props([
    'name' => '',
    'url' => null,
    'size' => 'md', // 'sm', 'md', 'lg', 'xl'
    'dot' => null,
    'isLead' => false,
])

@php
    $sizeClasses = match($size) {
        'sm' => 'w-7 h-7 rounded-full',
        'lg' => 'w-12 h-12 rounded-2xl',
        'xl' => 'w-20 h-20 rounded-3xl',
        default => 'w-9 h-9 rounded-xl',
    };

    $avatarUrl = $url ?: 'https://ui-avatars.com/api/?name='.urlencode($name ?: 'User').'&background=6366f1&color=fff';
@endphp

<div class="relative inline-block shrink-0">
    <img src="{{ $avatarUrl }}"
         alt="{{ $name }}"
         {{ $attributes->merge(['class' => "{$sizeClasses} object-cover ring-2 ring-white shadow-sm"]) }}>

    @if($isLead)
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-amber-400 rounded-full border border-white flex items-center justify-center text-[8px] font-black text-slate-950 shadow-sm"
              title="Team Lead">★</span>
    @elseif($dot)
        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white {{ $dot }}"></span>
    @endif
</div>
