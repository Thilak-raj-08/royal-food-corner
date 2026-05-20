<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::query()
            ->whereIn('item_name', ['Chicken Biriyani', 'Strawberry Cake', 'Watermelon Juice'])
            ->get();

        $highlights = Product::query()
            ->whereIn('category', ['Main Courses', 'Desserts', 'Beverages'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('user.home', compact('featured', 'highlights'));
    }
}
