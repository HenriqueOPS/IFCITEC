<?php

use Illuminate\Database\Seeder;
use App\Edicao;

class EdicaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$edicoes = [
			[
				'ano' => 1,
				'projetos' => 10,
				'inscricao_abertura' => '2013-06-26 00:00:00',
				'inscricao_fechamento' => '2013-06-26 00:00:00',
				'homologacao_abertura' => '2013-06-26 00:00:00',
				'homologacao_fechamento' => '2013-06-26 00:00:00',
				'avaliacao_abertura' => '2013-06-26 00:00:00',
				'avaliacao_fechamento' => '2013-06-26 00:00:00',
				'credenciamento_abertura' => '2013-06-26 00:00:00',
				'credenciamento_fechamento' => '2013-06-26 00:00:00',
				'voluntario_abertura' => '2013-06-26 00:00:00',
				'voluntario_fechamento' => '2013-06-26 00:00:00',
				'comissao_abertura' => '2013-06-26 00:00:00',
				'comissao_fechamento' => '2013-06-26 00:00:00',
				'feira_abertura' => '2013-06-26 00:00:00',
				'feira_fechamento' => '2013-06-26 00:00:00',
			],[
				'ano' => 2,
				'projetos' => 10,
				'inscricao_abertura' => '2014-06-26 00:00:00',
				'inscricao_fechamento' => '2014-06-26 00:00:00',
				'homologacao_abertura' => '2014-06-26 00:00:00',
				'homologacao_fechamento' => '2014-06-26 00:00:00',
				'avaliacao_abertura' => '2014-06-26 00:00:00',
				'avaliacao_fechamento' => '2014-06-26 00:00:00',
				'credenciamento_abertura' => '2014-06-26 00:00:00',
				'credenciamento_fechamento' => '2014-06-26 00:00:00',
				'voluntario_abertura' => '2014-06-26 00:00:00',
				'voluntario_fechamento' => '2014-06-26 00:00:00',
				'comissao_abertura' => '2014-06-26 00:00:00',
				'comissao_fechamento' => '2014-06-26 00:00:00',
				'feira_abertura' => '2014-06-26 00:00:00',
				'feira_fechamento' => '2014-06-26 00:00:00',
			],[
				'ano' => 3,
				'projetos' => 10,
				'inscricao_abertura' => '2015-06-26 00:00:00',
				'inscricao_fechamento' => '2015-06-26 00:00:00',
				'homologacao_abertura' => '2015-06-26 00:00:00',
				'homologacao_fechamento' => '2015-06-26 00:00:00',
				'avaliacao_abertura' => '2015-06-26 00:00:00',
				'avaliacao_fechamento' => '2015-06-26 00:00:00',
				'credenciamento_abertura' => '2015-06-26 00:00:00',
				'credenciamento_fechamento' => '2015-06-26 00:00:00',
				'voluntario_abertura' => '2015-06-26 00:00:00',
				'voluntario_fechamento' => '2015-06-26 00:00:00',
				'comissao_abertura' => '2015-06-26 00:00:00',
				'comissao_fechamento' => '2015-06-26 00:00:00',
				'feira_abertura' => '2015-06-26 00:00:00',
				'feira_fechamento' => '2015-06-26 00:00:00',
			],[
				'ano' => 4,
				'projetos' => 10,
				'inscricao_abertura' => '2016-06-26 00:00:00',
				'inscricao_fechamento' => '2016-06-26 00:00:00',
				'homologacao_abertura' => '2016-06-26 00:00:00',
				'homologacao_fechamento' => '2016-06-26 00:00:00',
				'avaliacao_abertura' => '2016-06-26 00:00:00',
				'avaliacao_fechamento' => '2016-06-26 00:00:00',
				'credenciamento_abertura' => '2016-06-26 00:00:00',
				'credenciamento_fechamento' => '2016-06-26 00:00:00',
				'voluntario_abertura' => '2016-06-26 00:00:00',
				'voluntario_fechamento' => '2016-06-26 00:00:00',
				'comissao_abertura' => '2016-06-26 00:00:00',
				'comissao_fechamento' => '2016-06-26 00:00:00',
				'feira_abertura' => '2016-06-26 00:00:00',
				'feira_fechamento' => '2016-06-26 00:00:00',
			],[
				'ano' => 5,
				'projetos' => 10,
				'inscricao_abertura' => '2017-06-26 00:00:00',
				'inscricao_fechamento' => '2017-06-26 00:00:00',
				'homologacao_abertura' => '2017-06-26 00:00:00',
				'homologacao_fechamento' => '2017-06-26 00:00:00',
				'avaliacao_abertura' => '2017-06-26 00:00:00',
				'avaliacao_fechamento' => '2017-06-26 00:00:00',
				'credenciamento_abertura' => '2017-06-26 00:00:00',
				'credenciamento_fechamento' => '2017-06-26 00:00:00',
				'voluntario_abertura' => '2017-06-26 00:00:00',
				'voluntario_fechamento' => '2017-06-26 00:00:00',
				'comissao_abertura' => '2017-06-26 00:00:00',
				'comissao_fechamento' => '2017-06-26 00:00:00',
				'feira_abertura' => '2017-06-26 00:00:00',
				'feira_fechamento' => '2017-06-26 00:00:00',
			]

		];

		foreach ($edicoes as $edicao) {
			$edicaoEloquent = new Edicao();
			$edicaoEloquent->fill($edicao);
			$edicaoEloquent->save();
		}
    }
}
