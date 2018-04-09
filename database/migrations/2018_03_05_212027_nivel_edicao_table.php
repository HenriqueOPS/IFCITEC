<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NivelEdicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.nivel_edicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('nivel_id')->unsigned();
            $table->integer('edicao_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('nivel_id')->references('id')->on(env('DB_SCHEMA').'.nivel');
            $table->foreign('edicao_id')->references('id')->on(env('DB_SCHEMA').'.edicao');
            //Other Constraints
            $table->unique(['nivel_id', 'edicao_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.nivel_edicao');
    }
}