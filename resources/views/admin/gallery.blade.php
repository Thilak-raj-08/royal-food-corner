@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')

<div x-data="{ search: '', lightbox: null }">

    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Gallery</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $images->count() }} {{ Str::plural('image', $images->count()) }} on the public gallery page</p>
        </div>
        <div class="flex gap-2">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-cocoa-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Search file…" class="input pl-10 !py-2.5 text-sm w-56">
            </div>
            <button @click="$dispatch('open-modal', 'addImage')" class="btn-primary !py-2.5 !px-5 text-sm">
                <i class="fa-solid fa-cloud-arrow-up"></i>Upload
            </button>
        </div>
    </div>

    @if ($images->isEmpty())
        <div class="card text-center py-16">
            <i class="fa-regular fa-images text-5xl text-cream-400 mb-3"></i>
            <h2 class="font-display text-xl font-bold text-cocoa-900">No images yet</h2>
            <p class="text-cocoa-500 mt-2">Upload your first gallery photo.</p>
            <button @click="$dispatch('open-modal', 'addImage')" class="btn-primary mt-5 inline-flex">
                <i class="fa-solid fa-cloud-arrow-up"></i>Upload
            </button>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($images as $img)
                <div
                    x-show="search === '' || '{{ strtolower($img->image) }}'.includes(search.toLowerCase())"
                    class="card !p-1.5 group relative overflow-hidden">
                    <div class="aspect-square overflow-hidden rounded-xl cursor-pointer" @click="lightbox = '{{ $img->image_url }}'">
                        <img src="{{ $img->image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition flex gap-1.5">
                        <button @click="lightbox = '{{ $img->image_url }}'" class="h-9 w-9 rounded-lg bg-white/95 hover:bg-white text-cocoa-700 shadow-soft" title="View">
                            <i class="fa-solid fa-expand"></i>
                        </button>
                        <form action="{{ route('admin.gallery.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                            @csrf @method('DELETE')
                            <button class="h-9 w-9 rounded-lg bg-signature-500 hover:bg-signature-600 text-white shadow-soft" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    <div class="text-[10px] text-cocoa-500 truncate px-1 py-1.5">{{ $img->image }}</div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- LIGHTBOX --}}
    <div x-show="lightbox" x-cloak
         class="fixed inset-0 z-[70] bg-cocoa-900/95 grid place-items-center p-6"
         @click.self="lightbox = null"
         @keydown.escape.window="lightbox = null"
         x-transition.opacity>
        <button @click="lightbox = null" class="absolute top-5 right-5 h-12 w-12 rounded-full bg-white/10 hover:bg-white/20 text-white text-xl">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img :src="lightbox" class="max-w-[90vw] max-h-[85vh] rounded-2xl shadow-soft-lg">
    </div>
</div>

{{-- UPLOAD MODAL --}}
<x-admin-modal name="addImage" title="Upload Gallery Image" icon="fa-cloud-arrow-up" size="max-w-md">
    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4"
          x-data="{ preview: null }">
        @csrf

        {{-- Drop zone --}}
        <label class="block">
            <div class="border-2 border-dashed border-cream-500 rounded-xl p-8 text-center hover:border-signature-500 hover:bg-cream-100 cursor-pointer transition relative overflow-hidden">
                <template x-if="!preview">
                    <div>
                        <i class="fa-solid fa-cloud-arrow-up text-4xl text-signature-500"></i>
                        <div class="font-semibold text-cocoa-900 mt-3">Drop your image here</div>
                        <div class="text-xs text-cocoa-500 mt-1">or click to browse · JPEG, PNG, WEBP up to 4 MB</div>
                    </div>
                </template>
                <template x-if="preview">
                    <img :src="preview" class="w-full h-48 object-cover rounded-xl">
                </template>
            </div>
            <input type="file" name="image" accept="image/*" required class="hidden"
                   @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
        </label>

        <div class="flex justify-end gap-2 pt-2">
            <button type="button" @click="open = false" class="btn-ghost !py-2 !px-4">Cancel</button>
            <button class="btn-primary !py-2 !px-5"><i class="fa-solid fa-upload"></i>Upload</button>
        </div>
    </form>
</x-admin-modal>

@endsection
