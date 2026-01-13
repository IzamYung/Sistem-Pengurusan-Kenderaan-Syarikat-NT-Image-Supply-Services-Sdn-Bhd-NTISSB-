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
        Schema::create('laporan_kerosakan', function (Blueprint $table) {
            // PK: id_laporan
            $table->id('id_laporan'); 

            $table->unsignedBigInteger('id_permohonan');
            $table->string('no_pendaftaran', 20);
            
            $table->dateTime('tarikh_laporan');
            $table->string('jenis_kerosakan', 100);
            $table->text('ulasan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_reports');
    }
};