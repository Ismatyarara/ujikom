<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'pengguna_id',
        'waktu_minum',
        'status_pengingat',
    ];

    protected $casts = [
        'waktu_minum' => 'datetime:H:i',
        'status_pengingat' => 'boolean',
    ];

    // Relasi
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    // Scope untuk filter jadwal aktif
    public function scopeAktif($query)
    {
        return $query->where('status_pengingat', 1);
    }

    // Scope untuk filter jadwal yang akan datang
    public function scopeAkanDatang($query)
    {
        return $query->where('waktu_minum', '>=', now()->format('H:i'));
    }
}