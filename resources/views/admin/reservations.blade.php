@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')

<div x-data="{ search: '', status: 'all' }">

    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-cocoa-900">Reservations</h1>
            <p class="text-cocoa-500 text-sm mt-1">{{ $reservations->count() }} {{ Str::plural('booking', $reservations->count()) }}</p>
        </div>
        <div class="flex gap-2">
            <select x-model="status" class="input !py-2.5 text-sm">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-cocoa-400 text-sm"></i>
                <input x-model="search" type="text" placeholder="Search guest…" class="input pl-10 !py-2.5 text-sm w-60">
            </div>
        </div>
    </div>

    @if ($reservations->isEmpty())
        <div class="card text-center py-16">
            <i class="fa-solid fa-calendar-days text-5xl text-cream-400 mb-3"></i>
            <p class="text-cocoa-600">No reservations yet.</p>
        </div>
    @else
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table-warm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Guest</th>
                            <th>When</th>
                            <th class="text-center">Guests</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $r)
                            <tr
                                x-show="
                                    (status === 'all' || status === '{{ $r->status }}') &&
                                    (search === '' ||
                                        '{{ strtolower($r->name) }}'.includes(search.toLowerCase()) ||
                                        '{{ strtolower($r->email) }}'.includes(search.toLowerCase()) ||
                                        '{{ $r->phone }}'.includes(search))
                                "
                                class="cursor-pointer" @click="$dispatch('open-modal', 'res-{{ $r->id }}')">
                                <td class="font-semibold">#{{ $r->id }}</td>
                                <td>
                                    <div class="font-semibold text-cocoa-900">{{ $r->name }}</div>
                                    <div class="text-xs text-cocoa-500">{{ $r->phone }}</div>
                                </td>
                                <td>
                                    <div class="font-semibold">{{ \Carbon\Carbon::parse($r->reservation_date)->format('M d, Y') }}</div>
                                    <div class="text-xs text-cocoa-500">{{ \Carbon\Carbon::parse($r->reservation_time)->format('h:i A') }}</div>
                                </td>
                                <td class="text-center font-bold text-signature-500">{{ $r->guests }}</td>
                                <td>
                                    @switch($r->status)
                                        @case('confirmed') <span class="chip bg-emerald-50 text-emerald-700 border-emerald-200">Confirmed</span> @break
                                        @case('cancelled') <span class="chip bg-signature-50 text-signature-700 border-signature-200">Cancelled</span> @break
                                        @default <span class="chip-gold">Pending</span>
                                    @endswitch
                                </td>
                                <td class="text-right">
                                    <button @click.stop="$dispatch('open-modal', 'res-{{ $r->id }}')" class="h-9 w-9 rounded-lg bg-cream-200 hover:bg-cream-300 text-cocoa-700">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

{{-- ─── RESERVATION DETAILS MODALS ─── --}}
@foreach ($reservations as $r)
    <x-admin-modal name="res-{{ $r->id }}" title="Reservation #{{ $r->id }}" icon="fa-calendar-check" size="max-w-2xl">
        <div class="space-y-5">

            {{-- Status banner --}}
            @if ($r->status === 'confirmed')
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-emerald-800 text-sm font-medium flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>This reservation is confirmed.
                </div>
            @elseif ($r->status === 'cancelled')
                <div class="rounded-xl bg-signature-50 border border-signature-200 px-4 py-3 text-signature-700 text-sm font-medium flex items-center gap-2">
                    <i class="fa-solid fa-ban"></i>This reservation was cancelled.
                </div>
            @else
                <div class="rounded-xl bg-amber-50 border border-amber-200 px-4 py-3 text-amber-800 text-sm font-medium flex items-center gap-2">
                    <i class="fa-solid fa-clock"></i>Pending confirmation.
                </div>
            @endif

            {{-- Guest details --}}
            <div class="grid sm:grid-cols-2 gap-3">
                <div class="card-warm p-4">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Guest</div>
                    <div class="font-display text-lg font-bold text-cocoa-900 mt-1">{{ $r->name }}</div>
                    <div class="text-xs text-cocoa-700 mt-2 space-y-1">
                        <div><i class="fa-solid fa-envelope text-signature-500 w-4"></i> <a href="mailto:{{ $r->email }}" class="hover:underline">{{ $r->email }}</a></div>
                        <div><i class="fa-solid fa-phone text-signature-500 w-4"></i> <a href="tel:{{ $r->phone }}" class="hover:underline">{{ $r->phone }}</a></div>
                    </div>
                </div>
                <div class="card-warm p-4">
                    <div class="text-[10px] uppercase tracking-wider font-semibold text-cocoa-500">Booking</div>
                    <div class="font-display text-lg font-bold text-cocoa-900 mt-1">
                        {{ \Carbon\Carbon::parse($r->reservation_date)->format('M d, Y') }}
                    </div>
                    <div class="text-sm text-cocoa-700 mt-2">
                        <i class="fa-regular fa-clock text-signature-500 w-4"></i> {{ \Carbon\Carbon::parse($r->reservation_time)->format('h:i A') }}
                    </div>
                    <div class="text-sm text-cocoa-700 mt-1">
                        <i class="fa-solid fa-users text-signature-500 w-4"></i> {{ $r->guests }} {{ Str::plural('guest', $r->guests) }}
                    </div>
                </div>
            </div>

            @if ($r->notes)
                <div>
                    <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-cocoa-500 mb-2">Special Requests</div>
                    <div class="card-warm p-4 text-sm text-cocoa-800 italic">"{{ $r->notes }}"</div>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-cream-300">
                <div class="flex gap-2">
                    @if ($r->status !== 'confirmed')
                        <form action="{{ route('admin.reservations.update', $r) }}" method="POST">
                            @csrf @method('PUT') <input type="hidden" name="status" value="confirmed">
                            <button class="btn-primary !py-2 !px-4 text-sm bg-gradient-to-r from-emerald-500 to-emerald-700 !shadow-none">
                                <i class="fa-solid fa-check"></i>Confirm
                            </button>
                        </form>
                    @endif
                    @if ($r->status !== 'cancelled')
                        <form action="{{ route('admin.reservations.update', $r) }}" method="POST">
                            @csrf @method('PUT') <input type="hidden" name="status" value="cancelled">
                            <button class="btn-ghost !py-2 !px-4 text-sm">
                                <i class="fa-solid fa-ban"></i>Cancel
                            </button>
                        </form>
                    @endif
                </div>
                <div class="flex gap-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $r->phone) }}" target="_blank" class="btn-whatsapp !py-2 !px-4 text-sm">
                        <i class="fa-brands fa-whatsapp"></i>WhatsApp
                    </a>
                    <form action="{{ route('admin.reservations.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete reservation #{{ $r->id }}?')">
                        @csrf @method('DELETE')
                        <button class="btn-ghost !py-2 !px-4 text-sm !text-signature-500 !border-signature-300 hover:!bg-signature-50">
                            <i class="fa-solid fa-trash"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </x-admin-modal>
@endforeach

@endsection
