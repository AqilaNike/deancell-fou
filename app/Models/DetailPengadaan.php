<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPengadaan extends Model
{
    protected $table = 'detail_pengadaans';
    public $incrementing = false;
    
    protected $fillable = [
        'idPengadaan', 'idProduk', 'jumlah_pesan', 'total'
    ];

    public function pengadaanBarang()
    {
        return $this->belongsTo(PengadaanBarang::class, 'idPengadaan', 'idPengadaan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }
}