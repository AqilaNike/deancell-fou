<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'idPelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['idPelanggan', 'nama'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'idPelanggan', 'idPelanggan');
    }
}