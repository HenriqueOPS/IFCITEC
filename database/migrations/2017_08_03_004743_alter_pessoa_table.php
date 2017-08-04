<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPessoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('pessoa', function($table)
        {
            $table->string('titulacao')->nullable();
            $table->string('lattes')->nullable();
            $table->string('profissao')->nullable();
            $table->string('instituicao')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->string('telefone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
