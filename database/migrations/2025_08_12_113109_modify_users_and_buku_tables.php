<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->after('id')->constrained('roles');
            
            $table->dropColumn('role');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->foreignId('jenis_id')->after('judul')->constrained('jenis');

            $table->dropColumn('jenis');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['pustakawan', 'siswa'])->default('siswa');
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->string('jenis', 50);
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');
        });
    }
};