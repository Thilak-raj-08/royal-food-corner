@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="btn-icon"><i class="fa-solid fa-arrow-left"></i></a>
        <h1 class="font-display text-3xl font-bold text-cocoa-900">Edit Product</h1>
    </div>

    <div class="card p-7">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="flex items-center gap-5">
                <img src="{{ $product->image_url }}" class="h-24 w-24 rounded-2xl object-cover ring-2 ring-cream-400" alt="">
                <div class="flex-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Replace Image (optional)</label>
                    <input type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm text-cocoa-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-signature-100 file:text-signature-600 file:font-semibold hover:file:bg-signature-200">
                </div>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Item Name</label>
                <input name="item_name" value="{{ old('item_name', $product->item_name) }}" class="input mt-1.5" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Price</label>
                    <input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="input mt-1.5" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Category</label>
                    <select name="category" class="input mt-1.5" required>
                        @foreach (\App\Models\Product::CATEGORIES as $cat)
                            <option value="{{ $cat }}" {{ $product->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Description</label>
                <textarea name="description" rows="4" class="input mt-1.5" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.dashboard') }}" class="btn-ghost">Cancel</a>
                <button class="btn-primary"><i class="fa-solid fa-floppy-disk"></i>Update</button>
            </div>
        </form>
    </div>
</div>

@endsection
