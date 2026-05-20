@extends('layouts.admin')

@section('title', 'Customer Orders')

@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Customer Orders</h1>
    <p class="text-cocoa-500 text-sm mt-1">All placed orders with items, addresses, and payment details.</p>
</div>

@if ($orders->isEmpty())
    <div class="card text-center py-16">
        <i class="fa-solid fa-bag-shopping text-5xl text-cream-400 mb-3"></i>
        <p class="text-cocoa-600">No orders placed yet.</p>
    </div>
@else
    <div class="space-y-5">
        @foreach ($orders as $order)
            <div class="card overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-cream-400 bg-cream-100">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-red-gradient grid place-items-center text-white shadow-soft font-bold">#{{ $order->id }}</div>
                        <div>
                            <div class="font-semibold text-cocoa-900">{{ $order->firstname }} {{ $order->lastname }}</div>
                            <div class="text-xs text-cocoa-500">{{ $order->phone }} · {{ $order->emailaddress }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-signature-500">Rs. {{ number_format($order->total_amount, 0) }}</div>
                        <div class="text-[11px] text-cocoa-500">{{ $order->created_at->format('M d, Y · h:i A') }}</div>
                    </div>
                </div>
                <div class="grid md:grid-cols-3 gap-0 border-b border-cream-400">
                    <div class="p-4 border-r border-cream-400">
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Billing</div>
                        <div class="text-sm mt-1 text-cocoa-800">{{ $order->billing_address ?: '—' }}</div>
                    </div>
                    <div class="p-4 border-r border-cream-400">
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Shipping</div>
                        <div class="text-sm mt-1 text-cocoa-800">{{ $order->shipping_address ?: '—' }}</div>
                    </div>
                    <div class="p-4">
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Payment</div>
                        <div class="text-sm mt-1 text-cocoa-800">{{ $order->payment->payment_method ?? '—' }}</div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-warm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $i)
                                <tr>
                                    <td>{{ $i->itemname }}</td>
                                    <td class="text-center">{{ $i->quantity }}</td>
                                    <td class="text-right">Rs. {{ number_format($i->price, 0) }}</td>
                                    <td class="text-right font-semibold">Rs. {{ number_format($i->total, 0) }}</td>
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
