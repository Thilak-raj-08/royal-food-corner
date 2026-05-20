<header x-data="{ mobile: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 24)"
        :class="scrolled ? 'bg-white shadow-soft border-b border-cream-500' : 'bg-cream-100/70 backdrop-blur'"
        class="fixed top-0 inset-x-0 z-40 transition-all duration-300">

    {{-- Top utility strip --}}
    <div class="hidden md:block bg-cocoa-900 text-cream-100 text-[12px]">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 flex items-center justify-between h-9">
            <div class="flex items-center gap-5">
                <span><i class="fa-solid fa-phone text-gold-400 mr-1.5"></i>+94 70 123 4567</span>
                <span><i class="fa-solid fa-envelope text-gold-400 mr-1.5"></i>RoyalFoodCornerRFC@gmail.com</span>
            </div>
            <div class="flex items-center gap-5">
                <span><i class="fa-regular fa-clock text-gold-400 mr-1.5"></i>Open 10:00 AM – 10:00 PM</span>
                <span><i class="fa-solid fa-location-dot text-gold-400 mr-1.5"></i>No. 8, Jaffna Street</span>
            </div>
        </div>
    </div>

    {{-- Main navbar --}}
    <div class="max-w-7xl mx-auto px-4 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="rfc-monogram group-hover:scale-105 transition">RFC</div>
                <div class="leading-tight">
                    <div class="font-display text-xl md:text-[22px] font-bold text-cocoa-900 tracking-tight">
                        Royal Food Corner
                    </div>
                    <div class="text-[10px] uppercase tracking-[0.25em] text-signature-500 font-semibold mt-0.5">
                        Indo · Sri Lankan · Cuisine
                    </div>
                </div>
            </a>

            {{-- DESKTOP NAV --}}
            <nav class="hidden lg:flex items-center gap-1">
                @php $nav = [
                    ['name' => 'Home',        'route' => 'home',             'icon' => 'fa-house'],
                    ['name' => 'Menu',        'route' => 'menu.index',       'icon' => 'fa-bowl-food'],
                    ['name' => 'Gallery',     'route' => 'gallery.index',    'icon' => 'fa-images'],
                    ['name' => 'Reservation', 'route' => 'reservations.create', 'icon' => 'fa-calendar-days'],
                ]; @endphp
                @foreach ($nav as $n)
                    @php $active = request()->routeIs($n['route']); @endphp
                    <a href="{{ route($n['route']) }}"
                       class="px-4 py-2.5 rounded-lg text-sm font-semibold flex items-center gap-2 transition
                              {{ $active
                                  ? 'text-signature-500 bg-signature-50'
                                  : 'text-cocoa-700 hover:text-signature-500 hover:bg-cream-200' }}">
                        <i class="fa-solid {{ $n['icon'] }} text-xs opacity-80"></i>{{ $n['name'] }}
                    </a>
                @endforeach
            </nav>

            {{-- RIGHT ACTIONS --}}
            <div class="flex items-center gap-2">

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative btn-icon">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if ($cartCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-signature-500 text-white text-[10px] font-bold grid place-items-center shadow-soft">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl border border-cocoa-200 bg-white hover:border-signature-500 transition">
                            <div class="h-8 w-8 rounded-lg bg-red-gradient grid place-items-center text-white text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-semibold text-cocoa-900">{{ auth()->user()->username }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-cocoa-500" :class="open && 'rotate-180'" style="transition: transform .2s"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition.scale.origin.top-right x-cloak
                             class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-soft-lg border border-cream-500 p-2">
                            <a href="{{ route('account.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-cream-100 text-sm text-cocoa-800">
                                <i class="fa-solid fa-user-gear text-signature-500 w-4"></i>My Account
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-cream-100 text-sm text-cocoa-800">
                                <i class="fa-solid fa-box text-signature-500 w-4"></i>My Orders
                            </a>
                            <hr class="my-1 border-cream-300">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-signature-50 text-sm text-signature-600">
                                    <i class="fa-solid fa-right-from-bracket w-4"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex btn-primary !py-2 !px-5 text-sm">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </a>
                @endauth

                {{-- Mobile burger --}}
                <button @click="mobile = !mobile" class="lg:hidden btn-icon">
                    <i class="fa-solid" :class="mobile ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobile" x-collapse x-cloak class="lg:hidden pb-4">
            <div class="card p-3 space-y-1">
                @foreach ($nav as $n)
                    @php $active = request()->routeIs($n['route']); @endphp
                    <a href="{{ route($n['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold {{ $active ? 'bg-signature-50 text-signature-600' : 'text-cocoa-700 hover:bg-cream-100' }}">
                        <i class="fa-solid {{ $n['icon'] }} text-signature-500 w-5 text-center"></i>{{ $n['name'] }}
                    </a>
                @endforeach
                @guest
                    <a href="{{ route('login') }}" class="btn-primary w-full mt-3 text-sm">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>

{{-- Spacer for fixed nav (utility strip + navbar) --}}
<div class="h-20 md:h-[116px]"></div>
