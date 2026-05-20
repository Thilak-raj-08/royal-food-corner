@extends('layouts.app')

@section('title', 'My Account')

@section('content')

<section class="py-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <div class="h-24 w-24 mx-auto rounded-3xl bg-gradient-to-br from-royal-500 via-royal-700 to-royal-950 grid place-items-center text-4xl font-black shadow-glow">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <h1 class="text-3xl font-display font-bold mt-5">{{ $user->username }}</h1>
            <p class="text-white/60 text-sm mt-1">{{ $user->email }}</p>
        </div>

        <div class="glass-card">
            <h2 class="text-xl font-display font-bold mb-1"><i class="fa-solid fa-user-gear text-gold-400 mr-2"></i>Edit Account</h2>
            <p class="text-sm text-white/60 mb-6">Update your profile details below. Leave password blank to keep it.</p>

            <form action="{{ route('account.update') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Username</label>
                    <input class="glass-input mt-1" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider text-white/60">Email</label>
                    <input class="glass-input mt-1" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs uppercase tracking-wider text-white/60">New Password</label>
                        <input class="glass-input mt-1" type="password" name="new_password" placeholder="••••••">
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-wider text-white/60">Confirm</label>
                        <input class="glass-input mt-1" type="password" name="new_password_confirmation" placeholder="••••••">
                    </div>
                </div>
                <button class="btn-primary w-full mt-2"><i class="fa-solid fa-floppy-disk"></i>Save Changes</button>
            </form>
        </div>
    </div>
</section>

@endsection
