<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPembelian extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_pembelian';

    protected $fillable = [
        'transaksi_pembelian_id',
        'id_obat',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'transaksi_pembelian_id');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }
}