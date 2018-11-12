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
            $table->string('tipo', 50);
            $table->string('campo', 50);
            $table->integer('categoria_id')->unsigned();
            $table->float('peso', 4, 2)->unsigned();
            $table->text('descricao');
            $table->boolean('val_0');
            $table->boolean('val_25');
            $table->boolean('val_50');
            $table->boolean('val_75');
            $table->boolean('val_100');
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('edicao_id')->references('id')->on(env('DB_SCHEMA').'.edicao');
            $table->foreign('categoria_id')->references('id')->on(env('DB_SCHEMA').'.categoria_avaliacao');
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
