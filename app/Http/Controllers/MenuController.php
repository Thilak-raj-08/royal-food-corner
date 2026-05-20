<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        $query = Product::query();
        if ($category && in_array($category, Product::CATEGORIES, true)) {
            $query->where('category', $category);
        }
        $products = $query->orderBy('category')->orderBy('item_name')->get();
        return view('user.menu', [
            'products' => $products,
            'activeCategory' => $category,
            'categories' => Product::CATEGORIES,
        ]);
    }

    public function show(Product $product)
    {
        return view('user.product-details', compact('product'));
    }
}
