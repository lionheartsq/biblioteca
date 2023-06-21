<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['name','document','address','phone','email','password','estado'];

    public $timestamps = false;

    public function roles() {
        return $this->belongsToMany('App\Tb_rol','tb_usuario_tiene_rol', 'idUser', 'idRol');
    }
}
