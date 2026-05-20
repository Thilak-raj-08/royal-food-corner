<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login · Royal Food Corner</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen grid place-items-center p-4">

<div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-32 -left-24 h-96 w-96 rounded-full bg-royal-600/40 blur-3xl"></div>
    <div class="absolute -bottom-32 -right-24 h-[28rem] w-[28rem] rounded-full bg-gold-500/15 blur-3xl"></div>
</div>

<div class="w-full max-w-md">
    <div class="glass-card">
        <div class="text-center mb-7">
            <div class="h-16 w-16 mx-auto rounded-2xl bg-gradient-to-br from-royal-500 via-royal-700 to-royal-950 grid place-items-center text-2xl font-black shadow-glow">
                R<span class="text-gold-400">F</span>C
            </div>
            <h1 class="text-3xl font-display font-bold mt-4">Admin Portal</h1>
            <p class="text-sm text-white/60 mt-1">Sign in to manage Royal Food Corner.</p>
        </div>

        @if (session('error'))
            <div class="alert alert-error mb-4"><i class="fa-solid fa-circle-exclamation"></i>{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Username</label>
                <input class="glass-input mt-1" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div>
                <label class="text-xs uppercase tracking-wider text-white/60">Password</label>
                <input class="glass-input mt-1" type="password" name="password" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-white/70">
                <input type="checkbox" name="remember" class="rounded bg-white/10 border-white/20 text-royal-500 focus:ring-royal-400">
                Remember me
            </label>
            <button class="btn-primary w-full"><i class="fa-solid fa-shield-halved"></i>Login</button>
        </form>

        <p class="text-center text-xs text-white/40 mt-6">
            <a href="{{ route('home') }}" class="hover:text-white">← Back to site</a>
        </p>
    </div>
    <p class="text-center text-[11px] text-white/40 mt-4">Default credentials: <code class="text-gold-400">admin / admin123</code></p>
</div>

</body>
</html>
