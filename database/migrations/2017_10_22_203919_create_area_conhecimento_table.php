<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaConhecimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.area_conhecimento', function (Blueprint $table) {
            $table->increments('id');
            $table->string('area_conhecimento');
            $table->text('descricao')->nullable();
            $table->integer('nivel_id')->unsigned();
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('nivel_id')->references('id')->on(env('DB_SCHEMA').'.nivel');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.area_conhecimento');
    }
}
