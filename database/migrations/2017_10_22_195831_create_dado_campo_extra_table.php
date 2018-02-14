<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadoCampoExtraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.dado_campo_extra', function (Blueprint $table) {
            $table->increments('id');  
            $table->integer('campo_id')->unsigned();
            $table->integer('valor_id')->unsigned();
            $table->string('dado');
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('campo_id')->references('id')->on(env('DB_SCHEMA').'.campo_extra');
            $table->foreign('valor_id')->references('id')->on(env('DB_SCHEMA').'.valor_campo_extra');
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
