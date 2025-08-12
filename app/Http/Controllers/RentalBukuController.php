<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

        return view('rent-buku', ['siswa' => $users, 'buku' => $buku]);
    }

    public function rent(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
        ]);

        try {
            DB::beginTransaction();

            $buku = Buku::findOrFail($request->buku_id);
            $user = User::findOrFail($request->user_id);

            if ($buku->stok <= 0) {
                return redirect('rent-buku')->with('message', 'Gagal, stok buku habis!')->with('alert-class', 'alert-danger');
            }

            $peminjamanAktif = Peminjaman::where('user_id', $user->id)->where('status', 'Dipinjam')->count();
            if ($peminjamanAktif >= 3) {
                return redirect('rent-buku')->with('message', 'Gagal, user telah mencapai batas peminjaman!')->with('alert-class', 'alert-danger');
            }

            Peminjaman::create([
                'user_id' => $user->id,
                'buku_id' => $buku->id,
                'tgl_pinjam' => Carbon::now()->toDateString(),
                'tgl_jatuh_tempo' => Carbon::now()->addDay(3)->toDateString(),
                'status' => 'Dipinjam',
            ]);

            $buku->decrement('stok');

            DB::commit();

            return redirect('rent-buku')->with('message', 'Buku berhasil dipinjam!')->with('alert-class', 'alert-success');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal melakukan peminjaman: ' . $th->getMessage());
            
            return redirect('rent-buku')->with('message', 'Terjadi kesalahan saat proses peminjaman.')->with('alert-class', 'alert-danger');
        }
    }

    public function return()
    {
        $peminjamanAktif = Peminjaman::where('status', 'Dipinjam')->with(['user', 'buku'])->get();

        return view('return-buku', ['peminjaman' => $peminjamanAktif]);
    }

    public function returning(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::where('user_id', $request->user_id)
                ->where('buku_id', $request->buku_id)
                ->where('status', 'Dipinjam')
                ->first();

            if (!$peminjaman) {
                 return redirect('return-buku')->with('message', 'Gagal, data peminjaman tidak ditemukan!')->with('alert-class', 'alert-danger');
            }

            $peminjaman->tgl_kembali = Carbon::now()->toDateString();
            $peminjaman->status = 'Kembali';
            $peminjaman->save();

            $peminjaman->buku->increment('stok');
            
            DB::commit();

            return redirect('return-buku')->with('message', 'Buku berhasil dikembalikan!')->with('alert-class', 'alert-success');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal melakukan pengembalian: ' . $th->getMessage());
            return redirect('return-buku')->with('message', 'Terjadi kesalahan saat proses pengembalian.')->with('alert-class', 'alert-danger');
        }
    }
}