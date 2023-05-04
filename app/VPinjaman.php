<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VPinjaman extends Model
{
    protected $table = 'view_pinjaman';
    public $timestamps = false;
    protected $guarded = ['id'];
}
