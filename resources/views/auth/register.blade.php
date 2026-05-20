@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="min-h-[80vh] grid place-items-center py-16 px-4">
    <div class="w-full max-w-md">
        <div class="glass-card">
            <div class="text-center mb-6">
                <div class="h-16 w-16 mx-auto rounded-2xl bg-gradient-to-br from-gold-400 to-royal-500 grid place-items-center shadow-glow">
                    <i class="fa-solid fa-user-plus text-2xl"></i>
                </div>
                <h1 class="text-3xl font-display font-bold mt-4">Join Royal Food</h1>
                <p class="text-sm text-white/60 mt-1">Create your account in seconds.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Username</label>
                    <input class="glass-input mt-1" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Email</label>
                    <input class="glass-input mt-1" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs uppercase tracking-wider text-white/60">Password</label>
                        <input class="glass-input mt-1" type="password" name="password" required>
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-wider text-white/60">Confirm</label>
                        <input class="glass-input mt-1" type="password" name="password_confirmation" required>
                    </div>
                </div>
                <button class="btn-primary w-full"><i class="fa-solid fa-user-plus"></i>Create Account</button>
            </form>

            <p class="text-center text-sm text-white/70 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-gold-400 hover:underline font-medium">Login</a>
            </p>
        </div>
    </div>
</section>

@endsection
