@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="flex flex-wrap items-end justify-between gap-3 mb-8">
    <div>
        <h1 class="text-3xl md:text-4xl font-display font-bold">Dashboard</h1>
        <p class="text-white/60 text-sm mt-1">Welcome back, {{ auth('admin')->user()->username }}. Here's what's happening.</p>
    </div>
    <button type="button" data-modal="addProduct" onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="btn-primary">
        <i class="fa-solid fa-plus"></i>Add New Product
    </button>
</div>

{{-- METRICS --}}
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    @php $stats = [
        ['Products',    $productsCount,    'fa-bag-shopping', 'from-royal-500 to-royal-700'],
        ['Messages',    $messagesCount,    'fa-message',      'from-sky-500 to-sky-700'],
        ['Items Sold',  $ordersQuantity,   'fa-cart-shopping','from-emerald-500 to-emerald-700'],
        ['Orders',      $ordersCount,      'fa-receipt',      'from-gold-400 to-royal-500'],
    ]; @endphp
    @foreach ($stats as [$label, $value, $icon, $grad])
        <div class="glass-card">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-xs uppercase tracking-[0.2em] text-white/60">{{ $label }}</div>
                    <div class="text-3xl font-bold mt-2">{{ $value }}</div>
                </div>
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br {{ $grad }} grid place-items-center shadow-lg">
                    <i class="fa-solid {{ $icon }}"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="glass-card !p-0 overflow-hidden mb-8">
    <div class="flex items-center justify-between p-5 border-b border-white/10">
        <div>
            <h2 class="font-display text-xl font-bold">Total Revenue</h2>
            <p class="text-xs text-white/60">Across all orders to date</p>
        </div>
        <div class="text-3xl font-bold text-gold-400">Rs. {{ number_format($totalRevenue, 2) }}</div>
    </div>
</div>

{{-- PRODUCTS TABLE --}}
<div class="glass-card !p-0 overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-white/10">
        <h2 class="font-display text-xl font-bold"><i class="fa-solid fa-bag-shopping text-gold-400 mr-2"></i>Products</h2>
        <span class="chip"><i class="fa-solid fa-database text-gold-400"></i>{{ $products->count() }} items</span>
    </div>
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full">
            <thead class="bg-white/5">
                <tr class="text-left text-xs uppercase tracking-wider text-white/60">
                    <th class="px-5 py-3">Image</th>
                    <th class="px-5 py-3">Item Name</th>
                    <th class="px-5 py-3">Price</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Description</th>
                    <th class="px-5 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $p)
                    <tr class="border-t border-white/5 hover:bg-white/5 transition">
                        <td class="px-5 py-3"><img src="{{ $p->image_url }}" class="h-14 w-14 rounded-xl object-cover" alt=""></td>
                        <td class="px-5 py-3 font-medium">{{ $p->item_name }}</td>
                        <td class="px-5 py-3 text-gold-400 font-semibold">Rs. {{ number_format($p->price, 2) }}</td>
                        <td class="px-5 py-3"><span class="chip !text-[10px] !py-1">{{ $p->category }}</span></td>
                        <td class="px-5 py-3 text-xs text-white/70 max-w-xs"><div class="line-clamp-2">{{ $p->description }}</div></td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $p) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-500/15 hover:bg-sky-500/30 text-sky-300 mr-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="h-9 w-9 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-300"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-white/60">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ADD PRODUCT MODAL --}}
<div id="addProductModal" class="hidden fixed inset-0 z-50 grid place-items-center p-4 bg-black/60 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="glass-dark rounded-3xl p-6 max-w-lg w-full">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-display font-bold"><i class="fa-solid fa-plus text-gold-400 mr-2"></i>Add New Product</h3>
            <button onclick="document.getElementById('addProductModal').classList.add('hidden')" class="h-9 w-9 rounded-xl bg-white/10 hover:bg-white/20"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Image</label>
                <input type="file" name="image" accept="image/*" required class="mt-1 block w-full text-sm text-white/80 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-royal-500/30 file:text-white hover:file:bg-royal-500/50">
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Item Name</label>
                <input name="item_name" class="glass-input mt-1" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Price (Rs.)</label>
                    <input name="price" type="number" step="0.01" min="0" class="glass-input mt-1" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Category</label>
                    <select name="category" class="glass-input mt-1" required>
                        <option value="" disabled selected>Choose…</option>
                        <option value="Main Courses">Main Courses</option>
                        <option value="Desserts">Desserts</option>
                        <option value="Beverages">Beverages</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Description</label>
                <textarea name="description" rows="3" class="glass-input mt-1" required></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="btn-ghost !py-2 !px-4">Cancel</button>
                <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-plus"></i>Add Product</button>
            </div>
        </form>
    </div>
</div>

@endsection
