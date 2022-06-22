<?php

use Illuminate\Database\Seeder;
use App\Pessoa;
use Illuminate\Hashing\BcryptHasher;

class PessoaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pessoas = [
            [
                'nome' => 'Arthur Von Groll',
                'email' => 'apvgroll@gmail.com',
                'senha' => bcrypt('123'),
                'cpf' => '123.456.789-00',
                'rg' => '0123456789',
                'camisa' => 'G',
                'dt_nascimento' => '2021-10-09 03:36:41',
                'telefone' => '01234567890',
                'titulacao' => 'estudante do ensino medio',
                'lattes' => 'au au au',
                'profissao' => 'estudante',
                'instituicao' => 'Instituto Federal de Educação, Ciência e Tecnologia do Rio Grande do Sul - Campus Canoas'
            ]
        ];
        
        foreach ($pessoas as $pessoa)
        {
            $pessoaEloquent = new Pessoa();
            $pessoaEloquent->fill($pessoa);
            $pessoaEloquent->save();
        }
    }
}
