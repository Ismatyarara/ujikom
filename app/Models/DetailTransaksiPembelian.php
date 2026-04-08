<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $transaksi_pembelian_id
 * @property int $id_obat
 * @property int $jumlah
 * @property int|float $harga_satuan
 * @property int|float $subtotal
 * @property Obat|null $obat
 * @property TransaksiPembelian|null $transaksi
 */

class DetailTransaksiPembelian extends Model
{
    use HasFactory;

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
