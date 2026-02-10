<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'nama',
        'spesialisasi_id',
        'pengalaman',
        'foto',
        'jadwal_praktik_hari',
        'jadwal_praktik_waktu',
        'tempat_praktik',
    ];

    protected $appends = ['foto_url'];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'spesialisasi_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : asset('assets/images/faces/face1.jpg');
    }
}
