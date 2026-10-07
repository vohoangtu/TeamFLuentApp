@props([
    'label' => null,
    'name' => null,
    'required' => false,
    'hint' => null,
])

<div class="space-y-1.5">
    @if($label)
        <label @if($name) for="{{ $name }}" @endif class="block text-xs font-bold text-slate-700">
            {{ $label }}
            @if($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <select @if($name) name="{{ $name }}" id="{{ $name }}" @endif
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'w-full px-4 py-2.5 text-xs rounded-xl mica-input']) }}>
        {{ $slot }}
    </select>

    @if($hint)
        <p class="text-[11px] text-slate-500">{{ $hint }}</p>
    @endif

    @if($name)
        @error($name)
            <p class="text-[11px] font-semibold text-rose-500">{{ $message }}</p>
        @enderror
    @endif
</div>
