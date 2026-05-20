@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')

<div class="flex flex-wrap items-end justify-between gap-3 mb-8">
    <div>
        <h1 class="text-3xl md:text-4xl font-display font-bold">Gallery</h1>
        <p class="text-white/60 text-sm mt-1">Upload and manage gallery images shown on the public site.</p>
    </div>
    <button onclick="document.getElementById('addImageModal').classList.remove('hidden')" class="btn-primary">
        <i class="fa-solid fa-plus"></i>Add Image
    </button>
</div>

@if ($images->isEmpty())
    <div class="glass-card text-center py-16">
        <i class="fa-regular fa-images text-4xl text-white/30 mb-3"></i>
        <p class="text-white/70">No gallery images yet.</p>
    </div>
@else
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach ($images as $img)
            <div class="glass-card !p-2 group relative overflow-hidden">
                <img src="{{ $img->image_url }}" alt="" class="w-full h-44 object-cover rounded-2xl">
                <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')"
                      class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition">
                    @csrf @method('DELETE')
                    <button class="h-10 w-10 rounded-xl bg-rose-500/90 hover:bg-rose-500 text-white shadow-lg">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
                <div class="text-xs text-white/60 truncate mt-2 px-1">{{ $img->image }}</div>
            </div>
        @endforeach
    </div>
@endif

{{-- ADD IMAGE MODAL --}}
<div id="addImageModal" class="hidden fixed inset-0 z-50 grid place-items-center p-4 bg-black/60 backdrop-blur-sm" onclick="if(event.target===this)this.classList.add('hidden')">
    <div class="glass-dark rounded-3xl p-6 max-w-md w-full">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-xl font-display font-bold"><i class="fa-solid fa-image text-gold-400 mr-2"></i>Upload Image</h3>
            <button onclick="document.getElementById('addImageModal').classList.add('hidden')" class="h-9 w-9 rounded-xl bg-white/10 hover:bg-white/20"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Image File</label>
                <input type="file" name="image" accept="image/*" required class="mt-1 block w-full text-sm text-white/80 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-royal-500/30 file:text-white hover:file:bg-royal-500/50">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('addImageModal').classList.add('hidden')" class="btn-ghost !py-2 !px-4">Cancel</button>
                <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-upload"></i>Upload</button>
            </div>
        </form>
    </div>
</div>

@endsection
