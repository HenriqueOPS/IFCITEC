<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevisaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.revisao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('projeto_id')->unsigned();
            $table->integer('pessoa_id')->unsigned();
            $table->integer('situacao_id')->unsigned();
            $table->text('observacao')->nullable();
            //Foreign Keys Constraints
            $table->foreign('projeto_id')->references('id')->on(env('DB_SCHEMA').'.projeto')->onDelete('cascade');
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
            $table->foreign('situacao_id')->references('id')->on(env('DB_SCHEMA').'.situacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(env('DB_SCHEMA').'.revisao');
    }
}
