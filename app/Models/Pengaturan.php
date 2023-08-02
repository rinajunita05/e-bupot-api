<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    
    use HasFactory;
    protected $table = 'pengaturan';
    protected $fillable = [
        'bertindak_sebagai',
        'identitas',
        'status',
        'nama',
        'nik',
        'npwp',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function scopeFilter($query, array $filters = []){
    $query->when($filters['pilihsebagai'] ?? false,function ($query, $filter){
        return $query->where('bertindak_sebagai',$filter);
    });
    $query->when($filters['status'] ?? false,function ($query, $filter){
        return $query->where('status',$filter);
    });
}
}