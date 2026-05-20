<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages', ['messages' => Contact::latest()->get()]);
    }

    public function destroy(Contact $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
