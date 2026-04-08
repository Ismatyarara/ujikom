<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $kode_transaksi
 * @property string|null $order_id
 * @property string $status
 * @property int|float $total_harga
 * @property string|null $snap_token
 * @property string|null $payment_type
 * @property string|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $tanggal_bayar
 * @property User|null $user
 * @property \Illuminate\Database\Eloquent\Collection<int, DetailTransaksiPembelian> $details
 */

class TransaksiPembelian extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pembelian';

    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'total_harga',
        'status',
        'alamat_pengiriman',
        'no_telepon',
        'catatan',
        'metode_pembayaran',
        'bukti_transfer',
        'tanggal_bayar',
        'verified_by',
        'verified_at',
        'catatan_staff',

            // Midtrans 
        'snap_token',
        'payment_type',
        'transaction_id',
        'order_id',
        'midtrans_response',
        'tanggal_bayar',
        'verified_by',
        'verified_at',
        'catatan_staff',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->kode_transaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksiPembelian::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksiPembelian::class, 'id_obat');
    }
}
