<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_pais extends Model
{
    //
    protected $table = 'tb_pais';

    protected $fillable = ['pais','iso','estado'];

    public $timestamps = false;
}
