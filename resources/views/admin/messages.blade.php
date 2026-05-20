@extends('layouts.admin')

@section('title', 'Customer Messages')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl md:text-4xl font-display font-bold">Customer Messages</h1>
    <p class="text-white/60 text-sm mt-1">Messages received via the contact form.</p>
</div>

@if ($messages->isEmpty())
    <div class="glass-card text-center py-16">
        <i class="fa-regular fa-message text-4xl text-white/30 mb-3"></i>
        <p class="text-white/70">No messages yet.</p>
    </div>
@else
    <div class="grid md:grid-cols-2 gap-5">
        @foreach ($messages as $m)
            <div class="glass-card">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-royal-500 to-royal-700 grid place-items-center font-bold">
                            {{ strtoupper(substr($m->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold">{{ $m->name }}</div>
                            <div class="text-xs text-white/60">{{ $m->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.messages.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                        @csrf @method('DELETE')
                        <button class="h-9 w-9 rounded-xl bg-rose-500/15 hover:bg-rose-500/30 text-rose-300"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-white/70"><i class="fa-solid fa-envelope text-gold-400"></i>{{ $m->email }}</div>
                    <div class="flex items-center gap-2 text-white/70"><i class="fa-solid fa-phone text-gold-400"></i>{{ $m->phone }}</div>
                </div>
                <hr class="border-white/10 my-4">
                <p class="text-white/85 italic">"{{ $m->message }}"</p>
            </div>
        @endforeach
    </div>
@endif

@endsection
