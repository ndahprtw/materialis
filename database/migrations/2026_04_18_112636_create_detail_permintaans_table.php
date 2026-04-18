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
        Schema::create('detail_permintaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_permintaan')->references('id')->on('permintaans')->onDelete('cascade');
            $table->foreignId('id_produk')->references('id')->on('products')->onDelete('cascade');
            $table->integer('jumlah_permintaan');
            $table->integer('jumlah_diterima')->nullable();
            $table->text('pesan')->nullable();
            $table->enum('status', ['stok tersedia', 'stok tidak tersedia'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_permintaans');
    }
};
