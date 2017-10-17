<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaNivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(env('DB_SCHEMA').'.area_nivel', function (Blueprint $table) {
            $table->integer('area_id')->unsigned();
            $table->integer('nivel_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('area_id')->references('id')->on(env('DB_SCHEMA').'.area_conhecimento');
            $table->foreign('nivel_id')->references('id')->on(env('DB_SCHEMA').'.nivel');
            //Other Constraints
            $table->primary(['area_id', 'nivel_id']);
            $table->unique(['area_id', 'nivel_id']);
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
