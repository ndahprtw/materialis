<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    public function run()
    {
        Pelanggan::create([
            'nama_pelanggan' => 'Waruuuung',
            'alamat_pelanggan' => 'Cilegon',
            
        ]);

    }
}
