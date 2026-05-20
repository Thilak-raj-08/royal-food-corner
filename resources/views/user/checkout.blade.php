@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<section class="bg-cream-200/40 border-b border-cream-500">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14 text-center">
        <span class="section-eyebrow">Final step</span>
        <h1 class="section-title">Secure <span class="accent">checkout</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <form action="{{ route('checkout.store') }}" method="POST" class="grid lg:grid-cols-[1fr_360px] gap-6">
            @csrf

            <div class="space-y-6">
                {{-- Billing --}}
                <div class="card p-7">
                    <h3 class="font-display text-2xl font-bold text-cocoa-900 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-signature-500"></i>Billing Details
                    </h3>
                    <p class="text-sm text-cocoa-500 mt-1 mb-6">Where should we deliver your order?</p>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">First Name</label>
                            <input class="input mt-1.5" name="firstname" value="{{ old('firstname', $order->firstname ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Last Name</label>
                            <input class="input mt-1.5" name="lastname" value="{{ old('lastname', $order->lastname ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Phone</label>
                            <input class="input mt-1.5" name="phone" value="{{ old('phone', $order->phone ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Email</label>
                            <input class="input mt-1.5" type="email" name="emailaddress" value="{{ old('emailaddress', $order->emailaddress ?? auth()->user()->email) }}" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Billing Address</label>
                            <input class="input mt-1.5" name="billing" value="{{ old('billing', $order->billing_address ?? '') }}" required>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Shipping Address</label>
                            <input class="input mt-1.5" name="shipping" value="{{ old('shipping', $order->shipping_address ?? '') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="card p-7">
                    <h3 class="font-display text-2xl font-bold text-cocoa-900 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-signature-500"></i>Payment
                    </h3>
                    <p class="text-sm text-cocoa-500 mt-1 mb-6">Your details are encrypted and never stored in plain text.</p>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Payment Method</label>
                            <select class="input mt-1.5" name="paymentMethod" required>
                                <option value="Credit Card" {{ ($payment->payment_method ?? '') === 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="Debit Card"  {{ ($payment->payment_method ?? '') === 'Debit Card'  ? 'selected' : '' }}>Debit Card</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Card Number</label>
                            <input class="input mt-1.5" name="creditCardNumber" placeholder="0000 0000 0000 0000" value="{{ old('creditCardNumber', $payment->credit_card_number ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Expiration (MM/YY)</label>
                            <input class="input mt-1.5" name="expirationDate" placeholder="MM/YY" value="{{ old('expirationDate', $payment->expiration_date ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">CVV</label>
                            <input class="input mt-1.5" name="cvv" placeholder="•••" value="{{ old('cvv', $payment->cvv ?? '') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <aside>
                <div class="card p-6 sticky top-32">
                    <h3 class="font-display text-xl font-bold text-cocoa-900">Order Summary</h3>
                    <div class="divider-gold mt-3"></div>

                    <div class="mt-5 space-y-3 max-h-72 overflow-y-auto scrollbar-thin pr-1">
                        @foreach ($items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <div class="font-semibold text-cocoa-900">{{ $item['pname'] }}</div>
                                    <div class="text-xs text-cocoa-500">× {{ $item['qty'] }}</div>
                                </div>
                                <div class="font-bold text-cocoa-900">Rs. {{ number_format($item['price'] * $item['qty'], 0) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <hr class="border-cream-400 my-4">
                    <div class="flex items-center justify-between text-sm text-cocoa-600">
                        <span>Subtotal</span><span class="font-semibold text-cocoa-900">Rs. {{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-sm text-cocoa-600">
                        <span>Delivery</span><span class="text-emerald-600 font-semibold">Free</span>
                    </div>
                    <hr class="border-cream-400 my-4">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-cocoa-900">Total</span>
                        <span class="font-bold text-signature-500 text-2xl">Rs. {{ number_format($total, 0) }}</span>
                    </div>
                    <button class="btn-primary w-full mt-5"><i class="fa-solid fa-lock"></i>Place Order</button>
                    <p class="text-[10px] text-cocoa-500 mt-3 text-center">By placing this order you agree to our terms.</p>
                </div>
            </aside>
        </form>
    </div>
</section>

@endsection
