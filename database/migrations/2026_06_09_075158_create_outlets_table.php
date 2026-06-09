<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outlets', function (Blueprint $table) {
            $table->char('id_outlet', 10)->primary();
            $table->string('nama_outlet', 100);
            $table->text('alamat');
            $table->string('no_telp_outlet', 20);
            $table->string('nama_manajer', 50);
            $table->string('jam_operasional', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outlets');
    }
};