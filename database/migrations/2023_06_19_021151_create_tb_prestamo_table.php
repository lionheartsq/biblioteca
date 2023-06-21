<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPrestamoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_prestamo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idLibro')->constrained('tb_books');
            $table->foreignId('idUser')->constrained('users');
            $table->date('fechaprestamo');
            $table->date('fechamaximadevolucion');
            $table->date('fechadevolucion');
            $table->string('observaciones', 255);
            $table->integer('dias');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_prestamo');
    }
}
