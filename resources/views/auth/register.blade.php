@extends('layouts.app')

@section('title', 'Register')

@section('content')

<section class="min-h-[70vh] grid place-items-center py-12 px-4">
    <div class="w-full max-w-md">
        <div class="card p-8">
            <div class="text-center mb-6">
                <div class="rfc-monogram mx-auto !h-14 !w-14 !text-xl bg-gold-gradient !text-cocoa-900 border-signature-500/40">RFC</div>
                <h1 class="font-display text-3xl font-bold text-cocoa-900 mt-4">Join Royal Food</h1>
                <p class="text-sm text-cocoa-500 mt-1">Create your account in seconds.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Username</label>
                    <input class="input mt-1.5" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Email</label>
                    <input class="input mt-1.5" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Password</label>
                        <input class="input mt-1.5" type="password" name="password" required>
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Confirm</label>
                        <input class="input mt-1.5" type="password" name="password_confirmation" required>
                    </div>
                </div>
                <button class="btn-primary w-full"><i class="fa-solid fa-user-plus"></i>Create Account</button>
            </form>

            <p class="text-center text-sm text-cocoa-600 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-signature-500 hover:underline font-semibold">Login</a>
            </p>
        </div>
    </div>
</section>

@endsection
