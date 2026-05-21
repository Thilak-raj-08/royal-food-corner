@extends('layouts.app')

@section('title', 'Order Confirmed · #' . $order->id)

@section('content')

@php
    $statusFlow = ['pending', 'preparing', 'ready', 'delivered'];
    $statusIdx = array_search($order->status, $statusFlow);
    $statusIdx = $statusIdx === false ? 0 : $statusIdx;

    $statusLabels = [
        'pending'   => ['icon' => 'fa-circle-check',   'label' => 'Order Placed',  'note' => 'We received your order'],
        'preparing' => ['icon' => 'fa-fire-burner',    'label' => 'Preparing',     'note' => 'Chef is cooking your meal'],
        'ready'     => ['icon' => 'fa-bell-concierge', 'label' => 'Ready',         'note' => 'Out for delivery / ready for pickup'],
        'delivered' => ['icon' => 'fa-check-double',   'label' => 'Delivered',     'note' => 'Enjoy your meal!'],
    ];
@endphp

<section class="py-12 print:py-4">

    <div class="max-w-3xl mx-auto px-4 lg:px-8">

        {{-- Hero confirmation --}}
        <div class="card overflow-hidden print:shadow-none print:border print:border-cocoa-300">
            <div class="bg-red-gradient text-white text-center py-10 px-6 relative print:bg-cocoa-900">
                <div class="h-20 w-20 mx-auto rounded-full bg-white text-signature-500 grid place-items-center text-4xl shadow-soft-lg animate-pulse-soft print:animate-none">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <h1 class="font-display text-4xl md:text-5xl font-bold mt-5">Thank you!</h1>
                <p class="text-cream-100/90 mt-2">Your order has been placed successfully.</p>
                <div class="mt-5 inline-block bg-white/10 border border-white/20 rounded-xl px-5 py-3 backdrop-blur">
                    <div class="text-[10px] uppercase tracking-[0.3em] text-gold-300">Order Number</div>
                    <div class="font-display text-2xl font-bold mt-1">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>

            {{-- Status timeline --}}
            <div class="p-6 md:p-8 border-b border-cream-400 print:hidden">
                <h2 class="font-display text-xl font-bold text-cocoa-900 flex items-center gap-2 mb-6">
                    <i class="fa-solid fa-route text-signature-500"></i>Order Status
                </h2>
                <div class="relative">
                    {{-- progress line --}}
                    <div class="absolute top-5 left-5 right-5 h-1 bg-cream-300 rounded-full -z-0"></div>
                    <div class="absolute top-5 left-5 h-1 bg-red-gradient rounded-full -z-0 transition-all"
                         style="width: calc({{ ($statusIdx / max(1, count($statusFlow) - 1)) * 100 }}% - 1rem)"></div>

                    <div class="relative grid grid-cols-4 gap-2">
                        @foreach ($statusFlow as $idx => $key)
                            @php $s = $statusLabels[$key]; $done = $idx <= $statusIdx; @endphp
                            <div class="text-center">
                                <div class="mx-auto h-10 w-10 rounded-full grid place-items-center text-sm font-bold relative z-10
                                    {{ $done ? 'bg-red-gradient text-white shadow-soft' : 'bg-cream-200 text-cocoa-400 border-2 border-cream-400' }}">
                                    <i class="fa-solid {{ $s['icon'] }}"></i>
                                </div>
                                <div class="mt-2 text-[10px] sm:text-xs font-semibold uppercase tracking-wider {{ $done ? 'text-cocoa-900' : 'text-cocoa-400' }}">{{ $s['label'] }}</div>
                                <div class="text-[10px] text-cocoa-500 mt-0.5 hidden sm:block">{{ $s['note'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Receipt body --}}
            <div class="p-6 md:p-8" id="receipt">
                <div class="grid sm:grid-cols-2 gap-4 mb-6">
                    <div class="card-warm p-4">
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Delivery Address</div>
                        <div class="font-semibold text-cocoa-900 mt-1">{{ $order->firstname }} {{ $order->lastname }}</div>
                        <div class="text-sm text-cocoa-700 mt-1.5">{{ $order->shipping_address }}</div>
                        <div class="text-xs text-cocoa-500 mt-2">
                            <i class="fa-solid fa-phone"></i> {{ $order->phone }}<br>
                            <i class="fa-solid fa-envelope"></i> {{ $order->emailaddress }}
                        </div>
                    </div>
                    <div class="card-warm p-4">
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Order Details</div>
                        <div class="text-sm text-cocoa-700 mt-2 space-y-1.5">
                            <div class="flex justify-between"><span>Order #</span><span class="font-semibold text-cocoa-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></div>
                            <div class="flex justify-between"><span>Date</span><span class="font-semibold text-cocoa-900">{{ $order->created_at->format('M d, Y') }}</span></div>
                            <div class="flex justify-between"><span>Time</span><span class="font-semibold text-cocoa-900">{{ $order->created_at->format('h:i A') }}</span></div>
                            <div class="flex justify-between"><span>Payment</span><span class="font-semibold text-cocoa-900">{{ $order->payment->payment_method ?? '—' }}</span></div>
                            <div class="flex justify-between"><span>Items</span><span class="font-semibold text-cocoa-900">{{ $order->items->count() }}</span></div>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border-2 border-dashed border-cream-400 overflow-hidden">
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
                                    <td class="font-semibold text-cocoa-900">{{ $i->itemname }}</td>
                                    <td class="text-center">{{ $i->quantity }}</td>
                                    <td class="text-right">Rs. {{ number_format($i->price, 0) }}</td>
                                    <td class="text-right font-bold">Rs. {{ number_format($i->total, 0) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-cream-100">
                                <td colspan="3" class="text-right font-semibold text-cocoa-700">Subtotal</td>
                                <td class="text-right font-semibold">Rs. {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                            <tr class="bg-cream-100">
                                <td colspan="3" class="text-right font-semibold text-cocoa-700">Delivery</td>
                                <td class="text-right text-emerald-600 font-semibold">Free</td>
                            </tr>
                            <tr class="bg-red-gradient text-white">
                                <td colspan="3" class="text-right font-display text-xl font-bold">Total</td>
                                <td class="text-right font-display text-2xl font-bold">Rs. {{ number_format($order->total_amount, 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 p-4 rounded-xl bg-cream-100 border border-cream-400 text-center text-sm text-cocoa-700">
                    <p><i class="fa-solid fa-circle-info text-signature-500"></i> A confirmation has been sent to <strong>{{ $order->emailaddress }}</strong>. We'll call you on <strong>{{ $order->phone }}</strong> if needed.</p>
                </div>
            </div>

            {{-- Actions (hidden on print) --}}
            <div class="p-6 md:p-8 border-t border-cream-400 bg-cream-100 print:hidden">
                <div class="grid sm:grid-cols-3 gap-3">
                    <button onclick="window.print()" class="btn-ghost"><i class="fa-solid fa-print"></i>Print Receipt</button>
                    <a href="{{ route('orders.index') }}" class="btn-dark"><i class="fa-solid fa-box"></i>My Orders</a>
                    <a href="{{ route('menu.index') }}" class="btn-primary"><i class="fa-solid fa-utensils"></i>Order Again</a>
                </div>
                @php $waPhone = '94701234567'; @endphp
                <a href="https://wa.me/{{ $waPhone }}?text=Hi%2C+I+placed+order+%23{{ $order->id }}+and+have+a+question" target="_blank" class="btn-whatsapp w-full mt-3">
                    <i class="fa-brands fa-whatsapp text-xl"></i>Need help? Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<style>
@media print {
    body { background: white !important; }
    header, footer, .alert, nav { display: none !important; }
}
</style>

@endsection
