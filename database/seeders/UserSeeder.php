<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Nazwa',
                'email' => 'Nazwa@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Admin',
                'profile' => 'file.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eka',
                'email' => 'eka@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Karyawan',
                'profile' => 'file.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kang Paket',
                'email' => 'paket@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Kurir',
                'profile' => 'file.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
