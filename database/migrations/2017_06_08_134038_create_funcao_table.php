<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up()
    {
           Schema::create(env('DB_SCHEMA').'.funcao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('funcao')->unique();
            $table->text('descricao')->nullable();
            $table->boolean('sistema')->default(false);
            $table->boolean('integrante')->default(false);
            $table->boolean('projeto')->default(false);      
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
        Schema::dropIfExists(env('DB_SCHEMA').'.funcao');
    }
}
