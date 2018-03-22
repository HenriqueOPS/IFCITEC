<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaEdicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.area_edicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->integer('edicao_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('area_id')->references('id')->on(env('DB_SCHEMA').'.area_conhecimento');
            $table->foreign('edicao_id')->references('id')->on(env('DB_SCHEMA').'.edicao');
            //Other Constraints
            $table->unique(['area_id', 'edicao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.area_edicao');
    }
}
