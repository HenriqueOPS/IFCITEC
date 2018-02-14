<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.campo_extra', function (Blueprint $table) {
            $table->increments('id');  
            $table->integer('edicao_id')->unsigned();
            $table->integer('tipo');
            $table->string('campo');
            $table->timestamps();
            //Foreign Keys Constraints
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
        Schema::dropIfExists(env('DB_SCHEMA').'.dado_campo_extra');
        Schema::dropIfExists(env('DB_SCHEMA').'.valor_campo_extra');
        Schema::dropIfExists(env('DB_SCHEMA').'.campo_extra');
    }
}
