<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class RentalBukuController extends Controller
{
    public function index()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'siswa');
        })->get();

        $buku = Buku::where('stok', '>', 0)->get();

        return view('admin.rent-buku', ['siswa' => $users, 'buku' => $buku]);
    }

    public function rent(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:today', // Wajib diisi, format tanggal, dan tidak boleh tanggal kemarin
        ]);

        try {
            DB::beginTransaction();

            $buku = Buku::findOrFail($request->buku_id);
            $user = User::findOrFail($request->user_id);

            if ($buku->stok <= 0) {
                return redirect()->route('admin.rent.buku')->with('message', 'Gagal, stok buku habis!')->with('alert-class', 'alert-danger');
            }

            $peminjamanAktif = Peminjaman::where('user_id', $user->id)->where('status', 'Dipinjam')->count();
            if ($peminjamanAktif >= 3) {
                return redirect()->route('admin.rent.buku')->with('message', 'Gagal, user telah mencapai batas peminjaman!')->with('alert-class', 'alert-danger');
            }

            Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tgl_pinjam' => Carbon::now()->toDateString(),
            'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
            'status' => 'Dipinjam',
        ]);

            $buku->decrement('stok');

            DB::commit();

            return redirect()->route('admin.rent.buku')->with('message', 'Buku berhasil dipinjam!')->with('alert-class', 'alert-success');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal melakukan peminjaman: ' . $th->getMessage());

            return redirect()->route('admin.rent.buku')->with('message', 'Terjadi kesalahan saat proses peminjaman.')->with('alert-class', 'alert-danger');
        }
    }

    public function return()
    {
        $peminjamanAktif = Peminjaman::where('status', 'Dipinjam')->with(['user', 'buku'])->get();

        return view('admin.return-buku', ['peminjaman' => $peminjamanAktif]);
    }

    public function returning(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

            if ($peminjaman->status !== 'Dipinjam') {
                return redirect()->route('admin.return.buku')
                    ->with('message', 'Gagal, buku ini statusnya sudah bukan dipinjam!')
                    ->with('alert-class', 'alert-warning');
            }

            $tarif_denda_harian = 5000;
            $total_denda = 0;
            $tgl_kembali = Carbon::now();
            $tgl_jatuh_tempo = Carbon::parse($peminjaman->tgl_jatuh_tempo);

            if ($tgl_kembali->gt($tgl_jatuh_tempo)) {
                $hari_terlambat = $tgl_kembali->diffInDays($tgl_jatuh_tempo);
                $total_denda = $hari_terlambat * $tarif_denda_harian;
            }

            $peminjaman->tgl_kembali = $tgl_kembali->toDateString();
            $peminjaman->status = 'Kembali';
            $peminjaman->denda = $total_denda;
            $peminjaman->save();

            $peminjaman->buku->increment('stok');
            
            DB::commit();

            return redirect()->route('admin.return.buku')
                ->with('message', 'Buku berhasil dikembalikan! Denda: Rp ' . number_format($total_denda))
                ->with('alert-class', 'alert-success');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal melakukan pengembalian: ' . $th->getMessage());
            return redirect()->route('admin.return.buku')
                ->with('message', 'Terjadi kesalahan saat proses pengembalian.')
                ->with('alert-class', 'alert-danger');
        }
    }

    public function pinjamBuku()
    {
        $buku = Buku::where('stok', '>', 0)->get();
        return view('pinjam-buku', ['buku' => $buku]);
    }

    public function prosesPinjamBuku(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tgl_jatuh_tempo' => 'required|date|after_or_equal:today',
        ]);

        $userId = Auth::id();

        try {
            DB::beginTransaction();

            $buku = Buku::findOrFail($request->buku_id);

            if ($buku->stok <= 0) {
                return redirect()->route('pinjam.buku')->with('message', 'Gagal, stok buku baru saja habis!')->with('alert-class', 'alert-danger');
            }

            $peminjamanAktif = Peminjaman::where('user_id', $userId)->where('status', 'Dipinjam')->count();
            if ($peminjamanAktif >= 3) {
                return redirect()->route('pinjam.buku')->with('message', 'Gagal, Anda telah mencapai batas peminjaman!')->with('alert-class', 'alert-danger');
            }

            Peminjaman::create([
                'user_id' => $userId, 
                'buku_id' => $buku->id,
                'tgl_pinjam' => Carbon::now()->toDateString(),
                'tgl_jatuh_tempo' => $request->tgl_jatuh_tempo,
                'status' => 'Dipinjam',
            ]);

            $buku->decrement('stok');

            DB::commit();

            return redirect()->route('pinjam.buku')->with('message', 'Buku berhasil dipinjam!')->with('alert-class', 'alert-success');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Siswa gagal pinjam buku: ' . $th->getMessage());
            return redirect()->route('pinjam.buku')->with('message', 'Terjadi kesalahan saat proses peminjaman.')->with('alert-class', 'alert-danger');
        }
    }

    public function peminjaman()
    {
        $logPeminjaman = Peminjaman::with(['user', 'buku'])->latest()->get();

        return view('admin.logPeminjaman', ['logPeminjaman' => $logPeminjaman]);
    }

}