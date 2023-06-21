<?php

namespace App\Http\Controllers;

use App\Tb_autor;
use App\Tb_book;
use Illuminate\Http\Request;

class BookController extends Controller
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
            $libros = Tb_book::join("tb_categoria","tb_categoria.id","=","tb_books.idCategoria")
            ->join("tb_autor","tb_autor.id","=","tb_books.idAutor")
            ->join("tb_editorial","tb_editorial.id","=","tb_books.idEditorial")
            ->select('tb_books.id','tb_books.codigo','tb_books.libro','tb_books.paginas','tb_books.edicion','tb_books.fechaedicion',
            'tb_books.idCategoria','tb_categoria.categoria as categoria','tb_books.idAutor','tb_autor.autor as autor','tb_books.idEditorial',
            'tb_editorial.editorial as editorial','tb_books.estado')
            ->orderBy('tb_books.id','desc')->paginate(5);
        }
        else {
            $libros = Tb_book::join("tb_categoria","tb_categoria.id","=","tb_books.idCategoria")
            ->join("tb_autor","tb_autor.id","=","tb_books.idAutor")
            ->join("tb_editorial","tb_editorial.id","=","tb_books.idEditorial")
            ->select('tb_books.id','tb_books.codigo','tb_books.libro','tb_books.paginas','tb_books.edicion','tb_books.fechaedicion',
            'tb_books.idCategoria','tb_categoria.categoria as categoria','tb_books.idAutor','tb_autor.autor as autor','tb_books.idEditorial',
            'tb_editorial.editorial as editorial','tb_books.estado')
            ->where('tb_books.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('tb_books.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$libros->total(),
                'current_page'  =>$libros->currentPage(),
                'per_page'      =>$libros->perPage(),
                'last_page'     =>$libros->lastPage(),
                'from'          =>$libros->firstItem(),
                'to'            =>$libros->lastItem(),
            ],
                'libros' => $libros
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $libros=new Tb_book();
        $libros->codigo=$request->codigo;
        $libros->libro=$request->libro;
        $libros->paginas=$request->paginas;
        $libros->edicion=$request->edicion;
        $libros->fechaedicion=$request->fechaedicion;
        $libros->idCategoria=$request->idCategoria;
        $libros->idAutor=$request->idAutor;
        $libros->idEditorial=$request->idEditorial;
        $libros->estado=1;
        $libros->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $libros=Tb_book::findOrFail($request->id);
        $libros->codigo=$request->codigo;
        $libros->libro=$request->libro;
        $libros->paginas=$request->paginas;
        $libros->edicion=$request->edicion;
        $libros->fechaedicion=$request->fechaedicion;
        $libros->idCategoria=$request->idCategoria;
        $libros->idAutor=$request->idAutor;
        $libros->idEditorial=$request->idEditorial;
        $libros->estado=1;
        $libros->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_books=Tb_book::findOrFail($request->id);
        $tb_books->estado='0';
        $tb_books->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tb_books=Tb_book::findOrFail($request->id);
        $tb_books->estado='1';
        $tb_books->save();
    }

    public function selectLibro(){
        $libros = Tb_book::select('id as idgenLibros','codigo','libro','paginas','edicion','fechaedicion')
        ->orderBy('autor','asc')->get();
        return ['libros' => $libros];
    }

}
