<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
     public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $jenis = Jenis::all();
        $bukuQuery = Buku::with('jenis');

        if ($request->filled('keyword')) {
            $bukuQuery->where(function ($query) use ($request) {
                $query->where('judul', 'like', '%' . $request->keyword . '%')
                    ->orWhere('author', 'like', '%' . $request->keyword . '%')
                    ->orWhere('barcode', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('jenis')) {
            $bukuQuery->where('jenis_id', $request->jenis);
        }

        $buku = $bukuQuery->paginate(12);

        $pinjamanSiswa = null;
        if ($user->isSiswa()) {
            $pinjamanSiswa = Peminjaman::where('user_id', $user->id)->whereNull('tgl_kembali')->get();
        }
        
        return view('welcome', [
            'user' => $user,
            'buku' => $buku,
            'jenis' => $jenis,
            'pinjamanSiswa' => $pinjamanSiswa,
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

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $updateData = $request->only('name', 'phone', 'address');
        
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $updateData['profile_picture'] = $path;
        }

        $user->update($updateData);

        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui.');
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
