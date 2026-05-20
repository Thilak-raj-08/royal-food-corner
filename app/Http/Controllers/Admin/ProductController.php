<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name'   => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        $data['image'] = $this->storeImage($request->file('image'));
        Product::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        return view('admin.product-edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'item_name'   => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $product->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Product deleted.');
    }

    private function storeImage($file): string
    {
        $name = Str::random(8) . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
        $file->storeAs('products', $name, 'public');
        return $name;
    }
}
