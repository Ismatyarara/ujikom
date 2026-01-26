<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

   protected $fillable = [
    'kode_obat',
    'foto',
    'nama_obat',
    'deskripsi',
    'aturan_pakai',
    'efek_samping',
    'stok',
    'harga',
    'satuan',
    'status',
];

    protected $casts = [
        'stok' => 'integer',
    ];

    // Relasi
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_obat');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_obat');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto 
            ? asset('storage/' . $this->foto) 
            : asset('assets/images/obat-default.png');
    }

    // Scope untuk filter obat tersedia
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }

    // Scope untuk filter stok menipis
    public function scopeStokMenupis($query, $batas = 10)
    {
        return $query->where('stok', '<=', $batas)->where('stok', '>', 0);
    }

    // Scope untuk filter stok habis
    public function scopeStokHabis($query)
    {
        return $query->where('stok', 0);
    }
}