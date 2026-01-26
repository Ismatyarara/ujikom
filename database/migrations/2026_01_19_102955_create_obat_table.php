<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
 Schema::create('obat', function (Blueprint $table) {
    $table->id();
    $table->string('kode_obat')->unique();
    $table->string('foto')->nullable();
    $table->string('nama_obat');
    $table->text('deskripsi');
    $table->text('aturan_pakai');
    $table->text('efek_samping');
    $table->integer('stok')->default(0);
    $table->integer('harga');
    $table->string('satuan')->default('tablet');
    $table->date('tanggal_kadaluarsa')->nullable();
    $table->boolean('status')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
