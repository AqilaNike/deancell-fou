<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->char('idProduk', 6)->primary();
            $table->string('namaProduk', 255)->nullable();
            $table->string('jenisProduk', 50)->nullable();
            $table->decimal('harga_beli', 10, 2)->nullable();
            $table->decimal('harga_jual', 10, 2)->nullable();
            $table->integer('stok')->nullable();
            $table->string('merk', 50)->nullable();
            $table->string('warna', 30)->nullable();
            $table->string('imei_sn', 50)->nullable();
            $table->enum('kondisi', ['Baru', 'Bekas'])->default('Baru');
            $table->string('garansi', 50)->nullable();
            $table->string('provider', 30)->nullable();
            $table->string('nominal_kuota', 50)->nullable();
            $table->integer('masa_aktif')->nullable();
            $table->decimal('biaya_admin', 12, 2)->nullable();
            $table->string('tipe_layanan', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};