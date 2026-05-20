<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit()
    {
        return view('user.account', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'username'             => ['required', 'string', 'min:3', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email'                => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'new_password'         => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->username = $data['username'];
        $user->email = $data['email'];
        if (! empty($data['new_password'])) {
            $user->password = $data['new_password'];
        }
        $user->save();

        return back()->with('success', 'Account updated successfully.');
    }
}
