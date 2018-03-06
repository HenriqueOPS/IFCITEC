<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CamposAvaliacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.campos_avaliacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edicao_id')->unsigned();
            $table->string('campo', 50);
            $table->float('min', 4, 2)->unsigned();
            $table->float('max', 4, 2)->unsigned();
            $table->text('descricao');
            $table->float('peso', 4, 2)->unsigned();
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
        Schema::dropIfExists(env('DB_SCHEMA').'.campos_avaliacao');
    }
}
