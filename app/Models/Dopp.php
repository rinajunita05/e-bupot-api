<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dopp extends Model
{
    use HasFactory;
    protected $table = 'dopp';
    protected $fillable = ['dopp_point_id','kode_objek_pajak','jumlah_dpp','jumlah_pph','pajak_penghasilan_id'];
    public $timestamps = true;
    }
