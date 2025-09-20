<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role_id',
        'profile_picture',
    ];

    /**
     * Relasi ke tabel Peminjaman.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_user');
    }

    /**
     * Relasi ke tabel Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isPustakawan(): bool
    {
        return $this->role && $this->role->name === 'Pustakawan';
    }

    public function isGuru(): bool
    {
        return $this->role && $this->role->name === 'Guru';
    }

    public function isSiswa(): bool
    {
        return $this->role && $this->role->name === 'Siswa';
    }

    /**
     * Konfigurasi untuk Sluggable.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getStatusAttribute(): string
    {
        if ($this->deleted_at) {
            return 'Banned';
        }
        return 'Active';
    }

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}