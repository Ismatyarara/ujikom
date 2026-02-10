<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spesialisasi extends Model
{
    use HasFactory;

    protected $table = 'spesialisasi';

    protected $fillable = [
        'name','foto',
    ];

    // Relationships
    public function dokter()
    {
        return $this->hasMany(Dokter::class, 'spesialisasi_id');
    }

    public function getFotoUrlAttribute()
{
    return $this->foto
        ? asset('storage/' . $this->foto)
        : asset('images/default-spesialisasi.png');
}

}