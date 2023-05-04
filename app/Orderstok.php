<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderstok extends Model
{
    protected $table = 'order_stok';
    public $timestamps = false;
    protected $guarded = ['id'];

    
}
