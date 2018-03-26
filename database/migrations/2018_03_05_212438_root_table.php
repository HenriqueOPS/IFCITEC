<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RootTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.root', function (Blueprint $table) {
            $table->integer('pessoa_id')->unsigned();
            $table->timestamps();
            //Foreign Keys Constraints
             $table->foreign('pessoa_id')->references('id')->on(env('DB_SCHEMA').'.pessoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.root');
    }
}
