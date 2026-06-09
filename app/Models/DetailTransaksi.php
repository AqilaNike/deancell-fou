<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksis';
    public $incrementing = false;
    
    protected $fillable = [
        'idTransaksi', 'idProduk', 'id_merchant', 'harga_satuan', 'jumlah', 'total'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'idTransaksi', 'idTransaksi');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }

    public function merchantBrilink()
    {
        return $this->belongsTo(MerchantBrilink::class, 'id_merchant', 'id_merchant');
    }
}