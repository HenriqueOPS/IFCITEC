<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuncaoPessoaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pessoaId = DB::table('pessoa')->where('email', 'apvgroll@gmail.com')->value('id');
        $funcaoId = DB::table('funcao')->where('funcao', 'Administrador')->value('id');
        $edicaoId = 6;

        DB::insert('INSERT INTO funcao_pessoa(pessoa_id, funcao_id, edicao_id, homologado) VALUES (?, ?, ?, false)', [$pessoaId, $funcaoId, $edicaoId]);
    }
}
