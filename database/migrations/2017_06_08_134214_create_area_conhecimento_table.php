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
            $table->string('area_conhecimento')->unique();
            $table->string('descricao')->nullable();
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
        Schema::dropIfExists(env('DB_SCHEMA').'.area_conhecimento');
    }
}
