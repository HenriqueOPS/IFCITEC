<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoriasAvaliacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create(env('DB_SCHEMA').'.categoria_avaliacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categoria_avaliacao');
            $table->float('peso', 4, 2)->unsigned();
            $table->text('descricao');
            $table->integer('edicao_id')->unsigned();
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('edicao_id')->references('id')->on(env('DB_SCHEMA').'.edicao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.categoria_avaliacao');
    }
}
