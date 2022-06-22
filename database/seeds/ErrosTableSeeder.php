<?php

use Illuminate\Database\Seeder;
use App\Erro;

class ErrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$erros = [
			[
				'descricao_erro' => 'Teste de descrição de erro...',
				'fingerprint' => sha1('123')
			]
		];

		foreach($erros as $erro)
		{
			$erroEloquent = new Erro();
			$erroEloquent->fill($erro);
			$erroEloquent->save();
		}
    }
}
