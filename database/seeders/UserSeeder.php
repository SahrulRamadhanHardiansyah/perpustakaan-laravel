<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::create([
            'id' => 1,
            'role_id' => 1, 
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), 
            'phone' => '081234567891',
            'address' => null,
            'profile_picture' => 'profile_pictures/CouYfKedtpx91x7t7e355wIpgZsQvuSw3R78iN8t.jpg',
        ]);

        User::create([
            'id' => 2,
            'role_id' => 1,
            'name' => 'Katherine Breitenberg',
            'email' => 'destin87@example.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '085711223344',
            'address' => null,
        ]);

        User::create([
            'id' => 3,
            'role_id' => 2, 
            'name' => 'Dhiya',
            'email' => 'shields.vanessa@example.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '082199887766',
            'address' => 'Patimura',
        ]);

        User::create([
            'id' => 4,
            'role_id' => 2, 
            'name' => 'Davin Prohaska',
            'email' => 'crona.michele@example.org',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '087854321098',
            'address' => null,
        ]);

        User::create([
            'id' => 5,
            'role_id' => 3, 
            'name' => 'Novta',
            'email' => 'geraldine.keebler@example.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '081366778899',
            'address' => null,
        ]);

         User::create([
            'id' => 6,
            'role_id' => 2, 
            'name' => 'Luciano Wintheiser',
            'email' => 'ebba.schaefer@example.net',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'phone' => '089612345678',
            'address' => null,
        ]);

        // use the factory for additional random users if needed
        // User::factory(5)->create(['role_id' => 2]); // Example: Create 5 more students
    }
}