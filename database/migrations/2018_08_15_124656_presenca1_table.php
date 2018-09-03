<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Presenca1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.presenca', function (Blueprint $table) {
            $table->increments('id_pessoa');
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('id_pessoa')->references('id')->on(env('DB_SCHEMA').'.pessoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.presenca');
    }
}
