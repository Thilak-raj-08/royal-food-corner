<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentic Indo-Sri Lankan Cuisine') · Royal Food Corner</title>

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

</body>
</html>
