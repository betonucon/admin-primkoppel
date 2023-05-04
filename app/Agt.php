<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agt extends Model
{
    protected $table = 'agt';
    protected $guarded = ['id'];
    public $timestamps = false;
}

