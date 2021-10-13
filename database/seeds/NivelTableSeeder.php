<?php

use Illuminate\Database\Seeder;
use App\Nivel;
class NivelTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $niveis = [
            [
                'nivel' => 'Ensino Fundamental',
                'descricao' => 'Anos Finais (6º ao 9º ano)',
            ],
            [
                'nivel' => 'Ensino Médio',
                'descricao' => 'Trabalhos do 1º ao 3º ano do Ensino Médio',
            ],
            [
                'nivel' => 'Ensino Médio Integrado ao Técnico',
                'descricao' =>'Trabalhos do 1º ao 4º ano do Ensino Médio Integrado',
            ],
            [
                'nivel' => 'Educação Profissional de Nível Técnico',
                'descricao' =>'Incluindo a modalidade de Educação de Jovens e Adultos',
            ],
        ];

        foreach ($niveis as $nivel){
            //Nivel::create();
            $nivelEloquent = new Nivel();
            $nivelEloquent->fill($nivel);
            $nivelEloquent->save();
        }

    }

}
