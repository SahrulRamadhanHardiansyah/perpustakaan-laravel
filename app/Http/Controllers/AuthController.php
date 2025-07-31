<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect('/');
        }

        Session::flash('status', 'The provided credentials do not match our records.');

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registering(Request $request)
    {
        $validatedData = $request->validate([
            'username' => ['required', 'unique:users', 'max:255'],
            'email'    => ['required', 'unique:users', 'email:dns', 'max:255', 'regex:/^[^@]+@[^@]+\..[^@]+$/'],
            'password' => ['required', 'max:255', 'min:8'],
            'confirm-password' => ['required', 'min:8', 'same:password'], 
            'phone'    => ['nullable', 'string', 'max:20'], 
            'address'  => ['required', 'string'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
