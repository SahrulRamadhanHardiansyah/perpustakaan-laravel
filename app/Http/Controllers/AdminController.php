<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $hitungBuku = Buku::count();
        $hitungJenis = Jenis::count();
        $hitungSiswa = User::whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->count();

        $logPeminjaman  = Peminjaman::with(['user', 'buku'])->latest()->limit(10)->get();

        return view('admin.dashboard', [
            'hitungBuku' => $hitungBuku,
            'hitungJenis' => $hitungJenis,
            'hitungSiswa' => $hitungSiswa,
            'logPeminjaman' => $logPeminjaman,
        ]);
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.index', ['user' => $user]);
    }

    public function profileEdit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', ['user' => $user]);
    }

    public function profileUpdate(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'phone' => 'numeric',
            'address' => 'string|nullable',
        ]);

        $user->update($request->only('name', 'email', 'phone', 'address'));

        return redirect()->route('admin.profile.index')->with('status', 'Profil berhasil diperbarui.');
    }

    public function showSiswa()
    {
        $siswa = User::whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->get();

        return view('admin.siswa.index', ['siswa' => $siswa]);
    }

    public function detail($slug) // detail siswa
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        $logPeminjaman = Peminjaman::with(['user', 'buku'])->where('user_id', $siswa->id)->latest()->get();
        return view('admin.siswa.detail', ['siswa' => $siswa, 'logPeminjaman' => $logPeminjaman]);
    }

    public function edit($slug) // edit siswa
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        return view('admin.siswa.edit', ['siswa' => $siswa]);
    }

    public function update(Request $request, $slug) // edit siswa
    {
        $siswa = User::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'phone' => 'numeric',
            'address' => 'string|nullable',
            'role_id' => 'in:1,2,3',
        ]);

        $siswa->update($request->only('name', 'phone', 'address', 'role_id'));

        return redirect()->route('admin.siswa.index')->with('status', 'Siswa berhasil diperbarui.');
    }

    public function ban($slug) // ban siswa (soft delete)
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        return view('admin.siswa.ban-confirm', ['siswa' => $siswa]);
    }

    public function banned() // ban siswa (soft delete)
    {
        $bannedSiswa = User::onlyTrashed()->whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->get();
        return view('admin.siswa.banned', ['bannedSiswa' => $bannedSiswa]);
    }

    public function restore($slug) // pulihkan siswa
    {
        $siswa = User::withTrashed()->where('slug', $slug)->firstOrFail();
        $siswa->restore();
        return redirect()->route('admin.siswa.banned')->with('status', 'Siswa berhasil dipulihkan.');
    }

    public function destroy($slug) // hapus siswa
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        $siswa->delete(); 
        return redirect()->route('admin.siswa.index')->with('status', 'Siswa berhasil di-ban.');
    }


    // public function delete($slug)
    // {
    //     $siswa = User::withTrashed()->where('slug', $slug)->firstOrFail();
    //     $siswa->forceDelete(); 
    //     return redirect()->route('admin.siswa.banned')->with('status', 'Siswa berhasil dihapus permanen.');
    // }

}