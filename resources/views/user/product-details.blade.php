@extends('layouts.app')

@section('title', $product->item_name)

@section('content')

<section class="py-12">
    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        {{-- breadcrumb --}}
        <nav class="text-xs text-cocoa-500 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-signature-500">Home</a><span>/</span>
            <a href="{{ route('menu.index') }}" class="hover:text-signature-500">Menu</a><span>/</span>
            <a href="{{ route('menu.index', ['category' => $product->category]) }}" class="hover:text-signature-500">{{ $product->category }}</a><span>/</span>
            <span class="text-cocoa-900 font-semibold">{{ $product->item_name }}</span>
        </nav>

        <div class="card overflow-hidden grid md:grid-cols-2">
            <div class="relative aspect-square md:aspect-auto bg-cream-200">
                <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}"
                     class="w-full h-full object-cover">
                <span class="absolute top-5 left-5 chip-gold"><i class="fa-solid fa-tag"></i>{{ $product->category }}</span>
            </div>

            <div class="p-7 md:p-10 flex flex-col">
                <h1 class="font-display text-4xl md:text-5xl font-bold text-cocoa-900 leading-tight">{{ $product->item_name }}</h1>

                <div class="mt-4 flex items-center gap-4">
                    <span class="text-3xl font-bold text-signature-500">Rs. {{ number_format($product->price, 0) }}</span>
                    <div class="text-gold-400 text-sm flex gap-0.5">
                        @for ($i = 0; $i < 4; $i++)<i class="fa-solid fa-star"></i>@endfor
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>

                <div class="mt-4"><x-product-badges :product="$product" size="lg" /></div>

                <hr class="border-cream-400 my-6">

                <p class="text-cocoa-700 leading-relaxed">{{ $product->description }}</p>

                <ul class="mt-6 grid grid-cols-1 gap-2 text-sm">
                    @php $perks = [
                        ['fa-leaf', 'Freshly prepared on order'],
                        ['fa-mortar-pestle', 'Authentic Indo-Sri Lankan recipe'],
                        ['fa-circle-check', 'Halal & hygiene certified'],
                    ]; @endphp
                    @foreach ($perks as [$ic, $txt])
                        <li class="flex items-center gap-2 text-cocoa-700">
                            <i class="fa-solid {{ $ic }} text-signature-500 w-5 text-center"></i>{{ $txt }}
                        </li>
                    @endforeach
                </ul>

                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto pt-8" x-data="{ qty: 1 }">
                    @csrf
                    <div class="flex items-center gap-4 mb-5">
                        <label class="text-sm font-semibold text-cocoa-700">Quantity</label>
                        <div class="flex items-center border-2 border-cocoa-200 rounded-xl overflow-hidden">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" class="px-4 py-2.5 text-cocoa-700 hover:bg-cream-100 font-bold">−</button>
                            <input type="number" name="qty" x-model="qty" min="1" max="99" class="w-14 bg-transparent border-0 text-center font-bold focus:ring-0">
                            <button type="button" @click="qty = Math.min(99, qty + 1)" class="px-4 py-2.5 text-cocoa-700 hover:bg-cream-100 font-bold">+</button>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="btn-primary flex-1"><i class="fa-solid fa-cart-plus"></i>Add to Cart</button>
                        <a href="{{ route('menu.index') }}" class="btn-ghost">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
