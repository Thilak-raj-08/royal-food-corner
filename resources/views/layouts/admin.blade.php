<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · RFC Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 text-cocoa-800 min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="hidden lg:flex flex-col fixed inset-y-0 left-0 w-64 bg-cocoa-900 text-cream-100 p-5 z-30">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 mb-8">
            <div class="rfc-monogram">RFC</div>
            <div class="leading-tight">
                <div class="font-display text-lg font-bold text-white">Royal Food</div>
                <div class="text-[10px] uppercase tracking-[0.2em] text-gold-400">Admin Panel</div>
            </div>
        </a>

        @php $nav = [
            ['Dashboard',    'admin.dashboard',          'fa-gauge-high'],
            ['Products',     'admin.products.index',     'fa-bowl-food'],
            ['Orders',       'admin.orders.index',       'fa-bag-shopping'],
            ['Reservations', 'admin.reservations.index', 'fa-calendar-days'],
            ['Gallery',      'admin.gallery.index',      'fa-image'],
            ['Messages',     'admin.messages.index',     'fa-message'],
        ]; @endphp

        <nav class="space-y-1">
            @foreach ($nav as [$label, $route, $icon])
                @php $active = request()->routeIs($route); @endphp
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
                          {{ $active ? 'bg-red-gradient text-white shadow-soft' : 'text-cream-200/85 hover:bg-cream-200/10 hover:text-white' }}">
                    <i class="fa-solid {{ $icon }} w-5 text-center {{ $active ? '' : 'text-gold-400' }}"></i>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-6 border-t border-cream-200/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-gold-gradient grid place-items-center text-cocoa-900 font-bold">
                    {{ strtoupper(substr(auth('admin')->user()->username ?? 'A', 0, 1)) }}
                </div>
                <div class="text-sm">
                    <div class="font-semibold text-white">{{ auth('admin')->user()->username ?? 'Admin' }}</div>
                    <div class="text-[10px] text-gold-400 uppercase tracking-widest">Administrator</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-signature-300 hover:bg-signature-500/20 transition">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>Logout
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="block mt-2 text-center text-xs text-cream-200/60 hover:text-white">View site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
    </aside>

    {{-- Mobile topbar --}}
    <div x-data="{ open: false }" class="lg:hidden fixed top-0 inset-x-0 z-40 bg-cocoa-900 text-cream-100 p-4 flex items-center justify-between shadow-soft">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="rfc-monogram !h-9 !w-9 !text-sm">RFC</div>
            <span class="font-display font-bold text-white">Admin</span>
        </a>
        <button @click="open = !open" class="h-10 w-10 grid place-items-center rounded-lg bg-cream-200/10">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="absolute top-full inset-x-0 bg-cocoa-900 p-4 border-t border-cream-200/10 space-y-1">
            @foreach ($nav as [$label, $route, $icon])
                <a href="{{ route($route) }}" class="block px-3 py-2.5 rounded-lg hover:bg-cream-200/10 text-sm">
                    <i class="fa-solid {{ $icon }} mr-2 text-gold-400"></i>{{ $label }}
                </a>
            @endforeach
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full text-left block px-3 py-2.5 rounded-lg text-signature-300 hover:bg-signature-500/20 text-sm">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    {{-- MAIN --}}
    <main class="flex-1 lg:ml-64 p-4 sm:p-6 lg:p-10 pt-20 lg:pt-10">

        @if (session('success') || session('error') || $errors->any())
            <div class="fixed top-20 right-6 z-50 w-full max-w-sm space-y-3"
                 x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)">
                @if (session('success'))
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check text-emerald-600"></i><span class="text-sm font-medium">{{ session('success') }}</span></div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation text-signature-500"></i><span class="text-sm font-medium">{{ session('error') }}</span></div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-error">
                        <div>
                            <strong>Validation:</strong>
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
