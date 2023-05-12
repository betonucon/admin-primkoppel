<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VSatuan extends Model
{
    protected $table = 'view_satuan';
    protected $guarded = ['id'];
    public $timestamps = false;
}
