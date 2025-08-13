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
            $table->string('slug')->unique()->after('judul');
        });
    }

    /**
     * Membatalkan migrasi (menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};