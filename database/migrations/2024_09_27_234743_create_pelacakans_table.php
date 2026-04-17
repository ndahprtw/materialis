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
        Schema::create('pelacakans', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['dikemas', 'dikirim', 'selesai', 'dibatalkan']);
            $table->foreignId('id_customer')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreignId('id_karyawan')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('id_produk')->references('id')->on('products')->onDelete('cascade');
            $table->integer('jumlah_barang');
            $table->integer('total');
            $table->integer('jumlah_pelunasan')->nullable();
            $table->integer('sisa_pelunasan')->nullable();
            $table->string('bukti')->nullable();
            $table->foreignId('id_inventory')->nullable()->references('id')->on('inventories')->onDelete('cascade');
            $table->foreignId('id_kurir')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelacakans');
    }
};
