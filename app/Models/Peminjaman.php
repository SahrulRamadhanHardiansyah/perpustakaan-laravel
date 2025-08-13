<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;
    
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_jatuh_tempo',
        'denda',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function isTerlambat(): bool
    {
        return $this->status === 'Dipinjam' && Carbon::now()->gt($this->tgl_jatuh_tempo);
    }
}