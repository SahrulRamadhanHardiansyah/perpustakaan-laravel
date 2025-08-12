<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    public function run(): void
    {
        Jenis::create(['name' => 'Novel']);
        Jenis::create(['name' => 'Pelajaran']);
        Jenis::create(['name' => 'Referensi']);
        Jenis::create(['name' => 'Komik']);
        Jenis::create(['name' => 'Majalah']);
    }
}