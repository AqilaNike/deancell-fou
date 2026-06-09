<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawans';
    protected $primaryKey = 'idKaryawan';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = ['idKaryawan', 'nama', 'noTelp', 'Alamat'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'idKaryawan', 'idKaryawan');
    }
}