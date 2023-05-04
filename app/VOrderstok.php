<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VOrderstok extends Model
{
    protected $table = 'view_order_stok';
    public $timestamps = false;
    protected $guarded = ['id'];

    
}
