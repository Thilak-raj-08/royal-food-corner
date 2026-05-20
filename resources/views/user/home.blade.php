@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- ─────── HERO ─────── --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-cocoa-900/85 via-cocoa-900/55 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-24 md:py-36">
        <div class="max-w-2xl text-cream-100">
            <span class="text-gold-400 font-script text-2xl">Welcome to</span>
            <h1 class="font-display text-5xl md:text-7xl font-bold leading-[1.05] mt-2 text-white">
                Royal Food <br><span class="text-gold-400">Corner</span>
            </h1>
            <div class="divider-gold mt-6"></div>
            <p class="mt-6 text-lg md:text-xl text-cream-200/90 max-w-xl leading-relaxed">
                Experience the timeless flavors of India and Sri Lanka — handcrafted recipes, fresh ingredients, unforgettable taste.
            </p>
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="{{ route('menu.index') }}" class="btn-primary text-base !py-3.5 !px-7">
                    <i class="fa-solid fa-bowl-food"></i>Explore Menu
                </a>
                <a href="{{ route('reservations.create') }}" class="btn-gold text-base !py-3.5 !px-7">
                    <i class="fa-solid fa-calendar-days"></i>Book a Table
                </a>
            </div>

            <div class="mt-14 flex flex-wrap gap-x-10 gap-y-4 text-cream-100">
                <div>
                    <div class="text-3xl font-display font-bold text-gold-400">30+</div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-cream-200/70 mt-1">Signature Dishes</div>
                </div>
                <div>
                    <div class="text-3xl font-display font-bold text-gold-400">10K+</div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-cream-200/70 mt-1">Happy Guests</div>
                </div>
                <div>
                    <div class="text-3xl font-display font-bold text-gold-400 flex items-center gap-2">4.9<i class="fa-solid fa-star text-2xl"></i></div>
                    <div class="text-[11px] uppercase tracking-[0.2em] text-cream-200/70 mt-1">Average Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─────── CATEGORY QUICK BOXES ─────── --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="text-center mb-10">
            <span class="section-eyebrow">Browse by category</span>
            <h2 class="section-title">What's on the <span class="accent">menu</span></h2>
        </div>
        @php
            $cats = [
                ['Main Courses', 'fa-bowl-rice', 'mc1.jpg', '15 dishes'],
                ['Desserts',     'fa-ice-cream', 'd1.jpg',  '6 dishes'],
                ['Beverages',    'fa-mug-hot',   'b9.jpg',  '9 dishes'],
            ];
        @endphp
        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($cats as [$name, $icon, $img, $count])
                <a href="{{ route('menu.index', ['category' => $name]) }}" class="card card-hover overflow-hidden group">
                    <div class="aspect-[16/10] overflow-hidden relative">
                        <img src="{{ asset('images/'.$img) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-cocoa-900/70 via-cocoa-900/10 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex items-end justify-between text-white">
                            <div>
                                <h3 class="font-display text-2xl font-bold">{{ $name }}</h3>
                                <p class="text-xs uppercase tracking-wider text-gold-300">{{ $count }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-white text-signature-500 grid place-items-center shadow-soft group-hover:bg-signature-500 group-hover:text-white transition">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ─────── FEATURED DISHES ─────── --}}
<section class="py-20 bg-cream-200/40 border-y border-cream-500">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="text-center mb-14">
            <span class="section-eyebrow">Chef's picks</span>
            <h2 class="section-title">Our <span class="accent">specials</span></h2>
            <p class="text-cocoa-600 mt-3 max-w-xl mx-auto">Our most loved creations — savor what makes Royal Food Corner unforgettable.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($featured as $product)
                <a href="{{ route('menu.show', $product) }}" class="card card-hover group block overflow-hidden">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <span class="absolute top-3 left-3 chip-gold">{{ $product->category }}</span>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-display font-bold text-cocoa-900">{{ $product->item_name }}</h3>
                        <p class="text-sm text-cocoa-600 mt-2 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-4 flex items-center justify-between pt-4 border-t border-cream-300">
                            <span class="text-xl font-bold text-signature-500">Rs. {{ number_format($product->price, 0) }}</span>
                            <span class="text-sm font-semibold text-cocoa-700 group-hover:text-signature-500 flex items-center gap-1">View <i class="fa-solid fa-arrow-right text-xs"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ─────── ABOUT ─────── --}}
