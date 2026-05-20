<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $category = $request->query('category');

        $query = Product::query();

        if ($category && in_array($category, Product::CATEGORIES, true)) {
            $query->where('category', $category);
        }
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->orderBy('category')->orderBy('item_name')->get();

        return view('user.menu', [
            'products'       => $products,
            'activeCategory' => $category,
            'search'         => $search,
            'categories'     => Product::CATEGORIES,
        ]);
    }

    public function show(Product $product)
    {
        return view('user.product-details', compact('product'));
    }
}
