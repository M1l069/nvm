<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
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

//             if(auth()->user()->must_change_password) {
//                 return redirect()->route('user.change-password.edit');
//             }

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
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request)
    {


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
