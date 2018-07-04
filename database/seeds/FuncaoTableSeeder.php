<?php

use Illuminate\Database\Seeder;
use App\Funcao;

class FuncaoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $funcoes = [
            [
                'funcao' => 'Usuário',
                'sistema' => true,
            ],
            [
                'funcao' => 'Organizador',
                'sistema' => true,
            ],
            [
                'funcao' => 'Avaliador',
                'projeto' => true,
            ],
            [
                'funcao' => 'Homologador',
                'projeto' => true,
            ],
            [
                'funcao' => 'Autor',
                'projeto' => true,
                'integrante' => true,
            ],
            [
                'funcao' => 'Coorientador',
                'projeto' => true,
                'integrante' => true,
            ],
            [
                'funcao' => 'Orientador',
                'projeto' => true,
                'integrante' => true,
            ],
            [
                'funcao' => 'Administrador',
                'sistema' => true
            ],
            [
                'funcao' => 'Voluntário',
                'sistema' => true
            ],
        ];

        foreach ($funcoes as $funcao) {
            $funcaoEloquent = new Funcao();
            $funcaoEloquent->fill($funcao);
            $funcaoEloquent->save();
        }
    }

}
