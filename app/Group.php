<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'm_group';
    protected $guarded = ['id'];
    public $timestamps = false;
}
