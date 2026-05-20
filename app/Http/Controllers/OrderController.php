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

    public function destroyItem(OrderItem $item)
    {
        abort_unless($item->order->user_id === Auth::id(), 403);
        $item->delete();
        return redirect()->route('orders.index')->with('success', 'Order item cancelled.');
    }
}
