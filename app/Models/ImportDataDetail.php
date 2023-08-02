<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDataDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "import_data_id",
        "tgl_pemotongan",
        "penerima_penghasilan",
        "npwp",
        "nik",
        "nama_penerima",
        "qq",
        "no_hp",
        "kode_objek_pajak",
        "penandatangan_bp",
        "penandatangan_menggunakan",
        "npwp_penandatangan",
        "nik_penandatangan",
        "namapenandatangan_sesuai_nik",
        "penghasilan_bruto",
        "fasilitas",
        "no_skb",
        "no_aturandtp",
        "no_suketpp23",
        "fasilitaspph_lainnya",
        "tarifpph_berfaspph_lainnya",
        "lb_diproses" 
    ];

}
