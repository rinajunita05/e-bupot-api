<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    use HasFactory;
    protected $table = 'penandatangan';
    protected $fillable = ['id','pengaturan_id','tahun_pajak','masa_pajak'];
    public $timestamps = false;
    
    public function pengaturan(){
        return $this->belongsTo(Pengaturan::class);
    }    
}

    
