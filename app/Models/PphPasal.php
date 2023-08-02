<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PphPasal extends Model
{
    use HasFactory;
    protected $table = 'pphpasal';
    protected $fillable = [
        'tahun_pajak',
        'masa_pajak',
        'npwp',
        'nama',
        'identitas',
        'no_identitas',
        'qq',
        'kode_objek_pajak',
        'fasilitas_pajak_penghasilan',
        'no_fasilitas',
        'jumlah_penghasilan_bruto',
        'tarif',
        'jumlah_setor',
        'pengaturan_id',
        'no_bukti',
        'status',
        'kelebihan_pemotongan',
        'pernyataan'
    ];
    public function dokumen_pphpasal(){
        return $this->hasOne(DokumenPphPasal::class,'id','pphpasal_id');
    }
    public function pengaturan(){
        return $this->belongsTo(Pengaturan::class);
    }
    
}
