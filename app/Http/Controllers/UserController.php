<?php

namespace App\Http\Controllers;

use App\User;
use App\Tb_rol;
use App\Tb_usuario_tiene_rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.document','users.address','users.phone','users.email','users.estado','tb_rol.id as idRol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as idexRol')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='name'){
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.document','users.address','users.phone','users.email','users.estado','tb_rol.id as idRol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as idexRol')
            ->where('users.name', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else if($criterio=='email'){
            $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
            ->leftJoin('tb_rol',function($join){
                $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
            })
            ->select('users.id','users.name','users.document','users.address','users.phone','users.email','users.estado','tb_rol.id as idRol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as idexRol')
            ->where('users.email', 'like', '%'. $buscar . '%')
            ->orderBy('users.id','desc')->paginate(5);
        }
        else {
                $usuarios = User::join("tb_usuario_tiene_rol","tb_usuario_tiene_rol.idUser","=","users.id")
                ->leftJoin('tb_rol',function($join){
                    $join->on('tb_usuario_tiene_rol.idRol','=','tb_rol.id');
                })
                ->select('users.id','users.name','users.document','users.address','users.phone','users.email','users.estado','tb_rol.id as idRol','tb_rol.rol','tb_rol.estado as estado_rol','tb_usuario_tiene_rol.id as idexRol')
                ->where('users.document', 'like', '%'. $buscar . '%')
                ->orderBy('users.id','desc')->paginate(5);
        }

        return [
            'pagination' => [
                'total'         =>$usuarios->total(),
                'current_page'  =>$usuarios->currentPage(),
                'per_page'      =>$usuarios->perPage(),
                'last_page'     =>$usuarios->lastPage(),
                'from'          =>$usuarios->firstItem(),
                'to'            =>$usuarios->lastItem(),
            ],
                'usuarios' => $usuarios
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $users=new User();
        $users->name=$request->nombre;
        $users->document=$request->documento;
        $users->address=$request->direccion;
        $users->phone=$request->telefono;
        $users->email=$request->correo;
        $users->password=bcrypt($request->documento);
        $users->save();
        $idtabla=DB::getPdo()->lastInsertId();
        $usersrela=new Tb_usuario_tiene_rol();
        $usersrela->idUser=$idtabla;
        $usersrela->idRol=$request->idRol;
        $usersrela->save();
    }

    public function update(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $users=User::findOrFail($request->id);
        $users->name=$request->name;
        $users->document=$request->document;
        $users->address=$request->address;
        $users->phone=$request->phone;
        $users->email=$request->email;
        $users->estado='1';
        $users->save();

        $userrela=Tb_usuario_tiene_rol::findOrFail($request->idexRol);
        $userrela->idUser=$request->id;
        $userrela->idRol=$request->idRol;
        $userrela->save();
    }

    public function deactivate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='0';
        $users->save();
    }

    public function activate(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $users=User::findOrFail($request->id);
        $users->estado='1';
        $users->save();
    }

}
