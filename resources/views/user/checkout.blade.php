@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-shadow-lg">Secure <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Checkout</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-3 gap-6">
            @csrf

            <div class="lg:col-span-2 space-y-6">
                {{-- Billing --}}
                <div class="glass-card">
                    <h3 class="text-2xl font-display font-bold mb-1"><i class="fa-solid fa-location-dot text-gold-400 mr-2"></i>Billing Details</h3>
                    <p class="text-sm text-white/60 mb-6">Where should we deliver your order?</p>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">First Name</label>
                            <input class="glass-input mt-1" name="firstname" value="{{ old('firstname', $order->firstname ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">Last Name</label>
                            <input class="glass-input mt-1" name="lastname" value="{{ old('lastname', $order->lastname ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">Phone</label>
                            <input class="glass-input mt-1" name="phone" value="{{ old('phone', $order->phone ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">Email</label>
                            <input class="glass-input mt-1" type="email" name="emailaddress" value="{{ old('emailaddress', $order->emailaddress ?? auth()->user()->email) }}" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-white/60">Billing Address</label>
                            <input class="glass-input mt-1" name="billing" value="{{ old('billing', $order->billing_address ?? '') }}" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-white/60">Shipping Address</label>
                            <input class="glass-input mt-1" name="shipping" value="{{ old('shipping', $order->shipping_address ?? '') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="glass-card">
                    <h3 class="text-2xl font-display font-bold mb-1"><i class="fa-solid fa-credit-card text-gold-400 mr-2"></i>Payment</h3>
                    <p class="text-sm text-white/60 mb-6">Your details are encrypted and never stored on our servers in plain text.</p>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-white/60">Method</label>
                            <select class="glass-input mt-1" name="paymentMethod" required>
                                <option value="Credit Card" {{ ($payment->payment_method ?? '') === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="Debit Card"  {{ ($payment->payment_method ?? '') === 'Debit Card'  ? 'selected' : '' }}>Debit Card</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider text-white/60">Card Number</label>
                            <input class="glass-input mt-1" name="creditCardNumber" placeholder="0000 0000 0000 0000" value="{{ old('creditCardNumber', $payment->credit_card_number ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">Expiration (MM/YY)</label>
                            <input class="glass-input mt-1" name="expirationDate" placeholder="MM/YY" value="{{ old('expirationDate', $payment->expiration_date ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider text-white/60">CVV</label>
                            <input class="glass-input mt-1" name="cvv" placeholder="•••" value="{{ old('cvv', $payment->cvv ?? '') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <aside class="space-y-6">
                <div class="glass-card sticky top-28">
                    <h3 class="text-xl font-display font-bold mb-4">Order Summary</h3>
                    <div class="space-y-3 max-h-72 overflow-y-auto scrollbar-thin pr-1">
                        @foreach ($items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <div class="font-medium">{{ $item['pname'] }}</div>
                                    <div class="text-xs text-white/60">× {{ $item['qty'] }}</div>
                                </div>
                                <div class="font-semibold">Rs. {{ number_format($item['price'] * $item['qty'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="border-white/15 my-4">
                    <div class="flex items-center justify-between text-sm text-white/75">
                        <span>Subtotal</span><span>Rs. {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-white/75 mt-2">
                        <span>Delivery</span><span class="text-emerald-300">Free</span>
                    </div>
                    <hr class="border-white/15 my-4">
                    <div class="flex items-center justify-between text-lg font-bold">
                        <span>Total</span><span class="text-gold-400">Rs. {{ number_format($total, 2) }}</span>
                    </div>
                    <button class="btn-primary w-full mt-5"><i class="fa-solid fa-lock"></i>Place Order</button>
                    <p class="text-[10px] text-white/50 mt-3 text-center">By placing this order you agree to our terms & conditions.</p>
                </div>
            </aside>
        </form>
    </div>
</section>

@endsection
