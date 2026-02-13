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
  
    Schema::create('jadwal', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('dokter_id')->constrained('dokter')->cascadeOnDelete();
    $table->foreignId('catatan_medis_id')->nullable()->constrained('catatan_medis')->nullOnDelete();

    $table->string('nama_obat');
    $table->text('deskripsi')->nullable();

    $table->date('tanggal_mulai');
    $table->date('tanggal_selesai');

    $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
    

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
