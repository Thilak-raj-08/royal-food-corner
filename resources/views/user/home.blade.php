@extends('layouts.app')

@section('title', 'Home')

@section('content')

{{-- HERO --}}
<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/1.jpeg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 hero-overlay"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36">
        <div class="max-w-3xl">
            <span class="chip mb-6"><i class="fa-solid fa-utensils text-gold-400"></i>Authentic Indo-Sri Lankan Cuisine</span>
            <h1 class="text-5xl md:text-7xl font-bold leading-[1.05] text-shadow-lg">
                Welcome to <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-royal-400">Royal Food Corner</span>
            </h1>
            <p class="mt-6 text-lg md:text-xl text-white/85 max-w-2xl">
                Experience the timeless flavors of India and Sri Lanka — handcrafted recipes, fresh ingredients, unforgettable taste.
            </p>
            <div class="mt-10 flex flex-wrap gap-4">
                <a href="{{ route('menu.index') }}" class="btn-primary text-lg !py-4 !px-8">
                    <i class="fa-solid fa-bowl-food"></i>Explore Our Menu
                </a>
                <a href="#about" class="btn-ghost text-lg !py-4 !px-8">
                    <i class="fa-solid fa-circle-info"></i>Our Story
                </a>
            </div>

            <div class="mt-14 grid grid-cols-3 gap-4 max-w-xl">
                <div class="glass-card !p-4 text-center">
                    <div class="text-3xl font-bold text-gold-400">30+</div>
                    <div class="text-xs uppercase tracking-wider text-white/70 mt-1">Dishes</div>
                </div>
                <div class="glass-card !p-4 text-center">
                    <div class="text-3xl font-bold text-gold-400">10K+</div>
                    <div class="text-xs uppercase tracking-wider text-white/70 mt-1">Happy Guests</div>
                </div>
                <div class="glass-card !p-4 text-center">
                    <div class="text-3xl font-bold text-gold-400">4.9<i class="fa-solid fa-star text-base ml-1"></i></div>
                    <div class="text-xs uppercase tracking-wider text-white/70 mt-1">Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="chip mb-4"><i class="fa-solid fa-star text-gold-400"></i>Chef's Specials</span>
            <h2 class="section-title">Featured <span class="accent">Dishes</span></h2>
            <p class="mt-4 text-white/70">Our most loved creations — savor what makes Royal Food Corner unforgettable.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($featured as $product)
                <a href="{{ route('menu.show', $product) }}" class="glass-card group block overflow-hidden !p-0">
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->item_name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 left-4 chip !text-xs">{{ $product->category }}</div>
                        <div class="absolute bottom-4 right-4 px-3 py-1.5 rounded-xl bg-royal-600 font-bold text-sm shadow-lg">
                            Rs. {{ number_format($product->price, 2) }}
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-xl font-bold">{{ $product->item_name }}</h3>
                        <p class="text-sm text-white/70 mt-2 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-xs text-gold-400">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <span class="text-sm text-royal-300 group-hover:text-royal-200">View Details <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section id="about" class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card !p-0 overflow-hidden grid md:grid-cols-2 gap-0">
            <div class="relative aspect-square md:aspect-auto">
                <img src="{{ asset('images/g1.jpg') }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-tr from-royal-950/40 to-transparent"></div>
            </div>
            <div class="p-8 md:p-12">
                <span class="chip mb-4"><i class="fa-solid fa-fire-flame-curved text-gold-400"></i>Our Story</span>
                <h2 class="section-title">About <span class="accent">Us</span></h2>
                <p class="mt-5 text-white/80 leading-relaxed">
                    Welcome to <strong>Royal Food Corner</strong> — your gateway to a culinary journey that blends the rich traditions of Indo-Sri Lankan cuisine with a modern touch. We're more than a restaurant; we're an experience that reflects the tapestry of flavors from India and Sri Lanka.
                </p>
                <p class="mt-4 text-white/70 leading-relaxed">
                    Our journey began with a passion for creating delicious, authentic, and memorable dishes. As a prominent establishment, we're committed to delighting our guests with a fusion of traditional cuisine and modern innovations.
                </p>
                <div class="grid grid-cols-3 gap-4 mt-8">
                    <div class="text-center">
                        <i class="fa-solid fa-leaf text-2xl text-gold-400"></i>
                        <div class="text-xs uppercase tracking-wider text-white/70 mt-2">Fresh Ingredients</div>
                    </div>
                    <div class="text-center">
                        <i class="fa-solid fa-mortar-pestle text-2xl text-gold-400"></i>
                        <div class="text-xs uppercase tracking-wider text-white/70 mt-2">Authentic Spices</div>
                    </div>
                    <div class="text-center">
                        <i class="fa-solid fa-truck-fast text-2xl text-gold-400"></i>
                        <div class="text-xs uppercase tracking-wider text-white/70 mt-2">Fast Delivery</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MENU HIGHLIGHTS --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="chip mb-4"><i class="fa-solid fa-bowl-rice text-gold-400"></i>Today's Highlights</span>
            <h2 class="section-title">Our <span class="accent">Menu</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($highlights as $product)
                <a href="{{ route('menu.show', $product) }}" class="glass-card group block !p-0 overflow-hidden">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="p-5">
                        <div class="text-xs uppercase tracking-wider text-gold-400">{{ $product->category }}</div>
                        <h3 class="text-lg font-bold mt-1">{{ $product->item_name }}</h3>
                        <div class="flex items-center justify-between mt-3">
                            <div class="text-royal-300 font-semibold">Rs. {{ number_format($product->price, 2) }}</div>
                            <span class="text-xs text-white/60 group-hover:text-white">Details <i class="fa-solid fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('menu.index') }}" class="btn-gold">
                View Full Menu <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="chip mb-4"><i class="fa-solid fa-comments text-gold-400"></i>Testimonials</span>
            <h2 class="section-title">What Our <span class="accent">Guests Say</span></h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php $testimonials = [
                ['name' => 'Vijay', 'img' => 'cu1.jpg', 'text' => 'The food here is amazing! I can\'t get enough of their dishes. Highly recommended!'],
                ['name' => 'Ajith', 'img' => 'cu2.jpg', 'text' => "I've been a loyal customer for years. The quality and taste are consistently superb."],
                ['name' => 'Vijaykanth', 'img' => 'cu3.jpg', 'text' => 'Your Food Store never disappoints. The service is fantastic, and the food is top-notch!'],
            ]; @endphp
            @foreach ($testimonials as $t)
                <div class="glass-card text-center">
                    <img src="{{ asset('images/'.$t['img']) }}" alt="" class="h-20 w-20 rounded-full object-cover mx-auto ring-4 ring-gold-400/30">
                    <div class="text-gold-400 text-sm my-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-white/80 italic">"{{ $t['text'] }}"</p>
                    <h4 class="font-display text-lg font-bold mt-4">{{ $t['name'] }}</h4>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-card !p-0 overflow-hidden grid md:grid-cols-2">
            <div class="relative min-h-[300px]">
                <img src="{{ asset('images/orders.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-br from-royal-950/80 via-royal-800/40 to-transparent flex items-end p-8">
                    <div>
                        <h3 class="text-3xl font-display font-bold">Get in Touch</h3>
                        <p class="text-white/80 mt-2">We'd love to hear from you. Reach out for reservations, catering, or just to say hello.</p>
                    </div>
                </div>
            </div>
            <div class="p-8 md:p-10">
                <span class="chip mb-4"><i class="fa-solid fa-paper-plane text-gold-400"></i>Contact</span>
                <h2 class="section-title text-3xl"><span class="accent">Contact</span> Us</h2>
                <form action="{{ route('contact.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <input class="glass-input" name="name" placeholder="Your Name" required>
                    <input class="glass-input" type="email" name="email" placeholder="Your Email" required>
                    <input class="glass-input" name="phone" placeholder="Your Phone" required>
                    <textarea class="glass-input" name="message" rows="4" placeholder="Your Message" required></textarea>
                    <button class="btn-primary w-full"><i class="fa-solid fa-paper-plane"></i>Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
