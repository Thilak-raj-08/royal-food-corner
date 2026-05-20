@props([
    'name',
    'title' => '',
    'icon' => 'fa-circle',
    'size' => 'max-w-lg',
])

<div x-data="{ open: false }"
     x-on:open-modal.window="if ($event.detail === '{{ $name }}') open = true"
     x-on:keydown.escape.window="open = false"
     x-show="open"
     x-cloak
     class="fixed inset-0 z-[60] grid place-items-center p-4 bg-cocoa-900/60 backdrop-blur-sm"
     x-transition.opacity
     @click.self="open = false">

    <div class="card w-full {{ $size }} max-h-[90vh] overflow-y-auto scrollbar-thin"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">

        <div class="flex items-center justify-between p-5 border-b border-cream-400 bg-cream-100 sticky top-0">
            <h3 class="font-display text-xl font-bold text-cocoa-900 flex items-center gap-2.5">
                <i class="fa-solid {{ $icon }} text-signature-500"></i>{{ $title }}
            </h3>
            <button type="button" @click="open = false" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300 text-cocoa-700 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
