<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjetoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.projeto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->text('resumo');
            $table->boolean('tomada')->nullable();
            $table->boolean('banner')->nullable();
            $table->timestamps();
            $table->integer('area_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            $table->integer('edicao_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('area_id')->references('id')->on(env('DB_SCHEMA').'.area_conhecimento');
            $table->foreign('nivel_id')->references('id')->on(env('DB_SCHEMA').'.nivel_edicao');
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
        Schema::dropIfExists(env('DB_SCHEMA').'.projeto');
    }
}
