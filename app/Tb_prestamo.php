<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_prestamo extends Model
{
    //
    protected $table = 'tb_prestamo';

    protected $fillable = ['idLibro','idUser','fechaprestamo','fechamaximadevolucion','fechadevolucion','observaciones','dias','estado'];

    public $timestamps = false;
}
