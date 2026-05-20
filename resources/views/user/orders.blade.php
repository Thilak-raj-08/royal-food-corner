@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-16 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-shadow-lg">My <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Orders</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if ($orders->isEmpty())
            <div class="glass-card text-center py-20">
                <i class="fa-solid fa-box text-5xl text-white/25 mb-4"></i>
                <h2 class="text-2xl font-display font-bold">No orders yet</h2>
                <p class="text-white/70 mt-2">Place your first order from our menu.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary mt-6"><i class="fa-solid fa-utensils"></i>Browse Menu</a>
            </div>
        @else
            @foreach ($orders as $order)
                <div class="glass-card !p-0 overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 p-5 border-b border-white/10 bg-white/5">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center text-white shadow-glow">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div>
                                <div class="font-display font-bold">Order #{{ $order->id }}</div>
                                <div class="text-xs text-white/60">{{ $order->created_at->format('M d, Y · h:i A') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="chip text-emerald-200 !border-emerald-400/40"><i class="fa-solid fa-circle-check"></i>{{ ucfirst($order->status) }}</span>
                            <div class="text-xl font-bold text-gold-400">Rs. {{ number_format($order->total_amount, 2) }}</div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white/5">
                                <tr class="text-left text-xs uppercase tracking-wider text-white/60">
                                    <th class="px-5 py-3">Item</th>
                                    <th class="px-5 py-3 text-center">Qty</th>
                                    <th class="px-5 py-3 text-right">Price</th>
                                    <th class="px-5 py-3 text-right">Total</th>
                                    <th class="px-5 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="border-t border-white/5">
                                        <td class="px-5 py-3">{{ $item->itemname }}</td>
                                        <td class="px-5 py-3 text-center">{{ $item->quantity }}</td>
                                        <td class="px-5 py-3 text-right">Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="px-5 py-3 text-right font-semibold">Rs. {{ number_format($item->total, 2) }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form action="{{ route('orders.item.destroy', $item) }}" method="POST" onsubmit="return confirm('Cancel this item?')">
                                                @csrf @method('DELETE')
                                                <button class="h-9 w-9 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-300">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
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
