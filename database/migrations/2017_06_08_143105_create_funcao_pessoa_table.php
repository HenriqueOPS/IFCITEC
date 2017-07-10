<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncaoPessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(env('DB_SCHEMA').'.funcao_pessoa', function (Blueprint $table) {
            $table->integer('pessoa_id')->unsigned();
            $table->integer('funcao_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->foreign('funcao_id')->references('id')->on(env('DB_SCHEMA').'.funcao');
            //Other Constraints
            $table->primary(['pessoa_id', 'funcao_id']);
            $table->unique(['pessoa_id', 'funcao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(env('DB_SCHEMA').'.funcao_pessoa');
    }

}