<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk menambahkan kolom.
     */
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('gambar')->nullable()->after('stok');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('gambar');
        });
    }
};