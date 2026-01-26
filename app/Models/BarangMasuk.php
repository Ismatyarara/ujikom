<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'id_obat',
        'kode',
        'jumlah',
        'tanggal_masuk',
        'deskripsi',
        'tanggal_kadaluwarsa',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_kadaluwarsa' => 'date',
        'jumlah' => 'integer',
    ];

    // Relasi
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    // Scope untuk filter barang yang akan segera kadaluwarsa
    public function scopeAkanKadaluwarsa($query, $hari = 30)
    {
        return $query->whereDate('tanggal_kadaluwarsa', '<=', now()->addDays($hari));
    }

    // Scope untuk filter barang yang sudah kadaluwarsa
    public function scopeSudahKadaluwarsa($query)
    {
        return $query->whereDate('tanggal_kadaluwarsa', '<', now());
    }
}