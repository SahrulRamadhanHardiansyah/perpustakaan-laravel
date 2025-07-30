<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom primary key 'id'
            $table->string('username')->unique(); // 'username' unik untuk setiap user
            $table->string('email')->unique(); // 'username' unik untuk setiap user
            $table->string('password');
            $table->string('phone')->nullable(); // 'phone' boleh kosong (nullable)
            $table->text('address');
            $table->string('slug')->unique(); // 'slug' juga harus unik
            $table->timestamps(); // Membuat kolom 'created_at' dan 'updated_at' secara otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};