<section id="about" class="py-24">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <img src="{{ asset('images/g1.jpg') }}" alt="" class="rounded-2xl shadow-soft-lg w-full aspect-[4/5] object-cover">
                <div class="absolute -bottom-6 -right-6 hidden md:block rounded-2xl bg-red-gradient text-white p-6 shadow-soft-lg max-w-[200px]">
                    <div class="text-4xl font-display font-bold">15+</div>
                    <div class="text-xs uppercase tracking-wider text-cream-100 mt-1">Years of Authentic Cooking</div>
                </div>
            </div>

            <div>
                <span class="section-eyebrow">Our story</span>
                <h2 class="section-title">A passion for <span class="accent">flavor</span></h2>
                <div class="divider-gold mt-4"></div>
                <p class="mt-6 text-cocoa-700 leading-relaxed">
                    Welcome to <strong>Royal Food Corner</strong> — your gateway to a culinary journey that blends the rich traditions of Indo-Sri Lankan cuisine with a modern touch. We're more than a restaurant; we're an experience that reflects the tapestry of flavors from India and Sri Lanka.
                </p>
                <p class="mt-4 text-cocoa-600 leading-relaxed">
                    Our journey began with a passion for creating delicious, authentic, and memorable dishes — committed to delighting our guests with traditional cuisine and modern innovations.
                </p>
                <div class="grid grid-cols-3 gap-3 mt-8">
                    @php $feats = [
                        ['fa-leaf', 'Fresh', 'Locally sourced'],
                        ['fa-mortar-pestle', 'Authentic', 'Real spices'],
                        ['fa-truck-fast', 'Quick', 'Fast delivery'],
                    ]; @endphp
                    @foreach ($feats as [$ic, $t, $s])
                        <div class="text-center card p-4">
                            <i class="fa-solid {{ $ic }} text-2xl text-signature-500"></i>
                            <div class="font-semibold text-cocoa-900 mt-2 text-sm">{{ $t }}</div>
                            <div class="text-[11px] text-cocoa-500 uppercase tracking-wider">{{ $s }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ─────── TESTIMONIALS ─────── --}}
<section class="py-20 bg-cream-200/40 border-y border-cream-500">
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="text-center mb-14">
            <span class="section-eyebrow">Testimonials</span>
            <h2 class="section-title">What our <span class="accent">guests say</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php $testimonials = [
                ['name'=>'Vijay',      'img'=>'cu1.jpg', 'text'=>'The food here is amazing! I can\'t get enough of their dishes. Highly recommended!'],
                ['name'=>'Ajith',      'img'=>'cu2.jpg', 'text'=>"I've been a loyal customer for years. The quality and taste are consistently superb."],
                ['name'=>'Vijaykanth', 'img'=>'cu3.jpg', 'text'=>'Your food never disappoints. The service is fantastic, and the food is top-notch!'],
            ]; @endphp
            @foreach ($testimonials as $t)
                <div class="card p-7 relative">
                    <i class="fa-solid fa-quote-right text-4xl text-cream-400 absolute top-5 right-5"></i>
                    <div class="text-gold-400 text-sm flex gap-0.5 mb-3">
                        @for ($i = 0; $i < 5; $i++)<i class="fa-solid fa-star"></i>@endfor
                    </div>
                    <p class="text-cocoa-700 italic leading-relaxed">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3 mt-6 pt-5 border-t border-cream-300">
                        <img src="{{ asset('images/'.$t['img']) }}" class="h-12 w-12 rounded-full object-cover ring-2 ring-gold-400/30">
                        <div>
                            <div class="font-display font-bold text-cocoa-900">{{ $t['name'] }}</div>
                            <div class="text-[11px] uppercase tracking-wider text-cocoa-500">Loyal Guest</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─────── CONTACT ─────── --}}
<section class="py-20">
    <div class="max-w-5xl mx-auto px-4 lg:px-8">
        <div class="card overflow-hidden grid md:grid-cols-2">
            <div class="relative min-h-[280px]">
                <img src="{{ asset('images/orders.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-cocoa-900/80 via-cocoa-800/50 to-transparent flex items-end p-7">
                    <div class="text-white">
                        <span class="text-gold-400 font-script text-xl">Get in touch</span>
                        <h3 class="text-3xl font-display font-bold mt-1">We'd love to hear from you</h3>
                        <p class="text-cream-200/85 mt-2 text-sm">For reservations, catering, or just to say hello.</p>
                    </div>
                </div>
            </div>
            <div class="p-7 md:p-10">
                <span class="section-eyebrow">Message us</span>
                <h2 class="section-title text-3xl">Contact <span class="accent">us</span></h2>
                <form action="{{ route('contact.store') }}" method="POST" class="mt-5 space-y-3">
                    @csrf
                    <input class="input" name="name" placeholder="Your Name" required>
                    <input class="input" type="email" name="email" placeholder="Your Email" required>
                    <input class="input" name="phone" placeholder="Your Phone" required>
                    <textarea class="input" name="message" rows="4" placeholder="Your Message" required></textarea>
                    <button class="btn-primary w-full"><i class="fa-solid fa-paper-plane"></i>Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
