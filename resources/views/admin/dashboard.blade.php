@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>


{{-- ─── PAGE HEADER ─── --}}
<div class="flex flex-wrap items-end justify-between gap-3 mb-8">
    <div>
        <span class="text-xs uppercase tracking-[0.3em] font-semibold text-signature-500">Admin Dashboard</span>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900 mt-1">Welcome back, {{ auth('admin')->user()->username }}</h1>
        <p class="text-cocoa-500 text-sm mt-1">{{ now()->format('l, F jS Y') }} · Here's what's happening at Royal Food Corner.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="btn-ghost !py-2.5 !px-4 text-sm">
            <i class="fa-solid fa-bowl-food"></i>Manage Menu
        </a>
        <button @click="$dispatch('open-modal', 'addProduct')" class="btn-primary !py-2.5 !px-5 text-sm">
            <i class="fa-solid fa-plus"></i>Add Product
        </button>
    </div>
</div>

{{-- ─── METRIC CARDS ─── --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    @php
        $kpi = [
            ['Revenue',        'Rs. ' . number_format($totalRevenue, 0), 'fa-sack-dollar', 'from-emerald-500 to-emerald-700', 'text-emerald-600 bg-emerald-50'],
            ['Total Orders',   $ordersCount,                              'fa-receipt',     'from-signature-500 to-signature-700', 'text-signature-600 bg-signature-50'],
            ['Items Sold',     $ordersQuantity,                           'fa-cart-shopping','from-amber-500 to-amber-700',     'text-amber-600 bg-amber-50'],
            ['Products',       $productsCount,                            'fa-bowl-food',   'from-gold-400 to-gold-600',       'text-gold-700 bg-gold-50'],
            ['Reservations',   $pendingReservations,                      'fa-calendar-days','from-sky-500 to-sky-700',         'text-sky-600 bg-sky-50'],
            ['Messages',       $messagesCount,                            'fa-message',     'from-violet-500 to-violet-700',   'text-violet-600 bg-violet-50'],
        ];
    @endphp
    @foreach ($kpi as [$label, $value, $icon, $grad, $pill])
        <div class="card p-4">
            <div class="flex items-center justify-between mb-3">
                <div class="h-10 w-10 rounded-xl {{ $pill }} grid place-items-center text-base">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
                @if ($label === 'Total Orders')
                    @if ($weeklyChange > 0)
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">
                            <i class="fa-solid fa-arrow-trend-up"></i> {{ $weeklyChange }}%
                        </span>
                    @elseif ($weeklyChange < 0)
                        <span class="text-[10px] font-bold text-signature-600 bg-signature-50 px-1.5 py-0.5 rounded">
                            <i class="fa-solid fa-arrow-trend-down"></i> {{ abs($weeklyChange) }}%
                        </span>
                    @endif
                @endif
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-cocoa-500">{{ $label }}</div>
            <div class="text-2xl font-display font-bold text-cocoa-900 mt-1 leading-tight">{{ $value }}</div>
        </div>
    @endforeach
</div>

{{-- ─── CHARTS ROW ─── --}}
<div class="grid lg:grid-cols-3 gap-5 mb-6">
    {{-- Revenue chart --}}
    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="font-display text-xl font-bold text-cocoa-900">Revenue · Last 7 Days</h2>
                <p class="text-xs text-cocoa-500 mt-0.5">Daily order revenue (Rs.)</p>
            </div>
            <span class="chip-gold"><i class="fa-solid fa-chart-line"></i>Weekly trend</span>
        </div>
        <div class="h-64"><canvas id="revenueChart"></canvas></div>
    </div>

    {{-- Categories donut --}}
    <div class="card p-5">
        <h2 class="font-display text-xl font-bold text-cocoa-900">Top Categories</h2>
        <p class="text-xs text-cocoa-500 mt-0.5">Items sold by category</p>
        @if (count($categoryStats) > 0)
            <div class="h-64 grid place-items-center"><canvas id="categoryChart"></canvas></div>
        @else
            <div class="h-64 grid place-items-center">
                <div class="text-center text-cocoa-400">
                    <i class="fa-regular fa-chart-pie text-4xl"></i>
                    <p class="text-sm mt-2">No category data yet</p>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ─── TOP ITEMS + RECENT ORDERS ─── --}}
