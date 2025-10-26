<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; 

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Peminjaman::truncate();
        Schema::enableForeignKeyConstraints();

        $peminjamanData = [
            [
                'id' => 4, 
                'user_id' => 2, 
                'buku_id' => 1, 
                'tgl_pinjam' => '2025-08-13',
                'tgl_jatuh_tempo' => '2025-08-20', 
                'tgl_kembali' => '2025-08-13', 
                'denda' => 0,
                'status_denda' => 'Lunas', 
                'status' => 'Kembali',
                'created_at' => '2025-08-13 14:00:24', 
                'updated_at' => '2025-08-13 14:01:41'
            ],
            [
                'id' => 5, 
                'user_id' => 3, 
                'buku_id' => 1, 
                'tgl_pinjam' => '2025-08-14',
                'tgl_jatuh_tempo' => '2025-08-21', 
                'tgl_kembali' => '2025-09-10', 
                'denda' => 102304,
                'status_denda' => 'Lunas', 
                'status' => 'Kembali',
                'created_at' => '2025-08-14 01:11:43', 
                'updated_at' => '2025-09-10 11:03:38'
            ],
            [
                'id' => 18, 
                'user_id' => 3, 
                'buku_id' => 10, 
                'tgl_pinjam' => '2025-09-19',
                'tgl_jatuh_tempo' => '2025-10-27',
                'tgl_kembali' => null, 
                'denda' => 0,
                'status_denda' => 'Belum Lunas', 
                'status' => 'Dipinjam',
                'created_at' => '2025-09-19 22:57:34', 
                'updated_at' => '2025-09-19 22:57:34'
            ],
            [
                'id' => 17, 
                'user_id' => 6, 
                'buku_id' => 2, 
                'tgl_pinjam' => '2025-09-10',
                'tgl_jatuh_tempo' => '2025-09-13',
                'tgl_kembali' => null, 
                'denda' => 0, 
                'status_denda' => 'Belum Lunas', 
                'status' => 'Dipinjam',
                'created_at' => '2025-09-10 20:59:05', 
                'updated_at' => '2025-09-10 20:59:05'
            ],
        ];

        Peminjaman::insert($peminjamanData);
    }
}