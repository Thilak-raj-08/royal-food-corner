@props(['product', 'size' => 'sm'])

@php
    $sm = $size === 'sm';
    $vegBg  = $product->is_vegetarian ? 'bg-emerald-50 text-emerald-700 border-emerald-300' : 'bg-signature-50 text-signature-700 border-signature-300';
    $vegIco = $product->is_vegetarian ? 'fa-leaf' : 'fa-drumstick-bite';
    $vegTxt = $product->is_vegetarian ? 'Veg' : 'Non-Veg';

    $spiceMap = [
        'mild'   => ['🌶️',     'text-amber-600',     'Mild'],
        'medium' => ['🌶️🌶️',   'text-orange-600',    'Medium'],
        'hot'    => ['🌶️🌶️🌶️', 'text-signature-600', 'Hot'],
    ];
@endphp

<div class="flex flex-wrap items-center gap-1.5">
    {{-- Veg / Non-veg --}}
    <span class="inline-flex items-center gap-1 rounded-md border {{ $vegBg }} font-semibold {{ $sm ? 'px-2 py-0.5 text-[10px]' : 'px-2.5 py-1 text-xs' }}">
        <i class="fa-solid {{ $vegIco }} {{ $sm ? 'text-[9px]' : 'text-[11px]' }}"></i>{{ $vegTxt }}
    </span>

    {{-- Spice --}}
    @if ($product->spice_level && $product->spice_level !== 'none' && isset($spiceMap[$product->spice_level]))
        @php [$emoji, $color, $label] = $spiceMap[$product->spice_level]; @endphp
        <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 {{ $color }} font-semibold {{ $sm ? 'px-2 py-0.5 text-[10px]' : 'px-2.5 py-1 text-xs' }}">
            <span class="{{ $sm ? 'text-[10px]' : 'text-xs' }}">{{ $emoji }}</span>{{ $label }}
        </span>
    @endif

    {{-- Prep time (only on detail/large) --}}
    @if (! $sm && $product->prep_minutes)
        <span class="inline-flex items-center gap-1 rounded-md bg-cream-200 border border-cream-500 text-cocoa-700 font-semibold px-2.5 py-1 text-xs">
            <i class="fa-regular fa-clock text-[11px]"></i>{{ $product->prep_minutes }} min
        </span>
    @endif
</div>
