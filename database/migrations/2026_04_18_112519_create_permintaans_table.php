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
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_permintaan');
            $table->foreignId('id_staff_gudang')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('id_staff_proyek')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->text('catatan')->nullable();
             $table->enum('status', ['dalam pengajuan', 'diajukan', 'diproses', 'selesai']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};
