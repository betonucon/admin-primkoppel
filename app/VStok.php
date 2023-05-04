<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VStok extends Model
{
    protected $table = 'view_stok';
    public $timestamps = false;
    protected $guarded = ['id'];
}
