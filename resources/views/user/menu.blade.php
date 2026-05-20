@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <span class="chip mb-4"><i class="fa-solid fa-utensils text-gold-400"></i>Browse Our Dishes</span>
        <h1 class="text-5xl md:text-6xl font-bold text-shadow-lg">Our <span class="accent text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Menu</span></h1>
        <p class="mt-4 text-white/80 max-w-xl mx-auto">From spicy main courses to refreshing beverages — pick what your heart craves.</p>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Category filters --}}
        <div class="flex flex-wrap items-center justify-center gap-3 mb-12">
            <a href="{{ route('menu.index') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-medium border transition
                      {{ ! $activeCategory ? 'bg-gradient-to-r from-royal-500 to-royal-700 border-transparent text-white shadow-glow' : 'glass border-white/20 text-white/80 hover:bg-white/15' }}">
                All
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('menu.index', ['category' => $cat]) }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-medium border transition
                          {{ $activeCategory === $cat ? 'bg-gradient-to-r from-royal-500 to-royal-700 border-transparent text-white shadow-glow' : 'glass border-white/20 text-white/80 hover:bg-white/15' }}">
                    @switch($cat)
                        @case('Main Courses') <i class="fa-solid fa-bowl-rice mr-1.5"></i> @break
                        @case('Desserts')     <i class="fa-solid fa-ice-cream mr-1.5"></i> @break
                        @case('Beverages')    <i class="fa-solid fa-mug-hot mr-1.5"></i> @break
                    @endswitch
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        {{-- Product grid --}}
        @if ($products->isEmpty())
            <div class="glass-card text-center py-16">
                <i class="fa-solid fa-utensils text-4xl text-white/30 mb-3"></i>
                <p class="text-white/70">No dishes found in this category.</p>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <a href="{{ route('menu.show', $product) }}" class="glass-card group block !p-0 overflow-hidden">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500" loading="lazy">
                            <div class="absolute top-3 left-3 chip !text-[10px] !py-1">{{ $product->category }}</div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">{{ $product->item_name }}</h3>
                            <div class="flex items-center justify-between mt-3">
                                <div class="text-royal-300 font-bold">Rs. {{ number_format($product->price, 2) }}</div>
                                <span class="text-xs text-white/60 group-hover:text-gold-400 transition">View <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
