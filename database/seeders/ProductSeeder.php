<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'nama_produk' => 'Produk A',
            'harga_produk' => 10000.00,
            'stok_produk' => 50,
            'id_sales' => 1
        ]);

        Product::create([
            'nama_produk' => 'Produk B',
            'harga_produk' => 20000.00,
            'stok_produk' => 30,
            'id_sales' => 2
        ]);

        // Tambahkan produk lain sesuai kebutuhan
    }
}
