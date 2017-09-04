<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRevisoresView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('create view revisoresview as select p.id, nome, titulacao, count(r.id) as tot_revisoes from public.pessoa p left join v2017.revisao r on r.pessoa_id = p.id inner join v2017.funcao_pessoa fp on fp.pessoa_id = p.id where fp.funcao_id = 4 group by p.id,p.nome,p.titulacao');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
