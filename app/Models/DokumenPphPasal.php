<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPphPasal extends Model
{
    use HasFactory;
    protected $table = 'dokumen_pphpasal';
    protected $fillable = [
        'nama_dokumen',
        'no_dokumen',
        'tgl_dokumen',
        'pajak_penghasilan_id'
    ];
    
}
