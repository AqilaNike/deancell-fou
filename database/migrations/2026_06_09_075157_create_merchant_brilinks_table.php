<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_brilinks', function (Blueprint $table) {
            $table->char('id_merchant', 10)->primary();
            $table->string('no_agen_bri', 20)->unique();
            $table->string('nama_toko', 100);
            $table->string('pemilik', 50)->nullable();
            $table->string('no_hp_terdaftar', 20)->nullable();
            $table->string('tipe_perangkat', 20);
            $table->decimal('saldo_limit', 15, 2)->default(0);
            $table->string('no_rekening_operasional', 25)->nullable();
            $table->string('kantor_wilayah', 100)->nullable();
            $table->integer('target_bulanan')->default(0);
            $table->boolean('status_aktif')->default(true);
            $table->text('alamat_toko')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_brilinks');
    }
};