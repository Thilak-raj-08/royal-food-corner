@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-shadow-lg">Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Cart</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (empty($items))
            <div class="glass-card text-center py-20">
                <i class="fa-solid fa-cart-shopping text-5xl text-white/25 mb-5"></i>
                <h2 class="text-2xl font-display font-bold">Your cart is empty</h2>
                <p class="text-white/70 mt-2">Browse our delicious menu and add something tasty.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-6"><i class="fa-solid fa-utensils"></i>Explore Menu</a>
            </div>
        @else
            <div class="glass-card !p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="glass-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $key => $item)
                                @php
                                    $imgPath = file_exists(public_path('storage/products/'.$item['image']))
                                        ? asset('storage/products/'.$item['image'])
                                        : asset('images/'.$item['image']);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-4">
                                            <img src="{{ $imgPath }}" class="h-16 w-16 rounded-xl object-cover" alt="">
                                            <div>
                                                <div class="font-semibold">{{ $item['pname'] }}</div>
                                                <div class="text-xs text-white/60 mt-1">Rs. {{ number_format($item['price'], 2) }} each</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center glass rounded-xl overflow-hidden">
                                            @csrf
                                            <input type="hidden" name="key" value="{{ $key }}">
                                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="99"
                                                   class="w-16 bg-transparent border-0 text-center text-white focus:ring-0"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="text-right">Rs. {{ number_format($item['price'], 2) }}</td>
                                    <td class="text-right font-semibold text-gold-400">Rs. {{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                    <td class="text-right">
                                        <form action="{{ route('cart.destroy', $item['pid']) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="h-9 w-9 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-300 transition">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mt-6">
                <div class="md:col-span-2 glass-card flex items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-lg">Need more?</h3>
                        <p class="text-sm text-white/70">Add more dishes before checking out.</p>
                    </div>
                    <a href="{{ route('menu.index') }}" class="btn-ghost"><i class="fa-solid fa-plus"></i>Add more</a>
                </div>
                <div class="glass-card">
                    <div class="flex items-center justify-between text-sm text-white/70">
                        <span>Subtotal</span><span>Rs. {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-white/70 mt-2">
                        <span>Delivery</span><span class="text-emerald-300">Free</span>
                    </div>
                    <hr class="border-white/15 my-3">
                    <div class="flex items-center justify-between text-lg font-bold">
                        <span>Total</span><span class="text-gold-400">Rs. {{ number_format($total, 2) }}</span>
                    </div>
                    @auth
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full mt-5">
                            Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary w-full mt-5">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>Login to Checkout
                        </a>
                    @endauth
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
