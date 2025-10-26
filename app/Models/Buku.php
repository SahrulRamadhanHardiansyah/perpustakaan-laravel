<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, Sluggable, SoftDeletes; 

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'barcode',
        'slug',
        'author',
        'isbn',
        'jenis_id',
        'kondisi',
        'stok',
        'gambar',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul'
            ]
        ];
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class);
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id', 'id');
    }

    public function getStatusAttribute(): string
    {
        if ($this->stok > 0) {
            return 'Tersedia';
        }

        return 'Habis';
    }
}