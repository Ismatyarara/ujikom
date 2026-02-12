<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
      
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'user_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'pengguna_id');
    }

    // Method Pengecekan Role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDokter(): bool
    {
        return $this->role === 'dokter';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isPengguna(): bool
    {
        return $this->role === 'user';
    }

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}