<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_pekerja')->primary(); // PK
            $table->string('nama');
            $table->string('jawatan')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_tel')->nullable();
            $table->string('gambar_profil')->nullable();
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->rememberToken(); // needed for auth remember me
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
