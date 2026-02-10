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
    {Schema::create('dokter', function (Blueprint $table) {
     $table->id();

    $table->foreignId('user_id')
          ->constrained('users')
          ->cascadeOnDelete();

    $table->string('nama');

    $table->foreignId('spesialisasi_id')
          ->constrained('spesialisasi')
          ->cascadeOnDelete();

    $table->text('pengalaman')->nullable();
    $table->string('foto')->nullable();
    $table->string('jadwal_praktik_hari');
    $table->string('jadwal_praktik_waktu');
    $table->string('tempat_praktik');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
