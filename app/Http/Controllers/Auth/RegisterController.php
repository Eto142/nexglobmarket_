<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'lname'    => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'currency' => ['required', 'string', 'max:10'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'country'  => ['nullable', 'string', 'max:100'],
            'state'    => ['nullable', 'string', 'max:100'],
            'address'  => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'lname'    => $request->lname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'currency' => $request->currency,
            'phone'    => $request->phone,
            'country'  => $request->country,
            'state'    => $request->state,
            'address'  => $request->address,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
