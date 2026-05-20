@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="min-h-[80vh] grid place-items-center py-16 px-4">
    <div class="w-full max-w-md">
        <div class="glass-card">
            <div class="text-center mb-6">
                <div class="h-16 w-16 mx-auto rounded-2xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center shadow-glow">
                    <i class="fa-solid fa-utensils text-2xl"></i>
                </div>
                <h1 class="text-3xl font-display font-bold mt-4">Welcome Back</h1>
                <p class="text-sm text-white/60 mt-1">Sign in to continue ordering.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
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
                <button class="btn-primary w-full"><i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button>
            </form>

            <p class="text-center text-sm text-white/70 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-gold-400 hover:underline font-medium">Register</a>
            </p>
            <p class="text-center text-xs text-white/40 mt-5">
                <a href="{{ route('admin.login') }}" class="hover:text-white">Admin Portal <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a>
            </p>
        </div>
    </div>
</section>

@endsection
