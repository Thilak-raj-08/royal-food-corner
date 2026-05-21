<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentic Indo-Sri Lankan Cuisine') · Royal Food Corner</title>

    {{-- SEO --}}
    <meta name="description" content="@yield('description', 'Royal Food Corner — Authentic Indo-Sri Lankan cuisine. Order online, book a table, enjoy biryani, kottu, fresh juices and traditional desserts.')">
    <meta name="keywords" content="Royal Food Corner, RFC, Indo Sri Lankan food, biryani, kottu, restaurant Jaffna, Sri Lanka restaurant, online food order">
    <meta name="author" content="Royal Food Corner">
    <meta name="theme-color" content="#C8102E">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Authentic Indo-Sri Lankan Cuisine') · Royal Food Corner">
    <meta property="og:description" content="@yield('description', 'Order authentic Indo-Sri Lankan dishes online. Biryanis, kottus, juices, desserts. Book a table or order via WhatsApp.')">
    <meta property="og:image" content="{{ asset('images/1.jpeg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Royal Food Corner">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Royal Food Corner')">
    <meta name="twitter:description" content="@yield('description', 'Authentic Indo-Sri Lankan cuisine — order online.')">
    <meta name="twitter:image" content="{{ asset('images/1.jpeg') }}">

    {{-- Favicon (inline SVG, no extra file needed) --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='22' fill='%23C8102E'/%3E%3Ctext x='50' y='66' font-family='Georgia,serif' font-size='44' font-weight='900' fill='white' text-anchor='middle' letter-spacing='-3'%3ERFC%3C/text%3E%3C/svg%3E">

    {{-- Fonts & icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&family=Dancing+Script:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @include('partials.navbar')

    {{-- Flash messages --}}
    @if (session('success') || session('error') || session('info') || $errors->any())
        <div class="fixed top-28 right-6 z-50 w-full max-w-sm space-y-3"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)">
            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i><span class="text-sm font-medium">{{ session('success') }}</span></div>
            @endif
            @if (session('error'))
                <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation text-signature-500 mt-0.5"></i><span class="text-sm font-medium">{{ session('error') }}</span></div>
            @endif
            @if (session('info'))
                <div class="alert alert-info"><i class="fa-solid fa-circle-info text-sky-500 mt-0.5"></i><span class="text-sm font-medium">{{ session('info') }}</span></div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation text-signature-500 mt-0.5"></i>
                    <div>
                        <p class="font-semibold mb-1 text-sm">Please fix the following:</p>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <main class="page-enter">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Back to top button --}}
    <button
        x-data="{ show: false }"
        x-init="window.addEventListener('scroll', () => show = window.scrollY > 500)"
        x-show="show" x-cloak x-transition.opacity
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Back to top"
        class="fixed bottom-6 right-6 h-12 w-12 rounded-full bg-red-gradient text-white shadow-soft-lg hover:shadow-glow-red transition z-40 print:hidden">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

</body>
</html>
