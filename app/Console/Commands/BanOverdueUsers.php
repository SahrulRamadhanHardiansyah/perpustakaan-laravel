<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BanOverdueUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ban-overdue-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mencari dan mem-ban (soft delete) siswa yang telat mengembalikan buku lebih dari 30 hari.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan peminjaman yang terlambat...');

        // Tentukan tanggal batas (30 hari yang lalu dari sekarang)
        $deadline = Carbon::now()->subDays(30)->toDateString();

        // Cari semua peminjaman yang statusnya 'Dipinjam' dan sudah melewati batas 30 hari
        $overdueLoans = Peminjaman::where('status', 'Dipinjam')
                                  ->where('tgl_jatuh_tempo', '<', $deadline)
                                  ->get();

        if ($overdueLoans->isEmpty()) {
            $this->info('Tidak ada siswa yang perlu di-ban hari ini.');
            return;
        }

        // Ambil ID user yang unik dari peminjaman yang terlambat
        $userIdsToBan = $overdueLoans->pluck('user_id')->unique();

        // Ban (soft delete) semua user yang ada di daftar
        $bannedCount = User::whereIn('id', $userIdsToBan)->delete();

        if ($bannedCount > 0) {
            $this->info("Proses selesai. Sebanyak {$bannedCount} siswa telah di-ban.");
            Log::info("Auto-ban: {$bannedCount} siswa di-ban karena terlambat lebih dari 30 hari.");
        } else {
            $this->info('Tidak ada siswa baru yang di-ban (mungkin sudah di-ban sebelumnya).');
        }
    }
}