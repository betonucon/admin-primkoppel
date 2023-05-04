<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VGetpinjaman extends Model
{
    protected $table = 'view_get_pinjaman';
    public $timestamps = false;
    protected $guarded = ['id'];
}
