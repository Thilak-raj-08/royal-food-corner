<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Core metrics ───────────────────────────────────────────
        $productsCount  = Product::count();
        $messagesCount  = Contact::count();
        $ordersQuantity = (int) (OrderItem::sum('quantity') ?? 0);
        $ordersCount    = Order::count();
        $totalRevenue   = (float) (Order::sum('total_amount') ?? 0);
        $pendingReservations = Reservation::where('status', 'pending')->count();

        // ── Period comparison (this week vs last week) ─────────────
        $thisWeek = Order::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $lastWeek = Order::whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ])->count();
        $weeklyChange = $lastWeek > 0 ? round((($thisWeek - $lastWeek) / $lastWeek) * 100, 1) : ($thisWeek > 0 ? 100 : 0);

        // ── Revenue over last 7 days (for chart) ───────────────────
        $revenue7 = [];
        $orders7 = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);
            $revenue7[] = [
                'label' => $day->format('M j'),
                'value' => (float) Order::whereDate('created_at', $day)->sum('total_amount'),
            ];
            $orders7[] = [
                'label' => $day->format('M j'),
                'value' => (int) Order::whereDate('created_at', $day)->count(),
            ];
        }

        // ── Orders by category (top categories from items) ─────────
        $categoryStats = OrderItem::query()
            ->join('products', 'products.item_name', '=', 'order_items.itemname')
            ->select('products.category', DB::raw('SUM(order_items.quantity) as total'))
            ->groupBy('products.category')
            ->pluck('total', 'category')
            ->toArray();

        // ── Top 5 selling items ────────────────────────────────────
        $topItems = OrderItem::query()
            ->select('itemname', DB::raw('SUM(quantity) as qty_sold'), DB::raw('SUM(total) as revenue'))
            ->groupBy('itemname')
            ->orderByDesc('qty_sold')
            ->limit(5)
            ->get();

        // ── Recent activity ────────────────────────────────────────
        $recentOrders = Order::with('items')->latest()->limit(5)->get();
        $recentReservations = Reservation::latest()->limit(5)->get();
        $recentMessages = Contact::latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'productsCount', 'messagesCount', 'ordersQuantity', 'ordersCount',
            'totalRevenue', 'pendingReservations',
            'thisWeek', 'lastWeek', 'weeklyChange',
            'revenue7', 'orders7', 'categoryStats', 'topItems',
            'recentOrders', 'recentReservations', 'recentMessages'
        ));
    }
}
