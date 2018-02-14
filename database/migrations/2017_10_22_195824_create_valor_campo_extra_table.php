<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValorCampoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.valor_campo_extra', function (Blueprint $table) {
            $table->increments('id');  
            $table->integer('campo_id')->unsigned();
            $table->string('valor');
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('campo_id')->references('id')->on(env('DB_SCHEMA').'.campo_extra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.valor_campo_extra');
    }
}
