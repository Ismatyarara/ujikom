<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanMedis extends Model
{
    use HasFactory;

    protected $table = 'catatan_medis';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'keluhan',
        'diagnosa',
        'deskripsi',
        'tanggal_catatan',
    ];

      protected $casts = [
        'tanggal_catatan' => 'datetime',
    ];

    // Scope untuk filter catatan terbaru
    public function scopeTerbaru($query, $hari = 30)
    {
        return $query->whereDate('tanggal_catatan', '>=', now()->subDays($hari))
                     ->orderBy('tanggal_catatan', 'desc');
    }
}