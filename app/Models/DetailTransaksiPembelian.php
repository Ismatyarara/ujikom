<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPembelian extends Model
{
     protected $table = 'detail_transaksi_pembelian';
     protected $fillable = [
        'transaksi_pembelian_id',
        'id_obat',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'id_obat');
    }

    public function transaksi()
    {
        return $this->belongsTo(TransaksiPembelian::class, 'transaksi_pembelian_id');
    }
}