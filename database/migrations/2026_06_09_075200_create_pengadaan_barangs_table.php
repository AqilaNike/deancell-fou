<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengadaan_barangs', function (Blueprint $table) {
            $table->char('idPengadaan', 6)->primary();
            $table->char('idPemasok', 6)->nullable();
            $table->date('tanggal_pesan')->nullable();
            $table->date('tanggal_terima')->nullable();
            $table->decimal('total_biaya', 10, 2)->nullable();
            
            $table->foreign('idPemasok')->references('idPemasok')->on('pemasoks')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengadaan_barangs');
    }
};