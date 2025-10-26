<?php

namespace Database\Seeders;

use App\Models\Jenis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; 

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Jenis::truncate();
        Schema::enableForeignKeyConstraints();

        $jenisBuku = [
            ['id' => 1, 'name' => 'Novel'],
            ['id' => 2, 'name' => 'Pelajaran'],
            ['id' => 3, 'name' => 'Referensi'],
            ['id' => 4, 'name' => 'Komik'],
            ['id' => 5, 'name' => 'Majalah'],
            ['id' => 6, 'name' => 'Jurnal'],
            ['id' => 7, 'name' => 'Ekonomi'],
            ['id' => 8, 'name' => 'Fiksi Klasik'],
            ['id' => 9, 'name' => 'Fantasi'],
            ['id' => 10, 'name' => 'Fiksi Ilmiah'],
            ['id' => 11, 'name' => 'Horor'],
            ['id' => 12, 'name' => 'Romansa'],
            ['id' => 13, 'name' => 'Sastra klasik'],
            ['id' => 14, 'name' => 'Thriller'],
            ['id' => 15, 'name' => 'Sejarah'],
            ['id' => 16, 'name' => 'Psikologi'],
        ];

        Jenis::insert($jenisBuku);

        foreach (Jenis::all() as $jenis) {
            $jenis->save(); 
        }
    }
}