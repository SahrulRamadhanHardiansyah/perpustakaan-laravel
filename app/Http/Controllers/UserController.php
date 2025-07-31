<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('welcome', ['user' => $user]);
    }

    public function edit() {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request) {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $user = User::find(Auth::id());

        if ($user) {
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            redirect(route('welcome'))->with('status', 'Profile berhasil diperbarui');
        }

        redirect(route('welcome'))->with('error', 'Gagal memperbarui profil. Pengguna tidak ditemukan');
    }
}
