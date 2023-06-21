<?php

use Illuminate\Database\Seeder;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Luis José García',
            "document" => "13514998",
            "address" => "Av 1 1 1",
            "phone" => "3158572686",
            'email' => 'ljgarcia899@misena.edu.co',
            'password' => bcrypt('Luis'),
        ]);

        DB::table('users')->insert([
            'name' => 'Carmen Lorena López',
            "document" => "98765432",
            "address" => "Av 1 1 1",
            "phone" => "3105982750",
            'email' => 'correo@correo.co',
            'password' => bcrypt('Lorena_2023?'),
        ]);

    }
}
