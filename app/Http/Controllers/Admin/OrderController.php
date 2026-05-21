<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const STATUSES = ['pending', 'preparing', 'ready', 'delivered', 'cancelled'];

    public function index()
    {
        $orders = Order::with(['items', 'payment', 'user'])->latest()->get();
        return view('admin.orders', ['orders' => $orders, 'statuses' => self::STATUSES]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', self::STATUSES),
        ]);
        $order->update($data);
        return back()->with('success', "Order #{$order->id} marked as {$data['status']}.");
    }
}
