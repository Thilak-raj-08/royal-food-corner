@extends('layouts.admin')

@section('title', 'Customer Orders')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl md:text-4xl font-display font-bold">Customer Orders</h1>
    <p class="text-white/60 text-sm mt-1">All placed orders with items and payment details.</p>
</div>

@if ($orders->isEmpty())
    <div class="glass-card text-center py-16">
        <i class="fa-solid fa-bag-shopping text-4xl text-white/30 mb-3"></i>
        <p class="text-white/70">No orders placed yet.</p>
    </div>
@else
    <div class="space-y-5">
        @foreach ($orders as $order)
            <div class="glass-card !p-0 overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-white/10 bg-white/5">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center shadow-glow">#{{ $order->id }}</div>
                        <div>
                            <div class="font-semibold">{{ $order->firstname }} {{ $order->lastname }}</div>
                            <div class="text-xs text-white/60">{{ $order->phone }} · {{ $order->emailaddress }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-xl font-bold text-gold-400">Rs. {{ number_format($order->total_amount, 2) }}</div>
                        <div class="text-[11px] text-white/60">{{ $order->created_at->format('M d, Y · h:i A') }}</div>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-0 border-b border-white/10">
                    <div class="p-4 border-r border-white/10">
                        <div class="text-[10px] uppercase tracking-wider text-white/50">Billing</div>
                        <div class="text-sm mt-1">{{ $order->billing_address ?: '—' }}</div>
                    </div>
                    <div class="p-4 border-r border-white/10">
                        <div class="text-[10px] uppercase tracking-wider text-white/50">Shipping</div>
                        <div class="text-sm mt-1">{{ $order->shipping_address ?: '—' }}</div>
                    </div>
                    <div class="p-4">
                        <div class="text-[10px] uppercase tracking-wider text-white/50">Payment</div>
                        <div class="text-sm mt-1">{{ $order->payment->payment_method ?? '—' }}</div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr class="text-xs uppercase tracking-wider text-white/60 text-left">
                                <th class="px-5 py-3">Item</th>
                                <th class="px-5 py-3 text-center">Qty</th>
                                <th class="px-5 py-3 text-right">Price</th>
                                <th class="px-5 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $i)
                                <tr class="border-t border-white/5">
                                    <td class="px-5 py-3">{{ $i->itemname }}</td>
                                    <td class="px-5 py-3 text-center">{{ $i->quantity }}</td>
                                    <td class="px-5 py-3 text-right">Rs. {{ number_format($i->price, 2) }}</td>
                                    <td class="px-5 py-3 text-right font-semibold">Rs. {{ number_format($i->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
