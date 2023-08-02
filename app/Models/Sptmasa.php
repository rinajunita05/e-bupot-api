<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sptmasa extends Model
{
    use HasFactory;
    protected $table = 'sptmasa';
    protected $fillable = [
        'user_id',
        'jenis_bukti_penyetoran',
        'ntpn',
        'nomor_bukti',
        'nomor_pemindahbukuan',
        'masa_pajak',
        'jenis_pajak',
        'jenis_setoran',
        'kode_objek_pajak',
        'jumlah_penghasilan_bruto',
        'jumlah_setor',
        'tanggal_setor',
        'pengaturan_id',
        'tahun_pajak',
        'nama',
        'identitas',
        'no_identitas',
        'qq',
        'no_fasilitas',
        'kelebihan_pemotongan',
        'status',
        'tin',
        'alamat',
        'negara',
        'tempat_lahir',
        'tgl_lahir',
        'no_paspor',
        'no_kitas',
        'fasilitas_pajak_penghasilan',
        'netto',
        'tarif',
        'no_bukti',
        'pernyataan',
        'is_posted',
        'tipe'
    ];
    
    public function pengaturan(){
        return $this->belongsTo(Pengaturan::class);
    }
}
