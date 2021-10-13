<?php

use Illuminate\Database\Seeder;
use App\Situacao;

class SituacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacoes = [
            [
                'situacao' => 'Não Homologado',
                'descricao' => 'Projeto não homologado!'
            ],
            [
                'situacao' => 'Homologado',
                'descricao' => 'Projeto homologado!'
            ]
        ];

        foreach($situacoes as $situacao)
        {
            $situacaoEloquent = new Situacao();
            $situacaoEloquent->fill($situacao);
            $situacaoEloquent->save();
        }
    }
}
