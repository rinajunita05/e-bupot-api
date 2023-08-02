<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PphSendiri extends Model
{
    use HasFactory;
    protected $table = 'pphsendiri';
    protected $fillable = [
        'jenis_bukti_penyetoran',
        'ntpn',
        'nomor_pemindahbukuan',
        'nomor_bukti',
        'tahun_pajak',
        'masa_pajak',
        'jenis_pajak',
        'jenis_setoran',
        'kode_objek_pajak',
        'jumlah_penghasilan_bruto',
        'jumlah_setor',
        'tanggal_setor',
    ];
    
}
