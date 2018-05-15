<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EnderecoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.endereco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cep',10)->nullable();
            $table->string('endereco',100)->nullable();
            $table->string('bairro',40)->nullable();
            $table->string('municipio',40)->nullable();
            $table->string('uf',20)->nullable();
            $table->string('numero',20)->nullable();

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
        Schema::dropIfExists(env('DB_SCHEMA').'.endereco');
    }
}
