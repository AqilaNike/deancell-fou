<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->char('idTransaksi', 6)->primary();
            $table->date('tanggal');
            $table->char('id_outlet', 10);
            $table->char('idPelanggan', 6);
            $table->char('idKaryawan', 6);
            $table->decimal('total', 10, 2);
            $table->string('metodeBayar', 20);
            
            $table->foreign('id_outlet')->references('id_outlet')->on('outlets')->onDelete('cascade');
            $table->foreign('idPelanggan')->references('idPelanggan')->on('pelanggans')->onDelete('cascade');
            $table->foreign('idKaryawan')->references('idKaryawan')->on('karyawans')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};