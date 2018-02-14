<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarefaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.tarefa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tarefa')->unique();
            $table->string('descricao')->nullable();
            $table->timestamps();   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.tarefa');
    }
}
