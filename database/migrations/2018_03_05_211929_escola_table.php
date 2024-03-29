<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EscolaTable extends Migration
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
            $table->string('email')->nullable();
            $table->string('telefone',15)->nullable();
            $table->integer('endereco_id')->unsigned()->nullable();
            $table->timestamps();  
            //Foreign Keys Constraints
            $table->foreign('endereco_id')->references('id')->on(env('DB_SCHEMA').'.endereco')->onDelete('cascade');
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
