<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tb_rol extends Model
{
    //
    protected $table = 'tb_rol';

    protected $fillable = ['rol','estado'];

    public $timestamps = false;
}
