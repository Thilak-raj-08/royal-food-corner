@extends('layouts.admin')

@section('title', 'Products')

@section('content')

<div x-data="{ search: '', category: 'all', sort: 'default' }">

    {{-- HEADER --}}
    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Products</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $products->count() }} dishes on the menu</p>
        </div>
        <button @click="$dispatch('open-modal', 'addProduct')" class="btn-primary !py-2.5 !px-5 text-sm">
            <i class="fa-solid fa-plus"></i>Add Product
        </button>
    </div>

    {{-- TOOLBAR --}}
    <div class="card p-4 mb-5">
        <div class="grid md:grid-cols-[1fr_180px_160px] gap-3">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-cocoa-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Search by name or description…" class="input pl-10">
            </div>
            <select x-model="category" class="input">
                <option value="all">All Categories</option>
                <option value="Main Courses">Main Courses</option>
                <option value="Desserts">Desserts</option>
                <option value="Beverages">Beverages</option>
            </select>
            <select x-model="sort" class="input">
                <option value="default">Sort: Default</option>
                <option value="price-asc">Price: Low → High</option>
                <option value="price-desc">Price: High → Low</option>
                <option value="name-asc">Name: A → Z</option>
            </select>
        </div>
    </div>

    {{-- PRODUCT GRID --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach ($products as $p)
            <div
                x-show="
                    (category === 'all' || category === '{{ $p->category }}') &&
                    (search === '' ||
                        '{{ strtolower($p->item_name) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower(addslashes($p->description)) }}'.includes(search.toLowerCase()))
                "
                :data-price="{{ $p->price }}"
                :data-name="'{{ strtolower($p->item_name) }}'"
                class="card overflow-hidden group">
                <div class="relative aspect-[4/3] overflow-hidden bg-cream-200">
                    <img src="{{ $p->image_url }}" alt="{{ $p->item_name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <span class="absolute top-3 left-3 chip-gold !text-[10px]">{{ $p->category }}</span>
                </div>
                <div class="p-4">
                    <h3 class="font-display font-bold text-cocoa-900 truncate">{{ $p->item_name }}</h3>
                    <p class="text-xs text-cocoa-500 mt-1 line-clamp-2 min-h-[2.5rem]">{{ $p->description }}</p>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-cream-300">
                        <span class="text-lg font-bold text-signature-500">Rs. {{ number_format($p->price, 0) }}</span>
                        <div class="flex gap-1">
                            <button @click="$dispatch('open-modal', 'edit-{{ $p->id }}')"
                                    class="h-9 w-9 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-600" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('admin.products.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete &quot;{{ $p->item_name }}&quot;?')">
                                @csrf @method('DELETE')
                                <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-600" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if ($products->isEmpty())
        <div class="card text-center py-20">
            <i class="fa-solid fa-bowl-food text-5xl text-cream-400 mb-4"></i>
            <h2 class="font-display text-2xl font-bold text-cocoa-900">No products yet</h2>
            <p class="text-cocoa-500 mt-2">Add your first product to get started.</p>
            <button @click="$dispatch('open-modal', 'addProduct')" class="btn-primary mt-5 inline-flex">
                <i class="fa-solid fa-plus"></i>Add Product
            </button>
        </div>
    @endif

</div>

{{-- ─── ADD PRODUCT MODAL ─── --}}
<x-admin-modal name="addProduct" title="Add New Product" icon="fa-plus" size="max-w-lg">
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
            <button type="button" @click="open = false" class="btn-ghost !py-2 !px-4">Cancel</button>
            <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-plus"></i>Add</button>
        </div>
    </form>
</x-admin-modal>

{{-- ─── EDIT PRODUCT MODALS (one per product) ─── --}}
@foreach ($products as $p)
    <x-admin-modal name="edit-{{ $p->id }}" title="Edit Product" icon="fa-pen-to-square" size="max-w-lg">
        <form action="{{ route('admin.products.update', $p) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div class="flex items-center gap-4">
                <img src="{{ $p->image_url }}" class="h-20 w-20 rounded-xl object-cover ring-2 ring-cream-400" alt="">
                <div class="flex-1">
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Replace Image (optional)</label>
                    <input type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-xs text-cocoa-700 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-signature-100 file:text-signature-600 file:font-semibold hover:file:bg-signature-200">
                </div>
            </div>

            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Item Name</label>
                <input name="item_name" value="{{ $p->item_name }}" class="input mt-1.5" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Price</label>
                    <input name="price" type="number" step="0.01" value="{{ $p->price }}" class="input mt-1.5" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Category</label>
                    <select name="category" class="input mt-1.5" required>
                        @foreach (\App\Models\Product::CATEGORIES as $cat)
                            <option value="{{ $cat }}" {{ $p->category === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Description</label>
                <textarea name="description" rows="3" class="input mt-1.5" required>{{ $p->description }}</textarea>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="open = false" class="btn-ghost !py-2 !px-4">Cancel</button>
                <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-floppy-disk"></i>Update</button>
            </div>
        </form>
    </x-admin-modal>
@endforeach

@endsection
