<footer class="mt-24 print:hidden">

    {{-- NEWSLETTER --}}
    <section class="py-14 bg-cream-300/60 border-y border-cream-500">
        <div class="max-w-5xl mx-auto px-4 lg:px-8">
            <div class="card overflow-hidden grid md:grid-cols-[1fr_auto] gap-6 items-center p-7 md:p-9 bg-red-gradient !border-0">
                <div class="text-white">
                    <span class="font-script text-gold-300 text-2xl">Stay in the loop</span>
                    <h3 class="font-display text-2xl md:text-3xl font-bold mt-1">Get exclusive offers & menu updates</h3>
                    <p class="text-cream-100/80 mt-2 text-sm">Be the first to know about new dishes, festival specials, and weekend discounts.</p>
                </div>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col sm:flex-row gap-2 min-w-0 md:w-96">
                    @csrf
                    <input type="email" name="email" required placeholder="your@email.com"
                           class="flex-1 rounded-xl px-4 py-3 border-0 focus:ring-2 focus:ring-gold-400 text-cocoa-900 placeholder-cocoa-400">
                    <button class="btn-gold whitespace-nowrap !py-3 !px-5">
                        <i class="fa-solid fa-paper-plane"></i>Subscribe
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- HOURS + MAP + INFO BAND --}}
    <section class="py-16 bg-cream-200/60 border-y border-cream-500">
        <div class="max-w-7xl mx-auto px-4 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">

                {{-- Hours --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-11 w-11 rounded-xl bg-red-gradient grid place-items-center text-white shadow-soft">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-bold text-cocoa-900">Opening Hours</h3>
                            <p class="text-xs text-cocoa-500">We're here all week</p>
                        </div>
                    </div>
                    <ul class="text-sm space-y-2">
                        @php $hours = [
                            ['Monday – Friday', '10:00 AM – 10:00 PM'],
                            ['Saturday',        '09:00 AM – 11:00 PM'],
                            ['Sunday',          '09:00 AM – 10:00 PM'],
                            ['Public Holidays', '11:00 AM – 09:00 PM'],
                        ]; @endphp
                        @foreach ($hours as [$d, $t])
                            <li class="flex items-center justify-between border-b border-cream-300 pb-2 last:border-0">
                                <span class="text-cocoa-700 font-medium">{{ $d }}</span>
                                <span class="text-cocoa-900 font-semibold">{{ $t }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Map --}}
                <div class="card p-0 overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps?q=Jaffna,Sri+Lanka&output=embed"
                        class="w-full h-full min-h-[260px]"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Royal Food Corner location"></iframe>
                </div>

                {{-- Contact summary --}}
                <div class="card p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-11 w-11 rounded-xl bg-gold-gradient grid place-items-center text-cocoa-900 shadow-soft">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h3 class="font-display text-xl font-bold text-cocoa-900">Find Us</h3>
                            <p class="text-xs text-cocoa-500">Stop by or call ahead</p>
                        </div>
                    </div>
                    <ul class="text-sm space-y-3">
                        <li class="flex items-start gap-3 text-cocoa-700">
                            <i class="fa-solid fa-location-dot text-signature-500 mt-1"></i>
                            <span>No. 8, Jaffna Street,<br>Northern Province, Sri Lanka</span>
                        </li>
                        <li class="flex items-start gap-3 text-cocoa-700">
                            <i class="fa-solid fa-phone text-signature-500 mt-1"></i>
                            <a href="tel:+94701234567" class="hover:text-signature-500 transition">+94 70 123 4567</a>
                        </li>
                        <li class="flex items-start gap-3 text-cocoa-700">
                            <i class="fa-solid fa-envelope text-signature-500 mt-1"></i>
                            <a href="mailto:RoyalFoodCornerRFC@gmail.com" class="hover:text-signature-500 transition break-all">RoyalFoodCornerRFC@gmail.com</a>
                        </li>
                        <li class="flex items-start gap-3 text-cocoa-700">
                            <i class="fa-brands fa-whatsapp text-emerald-600 mt-1"></i>
                            <a href="https://wa.me/94701234567" target="_blank" class="hover:text-emerald-600 transition">WhatsApp Order</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- BOTTOM BAND --}}
    <section class="bg-cocoa-900 text-cream-200">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">

                {{-- Brand --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="rfc-monogram">RFC</div>
                        <div>
                            <div class="font-display text-xl font-bold text-white">Royal Food Corner</div>
                            <div class="text-[10px] uppercase tracking-[0.25em] text-gold-400">Indo · Sri Lankan · Cuisine</div>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-cream-200/70 max-w-md">
                        Indulge in the rich flavors of India and Sri Lanka. An exquisite blend of traditional and modern cuisine — every bite tells a story.
                    </p>
                    <div class="flex gap-2 mt-5">
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-lg bg-cream-200/10 hover:bg-blue-500 transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-lg bg-cream-200/10 hover:bg-pink-500 transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-lg bg-cream-200/10 hover:bg-sky-500 transition"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="https://wa.me/94701234567" target="_blank" class="h-10 w-10 grid place-items-center rounded-lg bg-cream-200/10 hover:bg-emerald-500 transition"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs uppercase tracking-[0.25em] text-gold-400 mb-4 font-semibold">Explore</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-gold-400 transition">Home</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-gold-400 transition">Menu</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-gold-400 transition">Gallery</a></li>
                        <li><a href="{{ route('reservations.create') }}" class="hover:text-gold-400 transition">Reservations</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs uppercase tracking-[0.25em] text-gold-400 mb-4 font-semibold">Categories</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('menu.index', ['category' => 'Main Courses']) }}" class="hover:text-gold-400 transition">Main Courses</a></li>
                        <li><a href="{{ route('menu.index', ['category' => 'Desserts']) }}" class="hover:text-gold-400 transition">Desserts</a></li>
                        <li><a href="{{ route('menu.index', ['category' => 'Beverages']) }}" class="hover:text-gold-400 transition">Beverages</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-cream-200/10 my-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-cream-200/60">
                <p>&copy; {{ date('Y') }} Royal Food Corner. All rights reserved.</p>
                <p>Crafted with <i class="fa-solid fa-heart text-signature-400"></i> · Laravel · Tailwind</p>
            </div>
        </div>
    </section>
</footer>
