<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamSPT extends Model
{
    use HasFactory;
    protected $table = 'rekam_spt';
    protected $fillable = [
        'jenis_bukti_penyetoran',
        'npwp',
        'ntpn',
        'nomor_pemindahbukuan',
        'tahun_pajak',
        'masa_pajak',
        'jenis_pajak',
        'jenis_setoran',
        'jumlah_setor',
        'tanggal_setor',
    ];
    
}
