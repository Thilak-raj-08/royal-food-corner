@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="flex flex-wrap items-end justify-between gap-3 mb-8">
    <div>
        <h1 class="text-3xl md:text-4xl font-display font-bold text-cocoa-900">Dashboard</h1>
        <p class="text-cocoa-500 text-sm mt-1">Welcome back, {{ auth('admin')->user()->username }} — here's what's happening today.</p>
    </div>
    <button onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="btn-primary">
        <i class="fa-solid fa-plus"></i>Add New Product
    </button>
</div>

{{-- METRICS --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
    @php $stats = [
        ['Products',    $productsCount,    'fa-bag-shopping', 'from-signature-500 to-signature-700'],
        ['Messages',    $messagesCount,    'fa-message',      'from-sky-500 to-sky-700'],
        ['Items Sold',  $ordersQuantity,   'fa-cart-shopping','from-emerald-500 to-emerald-700'],
        ['Orders',      $ordersCount,      'fa-receipt',      'from-gold-400 to-gold-600'],
    ]; @endphp
    @foreach ($stats as [$label, $value, $icon, $grad])
        <div class="card p-5">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs uppercase tracking-[0.2em] font-semibold text-cocoa-500">{{ $label }}</div>
                    <div class="text-3xl font-display font-bold text-cocoa-900 mt-2">{{ $value }}</div>
                </div>
                <div class="h-12 w-12 rounded-xl bg-gradient-to-br {{ $grad }} grid place-items-center text-white shadow-soft">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card p-6 mb-8 flex items-center justify-between">
    <div>
        <div class="text-xs uppercase tracking-[0.2em] font-semibold text-cocoa-500">Total revenue</div>
        <div class="text-4xl font-display font-bold text-signature-500 mt-2">Rs. {{ number_format($totalRevenue, 0) }}</div>
        <div class="text-xs text-cocoa-500 mt-1">Across all orders to date</div>
    </div>
    <div class="h-16 w-16 rounded-2xl bg-gold-gradient grid place-items-center text-cocoa-900 shadow-soft">
        <i class="fa-solid fa-sack-dollar text-2xl"></i>
    </div>
</div>

{{-- PRODUCTS TABLE --}}
<div class="card overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-cream-400 bg-cream-200/40">
        <h2 class="font-display text-xl font-bold text-cocoa-900"><i class="fa-solid fa-bag-shopping text-signature-500 mr-2"></i>Products</h2>
        <span class="chip"><i class="fa-solid fa-database"></i>{{ $products->count() }} items</span>
    </div>
    <div class="overflow-x-auto scrollbar-thin">
        <table class="table-warm">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $p)
                    <tr>
                        <td><img src="{{ $p->image_url }}" class="h-14 w-14 rounded-xl object-cover" alt=""></td>
                        <td class="font-semibold text-cocoa-900">{{ $p->item_name }}</td>
                        <td class="text-signature-500 font-bold">Rs. {{ number_format($p->price, 0) }}</td>
                        <td><span class="chip-gold !text-[10px]">{{ $p->category }}</span></td>
                        <td class="max-w-xs"><div class="text-xs text-cocoa-600 line-clamp-2">{{ $p->description }}</div></td>
                        <td class="text-right">
                            <div class="flex justify-end gap-1.5">
                                <a href="{{ route('admin.products.edit', $p) }}" class="h-9 w-9 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-600 grid place-items-center">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-600"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-cocoa-500">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ADD PRODUCT MODAL --}}
<div id="addProductModal" class="hidden fixed inset-0 z-50 grid place-items-center p-4 bg-cocoa-900/60 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="card p-7 max-w-lg w-full">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-display text-xl font-bold text-cocoa-900"><i class="fa-solid fa-plus text-signature-500 mr-2"></i>Add New Product</h3>
            <button onclick="document.getElementById('addProductModal').classList.add('hidden')" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300 text-cocoa-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Image</label>
                <input type="file" name="image" accept="image/*" required class="mt-1.5 block w-full text-sm text-cocoa-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-signature-100 file:text-signature-600 file:font-semibold hover:file:bg-signature-200">
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Item Name</label>
                <input name="item_name" class="input mt-1.5" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Price (Rs.)</label>
                    <input name="price" type="number" step="0.01" min="0" class="input mt-1.5" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Category</label>
                    <select name="category" class="input mt-1.5" required>
                        <option value="" disabled selected>Choose…</option>
                        <option value="Main Courses">Main Courses</option>
                        <option value="Desserts">Desserts</option>
                        <option value="Beverages">Beverages</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Description</label>
                <textarea name="description" rows="3" class="input mt-1.5" required></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="btn-ghost !py-2 !px-4">Cancel</button>
                <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-plus"></i>Add</button>
            </div>
        </form>
    </div>
</div>

@endsection
