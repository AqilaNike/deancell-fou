<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'idProduk';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'idProduk', 'namaProduk', 'jenisProduk', 'harga_beli', 'harga_jual',
        'stok', 'merk', 'warna', 'imei_sn', 'kondisi', 'garansi', 'provider',
        'nominal_kuota', 'masa_aktif', 'biaya_admin', 'tipe_layanan'
    ];
}