<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posting extends Model
{
    
    use HasFactory;
    protected $table = 'posting';
    protected $fillable = [
        'pphsendiri_id',
        'pphpasal_id',
        'pph_nonresiden_id'
    ];
    
}
