<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBrilink extends Model
{
    use HasFactory;

    protected $table = 'transaksi_brilinks';

    protected $fillable = [
        'id_karyawan',
        'jenis_transaksi',
        'nomor_referensi',
        'nominal',
        'fee_admin',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'idKaryawan');
    }
}
