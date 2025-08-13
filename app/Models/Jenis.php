<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Jenis extends Model
{
    use HasFactory, Sluggable, SoftDeletes; 

    protected $table = 'jenis';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class);
    }
}