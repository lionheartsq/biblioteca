<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_categoria extends Model
{
    //
    protected $table = 'tb_categoria';

    protected $fillable = ['categoria','estado'];

    public $timestamps = false;
}
