@props([
    'color' => 'primary', // 'primary', 'cyan', 'emerald', 'amber', 'rose', 'slate', 'blue'
    'size' => 'md',       // 'sm', 'md'
    'dot' => false,
    'rounded' => 'full',  // 'full', 'xl', 'lg', 'md'
])

@php
    $sizeClasses = match($size) {
        'sm' => 'text-[10px] px-2 py-0.5 font-semibold',
        default => 'text-xs px-2.5 py-1 font-bold',
    };

    $roundedClasses = match($rounded) {
        'xl' => 'rounded-xl',
        'lg' => 'rounded-lg',
        'md' => 'rounded-md',
        default => 'rounded-full',
    };

    $colorClasses = match($color) {
        'cyan' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
        'emerald', 'success' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        'amber', 'warning' => 'bg-amber-100 text-amber-800 border-amber-300',
        'rose', 'danger' => 'bg-rose-100 text-rose-800 border-rose-300',
        'blue', 'info' => 'bg-blue-100 text-blue-800 border-blue-300',
        'slate', 'neutral' => 'bg-slate-100 text-slate-700 border-slate-300',
        default => 'bg-purple-100 text-purple-800 border-purple-300',
    };

    $dotColor = match($color) {
        'cyan' => 'bg-cyan-500',
        'emerald', 'success' => 'bg-emerald-500',
        'amber', 'warning' => 'bg-amber-500',
        'rose', 'danger' => 'bg-rose-500',
        'blue', 'info' => 'bg-blue-500',
        'slate', 'neutral' => 'bg-slate-500',
        default => 'bg-purple-500',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 border {$sizeClasses} {$roundedClasses} {$colorClasses} transition-colors"]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }} shrink-0"></span>
    @endif
    <span>{{ $slot }}</span>
</span>
