<?php

use Illuminate\Database\Seeder;
use App\Tarefa;

class TarefaTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tarefas = [
            [
                'tarefa' => 'Visitação',
                'descricao' => 'Acompanhar externos durante visitação no campus'
            ],
            [
                'tarefa' => 'Controle de Alunos',
                'descricao' => 'Controlar entrada de alunos no campus'
            ],
            [
                'tarefa' => 'Fiscal de Corredor',
                'descricao' => 'Auxiliar participantes nos corredores das bancas de apresentação'
            ],
            [
                'tarefa' => 'Coffee Break',
                'descricao' => 'Montagem do Coffee Break dos Avaliadores'
            ],
            [
                'tarefa' => 'Fotografia',
                'descricao' => 'Fotografar o evento nos dias do mesmo'
            ],
        ];
        
        foreach ($tarefas as $tarefa){
            $tarefaEloquent = new Tarefa();
            $tarefaEloquent->fill($tarefa);
            $tarefaEloquent->save();
        }
    }

}
