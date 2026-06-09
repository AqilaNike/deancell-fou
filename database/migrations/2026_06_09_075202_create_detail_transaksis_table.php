<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->char('idTransaksi', 6);
            $table->char('idProduk', 6);
            $table->char('id_merchant', 10)->nullable();
            $table->integer('harga_satuan');
            $table->integer('jumlah');
            $table->integer('total');
            
            $table->foreign('idTransaksi')->references('idTransaksi')->on('transaksis')->onDelete('cascade');
            $table->foreign('idProduk')->references('idProduk')->on('produks')->onDelete('cascade');
            $table->foreign('id_merchant')->references('id_merchant')->on('merchant_brilinks')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};