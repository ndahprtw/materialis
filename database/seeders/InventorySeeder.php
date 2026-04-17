<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventories')->insert([
            [
                'jenis' => 'barang masuk',
                'jumlah_barang' => 10,
                'id_produk' => 1, // Pastikan id_produk ini sesuai dengan data di tabel products
                'id_karyawan' => 1, // Pastikan id_karyawan ini sesuai dengan data di tabel users
                'pesan' => 'Barang masuk untuk stok awal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'barang keluar',
                'jumlah_barang' => 5,
                'id_produk' => 2,
                'id_karyawan' => 2,
                'pesan' => 'Barang keluar untuk pengiriman',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
