<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [ 
        'judul',
        'jenis',
        'kondisi',
        'stok',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class);
    }

    public function getStatusAttribute(): string
    {
        if ($this->stok > 0) {
            return 'Tersedia';
        } else {
            return 'Habis';
        }
    }
}