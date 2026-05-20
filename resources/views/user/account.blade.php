@extends('layouts.app')

@section('title', 'My Account')

@section('content')

<section class="py-14">
    <div class="max-w-3xl mx-auto px-4 lg:px-8">
        <div class="text-center mb-10">
            <div class="h-24 w-24 mx-auto rounded-2xl bg-red-gradient grid place-items-center text-4xl font-display font-black text-white shadow-soft">
                {{ strtoupper(substr($user->username, 0, 1)) }}
            </div>
            <h1 class="font-display text-3xl font-bold text-cocoa-900 mt-5">{{ $user->username }}</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $user->email }}</p>
        </div>

        <div class="card p-7">
            <h2 class="font-display text-xl font-bold text-cocoa-900 flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-signature-500"></i>Edit Account
            </h2>
            <p class="text-sm text-cocoa-500 mt-1 mb-6">Update your profile. Leave password blank to keep it.</p>

            <form action="{{ route('account.update') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Username</label>
                    <input class="input mt-1.5" name="username" value="{{ old('username', $user->username) }}" required>
                </div>
                <div>
                    <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Email</label>
                    <input class="input mt-1.5" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">New Password</label>
                        <input class="input mt-1.5" type="password" name="new_password" placeholder="••••••">
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Confirm</label>
                        <input class="input mt-1.5" type="password" name="new_password_confirmation" placeholder="••••••">
                    </div>
                </div>
                <button class="btn-primary w-full mt-2"><i class="fa-solid fa-floppy-disk"></i>Save Changes</button>
            </form>
        </div>
    </div>
</section>

@endsection
