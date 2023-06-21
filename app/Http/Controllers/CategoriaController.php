<?php

namespace App\Http\Controllers;

use App\Tb_categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
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
            $categorias = Tb_categoria::orderBy('id','desc')->paginate(5);
        }
        else {
            $categorias = Tb_categoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$categorias->total(),
                'current_page'  =>$categorias->currentPage(),
                'per_page'      =>$categorias->perPage(),
                'last_page'     =>$categorias->lastPage(),
                'from'          =>$categorias->firstItem(),
                'to'            =>$categorias->lastItem(),
            ],
                'categorias' => $categorias
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_categoria=new Tb_categoria();
        $tb_categoria->categoria=$request->categoria;
        $tb_categoria->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_categoria=Tb_categoria::findOrFail($request->id);
        $tb_categoria->categoria=$request->categoria;
        $tb_categoria->estado='1';
        $tb_categoria->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_categoria=Tb_categoria::findOrFail($request->id);
        $tb_categoria->estado='0';
        $tb_categoria->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_categoria=Tb_categoria::findOrFail($request->id);
        $tb_categoria->estado='1';
        $tb_categoria->save();
    }

    public function selectCategoria(){
        $categoria = Tb_categoria::where('estado','=','1')
        ->select('id as idgenCategoria','categoria')->orderBy('categoria','asc')->get();

        return ['categoria' => $categoria];
    }

}
