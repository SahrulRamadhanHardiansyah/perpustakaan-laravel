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
    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_buku')->constrained('buku')->onDelete('cascade');
        $table->date('tgl_pinjam');
        $table->date('tgl_kembali')->nullable();
        $table->integer('denda')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};