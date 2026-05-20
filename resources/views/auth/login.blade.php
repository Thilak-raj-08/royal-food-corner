@extends('layouts.app')

@section('title', 'Login')

@section('content')

<section class="min-h-[70vh] grid place-items-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-6">
                <div class="rfc-monogram mx-auto !h-14 !w-14 !text-xl">RFC</div>
                <h1 class="font-display text-3xl font-bold text-cocoa-900 mt-4">Welcome Back</h1>
                <p class="text-sm text-cocoa-500 mt-1">Sign in to continue ordering.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
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
                <button class="btn-primary w-full"><i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button>
            </form>

            <p class="text-center text-sm text-cocoa-600 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-signature-500 hover:underline font-semibold">Register</a>
            </p>
            <p class="text-center text-xs text-cocoa-400 mt-4 pt-4 border-t border-cream-300">
                <a href="{{ route('admin.login') }}" class="hover:text-cocoa-700">Admin Portal <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a>
            </p>
        </div>
    </div>
</section>

@endsection
