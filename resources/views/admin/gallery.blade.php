@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')

<div class="flex flex-wrap items-end justify-between gap-3 mb-8">
    <div>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Gallery</h1>
        <p class="text-cocoa-500 text-sm mt-1">Upload and manage gallery images shown on the public site.</p>
    </div>
    <button onclick="document.getElementById('addImageModal').classList.remove('hidden')" class="btn-primary">
        <i class="fa-solid fa-plus"></i>Add Image
    </button>
</div>

@if ($images->isEmpty())
    <div class="card text-center py-16">
        <i class="fa-regular fa-images text-5xl text-cream-400 mb-3"></i>
        <p class="text-cocoa-600">No gallery images yet.</p>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach ($images as $img)
            <div class="card p-2 group relative overflow-hidden">
                <img src="{{ $img->image_url }}" alt="" class="w-full h-44 object-cover rounded-xl">
                <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')"
                      class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                    @csrf @method('DELETE')
                    <button class="h-10 w-10 rounded-xl bg-signature-500 hover:bg-signature-600 text-white shadow-soft"><i class="fa-solid fa-trash"></i></button>
                </form>
                <div class="text-xs text-cocoa-500 truncate mt-2 px-1">{{ $img->image }}</div>
            </div>
        @endforeach
    </div>
@endif

<div id="addImageModal" class="hidden fixed inset-0 z-50 grid place-items-center p-4 bg-cocoa-900/60 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="card p-7 max-w-md w-full">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-display text-xl font-bold text-cocoa-900"><i class="fa-solid fa-image text-signature-500 mr-2"></i>Upload Image</h3>
            <button onclick="document.getElementById('addImageModal').classList.add('hidden')" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Image File</label>
                <input type="file" name="image" accept="image/*" required class="mt-1.5 block w-full text-sm text-cocoa-700 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-signature-100 file:text-signature-600 file:font-semibold hover:file:bg-signature-200">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addImageModal').classList.add('hidden')" class="btn-ghost !py-2 !px-4">Cancel</button>
                <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-upload"></i>Upload</button>
            </div>
        </form>
    </div>
</div>

@endsection
