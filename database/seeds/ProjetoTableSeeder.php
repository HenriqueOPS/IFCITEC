<?php

use Illuminate\Database\Seeder;
use App\Projeto;

class ProjetoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resumo = '';

        // Aqui como o mínimo de caracteres do resumo (normalmente) é de 800 e o máximo é 1500, mas no banco o mínimo é 1500, eu boto exatamente 1500 caracteres :)
        for ($i = 0; $i < 1500; $i++)
        {
            $resumo .= 'T';
        }

        $projetos = [
            [
                'titulo' => 'Projeto Teste',
                'resumo' => $resumo,
                'area_id' => 1,
                'nivel_id' => 1,
                'edicao_id' => 6,
                'situacao_id' => 1,
				'presenca' => false
            ]
        ];

        foreach($projetos as $projeto)
        {
            $projetoEloquent = new Projeto();
            $projetoEloquent->fill($projeto);
            $projetoEloquent->save();
        }

    }
}
