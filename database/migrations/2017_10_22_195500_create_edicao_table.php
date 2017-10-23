<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.edicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ano');   
            $table->integer('periodo_inscricao')->unsigned();
            $table->integer('periodo_homologacao')->unsigned();
            $table->integer('periodo_avaliacao')->unsigned();
            $table->integer('periodo_credenciamento')->unsigned();
            $table->integer('periodo_voluntario')->unsigned();
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('periodo_inscricao')->references('id')->on(env('DB_SCHEMA').'.periodo');
            $table->foreign('periodo_homologacao')->references('id')->on(env('DB_SCHEMA').'.periodo');
            $table->foreign('periodo_avaliacao')->references('id')->on(env('DB_SCHEMA').'.periodo');
            $table->foreign('periodo_credenciamento')->references('id')->on(env('DB_SCHEMA').'.periodo');
            $table->foreign('periodo_voluntario')->references('id')->on(env('DB_SCHEMA').'.periodo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.edicao');
    }
}
