<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PessoaTarefaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.pessoa_tarefa', function (Blueprint $table) {
            $table->integer('pessoa_id')->unsigned();
            $table->integer('tarefa_id')->unsigned();
            $table->integer('edicao_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('pessoa_id')->references('id')->on(env('DB_SCHEMA').'.pessoa');
            $table->foreign('tarefa_id')->references('id')->on(env('DB_SCHEMA').'.tarefa');
            $table->foreign('edicao_id')->references('id')->on(env('DB_SCHEMA').'.edicao');
            //Other Constraints
            $table->primary(['pessoa_id', 'tarefa_id', 'edicao_id']);
            $table->unique(['pessoa_id', 'tarefa_id', 'edicao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.pessoa_tarefa');    
    }
}
