@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<section class="bg-cream-200/40 border-b border-cream-500">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14 text-center">
        <span class="section-eyebrow">Your selection</span>
        <h1 class="section-title">Shopping <span class="accent">cart</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-6xl mx-auto px-4 lg:px-8">

        @if (empty($items))
            <div class="card text-center py-20">
                <i class="fa-solid fa-cart-shopping text-5xl text-cream-400 mb-5"></i>
                <h2 class="text-2xl font-display font-bold text-cocoa-900">Your cart is empty</h2>
                <p class="text-cocoa-600 mt-2">Browse our delicious menu and add something tasty.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-6 inline-flex"><i class="fa-solid fa-utensils"></i>Explore Menu</a>
            </div>
        @else
            {{-- Build a WhatsApp deep-link from cart items --}}
            @php
                $waPhone = '94701234567';
                $lines = ["*Royal Food Corner — Order Request*", ''];
                foreach ($items as $i) {
                    $lt = number_format($i['price'] * $i['qty'], 2);
                    $lines[] = "• {$i['pname']} × {$i['qty']} — Rs. {$lt}";
                }
                $lines[] = '';
                $lines[] = '*Total: Rs. ' . number_format($total, 2) . '*';
                $lines[] = '';
                $lines[] = 'Please confirm availability and delivery time.';
                $waMessage = rawurlencode(implode("\n", $lines));
                $waLink = "https://wa.me/{$waPhone}?text={$waMessage}";
            @endphp

            <div class="grid lg:grid-cols-[1fr_360px] gap-6">
                {{-- Items list --}}
                <div class="card overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="table-warm">
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
                                                    <div class="font-semibold text-cocoa-900">{{ $item['pname'] }}</div>
                                                    <div class="text-xs text-cocoa-500 mt-0.5">Rs. {{ number_format($item['price'], 0) }} each</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update') }}" method="POST" class="inline-flex items-center border-2 border-cocoa-200 rounded-xl overflow-hidden">
                                                @csrf
                                                <input type="hidden" name="key" value="{{ $key }}">
                                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="99"
                                                       class="w-14 bg-transparent border-0 text-center font-bold focus:ring-0"
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-right">Rs. {{ number_format($item['price'], 0) }}</td>
                                        <td class="text-right font-bold text-signature-500">Rs. {{ number_format($item['price'] * $item['qty'], 0) }}</td>
                                        <td class="text-right">
                                            <form action="{{ route('cart.destroy', $item['pid']) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-500 transition">
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

                {{-- Summary --}}
                <div>
                    <div class="card p-6 sticky top-32">
                        <h3 class="font-display text-xl font-bold text-cocoa-900">Order Summary</h3>
                        <div class="divider-gold mt-3"></div>

                        <div class="flex items-center justify-between mt-5 text-sm">
                            <span class="text-cocoa-600">Subtotal</span>
                            <span class="font-semibold">Rs. {{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-2 text-sm">
                            <span class="text-cocoa-600">Delivery</span>
                            <span class="text-emerald-600 font-semibold">Free</span>
                        </div>
                        <hr class="border-cream-400 my-4">
                        <div class="flex items-center justify-between text-lg">
                            <span class="font-bold text-cocoa-900">Total</span>
                            <span class="font-bold text-signature-500 text-2xl">Rs. {{ number_format($total, 0) }}</span>
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

                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn-whatsapp w-full mt-3">
                            <i class="fa-brands fa-whatsapp text-xl"></i>Order via WhatsApp
                        </a>

                        <p class="text-[11px] text-cocoa-500 text-center mt-4">
                            <i class="fa-solid fa-shield-halved text-signature-500"></i> Secure checkout
                        </p>

                        <a href="{{ route('menu.index') }}" class="text-center block text-sm font-semibold text-cocoa-700 hover:text-signature-500 mt-4">
                            <i class="fa-solid fa-arrow-left"></i> Continue shopping
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