<div class="grid lg:grid-cols-3 gap-5 mb-6">

    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-xl font-bold text-cocoa-900">Top Selling</h2>
            <span class="chip-red text-[10px]"><i class="fa-solid fa-fire"></i>Hot</span>
        </div>
        @if ($topItems->isEmpty())
            <div class="text-center py-8 text-cocoa-400">
                <i class="fa-solid fa-fire text-3xl"></i>
                <p class="text-sm mt-2">No sales yet</p>
            </div>
        @else
            <ol class="space-y-3">
                @foreach ($topItems as $idx => $item)
                    <li class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg grid place-items-center text-xs font-bold flex-shrink-0
                            {{ $idx === 0 ? 'bg-gold-gradient text-cocoa-900' : ($idx === 1 ? 'bg-cocoa-200 text-cocoa-800' : ($idx === 2 ? 'bg-amber-100 text-amber-800' : 'bg-cream-200 text-cocoa-600')) }}">
                            {{ $idx + 1 }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-cocoa-900 truncate">{{ $item->itemname }}</div>
                            <div class="text-[11px] text-cocoa-500">{{ $item->qty_sold }} sold</div>
                        </div>
                        <div class="text-sm font-bold text-signature-500">Rs.{{ number_format($item->revenue, 0) }}</div>
                    </li>
                @endforeach
            </ol>
        @endif
    </div>

    <div class="card p-5 lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-xl font-bold text-cocoa-900">Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-semibold text-signature-500 hover:underline">View all <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
        </div>
        @if ($recentOrders->isEmpty())
            <div class="text-center py-10 text-cocoa-400">
                <i class="fa-solid fa-receipt text-3xl"></i>
                <p class="text-sm mt-2">No orders yet</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach ($recentOrders as $order)
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-cream-100 transition">
                        <div class="h-10 w-10 rounded-lg bg-red-gradient grid place-items-center text-white text-xs font-bold flex-shrink-0">
                            #{{ $order->id }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-cocoa-900 truncate">{{ $order->firstname }} {{ $order->lastname }}</div>
                            <div class="text-[11px] text-cocoa-500">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} · {{ $order->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-signature-500">Rs.{{ number_format($order->total_amount, 0) }}</div>
                            <div class="text-[10px] text-cocoa-500 uppercase tracking-wider">{{ $order->status }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ─── RESERVATIONS + MESSAGES ─── --}}
<div class="grid lg:grid-cols-2 gap-5 mb-6">

    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-xl font-bold text-cocoa-900">Recent Reservations</h2>
            <a href="{{ route('admin.reservations.index') }}" class="text-xs font-semibold text-signature-500 hover:underline">View all <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
        </div>
        @if ($recentReservations->isEmpty())
            <div class="text-center py-8 text-cocoa-400">
                <i class="fa-solid fa-calendar-days text-3xl"></i>
                <p class="text-sm mt-2">No reservations yet</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($recentReservations as $r)
                    <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-cream-100 transition">
                        <div class="h-10 w-10 rounded-lg bg-gold-gradient grid place-items-center text-cocoa-900 flex-shrink-0">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-cocoa-900 truncate">{{ $r->name }}</div>
                            <div class="text-[11px] text-cocoa-500">
                                {{ \Carbon\Carbon::parse($r->reservation_date)->format('M d') }} ·
                                {{ \Carbon\Carbon::parse($r->reservation_time)->format('h:i A') }} ·
                                {{ $r->guests }} guests
                            </div>
                        </div>
                        @if ($r->status === 'confirmed')
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-1 rounded-md">Confirmed</span>
                        @elseif ($r->status === 'cancelled')
                            <span class="text-[10px] font-bold text-signature-700 bg-signature-50 px-2 py-1 rounded-md">Cancelled</span>
                        @else
                            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-md">Pending</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-xl font-bold text-cocoa-900">Recent Messages</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-signature-500 hover:underline">View all <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
        </div>
        @if ($recentMessages->isEmpty())
            <div class="text-center py-8 text-cocoa-400">
                <i class="fa-regular fa-message text-3xl"></i>
                <p class="text-sm mt-2">No messages yet</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($recentMessages as $m)
                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-cream-100 transition">
                        <div class="h-10 w-10 rounded-lg bg-violet-100 text-violet-600 grid place-items-center font-bold flex-shrink-0">
                            {{ strtoupper(substr($m->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <div class="text-sm font-semibold text-cocoa-900 truncate">{{ $m->name }}</div>
                                <div class="text-[11px] text-cocoa-500 flex-shrink-0">{{ $m->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-xs text-cocoa-600 mt-0.5 line-clamp-2">{{ $m->message }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ─── ADD PRODUCT MODAL ─── --}}
<x-admin-modal name="addProduct" title="Add New Product" icon="fa-plus" size="max-w-lg">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Image</label>
            <input type="file" name="image" accept="image/*" required class="mt-1.5 block w-full text-sm text-cocoa-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-signature-100 file:text-signature-600 file:font-semibold hover:file:bg-signature-200">
        </div>
        <div>
            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Item Name</label>
            <input name="item_name" class="input mt-1.5" required>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Price (Rs.)</label>
                <input name="price" type="number" step="0.01" min="0" class="input mt-1.5" required>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Category</label>
                <select name="category" class="input mt-1.5" required>
                    <option value="" disabled selected>Choose…</option>
                    <option value="Main Courses">Main Courses</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Beverages">Beverages</option>
                </select>
            </div>
        </div>
        <div>
            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Description</label>
            <textarea name="description" rows="3" class="input mt-1.5" required></textarea>
        </div>
        <div class="flex justify-end gap-2 pt-2">
            <button type="button" @click="open = false" class="btn-ghost !py-2 !px-4">Cancel</button>
            <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-plus"></i>Add Product</button>
        </div>
    </form>
</x-admin-modal>

{{-- ─── CHART.JS RENDER ─── --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cocoa = '#3D281F', gold = '#D4AF37', red = '#C8102E';

    // Revenue line chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: @json(array_column($revenue7, 'label')),
            datasets: [{
                label: 'Revenue',
                data: @json(array_column($revenue7, 'value')),
                fill: true,
                backgroundColor: 'rgba(200, 16, 46, 0.08)',
                borderColor: red,
                tension: 0.35,
                pointRadius: 4,
                pointBackgroundColor: red,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => 'Rs.' + v.toLocaleString() }, grid: { color: 'rgba(75,52,38,0.06)' } },
                x: { grid: { display: false } }
            }
        }
    });

    @if (count($categoryStats) > 0)
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($categoryStats)),
            datasets: [{
                data: @json(array_values($categoryStats)),
                backgroundColor: [red, gold, cocoa, '#F4505C', '#C19A2E'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '65%',
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, font: { size: 11, family: 'Inter' } } }
            }
        }
    });
    @endif
});
</script>

@endsection
