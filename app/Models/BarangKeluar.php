<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    protected $fillable = [
        'id_obat',
        'kode',
        'jumlah',
        'tanggal_keluar',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
        'jumlah' => 'integer',
    ];

    // Relasi
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    // Scope untuk filter transaksi hari ini
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_keluar', today());
    }

    // Scope untuk filter transaksi bulan ini
    public function scopeBulanIni($query)
    {
        return $query->whereMonth('tanggal_keluar', now()->month)
                     ->whereYear('tanggal_keluar', now()->year);
    }
}