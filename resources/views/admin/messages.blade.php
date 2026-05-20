@extends('layouts.admin')

@section('title', 'Customer Messages')

@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Customer Messages</h1>
    <p class="text-cocoa-500 text-sm mt-1">Messages received via the contact form.</p>
</div>

@if ($messages->isEmpty())
    <div class="card text-center py-16">
        <i class="fa-regular fa-message text-5xl text-cream-400 mb-3"></i>
        <p class="text-cocoa-600">No messages yet.</p>
    </div>
@else
    <div class="grid md:grid-cols-2 gap-5">
        @foreach ($messages as $m)
            <div class="card p-6">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-11 w-11 rounded-xl bg-red-gradient grid place-items-center text-white font-bold">
                            {{ strtoupper(substr($m->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-semibold text-cocoa-900">{{ $m->name }}</div>
                            <div class="text-xs text-cocoa-500">{{ $m->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    <form action="{{ route('admin.messages.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                        @csrf @method('DELETE')
                        <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-500"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-cocoa-700"><i class="fa-solid fa-envelope text-signature-500 w-4"></i>{{ $m->email }}</div>
                    <div class="flex items-center gap-2 text-cocoa-700"><i class="fa-solid fa-phone text-signature-500 w-4"></i>{{ $m->phone }}</div>
                </div>
                <hr class="border-cream-400 my-4">
                <p class="text-cocoa-700 italic">"{{ $m->message }}"</p>
            </div>
        @endforeach
    </div>
@endif

@endsection
