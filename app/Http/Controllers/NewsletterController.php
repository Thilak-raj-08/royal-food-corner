<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $data['email'])->exists();

        if ($existing) {
            return back()->with('info', "You're already subscribed — thanks for staying with us!");
        }

        NewsletterSubscriber::create([
            'email' => $data['email'],
            'subscribed_at' => now(),
        ]);

        return back()->with('success', '🎉 Subscribed! We will share offers and new dishes with you.');
    }
}
