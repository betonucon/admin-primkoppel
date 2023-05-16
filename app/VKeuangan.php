<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VKeuangan extends Model
{
    protected $table = 'view_keuangan';
    public $timestamps = false;
    protected $guarded = ['id'];

}
