<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                // Admin user (unchanged)
                'id_pekerja' => 'A1001',
                'nama' => 'Admin',
                'jawatan' => 'Administrator',
                'email' => 'admin@ntissb.com',
                'password' => Hash::make('admin123'),
                'no_tel' => '0123456789',
                'gambar_profil' => 'images/profile_picture/admin.jpeg',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ==========================
            // 4 REAL STAFF YOU REQUESTED
            // ==========================

            [
                'id_pekerja' => 'PKR001',
                'nama' => 'Muhammad Danish Haikal',
                'jawatan' => 'Technician',
                'email' => 'danish.haikal@ntissb.com',
                'password' => Hash::make('Danish@123'),
                'no_tel' => '0124589210',
                'gambar_profil' => 'images/profile_picture/casual3.jpg',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_pekerja' => 'PKR002',
                'nama' => 'Ahmad Firdaus Ramli',
                'jawatan' => 'Driver',
                'email' => 'firdaus.ramli@ntissb.com',
                'password' => Hash::make('Firdaus@123'),
                'no_tel' => '0137786402',
                'gambar_profil' => 'images/profile_picture/casual1.jpg',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
