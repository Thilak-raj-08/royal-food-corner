@extends('layouts.app')

@section('title', 'Gallery')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <span class="chip mb-4"><i class="fa-solid fa-images text-gold-400"></i>Our Visual Journey</span>
        <h1 class="text-5xl md:text-6xl font-bold text-shadow-lg">Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Gallery</span></h1>
    </div>
</section>

<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($images->isEmpty())
            <div class="glass-card text-center py-16">
                <i class="fa-regular fa-images text-4xl text-white/30 mb-3"></i>
                <p class="text-white/70">No gallery images yet.</p>
            </div>
        @else
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
                @foreach ($images as $img)
                    <div class="break-inside-avoid overflow-hidden rounded-2xl glass !p-0 group">
                        <img src="{{ $img->image_url }}" alt=""
                             class="w-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
