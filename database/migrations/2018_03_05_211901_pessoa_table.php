<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('senha');
            $table->string('cpf', 14)->nullable();
            $table->string('rg', 10)->nullable();
            $table->date('dt_nascimento');
            $table->string('telefone', 14)->nullable();
            $table->string('lattes')->nullable();
            $table->integer('endereco_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('endereco_id')->references('id')->on(env('DB_SCHEMA').'.endereco')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.pessoa');
    }
}
