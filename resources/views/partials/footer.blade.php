<footer class="mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-dark rounded-3xl p-8 lg:p-12">
            <div class="grid md:grid-cols-3 gap-10">

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center font-black">
                            R<span class="text-gold-400">F</span>C
                        </div>
                        <span class="font-display text-xl font-bold">Royal<span class="text-gold-400">Food</span>Corner</span>
                    </div>
                    <p class="text-sm text-white/70 leading-relaxed">
                        Indulge in the rich flavors of India and Sri Lanka. An exquisite blend of traditional and modern cuisine — every bite tells a story.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-xl bg-white/10 hover:bg-blue-500/30 transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-xl bg-white/10 hover:bg-sky-500/30 transition"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-xl bg-white/10 hover:bg-pink-500/30 transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="h-10 w-10 grid place-items-center rounded-xl bg-white/10 hover:bg-red-500/30 transition"><i class="fa-brands fa-google"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm uppercase tracking-[0.25em] text-gold-400 mb-4">Categories</h4>
                    <ul class="space-y-2 text-sm text-white/80">
                        <li><a href="{{ route('menu.index', ['category' => 'Main Courses']) }}" class="hover:text-gold-400 transition"><i class="fa-solid fa-bowl-rice mr-2 text-xs text-gold-400/70"></i>Main Courses</a></li>
                        <li><a href="{{ route('menu.index', ['category' => 'Desserts']) }}" class="hover:text-gold-400 transition"><i class="fa-solid fa-ice-cream mr-2 text-xs text-gold-400/70"></i>Desserts</a></li>
                        <li><a href="{{ route('menu.index', ['category' => 'Beverages']) }}" class="hover:text-gold-400 transition"><i class="fa-solid fa-mug-hot mr-2 text-xs text-gold-400/70"></i>Beverages</a></li>
                        <li><a href="{{ route('gallery.index') }}" class="hover:text-gold-400 transition"><i class="fa-solid fa-images mr-2 text-xs text-gold-400/70"></i>Gallery</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-sm uppercase tracking-[0.25em] text-gold-400 mb-4">Contact</h4>
                    <ul class="space-y-3 text-sm text-white/80">
                        <li class="flex items-start gap-3"><i class="fa-solid fa-envelope mt-1 text-gold-400"></i> RoyalFoodCornerRFC@gmail.com</li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-phone mt-1 text-gold-400"></i> +94 70 123 4567</li>
                        <li class="flex items-start gap-3"><i class="fa-solid fa-location-dot mt-1 text-gold-400"></i> No. 8, Jaffna Street, Sri Lanka</li>
                    </ul>
                </div>
            </div>

            <hr class="border-white/10 my-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/60">
                <p>&copy; {{ date('Y') }} Royal Food Corner. All rights reserved.</p>
                <p>Crafted with <i class="fa-solid fa-heart text-royal-500"></i> on Laravel + Tailwind</p>
            </div>
        </div>
    </div>
    <div class="h-8"></div>
</footer>
