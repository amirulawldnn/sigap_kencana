<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinsi';
    
    protected $filltable = [
        'nama_provinsi',
        'kode_provinsi',
        'geom',
    ];
}
