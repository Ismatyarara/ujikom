<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama_panjang',
        'tanggal_lahir',
        'golongan_darah',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Accessor
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir?->age;
    }
}