<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            JenisSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin Pustakawan',
            'email' => 'admin@gmail.com',
            'role_id' => 1, 
        ]);

        User::factory(5)->create([
            'role_id' => 2, 
        ]);
    }
}
