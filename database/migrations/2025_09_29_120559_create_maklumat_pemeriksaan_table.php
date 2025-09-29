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
            Schema::create('maklumat_pemeriksaan', function (Blueprint $table) {
            // PK: id_pemeriksaan
            $table->id('id_pemeriksaan'); 

            // Foreign Key placeholder to vehicles.no_pendaftaran
            $table->string('no_pendaftaran', 20);

            $table->string('kategori', 50);
            $table->string('nama_komponen', 100);
            $table->string('status', 20);
            $table->text('ulasan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_details');
    }
};
