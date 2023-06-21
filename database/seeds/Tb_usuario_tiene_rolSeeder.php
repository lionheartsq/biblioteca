<?php

use App\Tb_usuario_tiene_rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tb_usuario_tiene_rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tb_usuario_tiene_rol')->insert([
            'idUser' => '1',
            'idRol' => '1'
        ]);
        DB::table('tb_usuario_tiene_rol')->insert([
            'idUser' => '2',
            'idRol' => '1'
        ]);

    }
}
