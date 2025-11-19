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
                // Admin user
                'id_pekerja' => 'A1001',
                'nama' => 'Admin Test',
                'jawatan' => 'Administrator',
                'email' => 'admin@example.test',
                'password' => Hash::make('admin123'), // hashed
                'no_tel' => '0123456789',
                'gambar_profil' => 'images/profile_picture/admin.jpeg',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                // Regular user
                'id_pekerja' => 'U1001',
                'nama' => 'User Test',
                'jawatan' => 'Staff',
                'email' => 'user@example.test',
                'password' => Hash::make('user123'), // hashed
                'no_tel' => '0198765432',
                'gambar_profil' => 'images/profile_picture/default-profile.png',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
