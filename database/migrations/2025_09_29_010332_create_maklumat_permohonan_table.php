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
            $table->string('id_user'); // user's id_pekerja (string)
            $table->string('no_pendaftaran', 20);
            $table->dateTime('tarikh_mohon');
            $table->dateTime('tarikh_pelepasan')->nullable();
            $table->string('lokasi', 150);
            $table->unsignedSmallInteger('bil_penumpang');
            $table->string('kod_projek', 50);
            $table->string('hak_milik')->nullable();
            $table->json('lampiran')->nullable(); // array of stored filenames/paths
            $table->string('status_pengesahan', 30)->default('Buat Pemeriksaan');
            $table->unsignedInteger('speedometer_sebelum')->nullable();
            $table->unsignedInteger('speedometer_selepas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maklumat_permohonan');
    }
};
