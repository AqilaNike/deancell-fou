<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $primaryKey = 'idTransaksi';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'idTransaksi', 'tanggal', 'id_outlet', 'idPelanggan', 'idKaryawan', 'total', 'metodeBayar'
    ];

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet', 'id_outlet');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idPelanggan', 'idPelanggan');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'idKaryawan', 'idKaryawan');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'idTransaksi', 'idTransaksi');
    }
}