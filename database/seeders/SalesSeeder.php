<?php

namespace Database\Seeders;

use App\Models\Sales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Sales::create([
        'nama' => 'Miniso',
        'alamat' => 'Cilegon',
        'telepon' => '6282132331947'
    ]);

    Sales::create([
        'nama' => 'Mitra Bangunan',
        'alamat' => 'Serang',
        'telepon' => '6281234567890'
    ]);

    Sales::create([
        'nama' => 'Sumber Jaya Material',
        'alamat' => 'Tangerang',
        'telepon' => '6289876543210'
    ]);

    Sales::create([
        'nama' => 'Toko Makmur',
        'alamat' => 'Jakarta',
        'telepon' => '6281112223333'
    ]);
    }
}
