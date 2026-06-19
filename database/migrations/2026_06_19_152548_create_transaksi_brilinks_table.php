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
        Schema::create('transaksi_brilinks', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan');
            $table->string('jenis_transaksi'); // Tarik Tunai, Setor Tunai, Transfer
            $table->string('nomor_referensi');
            $table->decimal('nominal', 15, 2);
            $table->decimal('fee_admin', 15, 2);
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
            
            // Relasi ke tabel karyawans
            $table->foreign('id_karyawan')->references('idKaryawan')->on('karyawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_brilinks');
    }
};
