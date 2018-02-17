<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(env('DB_SCHEMA').'.edicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ano');   
            //Periodo de Inscricao
            $table->dateTime('inscricao_abertura');
            $table->dateTime('inscricao_fechamento');
            //Periodo de Homologacao
            $table->dateTime('homologacao_abertura');
            $table->dateTime('homologacao_fechamento');
            //Periodo de Avaliação
            $table->dateTime('avaliacao_abertura');
            $table->dateTime('avaliacao_fechamento');
            //Periodo de Credenciamento
            $table->dateTime('credenciamento_abertura');
            $table->dateTime('credenciamento_fechamento');
            //Periodo de Inscrição para Voluntarios
            $table->dateTime('voluntario_abertura');
            $table->dateTime('voluntario_fechamento');
            //Periodo de Inscrição para Avaliador/Homologador
            $table->dateTime('comissao_abertura');
            $table->dateTime('comissao_fechamento');
            //Periodo de Submissão Relatório Final
            $table->dateTime('relatorio_abertura');
            $table->dateTime('relatorio_fechamento');
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
        Schema::dropIfExists(env('DB_SCHEMA').'.edicao');
    }
}
