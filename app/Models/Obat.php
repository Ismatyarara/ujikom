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
        'user_id',
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'stok'               => 'integer',
        'harga'              => 'float',
        'status'             => 'boolean',
    ];

    // ==================== Relationships ====================

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_obat');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'id_obat');
    }

    // ==================== Accessors ====================

        public function getFotoUrlAttribute(): ?string
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : null;
    }

    public function getIsAktifAttribute(): bool
    {
        $status = $this->getRawOriginal('status');

        if (is_bool($status) || is_numeric($status)) {
            return (bool) $status;
        }

        return strtolower(trim((string) $status)) === 'aktif';
    }

    // ==================== Scopes ====================

    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0);
    }

    public function scopeStokMenupis($query, int $batas = 10)
    {
        return $query->whereBetween('stok', [1, $batas]);
    }

    public function scopeStokHabis($query)
    {
        return $query->where('stok', 0);
    }
}
