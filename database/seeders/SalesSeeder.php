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
            'nama' => 'Busana busani',
            'alamat' => 'Cilegon',
            'telepon' => '6282132331947'
        ]);

        Sales::create([
            'nama' => 'Miniso',
            'alamat' => 'Cilegon',
            'telepon' => '6282132331947'
        ]);
    }
}
