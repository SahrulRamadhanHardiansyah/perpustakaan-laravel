<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Peminjaman;
use App\Models\User;

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

    public function showSiswa()
    {
        $siswa = User::whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->get();

        return view('admin.siswa.index', ['siswa' => $siswa]);
    }

    public function detail($slug)
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        $logPeminjaman = Peminjaman::with(['user', 'buku'])->where('user_id', $siswa->id)->latest()->get();
        return view('admin.siswa.detail', ['siswa' => $siswa, 'logPeminjaman' => $logPeminjaman]);
    }
    
    public function ban($slug)
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        return view('admin.siswa.ban-confirm', ['siswa' => $siswa]);
    }

    public function destroy($slug)
    {
        $siswa = User::where('slug', $slug)->firstOrFail();
        $siswa->delete(); 
        return redirect()->route('admin.siswa.index')->with('status', 'Siswa berhasil di-ban.');
    }

    public function banned()
    {
        $bannedSiswa = User::onlyTrashed()->whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->get();
        return view('admin.siswa.banned', ['bannedSiswa' => $bannedSiswa]);
    }

    public function restore($slug)
    {
        $siswa = User::withTrashed()->where('slug', $slug)->firstOrFail();
        $siswa->restore();
        return redirect()->route('admin.siswa.banned')->with('status', 'Siswa berhasil dipulihkan.');
    }

    // public function delete($slug)
    // {
    //     $siswa = User::withTrashed()->where('slug', $slug)->firstOrFail();
    //     $siswa->forceDelete(); 
    //     return redirect()->route('admin.siswa.banned')->with('status', 'Siswa berhasil dihapus permanen.');
    // }

}