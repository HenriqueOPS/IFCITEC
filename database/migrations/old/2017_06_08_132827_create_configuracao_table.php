<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create(env('DB_SCHEMA').'.configuracao', function (Blueprint $table) {
            $table->increments('edicao');
            $table->string('nome_evento');
            $table->timestampTz('comeco_inscricoes');
            $table->timestampTz('fim_inscricoes');
            $table->timestampTz('comeco_evento');
            $table->timestampTz('fim_evento');
            $table->boolean('camisa');
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
        Schema::dropIfExists(env('DB_SCHEMA').'.configuracao');
    }
}
