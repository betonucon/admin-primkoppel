<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VBarang extends Model
{
    protected $table = 'view_barang';
    protected $guarded = ['id'];
    public $timestamps = false;
}
