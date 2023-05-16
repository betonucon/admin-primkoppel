<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zperiodetahungroup extends Model
{
    protected $table = 'z_periode_tahun_group';
    public $timestamps = false;
    protected $guarded = ['id'];
    
    // function memploye(){
    //     return $this->belongsTo('App\Models\Employe','nik','nik');
    // }
    
}
