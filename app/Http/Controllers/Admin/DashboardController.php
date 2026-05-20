<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productsCount'  => Product::count(),
            'messagesCount'  => Contact::count(),
            'ordersQuantity' => (int) (OrderItem::sum('quantity') ?? 0),
            'ordersCount'    => Order::count(),
            'totalRevenue'   => (float) (Order::sum('total_amount') ?? 0),
            'products'       => Product::latest()->get(),
        ]);
    }
}
