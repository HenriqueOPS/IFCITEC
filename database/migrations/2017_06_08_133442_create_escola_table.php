<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscolaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
           Schema::create(env('DB_SCHEMA').'.escola', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_completo')->unique();
            $table->string('nome_curto')->unique();
            $table->string('email')->unique();
            $table->string('moodle_link')->nullable();
            $table->string('moodle_versao')->nullable();
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
        Schema::dropIfExists(env('DB_SCHEMA').'.escola');
    }
}
