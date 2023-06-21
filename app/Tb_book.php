<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tb_book extends Model
{
    //
    protected $table = 'tb_books';

    protected $fillable = ['codigo','libro','paginas','edicion','fechaedicion','idCategoria','idAutor','idEditorial','estado'];

    public $timestamps = false;
}
