<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'kodetransaksi',
        'kategori_id',
        'name',
        'bulan',
        'tahun',
        'tanggal',
        'nominal',
        'sts',
        'margin',
        'cost',


    ];

    function kategori(){
		return $this->belongsTo('App\Kategori','kategori_id','id');
    }
}
