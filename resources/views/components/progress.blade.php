@props([
    'value' => 0,
    'label' => null,
    'showValue' => true,
    'color' => 'from-violet-500 to-indigo-600',
    'size' => 'md', // 'sm', 'md', 'lg'
])

@php
    $heightClass = match($size) {
        'sm' => 'h-1.5',
        'lg' => 'h-3',
        default => 'h-2',
    };
    $clampedValue = max(0, min(100, (int) $value));
@endphp

<div class="space-y-1.5">
    @if($label || $showValue)
        <div class="flex items-center justify-between text-xs font-medium">
            @if($label)
                <span class="text-slate-500 font-medium">{{ $label }}</span>
            @endif
            @if($showValue)
                <span class="text-slate-900 font-bold ml-auto">{{ $clampedValue }}%</span>
            @endif
        </div>
    @endif

    <div class="w-full bg-slate-100 rounded-full {{ $heightClass }} overflow-hidden border border-slate-200/60">
        <div class="h-full bg-gradient-to-r {{ $color }} rounded-full transition-all duration-500"
             style="width: {{ $clampedValue }}%;"></div>
    </div>
</div>
