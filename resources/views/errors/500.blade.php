@extends('layouts.app')

@section('title', '500 · Server Error')

@section('content')

<section class="min-h-[70vh] grid place-items-center px-4 py-16">
    <div class="text-center max-w-xl">
        <div class="font-display text-[180px] md:text-[220px] leading-none font-black text-cream-300 select-none">500</div>
        <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900 mt-4">Something burned in the kitchen</h1>
        <p class="text-cocoa-600 mt-3">An unexpected error occurred on our side. Our team has been notified — please try again in a moment.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('home') }}" class="btn-primary"><i class="fa-solid fa-house"></i>Back to Home</a>
            <button onclick="location.reload()" class="btn-ghost"><i class="fa-solid fa-rotate"></i>Try Again</button>
        </div>
    </div>
</section>

@endsection
