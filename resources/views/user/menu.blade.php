@extends('layouts.app')

@section('title', 'Menu')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-cocoa-900/80 via-cocoa-900/60 to-cream-100"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-20 text-center text-white">
        <span class="text-gold-400 font-script text-2xl">Our</span>
        <h1 class="text-5xl md:text-6xl font-display font-bold text-shadow-lg">Complete <span class="text-gold-400">Menu</span></h1>
        <p class="mt-4 text-cream-200/90 max-w-xl mx-auto">From spicy main courses to refreshing beverages — pick what your heart craves.</p>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">

        {{-- SEARCH + CATEGORY FILTER --}}
        <div class="card p-5 md:p-6 mb-10 -mt-16 relative z-10" x-data="{ q: '{{ $search ?? '' }}' }">
            <form method="GET" action="{{ route('menu.index') }}" class="grid md:grid-cols-[1fr_auto] gap-3 items-stretch">
                {{-- Search --}}
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-cocoa-400"></i>
                    <input
                        type="text" name="search" x-model="q"
                        value="{{ $search ?? '' }}"
                        placeholder="Search for a dish (e.g. Biriyani, Juice…)"
                        class="input pl-11 pr-12">
                    <button x-show="q.length > 0" x-cloak type="button" @click="q=''; $el.form.submit()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 h-8 w-8 rounded-full hover:bg-cream-200 grid place-items-center text-cocoa-500">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>
                {{-- Hidden category preserved --}}
                @if ($activeCategory)<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
                <button class="btn-primary !py-3 !px-7">
                    <i class="fa-solid fa-magnifying-glass"></i>Search
                </button>
            </form>

            {{-- Category pills --}}
            <div class="flex flex-wrap items-center gap-2 mt-5">
                <a href="{{ route('menu.index', array_filter(['search' => $search])) }}"
                   class="px-4 py-2 rounded-full text-sm font-semibold border transition
                          {{ ! $activeCategory ? 'bg-red-gradient text-white border-transparent shadow-soft' : 'bg-white text-cocoa-700 border-cocoa-200 hover:border-signature-500 hover:text-signature-500' }}">
                    All Items
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('menu.index', array_filter(['category' => $cat, 'search' => $search])) }}"
                       class="px-4 py-2 rounded-full text-sm font-semibold border transition
                              {{ $activeCategory === $cat ? 'bg-red-gradient text-white border-transparent shadow-soft' : 'bg-white text-cocoa-700 border-cocoa-200 hover:border-signature-500 hover:text-signature-500' }}">
                        @switch($cat)
                            @case('Main Courses') <i class="fa-solid fa-bowl-rice mr-1"></i> @break
                            @case('Desserts')     <i class="fa-solid fa-ice-cream mr-1"></i> @break
                            @case('Beverages')    <i class="fa-solid fa-mug-hot mr-1"></i> @break
                        @endswitch
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Results header --}}
        <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
            <div>
                <h2 class="font-display text-2xl font-bold text-cocoa-900">
                    {{ $activeCategory ?? 'All Dishes' }}
                    @if ($search)<span class="text-cocoa-500 font-normal">· results for "{{ $search }}"</span>@endif
                </h2>
                <p class="text-sm text-cocoa-500 mt-1">{{ $products->count() }} {{ Str::plural('item', $products->count()) }} found</p>
            </div>
            @if ($search || $activeCategory)
                <a href="{{ route('menu.index') }}" class="btn-ghost !py-2 !px-4 text-sm"><i class="fa-solid fa-rotate-left"></i>Reset Filters</a>
            @endif
        </div>

        {{-- Product grid --}}
        @if ($products->isEmpty())
            <div class="card text-center py-20">
                <i class="fa-solid fa-utensils text-5xl text-cream-400 mb-4"></i>
                <h3 class="font-display text-2xl font-bold text-cocoa-900">No dishes found</h3>
                <p class="text-cocoa-500 mt-2">Try a different search or category.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-5 inline-flex"><i class="fa-solid fa-rotate-left"></i>Show All</a>
            </div>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($products as $product)
                    <a href="{{ route('menu.show', $product) }}" class="card card-hover group block overflow-hidden">
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700" loading="lazy">
                            <span class="absolute top-3 left-3 chip-gold !text-[10px]">{{ $product->category }}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-display font-bold text-cocoa-900 leading-tight">{{ $product->item_name }}</h3>
                            <p class="text-xs text-cocoa-500 mt-1.5 line-clamp-1">{{ $product->description }}</p>
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-cream-300">
                                <span class="text-lg font-bold text-signature-500">Rs. {{ number_format($product->price, 0) }}</span>
                                <span class="text-xs font-semibold text-cocoa-600 group-hover:text-signature-500 flex items-center gap-1">View <i class="fa-solid fa-arrow-right text-[10px]"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
