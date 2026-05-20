@extends('layouts.admin')

@section('title', 'Customer Messages')

@section('content')

<div x-data="{ search: '' }">

    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Customer Messages</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $messages->count() }} {{ Str::plural('message', $messages->count()) }} from the contact form</p>
        </div>
        <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-cocoa-400 text-sm"></i>
            <input x-model="search" type="text" placeholder="Search…" class="input pl-10 !py-2.5 text-sm w-72">
        </div>
    </div>

    @if ($messages->isEmpty())
        <div class="card text-center py-16">
            <i class="fa-regular fa-message text-5xl text-cream-400 mb-3"></i>
            <p class="text-cocoa-600">No messages yet.</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-5">
            @foreach ($messages as $m)
                <div
                    x-show="
                        search === '' ||
                        '{{ strtolower($m->name) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower($m->email) }}'.includes(search.toLowerCase()) ||
                        '{{ strtolower(addslashes(\Illuminate\Support\Str::limit($m->message, 100))) }}'.includes(search.toLowerCase())
                    "
                    class="card p-5 hover:shadow-soft-lg transition cursor-pointer" @click="$dispatch('open-modal', 'msg-{{ $m->id }}')">
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
                        <button @click.stop="$dispatch('open-modal', 'msg-{{ $m->id }}')" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300 text-cocoa-700">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-sm text-cocoa-700 mt-4 line-clamp-3 italic">"{{ $m->message }}"</p>
                    <div class="flex items-center gap-4 mt-4 pt-4 border-t border-cream-300 text-xs text-cocoa-500">
                        <span><i class="fa-solid fa-envelope text-signature-500"></i> {{ Str::limit($m->email, 25) }}</span>
                        <span><i class="fa-solid fa-phone text-signature-500"></i> {{ $m->phone }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ─── MESSAGE VIEW MODALS ─── --}}
@foreach ($messages as $m)
    <x-admin-modal name="msg-{{ $m->id }}" title="Message from {{ $m->name }}" icon="fa-message" size="max-w-xl">
        <div class="space-y-4">
            <div class="flex items-center gap-4 pb-4 border-b border-cream-300">
                <div class="h-14 w-14 rounded-xl bg-red-gradient grid place-items-center text-white text-xl font-bold">
                    {{ strtoupper(substr($m->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-display text-xl font-bold text-cocoa-900">{{ $m->name }}</div>
                    <div class="text-xs text-cocoa-500">{{ $m->created_at->format('M d, Y · h:i A') }} ({{ $m->created_at->diffForHumans() }})</div>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <a href="mailto:{{ $m->email }}" class="card-warm p-3 flex items-center gap-3 hover:border-signature-500 transition">
                    <i class="fa-solid fa-envelope text-signature-500"></i>
                    <div>
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Email</div>
                        <div class="text-sm font-semibold text-cocoa-900">{{ $m->email }}</div>
                    </div>
                </a>
                <a href="tel:{{ $m->phone }}" class="card-warm p-3 flex items-center gap-3 hover:border-signature-500 transition">
                    <i class="fa-solid fa-phone text-signature-500"></i>
                    <div>
                        <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Phone</div>
                        <div class="text-sm font-semibold text-cocoa-900">{{ $m->phone }}</div>
                    </div>
                </a>
            </div>

            <div>
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-cocoa-500 mb-2">Message</div>
                <div class="card-warm p-4 text-cocoa-800 leading-relaxed">{{ $m->message }}</div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-cream-300">
                <div class="flex gap-2">
                    <a href="mailto:{{ $m->email }}?subject=Re: Your message to Royal Food Corner" class="btn-primary !py-2 !px-4 text-sm">
                        <i class="fa-solid fa-reply"></i>Reply via Email
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $m->phone) }}" target="_blank" class="btn-whatsapp !py-2 !px-4 text-sm">
                        <i class="fa-brands fa-whatsapp"></i>WhatsApp
                    </a>
                </div>
                <form action="{{ route('admin.messages.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button class="btn-ghost !py-2 !px-4 text-sm !text-signature-500 !border-signature-300 hover:!bg-signature-50">
                        <i class="fa-solid fa-trash"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </x-admin-modal>
@endforeach

@endsection
