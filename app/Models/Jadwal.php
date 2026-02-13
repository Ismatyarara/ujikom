<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'catatan_medis_id',
        'nama_obat',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'status_pengingat',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'status_pengingat' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */


    // Jadwal terkait Catatan Medis
    public function catatanMedis()
    {
        return $this->belongsTo(\App\Models\CatatanMedis::class);
    }

    // Relasi ke waktu obat
    public function waktuObat()
    {
        return $this->hasMany(JadwalObatWaktu::class, 'jadwal_obat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
