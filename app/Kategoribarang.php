<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategoribarang extends Model
{
    protected $table = 'kategori_barang';
    protected $guarded = ['id'];
    public $timestamps = false;
}
