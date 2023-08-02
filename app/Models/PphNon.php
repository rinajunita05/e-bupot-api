<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PphNon extends Model
{
    use HasFactory;
    protected $table = 'pph_nonresiden';
    protected $fillable = [
        'pengaturan_id',
        'tahun_pajak',
        'masa_pajak',
        'tin',
        'nama',
        'alamat',
        'negara',
        'tempat_lahir',
        'tgl_lahir',
        'no_paspor',
        'no_kitas',
        'kode_objek_pajak',
        'fasilitas_pajak_penghasilan',
        'no_fasilitas',
        'jumlah_penghasilan_bruto',
        'netto',
        'tarif',
        'jumlah_setor',
        'no_bukti',
        'status',
        'kelebihan_pemotongan',
        'pernyataan'
    ];
    
}
