<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::totalQty() === 0) {
            return redirect()->route('menu.index')->with('info', 'Your cart is empty.');
        }

        $lastOrder = Auth::user()?->orders()->latest()->first();
        return view('user.checkout', [
            'items'   => Cart::items(),
            'total'   => Cart::totalAmount(),
            'order'   => $lastOrder,
            'payment' => $lastOrder?->payment,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstname'        => 'required|string|max:50',
            'lastname'         => 'required|string|max:50',
            'phone'            => 'required|string|max:15',
            'emailaddress'     => 'required|email|max:100',
            'billing'          => 'required|string|max:255',
            'shipping'         => 'required|string|max:255',
            'paymentMethod'    => 'required|in:Credit Card,Debit Card',
            'creditCardNumber' => 'required|string|max:32',
            'expirationDate'   => 'required|string|max:7',
            'cvv'              => 'required|string|max:4',
        ]);

        if (Cart::totalQty() === 0) {
            return redirect()->route('menu.index')->with('error', 'Cart empty.');
        }

        $order = DB::transaction(function () use ($data) {
            $order = Order::create([
                'user_id'          => Auth::id(),
                'firstname'        => $data['firstname'],
                'lastname'         => $data['lastname'],
                'phone'            => $data['phone'],
                'emailaddress'     => $data['emailaddress'],
                'billing_address'  => $data['billing'],
                'shipping_address' => $data['shipping'],
                'total_amount'     => Cart::totalAmount(),
                'status'           => 'pending',
            ]);

            foreach (Cart::items() as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'itemname' => $item['pname'],
                    'quantity' => $item['qty'],
                    'price'    => $item['price'],
                    'total'    => $item['qty'] * $item['price'],
                ]);
            }

            Payment::create([
                'order_id'           => $order->id,
                'payment_method'     => $data['paymentMethod'],
                'credit_card_number' => $data['creditCardNumber'],
                'expiration_date'    => $data['expirationDate'],
                'cvv'                => $data['cvv'],
            ]);

            return $order;
        });

        Cart::clear();

        return redirect()->route('orders.index')->with('success', "Order #{$order->id} placed successfully!");
    }
}
