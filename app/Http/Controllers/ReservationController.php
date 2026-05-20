<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create()
    {
        return view('user.reservation');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|max:20',
            'reservation_date' => 'required|date|after_or_equal:today',
            'reservation_time' => 'required',
            'guests'           => 'required|integer|min:1|max:50',
            'notes'            => 'nullable|string|max:1000',
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        Reservation::create($data);

        return redirect()->route('reservations.create')
            ->with('success', 'Thank you! Your reservation request has been received — we will confirm shortly.');
    }
}
