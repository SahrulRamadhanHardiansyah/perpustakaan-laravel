<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
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
            'name' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
             /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user->isPustakawan()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('welcome');
        }

        Session::flash('status', 'The provided credentials do not match our records.');

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ])->onlyInput('name');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registering(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:users', 'max:255'],
            'email' => ['required', 'unique:users', 'email:dns', 'max:255'],
            'password' => ['required', 'max:255', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'], 
            'address' => ['required', 'string'],
        ]);

        $siswaRole = Role::where('name', 'siswa')->first();

        if (!$siswaRole) {
            return back()->with('error', 'Registrasi gagal, role default tidak ditemukan.');
        }

        $validatedData['role_id'] = $siswaRole->id;
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
