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
        Schema::create('maklumat_permohonan', function (Blueprint $table) {
            // PK: id_permohonan
            $table->id('id_permohonan'); 

            // Foreign Key placeholder to users.id_pekerja (which is an auto-incrementing big integer now)
            $table->unsignedBigInteger('id_user'); 
            // Foreign Key placeholder to vehicles.no_pendaftaran
            $table->string('no_pendaftaran', 20); 

            $table->dateTime('tarikh_mohon');
            $table->dateTime('tarikh_pelepasan')->nullable(); // Date/time vehicle was released/used
            $table->string('lokasi', 150);
            $table->unsignedSmallInteger('bil_penumpang');
            $table->string('kod_projek', 50);
            $table->string('lampiran')->nullable(); // Path/filename for attachment
            $table->string('status_pengesahan', 30);
            $table->unsignedInteger('speedometer_sebelum'); // Start mileage
            $table->unsignedInteger('speedometer_selepas')->nullable(); // End mileage, nullable until returned

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_details');
    }
};
