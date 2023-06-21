<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Facades\Redis;
use App\Jobs\Prueba;
use App\Tb_inventario;
use App\Tb_nomina;
use App\Tb_detalle_inventario;
use App\Exports\DetalleNominaFija;
use App\Exports\DetalleNominaDestajo;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', 'Auth\LoginController@showLoginForm');
//Auth::routes(['register'=>false,'reset'=>false]);

//accesos para los usuarios que no estan autenticados
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/', 'Auth\LoginController@login')->name('login');
    Route::post('/login', 'Auth\LoginController@login');
});
//---------------------------------------------------------------------------//

//accesos para los usuarios que si estan autenticados
    Route::group(['middleware' => ['auth']], function () {

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('/principal', function () {
            return view('contenido/contenido');
        })->name('principal');

        Route::get('/pruebas', function () {
            return view('home');
        })->name('pruebas');

        Route::get("/usuario", "UserController@index");
        Route::post("/usuario/store", "UserController@store");
        Route::put("/usuario/update", "UserController@update");
        Route::put("/usuario/deactivate", "UserController@deactivate");
        Route::put("/usuario/activate", "UserController@activate");
        Route::get("/usuario/selectUsuario", "UserController@selectUsuario");

        Route::get("/categoria", "CategoriaController@index");
        Route::post("/categoria/store", "CategoriaController@store");
        Route::put("/categoria/update", "CategoriaController@update");
        Route::put("/categoria/deactivate", "CategoriaController@deactivate");
        Route::put("/categoria/activate", "CategoriaController@activate");
        Route::get("/categoria/selectcategoria", "CategoriaController@selectCategoria");

        Route::get("/editorial", "EditorialController@index");
        Route::post("/editorial/store", "EditorialController@store");
        Route::put("/editorial/update", "EditorialController@update");
        Route::put("/editorial/deactivate", "EditorialController@deactivate");
        Route::put("/editorial/activate", "EditorialController@activate");
        Route::get("/editorial/selecteditorial", "EditorialController@selectEditorial");

        Route::get("/autor", "AutorController@index");
        Route::post("/autor/store", "AutorController@store");
        Route::put("/autor/update", "AutorController@update");
        Route::get("/autor/selectautor", "AutorController@selectAutor");

        Route::get("/pais/selectpais", "PaisController@selectPais");

        Route::get("/libro", "BookController@index");
        Route::post("/libro/store", "BookController@store");
        Route::put("/libro/update", "BookController@update");
        Route::put("/libro/deactivate", "BookController@deactivate");
        Route::put("/libro/activate", "BookController@activate");
        Route::get("/libro/selectlibros", "BookController@selectLibro");

        Route::get("/prestamo", "PrestamoController@index");
        Route::post("/prestamo/store", "PrestamoController@store");
        Route::put("/prestamo/update", "PrestamoController@update");
        Route::put("/prestamo/deactivate", "PrestamoController@deactivate");
        Route::put("/prestamo/activate", "PrestamoController@activate");
        Route::get("/prestamo/selectprestamos", "PrestamoController@selectLibro");
//---------------------------------------------------------------------------//

//accesos para los usuarios que son superadministrador

    Route::group(['middleware' => ['Superadministrador']], function () {

    });

//---------------------------------------------------------------------------//

//accesos para los usuarios que son empresarios


    Route::group(['middleware' => ['Administrador']], function () {
        //accesos para los usuarios que son empresarios

    });

});
