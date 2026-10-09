@props([
    'text' => '',       // Short description text
    'color' => 'blue',  // 'blue', 'cyan', 'amber', 'emerald', 'rose', 'slate'
    'placement' => 'bottom', // 'bottom', 'top', 'left', 'right'
    'size' => 'md',     // 'sm', 'md'
])

@php
    $id = 'popover-' . uniqid();

    $iconSize = match($size) {
        'sm' => 'w-3.5 h-3.5 text-[10px]',
        default => 'w-4 h-4 text-xs',
    };

    $badgeColor = match($color) {
        'cyan'    => 'bg-cyan-100 border-cyan-300 text-cyan-700 hover:bg-cyan-200',
        'amber'   => 'bg-amber-100 border-amber-300 text-amber-700 hover:bg-amber-200',
        'emerald' => 'bg-emerald-100 border-emerald-300 text-emerald-700 hover:bg-emerald-200',
        'rose'    => 'bg-rose-100 border-rose-300 text-rose-700 hover:bg-rose-200',
        'slate'   => 'bg-slate-100 border-slate-300 text-slate-600 hover:bg-slate-200',
        default   => 'bg-blue-100 border-blue-300 text-blue-700 hover:bg-blue-200',
    };

    $tooltipText = $slot->isEmpty() ? $text : null;
@endphp

<div class="relative inline-flex items-center"
     x-data="{ open: false }"
     x-on:click.outside="open = false">

    {{-- Info badge button --}}
    <button
        type="button"
        x-on:click="open = !open"
        title="{{ $tooltipText }}"
        class="inline-flex items-center justify-center {{ $iconSize }} rounded-full border {{ $badgeColor }} cursor-pointer transition-colors select-none shrink-0 font-bold leading-none"
        aria-label="Thông tin chi tiết"
    >
        !
    </button>

    {{-- Popover panel --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @class([
            'absolute z-50 w-64 rounded-xl bg-white border border-slate-200 shadow-xl p-3.5 text-xs text-slate-700 leading-relaxed',
            'top-6 left-0'   => $placement === 'bottom',
            'bottom-6 left-0' => $placement === 'top',
            'top-0 right-6'  => $placement === 'left',
            'top-0 left-6'   => $placement === 'right',
        ])
        style="display: none;"
        x-cloak
    >
        {{-- Arrow --}}
        @if($placement === 'bottom')
            <div class="absolute -top-1.5 left-3 w-3 h-3 bg-white border-l border-t border-slate-200 rotate-45"></div>
        @elseif($placement === 'top')
            <div class="absolute -bottom-1.5 left-3 w-3 h-3 bg-white border-r border-b border-slate-200 rotate-45"></div>
        @elseif($placement === 'right')
            <div class="absolute top-2 -left-1.5 w-3 h-3 bg-white border-l border-b border-slate-200 rotate-45"></div>
        @elseif($placement === 'left')
            <div class="absolute top-2 -right-1.5 w-3 h-3 bg-white border-r border-t border-slate-200 rotate-45"></div>
        @endif

        @if(!$slot->isEmpty())
            {{ $slot }}
        @else
            {{ $text }}
        @endif
    </div>
</div>
