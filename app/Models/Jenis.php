<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenis extends Model
{
    protected $table = 'jenis';

    protected $fillable = [
        'name',
    ];

    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class);
    }
}