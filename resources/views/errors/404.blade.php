@extends('layouts.app')

@section('title', '404 · Page Not Found')

@section('content')

<section class="min-h-[70vh] grid place-items-center px-4 py-16">
    <div class="text-center max-w-xl">
        <div class="relative inline-block">
            <div class="font-display text-[180px] md:text-[220px] leading-none font-black text-cream-300 select-none">404</div>
            <i class="fa-solid fa-bowl-food absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-7xl text-signature-500 animate-pulse-soft"></i>
        </div>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900 mt-4">Looks like this dish is off the menu</h1>
        <p class="text-cocoa-600 mt-3">The page you're looking for doesn't exist or has been moved. Don't worry — there's plenty of deliciousness elsewhere.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary"><i class="fa-solid fa-house"></i>Back to Home</a>
            <a href="{{ route('menu.index') }}" class="btn-ghost"><i class="fa-solid fa-utensils"></i>Explore Menu</a>
        </div>
    </div>
</section>

@endsection
