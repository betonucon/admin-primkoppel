<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VSim extends Model
{
    protected $table = 'view_m_sim';
    protected $guarded = ['id'];
    public $timestamps = false;
}
