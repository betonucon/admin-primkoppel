<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';
    public $timestamps = false;
    protected $guarded = ['id'];
}
