<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zperiodetahun extends Model
{
    protected $table = 'z_periode_tahun';
    public $timestamps = false;
    protected $guarded = ['id'];
    
    // function memploye(){
    //     return $this->belongsTo('App\Models\Employe','nik','nik');
    // }
    
}
