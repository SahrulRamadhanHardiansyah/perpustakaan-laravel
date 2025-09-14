<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DendaController extends Controller
{
    public function index()
    {
        $dendaBelumLunas = Peminjaman::where('denda', '>', 0)
            ->where('status_denda', 'Belum Lunas')
            ->with(['user', 'buku'])
            ->latest()
            ->get();
            
        return view('admin.denda.index', ['dendaList' => $dendaBelumLunas]);
    }

    public function bayar(Request $request, $peminjaman_id)
    {
        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($peminjaman_id);

            Pembayaran::create([
                'peminjaman_id' => $peminjaman->id,
                'jumlah_bayar' => $peminjaman->denda,
                'tgl_bayar' => Carbon::now(),
            ]);

            $peminjaman->status_denda = 'Lunas';
            $peminjaman->save();

            DB::commit();

            return redirect()->route('admin.denda.index')->with('status', 'Denda berhasil dibayar.');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal bayar denda: ' . $th->getMessage());
            return redirect()->route('admin.denda.index')->with('error', 'Terjadi kesalahan saat proses pembayaran denda.');
        }
    }
}