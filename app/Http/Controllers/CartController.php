<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('user.cart', [
            'items' => Cart::items(),
            'total' => Cart::totalAmount(),
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => 'required|integer|min:1|max:99',
        ]);
        $added = Cart::add($product, (int) $data['qty']);

        return redirect()->route('cart.index')->with(
            $added ? 'success' : 'info',
            $added ? "{$product->item_name} added to cart." : "{$product->item_name} is already in your cart."
        );
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'key' => 'required|integer|min:0',
            'qty' => 'required|integer|min:1|max:99',
        ]);
        Cart::updateQty((int) $data['key'], (int) $data['qty']);
        return redirect()->route('cart.index');
    }

    public function destroy(int $pid)
    {
        Cart::remove($pid);
        return redirect()->route('cart.index')->with('info', 'Item removed.');
    }
}
