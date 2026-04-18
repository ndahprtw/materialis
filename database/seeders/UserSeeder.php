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
                'profile' => 'admin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eka',
                'email' => 'eka@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Staff Proyek',
                'profile' => 'staff proyek.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Haikal',
                'email' => 'haikal@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Staff Gudang',
                'profile' => 'staff gudang.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Promono',
                'email' => 'promono@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'Manager',
                'profile' => 'manager.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
