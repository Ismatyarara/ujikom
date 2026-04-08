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
        'kode_pasien',
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


    // app/Models/User.php

public static function generateKodePasien(): string
{
    // Ambil data user terakhir berdasarkan ID terbesar
    $lastRecord = User::latest('id')->first();
    
    // Kalau belum ada data → ID = 0, kalau ada → ambil ID-nya
    $lastId = $lastRecord ? $lastRecord->id : 0;
    
    // Ambil tahun sekarang, contoh hasilnya: 2025
    $tahun = date('Y');
    
    // Gabungkan semua jadi kode pasien
    // str_pad → memastikan angka selalu 4 digit (0001, 0012, 0123, dst)
    // +1 supaya kode untuk pasien BERIKUTNYA, bukan yang terakhir
    $kode = 'BTK-' . $tahun . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    
    return $kode;
}
}