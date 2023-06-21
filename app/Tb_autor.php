<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_autor extends Model
{
    //
    protected $table = 'tb_autor';

    protected $fillable = ['autor','seudonimo','idPais'];

    public $timestamps = false;

}
