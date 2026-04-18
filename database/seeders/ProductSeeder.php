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
            'nama_produk' => 'Semen',
            'stok_produk' => 100,
            'harga_produk' => 5000,
            'id_sales' => 1
        ]);

        Product::create([
            'nama_produk' => 'Pasir',
            'stok_produk' => 200,
            'harga_produk' => 20000,
            'id_sales' => 2
        ]);

        Product::create([
            'nama_produk' => 'Batu Bata',
            'stok_produk' => 1000,
            'harga_produk' => 50000,
            'id_sales' => 1
        ]);

        Product::create([
            'nama_produk' => 'Besi Beton',
            'stok_produk' => 150,
            'harga_produk' => 75000,
            'id_sales' => 3
        ]);

        Product::create([
            'nama_produk' => 'Cat Tembok',
            'stok_produk' => 75,
            'harga_produk' => 30000,
            'id_sales' => 2
        ]);
    }
}
