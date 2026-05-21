<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items')->latest()->get();
        return view('user.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        $order->load('items', 'payment');
        return view('user.order-success', compact('order'));
    }

    public function destroyItem(OrderItem $item)
    {
        abort_unless($item->order->user_id === Auth::id(), 403);
        $item->delete();
        return redirect()->route('orders.index')->with('success', 'Order item cancelled.');
    }
}
