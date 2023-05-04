<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaranpinjaman extends Model
{
    protected $table = 'pembayaran_pinjaman';
    public $timestamps = false;
    protected $guarded = ['id'];

}
