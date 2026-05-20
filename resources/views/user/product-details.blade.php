@extends('layouts.app')

@section('title', $product->item_name)

@section('content')

<section class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card !p-0 overflow-hidden grid md:grid-cols-2">
            <div class="relative aspect-square md:aspect-auto overflow-hidden">
                <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-tr from-royal-950/40 to-transparent"></div>
                <span class="absolute top-5 left-5 chip"><i class="fa-solid fa-tag text-gold-400"></i>{{ $product->category }}</span>
            </div>

            <div class="p-8 md:p-12 flex flex-col">
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">{{ $product->item_name }}</h1>

                <div class="mt-3 flex items-center gap-4">
                    <span class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">
                        Rs. {{ number_format($product->price, 2) }}
                    </span>
                    <div class="text-gold-400 text-sm">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                    </div>
                </div>

                <hr class="border-white/15 my-6">

                <p class="text-white/80 leading-relaxed">{{ $product->description }}</p>

                <ul class="mt-6 space-y-2 text-sm text-white/75">
                    <li><i class="fa-solid fa-check text-gold-400 mr-2"></i>Freshly prepared on order</li>
                    <li><i class="fa-solid fa-check text-gold-400 mr-2"></i>Authentic Indo-Sri Lankan recipe</li>
                    <li><i class="fa-solid fa-check text-gold-400 mr-2"></i>Halal & hygiene certified</li>
                </ul>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto pt-8">
                    @csrf
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-white/80 font-medium">Quantity</label>
                        <div x-data="{ qty: 1 }" class="flex items-center glass rounded-xl overflow-hidden">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-4 py-3 hover:bg-white/10">−</button>
                            <input type="number" name="qty" x-model="qty" min="1" max="99" class="w-16 bg-transparent border-0 text-center focus:ring-0 text-white">
                            <button type="button" @click="qty = Math.min(99, qty + 1)" class="px-4 py-3 hover:bg-white/10">+</button>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="btn-primary flex-1"><i class="fa-solid fa-cart-plus"></i>Add to Cart</button>
                        <a href="{{ route('menu.index') }}" class="btn-ghost">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
