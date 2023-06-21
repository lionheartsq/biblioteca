<?php

namespace App\Http\Controllers;

use App\Tb_autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio= $request->criterio;

        if ($buscar=='') {
            $autores = Tb_autor::join("tb_pais","tb_pais.id","=","tb_autor.idPais")
            ->select('tb_autor.id','tb_autor.autor','tb_autor.seudonimo','tb_autor.idPais','tb_pais.pais as pais','tb_pais.id as idexPais')
            ->orderBy('tb_autor.id','desc')->paginate(5);
        }
        else {
            $autores = Tb_autor::join("tb_pais","tb_pais.id","=","tb_autor.idPais")
            ->select('tb_autor.id','tb_autor.autor','tb_autor.seudonimo','tb_autor.idPais','tb_pais.pais as pais','tb_pais.id as idexPais')
            ->where('tb_autor.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_autor.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$autores->total(),
                'current_page'  =>$autores->currentPage(),
                'per_page'      =>$autores->perPage(),
                'last_page'     =>$autores->lastPage(),
                'from'          =>$autores->firstItem(),
                'to'            =>$autores->lastItem(),
            ],
                'autores' => $autores
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $autores=new Tb_autor();
        $autores->autor=$request->autor;
        $autores->seudonimo=$request->seudonimo;
        $autores->idPais=$request->idPais;
        $autores->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $autores=Tb_autor::findOrFail($request->id);
        $autores->autor=$request->autor;
        $autores->seudonimo=$request->seudonimo;
        $autores->idPais=$request->idPais;
        $autores->save();
    }

    public function selectAutor(){
        $autores = Tb_autor::select('id as idgenAutor','autor')->orderBy('autor','asc')->get();
        return ['autores' => $autores];
    }

}
