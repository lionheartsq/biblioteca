<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_books', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 255)->nullable();
            $table->string('libro', 255);
            $table->integer('paginas');
            $table->integer('edicion');
            $table->integer('fechaedicion');
            $table->foreignId('idCategoria')->constrained('tb_categoria');
            $table->foreignId('idAutor')->constrained('tb_autor');
            $table->foreignId('idEditorial')->constrained('tb_editorial');
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
        Schema::dropIfExists('tb_books');
    }
}
