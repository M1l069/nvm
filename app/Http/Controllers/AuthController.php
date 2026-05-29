<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{

    /**
     * Show the form for logging in.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Log in user, and if must_change_password is true (user is newly created, and he is logging in for the first time)
     * he will be redirected to form for changing the password.
     */
    public function store(Request $request)
    {
        $request->validate([
           'username' => 'required|string',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');
        $remember = $request->filled('remember');


         if(Auth::attempt($credentials, $remember)) {
             $request->session()->regenerate();

             if(auth()->user()->must_change_password) {
                 return redirect()->route('user.change-password.edit');
             }

             return redirect()->intended('/');
         }

         else {
             return redirect()->back()->with('error', 'Nesprávne prihlasovacie údaje');
         }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPassword()
    {
        return view('auth.edit');
    }

    /**
     * Update user's password.
     */
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()]
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($data['password']),
            'must_change_password' => false
        ]);

        return redirect()->route('home')->with('success', 'Heslo bolo úspešne zmenené');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
