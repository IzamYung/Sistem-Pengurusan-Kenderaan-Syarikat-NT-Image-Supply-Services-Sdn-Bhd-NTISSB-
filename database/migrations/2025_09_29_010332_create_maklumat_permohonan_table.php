<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maklumat_permohonan', function (Blueprint $table) {
            $table->id('id_permohonan');

            $table->string('id_user'); // id_pekerja
            $table->string('no_pendaftaran', 20);

            $table->dateTime('tarikh_mohon');
            $table->dateTime('tarikh_pelepasan')->nullable();
            $table->dateTime('tarikh_pulang')->nullable();

            $table->string('lokasi', 150);
            $table->unsignedSmallInteger('bil_penumpang');

            $table->string('kod_projek', 50);
            $table->string('hak_milik')->nullable();

            // Lampiran lain (lesen, surat, etc)
            $table->json('lampiran')->nullable();

            // Gambar speedometer
            $table->string('speedometer_sebelum')->nullable();
            $table->string('speedometer_selepas')->nullable();

            // Ulasan pegawai
            $table->text('ulasan')->nullable();

            $table->string('status_pengesahan', 30)
                  ->default('Buat Pemeriksaan');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maklumat_permohonan');
    }
};
