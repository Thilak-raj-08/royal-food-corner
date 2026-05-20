@extends('layouts.app')

@section('title', 'Reservations')

@section('content')

<section class="relative">
    <div class="absolute inset-0 -z-10">
        <img src="{{ asset('images/g3.jpg') }}" alt="" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-cocoa-900/85 via-cocoa-900/70 to-cream-100"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-20 text-center text-white">
        <span class="text-gold-400 font-script text-2xl">Reserve your table</span>
        <h1 class="text-5xl md:text-6xl font-display font-bold text-shadow-lg">Book a <span class="text-gold-400">Table</span></h1>
        <p class="mt-4 text-cream-200/90 max-w-xl mx-auto">Plan your visit ahead. We'll make sure your favorite spot is waiting for you.</p>
    </div>
</section>

<section class="py-12">
    <div class="max-w-5xl mx-auto px-4 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-6">

            {{-- INFO PANEL --}}
            <div class="space-y-5">
                <div class="card p-6">
                    <h3 class="font-display text-xl font-bold text-cocoa-900 flex items-center gap-2">
                        <i class="fa-regular fa-clock text-signature-500"></i>Reservation Hours
                    </h3>
                    <div class="divider-gold mt-3 mb-4"></div>
                    <ul class="space-y-2 text-sm">
                        <li class="flex justify-between"><span class="text-cocoa-600">Mon – Fri</span><span class="font-semibold">10:00 AM – 10:00 PM</span></li>
                        <li class="flex justify-between"><span class="text-cocoa-600">Sat</span><span class="font-semibold">9:00 AM – 11:00 PM</span></li>
                        <li class="flex justify-between"><span class="text-cocoa-600">Sun</span><span class="font-semibold">9:00 AM – 10:00 PM</span></li>
                    </ul>
                </div>

                <div class="card p-6 bg-cream-200/60">
                    <h3 class="font-display text-xl font-bold text-cocoa-900 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-signature-500"></i>Good to Know
                    </h3>
                    <div class="divider-gold mt-3 mb-4"></div>
                    <ul class="space-y-2.5 text-sm text-cocoa-700">
                        <li class="flex gap-2"><i class="fa-solid fa-check text-gold-500 mt-1"></i>Reservations confirmed within 2 hours via WhatsApp / phone.</li>
                        <li class="flex gap-2"><i class="fa-solid fa-check text-gold-500 mt-1"></i>For parties of 10+, please call us directly.</li>
                        <li class="flex gap-2"><i class="fa-solid fa-check text-gold-500 mt-1"></i>Tables held for 15 minutes past booking time.</li>
                        <li class="flex gap-2"><i class="fa-solid fa-check text-gold-500 mt-1"></i>No deposit required.</li>
                    </ul>
                </div>

                <a href="https://wa.me/94701234567?text=Hi%2C+I%27d+like+to+make+a+reservation" target="_blank" class="btn-whatsapp w-full">
                    <i class="fa-brands fa-whatsapp text-xl"></i>Quick book via WhatsApp
                </a>
            </div>

            {{-- FORM --}}
            <div class="card p-7">
                <h2 class="font-display text-2xl font-bold text-cocoa-900">Booking Details</h2>
                <p class="text-sm text-cocoa-500 mt-1 mb-6">Fill in your details below.</p>

                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Full Name</label>
                        <input class="input mt-1.5" name="name" value="{{ old('name', auth()->user()->username ?? '') }}" required>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Email</label>
                            <input class="input mt-1.5" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Phone</label>
                            <input class="input mt-1.5" name="phone" value="{{ old('phone') }}" required>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Date</label>
                            <input class="input mt-1.5" type="date" name="reservation_date" min="{{ date('Y-m-d') }}" value="{{ old('reservation_date') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Time</label>
                            <input class="input mt-1.5" type="time" name="reservation_time" value="{{ old('reservation_time', '19:00') }}" required>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Guests</label>
                            <select class="input mt-1.5" name="guests" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ old('guests', 2) == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ Str::plural('guest', $i) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-wider font-semibold text-cocoa-600">Special Requests <span class="text-cocoa-400 normal-case lowercase tracking-normal">(optional)</span></label>
                        <textarea class="input mt-1.5" name="notes" rows="3" placeholder="Allergies, birthday surprise, seating preference…">{{ old('notes') }}</textarea>
                    </div>
                    <button class="btn-primary w-full mt-2 !py-3.5"><i class="fa-solid fa-calendar-check"></i>Confirm Reservation</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
