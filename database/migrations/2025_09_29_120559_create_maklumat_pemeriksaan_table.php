<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maklumat_pemeriksaan', function (Blueprint $table) {
            // PK: id_pemeriksaan
            $table->id('id_pemeriksaan'); 

            // Foreign Key: Link ke maklumat_permohonan
            $table->unsignedBigInteger('id_permohonan'); 
            
            // Kolum Pemeriksaan
            $table->string('nama_komponen', 100);
            $table->string('status', 20);
            $table->text('ulasan')->nullable();

            $table->timestamps();

            // --- DEFINISI FOREIGN KEY CONSTRAINT ---
            
            // Link ke Permohonan (Wajib untuk integriti data)
            $table->foreign('id_permohonan')
                  ->references('id_permohonan')->on('maklumat_permohonan')
                  ->onDelete('cascade'); 
                  
            // NOTA: Lajur dan Foreign Key 'no_pendaftaran' telah dikeluarkan.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maklumat_pemeriksaan');
    }
};