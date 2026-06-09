<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasoks';
    protected $primaryKey = 'idPemasok';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'idPemasok', 'nama', 'noTelp', 'kategoriProduk'
    ];
}