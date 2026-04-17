<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['barang masuk', 'barang keluar']);
            $table->integer('jumlah_barang');
            $table->foreignId('id_produk')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('id_karyawan')->references('id')->on('users')->onDelete('cascade');
            $table->text('pesan')->nullable();
            $table->integer('pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
