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
       Schema::create('catatan_medis', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('deskripsi');
    $table->string('diagnosa_ringan');
    $table->text('saran_pengobatan');
    $table->date('tanggal_catatan');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_medis');
    }
};
