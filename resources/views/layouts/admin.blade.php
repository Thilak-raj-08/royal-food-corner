<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · RFC Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex">

    {{-- Ambient blobs --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full bg-royal-700/30 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-[26rem] w-[26rem] rounded-full bg-gold-500/10 blur-3xl"></div>
    </div>

    {{-- SIDEBAR --}}
    <aside x-data="{ open: true }"
           class="hidden lg:flex flex-col fixed inset-y-0 left-0 w-64 glass-dark border-r border-white/10 p-5 z-30">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 mb-8">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-royal-500 via-royal-700 to-royal-950 grid place-items-center font-black shadow-glow">
                R<span class="text-gold-400">F</span>C
            </div>
            <div>
                <div class="font-display text-lg font-bold leading-tight">Royal Food</div>
                <div class="text-[10px] uppercase tracking-[0.2em] text-gold-400">Admin Panel</div>
            </div>
        </a>

        @php $nav = [
            ['Dashboard', 'admin.dashboard',       'fa-gauge-high'],
            ['Orders',    'admin.orders.index',    'fa-bag-shopping'],
            ['Gallery',   'admin.gallery.index',   'fa-image'],
            ['Messages',  'admin.messages.index',  'fa-message'],
        ]; @endphp

        <nav class="space-y-1">
            @foreach ($nav as [$label, $route, $icon])
                @php $active = request()->routeIs($route); @endphp
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition
                          {{ $active ? 'bg-gradient-to-r from-royal-500/30 to-royal-700/20 text-white border border-royal-400/40 shadow-glow' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid {{ $icon }} w-5 text-center {{ $active ? 'text-gold-400' : '' }}"></i>
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto pt-6 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-gold-400 to-royal-500 grid place-items-center text-sm font-bold">
                    {{ strtoupper(substr(auth('admin')->user()->username ?? 'A', 0, 1)) }}
                </div>
                <div class="text-sm">
                    <div class="font-semibold">{{ auth('admin')->user()->username ?? 'Admin' }}</div>
                    <div class="text-[10px] text-gold-400 uppercase tracking-widest">Administrator</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-rose-200 hover:bg-rose-500/20 transition">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>Logout
                </button>
            </form>
            <a href="{{ route('home') }}" target="_blank" class="block mt-2 text-center text-xs text-white/50 hover:text-white">View site <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
        </div>
    </aside>

    {{-- Mobile topbar --}}
    <div x-data="{ open: false }" class="lg:hidden fixed top-0 inset-x-0 z-40 glass-dark border-b border-white/10 p-4 flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center font-black text-sm">R<span class="text-gold-400">F</span>C</div>
            <span class="font-display font-bold">Admin</span>
        </a>
        <button @click="open = !open" class="p-2 rounded-xl bg-white/10"><i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i></button>
        <div x-show="open" x-collapse x-cloak class="absolute top-full inset-x-0 glass-dark p-4 border-b border-white/10 space-y-1">
            @foreach ($nav as [$label, $route, $icon])
                <a href="{{ route($route) }}" class="block px-3 py-2.5 rounded-xl hover:bg-white/10 text-sm">
                    <i class="fa-solid {{ $icon }} mr-2 text-gold-400"></i>{{ $label }}
                </a>
            @endforeach
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full text-left block px-3 py-2.5 rounded-xl text-rose-200 hover:bg-rose-500/20 text-sm">
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
                    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i>{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>
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
