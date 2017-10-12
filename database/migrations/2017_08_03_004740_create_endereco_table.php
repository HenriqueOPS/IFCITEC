<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create(env('DB_SCHEMA') . '.endereco', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rua');
            $table->integer('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');
            $table->text('complemento')->nullable();
            $table->integer('pessoa_id')->unsigned();
            $table->timestamps();
            //Foreign Keys Constraints
            $table->foreign('pessoa_id')->references('id')->on('pessoa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists(env('DB_SCHEMA') . '.endereco');
    }

}
