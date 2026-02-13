<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalObatWaktu extends Model
{
    use HasFactory;

    protected $table = 'jadwal_obat_waktu';

    protected $fillable = [
        'jadwal_obat_id',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime:H:i',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    
       // Relasi ke Jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_obat_id');
    }
}
