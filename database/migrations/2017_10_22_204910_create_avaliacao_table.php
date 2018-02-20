<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvaliacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.avaliacao', function (Blueprint $table) {
            $table->increments('id');
            $table->text('observacao')->nullable();
            $table->integer('nota_final')->unsigned();
            $table->integer('projeto_id')->unsigned();
            $table->integer('pessoa_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('projeto_id')->references('id')->on(env('DB_SCHEMA').'.projeto')->onDelete('cascade');
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.avaliacao');
    }
}
