<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengadaans', function (Blueprint $table) {
            $table->char('idPengadaan', 6);
            $table->char('idProduk', 6);
            $table->integer('jumlah_pesan')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            
            $table->foreign('idPengadaan')->references('idPengadaan')->on('pengadaan_barangs')->onDelete('cascade');
            $table->foreign('idProduk')->references('idProduk')->on('produks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengadaans');
    }
};