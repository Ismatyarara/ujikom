<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'nama_panjang',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'no_hp',
        'alamat',
        'foto', // opsional
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // Accessor umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : null;
    }
}
