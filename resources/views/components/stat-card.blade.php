@props([
    'title' => '',
    'value' => '0',
    'subtitle' => null,
    'color' => 'from-violet-500 to-indigo-600',
    'badge' => null,
    'badgeColor' => 'primary',
])

<div {{ $attributes->merge(['class' => 'mica-card rounded-2xl p-5 transition-all flex flex-col justify-between']) }}>
    <div class="flex items-center justify-between mb-3">
        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">{{ $title }}</span>
        @if($badge)
            <x-badge :color="$badgeColor" size="sm">{{ $badge }}</x-badge>
        @else
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr {{ $color }} flex items-center justify-center text-white text-xs shadow-md">
                {{ $icon ?? '✦' }}
            </div>
        @endif
    </div>

    <div>
        <div class="text-3xl font-black text-slate-900 tracking-tight">{{ $value }}</div>
        @if($subtitle)
            <p class="text-[11px] text-slate-500 font-medium mt-1">{{ $subtitle }}</p>
        @endif
    </div>
</div>
