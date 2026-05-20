<nav x-data="{ open: false, scrolled: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 16)"
     :class="scrolled ? 'bg-royal-950/70 backdrop-blur-xl border-b border-white/10 shadow-xl' : 'bg-transparent'"
     class="fixed top-0 inset-x-0 z-40 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">

            {{-- Brand --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-royal-500 via-royal-700 to-royal-950 grid place-items-center text-white font-black shadow-glow group-hover:scale-110 transition">
                    R<span class="text-gold-400">F</span>C
                </div>
                <div class="hidden sm:block leading-tight">
                    <div class="font-display text-xl font-bold">Royal<span class="text-gold-400">Food</span>Corner</div>
                    <div class="text-[10px] uppercase tracking-[0.25em] text-white/60">Indo • Sri Lankan • Cuisine</div>
                </div>
            </a>

            {{-- Desktop links --}}
            <div class="hidden lg:flex items-center gap-1">
                @php $nav = [
                    ['name' => 'Home',    'route' => 'home',          'icon' => 'fa-house'],
                    ['name' => 'Menu',    'route' => 'menu.index',    'icon' => 'fa-utensils'],
                    ['name' => 'Gallery', 'route' => 'gallery.index', 'icon' => 'fa-images'],
                ]; @endphp
                @foreach ($nav as $n)
                    @php $active = request()->routeIs($n['route']); @endphp
                    <a href="{{ route($n['route']) }}"
                       class="px-4 py-2 rounded-xl text-sm font-medium flex items-center gap-2 transition
                              {{ $active ? 'bg-white/15 text-white border border-white/20' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <i class="fa-solid {{ $n['icon'] }} text-xs opacity-75"></i>{{ $n['name'] }}
                    </a>
                @endforeach
            </div>

            {{-- Right actions --}}
            <div class="flex items-center gap-3">

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 backdrop-blur transition">
                    <i class="fa-solid fa-cart-shopping text-white"></i>
                    @if ($cartCount > 0)
                        <span class="absolute -top-1.5 -right-1.5 min-w-[20px] h-5 px-1 rounded-full bg-gradient-to-br from-royal-500 to-royal-700 text-white text-[10px] font-bold grid place-items-center shadow-lg shadow-royal-700/50 animate-pulse-glow">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 backdrop-blur transition">
                            <div class="h-7 w-7 rounded-full bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                            <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->username }}</span>
                            <i class="fa-solid fa-chevron-down text-xs opacity-70" :class="open && 'rotate-180'" style="transition: transform .2s"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-transition.scale.origin.top
                             class="absolute right-0 mt-2 w-56 glass-dark rounded-2xl p-2 shadow-2xl" style="display:none">
                            <a href="{{ route('account.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 text-sm">
                                <i class="fa-solid fa-user-gear text-gold-400"></i>My Account
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-white/10 text-sm">
                                <i class="fa-solid fa-box text-gold-400"></i>My Orders
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-rose-500/20 text-sm text-rose-200">
                                    <i class="fa-solid fa-right-from-bracket"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex btn-primary !py-2 !px-5 !text-sm">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </a>
                @endauth

                {{-- Mobile burger --}}
                <button @click="open = !open" class="lg:hidden p-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-collapse x-cloak class="lg:hidden pb-4">
            <div class="glass-dark rounded-2xl p-3 space-y-1">
                @foreach ($nav as $n)
                    @php $active = request()->routeIs($n['route']); @endphp
                    <a href="{{ route($n['route']) }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ $active ? 'bg-white/15' : 'hover:bg-white/10' }}">
                        <i class="fa-solid {{ $n['icon'] }} text-gold-400"></i>{{ $n['name'] }}
                    </a>
                @endforeach
                @guest
                    <a href="{{ route('login') }}" class="block mt-2 btn-primary text-center">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i>Login
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

{{-- Spacer for fixed nav --}}
<div class="h-20"></div>
