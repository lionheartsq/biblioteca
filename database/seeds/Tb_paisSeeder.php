<?php

use App\Tb_pais;
use Illuminate\Database\Seeder;

class Tb_paisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_paises.json'));
        foreach ($data as $item){
            Tb_pais::create(array(
                'id' => $item->id,
                'pais' => $item->pais,
                'iso' => $item->iso,
                'estado' => $item->estado,
            ));
            }
        /*
        DB::table('tb_rol')->insert([
            'rol' => 'SuperAdministrador',
        ]);

        DB::table('tb_rol')->insert([
            'rol' => 'Empresario',
        ]
        );
        */
    }
}
