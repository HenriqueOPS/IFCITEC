<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EscolaFuncaoPessoaProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nomesGigante = [
            [
                'escola_id' => 1,
                'funcao_id' => DB::table('funcao')->where('funcao', 'Autor')->value('id'),
                'pessoa_id' => DB::table('pessoa')->where('email', 'apvgroll@gmail.com')->value('id'),
                'projeto_id' => DB::table('projeto')->where('titulo', 'Projeto Teste')->value('id'),
                'edicao_id' => 6
            ]
        ];

        foreach($nomesGigante as $nomeGigante)
        {
            DB::insert('INSERT INTO escola_funcao_pessoa_projeto(escola_id, funcao_id, pessoa_id, projeto_id, edicao_id) VALUES (?, ?, ?, ?, ?)', [$nomeGigante['escola_id'], $nomeGigante['funcao_id'], $nomeGigante['pessoa_id'], $nomeGigante['projeto_id'], $nomeGigante['edicao_id']]);
        }
    }
}
