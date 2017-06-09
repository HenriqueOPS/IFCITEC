<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePalavraProjetoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(env('DB_SCHEMA').'.palavra_projeto', function (Blueprint $table) {
            $table->integer('palavra_id')->unsigned();
            $table->integer('projeto_id')->unsigned();
            //Foreign Keys Constraints
            $table->foreign('palavra_id')->references('id')->on(env('DB_SCHEMA').'.palavra_chave');
            $table->foreign('projeto_id')->references('id')->on(env('DB_SCHEMA').'.projeto')->onDelete('cascade');
           //Other Constraints
            $table->primary(['palavra_id', 'projeto_id']);
            $table->unique(['palavra_id', 'projeto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(env('DB_SCHEMA').'.palavra_projeto');
    }

}
