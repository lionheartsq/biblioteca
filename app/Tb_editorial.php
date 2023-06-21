<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_editorial extends Model
{
    //
    protected $table = 'tb_editorial';

    protected $fillable = ['editorial','estado'];

    public $timestamps = false;
}
