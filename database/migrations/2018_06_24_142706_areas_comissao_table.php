<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreasComissaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.areas_comissao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->integer('comissao_edicao_id')->unsigned();
            $table->boolean('homologado')->default(false);
            //Foreign Keys Constraints
            $table->foreign('area_id')->references('id')->on(env('DB_SCHEMA').'.area_conhecimento');
            $table->foreign('comissao_edicao_id')->references('id')->on(env('DB_SCHEMA').'.comissao_edicao');
            //Other Constraints
            $table->unique(['area_id', 'comissao_edicao_id']);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.areas_comissao');
    }
}
