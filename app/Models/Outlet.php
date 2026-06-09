<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlets';
    protected $primaryKey = 'id_outlet';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_outlet', 'nama_outlet', 'alamat', 'no_telp_outlet', 'nama_manajer', 'jam_operasional'
    ];
    
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_outlet', 'id_outlet');
    }
}