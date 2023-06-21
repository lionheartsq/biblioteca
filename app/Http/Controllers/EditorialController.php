<?php

namespace App\Http\Controllers;

use App\Tb_editorial;
use Illuminate\Http\Request;

class EditorialController extends Controller
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
            $editoriales = Tb_editorial::orderBy('id','desc')->paginate(5);
        }
        else {
            $editoriales = Tb_editorial::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$editoriales->total(),
                'current_page'  =>$editoriales->currentPage(),
                'per_page'      =>$editoriales->perPage(),
                'last_page'     =>$editoriales->lastPage(),
                'from'          =>$editoriales->firstItem(),
                'to'            =>$editoriales->lastItem(),
            ],
                'editoriales' => $editoriales
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_editorial=new Tb_editorial();
        $tb_editorial->editorial=$request->editorial;
        $tb_editorial->save();
    }

    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_editorial=Tb_editorial::findOrFail($request->id);
        $tb_editorial->editorial=$request->editorial;
        $tb_editorial->estado='1';
        $tb_editorial->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_editorial=Tb_editorial::findOrFail($request->id);
        $tb_editorial->estado='0';
        $tb_editorial->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_editorial=Tb_editorial::findOrFail($request->id);
        $tb_editorial->estado='1';
        $tb_editorial->save();
    }

    public function selectEditorial(){
        $editorial = Tb_editorial::where('estado','=','1')
        ->select('id as idgenEditorial','editorial')->orderBy('editorial','asc')->get();

        return ['editorial' => $editorial];
    }

}
