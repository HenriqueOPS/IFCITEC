<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AvaliacaoTable extends Migration
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
            $table->integer('projeto_id')->unsigned();
            $table->integer('pessoa_id')->unsigned();
            $table->float('nota_final', 6, 2)->unsigned();
            $table->text('observacao');
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('projeto_id')->references('id')->on(env('DB_SCHEMA').'.projeto');
            $table->foreign('pessoa_id')->references('id')->on(env('DB_SCHEMA').'.pessoa');
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
