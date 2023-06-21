<?php

namespace App\Http\Controllers;

use App\Tb_pais;
use Illuminate\Http\Request;

class PaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function selectPais(){
        $paises = Tb_pais::where('estado','=','1')
        ->select('id as idgenPais','pais')->orderBy('pais','asc')->get();

        return ['paises' => $paises];
    }

}
