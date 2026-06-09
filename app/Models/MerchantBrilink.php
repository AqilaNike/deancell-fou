<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantBrilink extends Model
{
    protected $table = 'merchant_brilinks';
    protected $primaryKey = 'id_merchant';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_merchant', 'no_agen_bri', 'nama_toko', 'pemilik', 'no_hp_terdaftar',
        'tipe_perangkat', 'saldo_limit', 'no_rekening_operasional', 'kantor_wilayah',
        'target_bulanan', 'status_aktif', 'alamat_toko'
    ];
}