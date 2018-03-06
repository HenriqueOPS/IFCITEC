<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.nivel', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('max_ch');
            $table->integer('min_ch');
            $table->string('nivel');
            $table->text('descricao');
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
        Schema::dropIfExists(env('DB_SCHEMA').'.nivel');
    }
}
