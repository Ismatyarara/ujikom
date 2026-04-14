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
        'is_verified',
        'verified_at',
        'verified_by',
    ];

    protected $appends = ['foto_url', 'inisial_nama'];
    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'spesialisasi_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : null;
    }

    public function getInisialNamaAttribute()
    {
        $nama = trim((string) $this->nama);

        if ($nama === '') {
            return 'DR';
        }

        $bagianNama = preg_split('/\s+/', $nama, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $inisial = collect($bagianNama)
            ->take(2)
            ->map(function ($item) {
                return strtoupper(substr($item, 0, 1));
            })
            ->implode('');

        return $inisial !== '' ? $inisial : 'DR';
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }
}
