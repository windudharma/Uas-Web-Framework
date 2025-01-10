<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Assetica',
            'email' => 'admin@mail.com',
            'password' => Hash::make('123123123'),
            'profile_photo' => null,
            'role' => 'admin', // Tambahkan kolom ini jika sistem role Anda menggunakannya
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
