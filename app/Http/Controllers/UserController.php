<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
     public function index(Request $request)
    {
        $jenis = Jenis::all();

        $bukuQuery = Buku::with('jenis');

        if ($request->filled('judul')) {
            $bukuQuery->where('judul', 'like', '%' . $request->judul . '%');
        }

        if ($request->filled('jenis')) {
            $bukuQuery->where('jenis_id', $request->jenis);
        }

        $buku = $bukuQuery->paginate(12);

        return view('welcome', [
            'buku' => $buku,
            'jenis' => $jenis,
            'user' => Auth::user(),
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        $logPeminjaman = Peminjaman::with(['user', 'buku'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('profile.index', [
            'user' => $user,
            'logPeminjaman' => $logPeminjaman
        ]);
    }

    public function edit() {
        $user = Auth::user();
        return view('profile.edit', ['user' => $user]);
    }

    public function update(Request $request) {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        if ($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->save();

            return redirect(route('profile'))->with('status', 'Profile berhasil diperbarui');
        }

        return redirect(route('profile'))->with('error', 'Gagal memperbarui profil. Pengguna tidak ditemukan');
    }

    
    public function detail($slug)
    {
        $user = User::where('slug', $slug)->first();
        $peminjaman = Peminjaman::with(['user', 'buku'])->where('user_id', $user->id)->get();
        return view('admin.users-detail', ['user' => $user, 'peminjaman' => $peminjaman]);
    }

    
    public function ban($slug) {
        $user = User::where('slug', $slug)->first();
        return view('admin.user-ban', ['user' => $user]);
    }

    public function delete($slug)
    {
        $user = User::where('slug', $slug)->first();
        $user->delete();
        return redirect('admin.users')->with('status', 'User banned successfully');
    }
    public function banned()
    {
        $user = User::onlyTrashed()->get();
        return view('admin.users-banned', ['bannedUser' => $user]);
    }

    public function restore($slug)
    {
        $user = User::withTrashed()->where('slug', $slug)->first();
        $user->restore();
        return redirect('admin.users')->with('status', 'User restored successfully');
    }
}
