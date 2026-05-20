@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<section class="bg-cream-200/40 border-b border-cream-500">
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-14 text-center">
        <span class="section-eyebrow">Order history</span>
        <h1 class="section-title">My <span class="accent">orders</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-5xl mx-auto px-4 lg:px-8 space-y-5">

        @if ($orders->isEmpty())
            <div class="card text-center py-20">
                <i class="fa-solid fa-box text-5xl text-cream-400 mb-4"></i>
                <h2 class="text-2xl font-display font-bold text-cocoa-900">No orders yet</h2>
                <p class="text-cocoa-600 mt-2">Place your first order from our menu.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-6 inline-flex"><i class="fa-solid fa-utensils"></i>Browse Menu</a>
            </div>
        @else
            @foreach ($orders as $order)
                <div class="card overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-cream-400 bg-cream-100">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-red-gradient grid place-items-center text-white shadow-soft">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <div class="font-display font-bold text-cocoa-900">Order #{{ $order->id }}</div>
                                <div class="text-xs text-cocoa-500">{{ $order->created_at->format('M d, Y · h:i A') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="chip-gold"><i class="fa-solid fa-circle-check"></i>{{ ucfirst($order->status) }}</span>
                            <div class="text-2xl font-bold text-signature-500">Rs. {{ number_format($order->total_amount, 0) }}</div>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->itemname }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">Rs. {{ number_format($item->price, 0) }}</td>
                                        <td class="text-right font-semibold">Rs. {{ number_format($item->total, 0) }}</td>
                                        <td class="text-right">
                                            <form action="{{ route('orders.item.destroy', $item) }}" method="POST" onsubmit="return confirm('Cancel this item?')">
                                                @csrf @method('DELETE')
                                                <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-500"><i class="fa-solid fa-xmark"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</section>

@endsection
