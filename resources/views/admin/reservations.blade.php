@extends('layouts.admin')

@section('title', 'Reservations')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl md:text-4xl font-display font-bold text-cocoa-900">Table Reservations</h1>
    <p class="text-cocoa-500 text-sm mt-1">Manage incoming reservation requests.</p>
</div>

@if ($reservations->isEmpty())
    <div class="card text-center py-16">
        <i class="fa-solid fa-calendar-days text-5xl text-cream-400 mb-4"></i>
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
                        <th>Phone</th>
                        <th>Date / Time</th>
                        <th class="text-center">Guests</th>
                        <th>Notes</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $r)
                        <tr>
                            <td class="font-semibold">#{{ $r->id }}</td>
                            <td>
                                <div class="font-semibold text-cocoa-900">{{ $r->name }}</div>
                                <div class="text-xs text-cocoa-500">{{ $r->email }}</div>
                            </td>
                            <td><a href="tel:{{ $r->phone }}" class="text-signature-500 hover:underline">{{ $r->phone }}</a></td>
                            <td>
                                <div class="font-semibold">{{ \Carbon\Carbon::parse($r->reservation_date)->format('M d, Y') }}</div>
                                <div class="text-xs text-cocoa-500">{{ \Carbon\Carbon::parse($r->reservation_time)->format('h:i A') }}</div>
                            </td>
                            <td class="text-center font-bold text-signature-500">{{ $r->guests }}</td>
                            <td class="max-w-xs"><div class="text-xs text-cocoa-600 line-clamp-2">{{ $r->notes ?: '—' }}</div></td>
                            <td>
                                @switch($r->status)
                                    @case('confirmed') <span class="chip bg-emerald-50 text-emerald-700 border-emerald-200">Confirmed</span> @break
                                    @case('cancelled') <span class="chip bg-signature-50 text-signature-700 border-signature-200">Cancelled</span> @break
                                    @default <span class="chip-gold">Pending</span>
                                @endswitch
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-1.5">
                                    @if ($r->status !== 'confirmed')
                                        <form action="{{ route('admin.reservations.update', $r) }}" method="POST">
                                            @csrf @method('PUT') <input type="hidden" name="status" value="confirmed">
                                            <button class="h-9 w-9 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-600" title="Confirm"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                    @endif
                                    @if ($r->status !== 'cancelled')
                                        <form action="{{ route('admin.reservations.update', $r) }}" method="POST">
                                            @csrf @method('PUT') <input type="hidden" name="status" value="cancelled">
                                            <button class="h-9 w-9 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600" title="Cancel"><i class="fa-solid fa-ban"></i></button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reservations.destroy', $r) }}" method="POST" onsubmit="return confirm('Delete this reservation?')">
                                        @csrf @method('DELETE')
                                        <button class="h-9 w-9 rounded-lg bg-signature-50 hover:bg-signature-100 text-signature-600" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
