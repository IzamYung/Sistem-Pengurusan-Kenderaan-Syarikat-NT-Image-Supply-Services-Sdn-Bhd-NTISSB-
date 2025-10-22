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
                'nama' => 'Admin Test',
                'jawatan' => 'Administrator',
                'email' => 'admin@example.test',
                'password' => Hash::make('admin123'), // hashed
                'no_tel' => '0123456789',
                'role' => 'admin',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                // Regular user
                'nama' => 'User Test',
                'jawatan' => 'Staff',
                'email' => 'user@example.test',
                'password' => Hash::make('user123'), // hashed
                'no_tel' => '0198765432',
                'role' => 'user',
                'remember_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
