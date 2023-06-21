<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_autor', function (Blueprint $table) {
            $table->id();
            $table->string('autor', 255);
            $table->string('seudonimo', 255)->nullable();
            $table->foreignId('idPais')->constrained('tb_pais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_autor');
    }
}
