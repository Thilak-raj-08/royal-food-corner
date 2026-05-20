<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) — Royal Food Corner</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    {{-- Ambient decorative blobs --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full bg-royal-600/30 blur-3xl"></div>
        <div class="absolute top-1/3 right-0 h-[28rem] w-[28rem] rounded-full bg-gold-500/15 blur-3xl"></div>
        <div class="absolute -bottom-40 left-1/3 h-[34rem] w-[34rem] rounded-full bg-royal-800/30 blur-3xl"></div>
    </div>

    @include('partials.navbar')

    {{-- Flash messages --}}
    @if (session('success') || session('error') || session('info') || $errors->any())
        <div class="fixed top-24 right-6 z-50 w-full max-w-sm space-y-3"
             x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)">
            @if (session('success'))
                <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span></div>
            @endif
            @if (session('error'))
                <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i><span>{{ session('error') }}</span></div>
            @endif
            @if (session('info'))
                <div class="alert alert-info"><i class="fa-solid fa-circle-info"></i><span>{{ session('info') }}</span></div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <p class="font-semibold mb-1">Please fix the following:</p>
                        <ul class="list-disc list-inside text-sm space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
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

</body>
</html>
