@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-cocoa-900/80 via-cocoa-900/60 to-cream-100"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-20 text-center text-white">
        <span class="text-gold-400 font-script text-2xl">Our visual journey</span>
        <h1 class="text-5xl md:text-6xl font-display font-bold text-shadow-lg">Photo <span class="text-gold-400">Gallery</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        @if ($images->isEmpty())
            <div class="card text-center py-20">
                <i class="fa-regular fa-images text-5xl text-cream-400 mb-4"></i>
                <p class="text-cocoa-600">No gallery images yet.</p>
            </div>
        @else
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @foreach ($images as $img)
                    <div class="break-inside-avoid overflow-hidden rounded-2xl shadow-soft hover:shadow-soft-lg transition group cursor-pointer bg-white">
                        <img src="{{ $img->image_url }}" alt=""
                             class="w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
