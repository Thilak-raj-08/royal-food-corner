<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login · Royal Food Corner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen grid place-items-center p-4 bg-cocoa-900 bg-cream-noise">

<div class="w-full max-w-md">
    <div class="card p-8">
        <div class="text-center mb-7">
            <div class="rfc-monogram mx-auto !h-16 !w-16 !text-2xl">RFC</div>
            <h1 class="font-display text-3xl font-bold text-cocoa-900 mt-4">Admin Portal</h1>
            <p class="text-sm text-cocoa-500 mt-1">Sign in to manage Royal Food Corner.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error mb-4"><i class="fa-solid fa-circle-exclamation text-signature-500"></i>{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Username</label>
                <input class="input mt-1.5" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Password</label>
                <input class="input mt-1.5" type="password" name="password" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-cocoa-700">
                <input type="checkbox" name="remember" class="rounded border-cocoa-300 text-signature-500 focus:ring-signature-500">
                Remember me
            </label>
            <button class="btn-primary w-full"><i class="fa-solid fa-shield-halved"></i>Login</button>
        </form>

        <p class="text-center text-xs text-cocoa-400 mt-6 pt-4 border-t border-cream-300">
            <a href="{{ route('home') }}" class="hover:text-cocoa-700">← Back to site</a>
        </p>
    </div>
    <p class="text-center text-[11px] text-cream-200/60 mt-4">Default: <code class="text-gold-400">admin / admin123</code></p>
</div>

</body>
</html>
