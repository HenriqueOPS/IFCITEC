<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscolaFuncaoPessoaProjetoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(env('DB_SCHEMA').'.escola_funcao_pessoa_projeto', function (Blueprint $table) {
            $table->integer('escola_id')->unsigned();
            $table->integer('funcao_id')->unsigned();
            $table->integer('pessoa_id')->unsigned();
            $table->integer('projeto_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('escola_id')->references('id')->on(env('DB_SCHEMA').'.escola');
            $table->foreign('funcao_id')->references('id')->on(env('DB_SCHEMA').'.funcao');
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->foreign('projeto_id')->references('id')->on(env('DB_SCHEMA').'.projeto')->onDelete('cascade');
            //Other Constraints
            $table->primary(['pessoa_id', 'projeto_id']);
            $table->unique(['pessoa_id', 'projeto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(env('DB_SCHEMA').'.escola_funcao_pessoa_projeto');
    }
}
