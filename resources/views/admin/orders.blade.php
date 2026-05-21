@extends('layouts.admin')

@section('title', 'Customer Orders')

@section('content')

<div x-data="{ search: '' }">

    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Customer Orders</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $orders->count() }} {{ Str::plural('order', $orders->count()) }} · click any row to see full details</p>
        </div>
        <div class="flex gap-2 items-center">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-cocoa-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Search name, phone, email…" class="input pl-10 !py-2.5 text-sm w-72">
            </div>
        </div>
    </div>

    @if ($orders->isEmpty())
        <div class="card text-center py-16">
            <i class="fa-solid fa-bag-shopping text-5xl text-cream-400 mb-3"></i>
            <p class="text-cocoa-600">No orders placed yet.</p>
        </div>
    @else
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-warm">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Date</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr
                                x-show="
                                    search === '' ||
                                    '{{ strtolower($order->firstname . ' ' . $order->lastname) }}'.includes(search.toLowerCase()) ||
                                    '{{ strtolower($order->emailaddress ?? '') }}'.includes(search.toLowerCase()) ||
                                    '{{ $order->phone }}'.includes(search) ||
                                    '#{{ $order->id }}'.includes(search)
                                "
                                class="cursor-pointer" @click="$dispatch('open-modal', 'order-{{ $order->id }}')">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-red-gradient grid place-items-center text-white text-xs font-bold">#{{ $order->id }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="font-semibold text-cocoa-900">{{ $order->firstname }} {{ $order->lastname }}</div>
                                    <div class="text-xs text-cocoa-500">{{ $order->phone }}</div>
                                </td>
                                <td>
                                    <div class="text-sm text-cocoa-700">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</div>
                                    <div class="text-xs text-cocoa-500">{{ $order->items->pluck('itemname')->take(2)->join(', ') }}{{ $order->items->count() > 2 ? '…' : '' }}</div>
                                </td>
                                <td>
                                    <div class="text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-cocoa-500">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="text-right font-bold text-signature-500">Rs. {{ number_format($order->total_amount, 0) }}</td>
                                <td class="text-right">
                                    @php
                                        $statusColors = [
                                            'pending'   => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'preparing' => 'bg-sky-50 text-sky-700 border-sky-200',
                                            'ready'     => 'bg-violet-50 text-violet-700 border-violet-200',
                                            'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'cancelled' => 'bg-signature-50 text-signature-700 border-signature-200',
                                        ];
                                        $color = $statusColors[$order->status] ?? $statusColors['pending'];
                                    @endphp
                                    <div class="flex items-center justify-end gap-1.5">
                                        <span class="chip border {{ $color }} !text-[10px]">{{ ucfirst($order->status) }}</span>
                                        <button @click.stop="$dispatch('open-modal', 'order-{{ $order->id }}')" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300 text-cocoa-700">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- ─── ORDER DETAILS MODAL (one per order) ─── --}}
@foreach ($orders as $order)
    <x-admin-modal name="order-{{ $order->id }}" title="Order #{{ $order->id }}" icon="fa-receipt" size="max-w-3xl">
        <div class="space-y-5">

            {{-- Customer + Total --}}
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="card-warm p-4 sm:col-span-2">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Customer</div>
                    <div class="font-display text-lg font-bold text-cocoa-900 mt-1">{{ $order->firstname }} {{ $order->lastname }}</div>
                    <div class="text-sm text-cocoa-700 mt-2 space-y-1">
                        <div><i class="fa-solid fa-phone text-signature-500 w-4"></i> <a href="tel:{{ $order->phone }}" class="hover:underline">{{ $order->phone }}</a></div>
                        <div><i class="fa-solid fa-envelope text-signature-500 w-4"></i> <a href="mailto:{{ $order->emailaddress }}" class="hover:underline">{{ $order->emailaddress }}</a></div>
                    </div>
                </div>
                <div class="card-warm p-4 text-right">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Total</div>
                    <div class="text-3xl font-bold text-signature-500 mt-1">Rs.{{ number_format($order->total_amount, 0) }}</div>
                    <div class="text-[10px] text-cocoa-500 mt-1">{{ $order->created_at->format('M d, Y · h:i A') }}</div>
                </div>
            </div>

            {{-- Addresses & payment --}}
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="card-warm p-4">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500"><i class="fa-solid fa-location-dot text-signature-500 mr-1"></i>Billing</div>
                    <div class="text-sm text-cocoa-800 mt-2">{{ $order->billing_address ?: '—' }}</div>
                </div>
                <div class="card-warm p-4">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500"><i class="fa-solid fa-truck text-signature-500 mr-1"></i>Shipping</div>
                    <div class="text-sm text-cocoa-800 mt-2">{{ $order->shipping_address ?: '—' }}</div>
                </div>
                <div class="card-warm p-4">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500"><i class="fa-solid fa-credit-card text-signature-500 mr-1"></i>Payment</div>
                    <div class="text-sm text-cocoa-800 mt-2">{{ $order->payment->payment_method ?? '—' }}</div>
                </div>
            </div>

            {{-- Items --}}
            <div>
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-cocoa-500 mb-2">Items ({{ $order->items->count() }})</div>
                <div class="overflow-hidden rounded-xl border border-cream-400">
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
                            <tr class="bg-cream-100 font-bold">
                                <td colspan="3" class="text-right text-cocoa-800">Total</td>
                                <td class="text-right text-signature-500 text-lg">Rs. {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Status workflow --}}
            <div class="card-warm p-4">
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-cocoa-500 mb-3">Update Status</div>
                @php
                    $flow = [
                        'pending'   => ['fa-clock',          'text-amber-600 bg-amber-50 border-amber-200'],
                        'preparing' => ['fa-fire-burner',    'text-sky-600 bg-sky-50 border-sky-200'],
                        'ready'     => ['fa-bell-concierge', 'text-violet-600 bg-violet-50 border-violet-200'],
                        'delivered' => ['fa-check-double',   'text-emerald-600 bg-emerald-50 border-emerald-200'],
                        'cancelled' => ['fa-ban',            'text-signature-600 bg-signature-50 border-signature-200'],
                    ];
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                    @foreach ($flow as $key => [$icon, $color])
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="{{ $key }}">
                            <button class="w-full px-2 py-2.5 rounded-lg border-2 text-xs font-semibold transition flex flex-col items-center gap-1 {{ $order->status === $key ? $color . ' ring-2 ring-offset-1 ring-current' : 'border-cream-400 text-cocoa-500 hover:border-cocoa-400' }}">
                                <i class="fa-solid {{ $icon }} text-base"></i>
                                <span class="text-[10px] uppercase tracking-wider">{{ ucfirst($key) }}</span>
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center pt-3">
                <a href="tel:{{ $order->phone }}" class="btn-ghost !py-2 !px-4 text-sm"><i class="fa-solid fa-phone"></i>Call Customer</a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}" target="_blank" class="btn-whatsapp !py-2 !px-4 text-sm">
                    <i class="fa-brands fa-whatsapp"></i>WhatsApp
                </a>
            </div>
        </div>
    </x-admin-modal>
@endforeach

@endsection
