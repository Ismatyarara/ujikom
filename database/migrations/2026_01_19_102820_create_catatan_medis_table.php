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
        $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade'); 
        $table->foreignId('dokter_id')
              ->constrained('dokter')
              ->onDelete('cascade');
        $table->text('keluhan');              
        $table->enum('diagnosa',['Ringan','Sedang','Berat']);   
        $table->text('deskripsi')->nullable();
        $table->datetime('tanggal_catatan');
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
