<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodepinjaman extends Model
{
    protected $table = 'periode_pinjaman';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'nominal',
        'tanggal',
        'nomorpinjaman',
        'ke',
        'sts',
        'margin',
    ];

    function pinjaman(){
		return $this->belongsTo('App\Pinjaman','nomorpinjaman','nomorpinjaman');
    }
}
