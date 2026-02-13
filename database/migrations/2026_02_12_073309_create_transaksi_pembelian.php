<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['pending', 'dibayar', 'diverifikasi', 'selesai', 'expired', 'dibatalkan'])->default('pending');
            $table->text('alamat_pengiriman');
            $table->string('no_telepon');
            $table->text('catatan')->nullable();
            
            // Midtrans Payment
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('order_id')->unique()->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->text('midtrans_response')->nullable();
            
            // Verifikasi Staff
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('catatan_staff')->nullable();
            
            $table->timestamps();
        });

        Schema::create('detail_transaksi_pembelian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_pembelian_id')->constrained('transaksi_pembelian')->onDelete('cascade');
            // PERBAIKAN: ubah dari 'obats' jadi 'obat'
            $table->foreignId('id_obat')->constrained('obat')->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transaksi_pembelian');
        Schema::dropIfExists('transaksi_pembelian');
    }
};