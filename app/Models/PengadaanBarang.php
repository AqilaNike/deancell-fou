<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengadaanBarang extends Model
{
    protected $table = 'pengadaan_barangs';
    protected $primaryKey = 'idPengadaan';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'idPengadaan', 'idPemasok', 'tanggal_pesan', 'tanggal_terima', 'total_biaya'
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'idPemasok', 'idPemasok');
    }

    public function detailPengadaans()
    {
        return $this->hasMany(DetailPengadaan::class, 'idPengadaan', 'idPengadaan');
    }
}