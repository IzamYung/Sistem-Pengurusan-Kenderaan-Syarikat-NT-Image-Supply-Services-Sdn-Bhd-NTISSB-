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
        Schema::create('kenderaan', function (Blueprint $table) {
            // PK: no_pendaftaran (Primary Key, based on ERD)
            $table->string('no_pendaftaran', 20)->primary();

            $table->string('jenis_kenderaan', 50);
            $table->string('jenama', 50);
            $table->string('model', 50);
            $table->string('warna', 30);
            $table->unsignedSmallInteger('kapasiti_penumpang'); // E.g., 2, 5, 7
            $table->date('tarikh_mula_roadtax');
            $table->date('tarikh_tamat_roadtax');
            $table->string('status_kenderaan', 20);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
