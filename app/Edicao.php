<?php

namespace App;

use App\Mods\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Edicao extends Model
{

	protected $table = 'edicao';

	protected $fillable = [
		'inscricao_abertura', 'inscricao_fechamento',
		'homologacao_abertura', 'homologacao_fechamento',
		'avaliacao_abertura', 'avaliacao_fechamento',
		'credenciamento_abertura', 'credenciamento_fechamento',
		'voluntario_abertura', 'voluntario_fechamento',
		'comissao_abertura', 'comissao_fechamento',
		'feira_abertura', 'feira_fechamento', 'ano', 'projetos'
	];

	//Pega o ID da edição atual pelo período da feira
	public static function getEdicaoId()
	{


		$edicao = Edicao::whereRaw("(NOW() AT TIME ZONE 'America/Sao_Paulo') >= feira_abertura")
			->whereRaw("(NOW() AT TIME ZONE 'America/Sao_Paulo') <= feira_fechamento")
			->get();

		if ($edicao->count()) {
			return $edicao[0]->id;
		}

		return 0;
	}

	public static function numeroProjetos()
	{

		$edicao = Edicao::select(['projetos'])
			->where('id', '=', Edicao::getEdicaoId())
			->get();

		if ($edicao->count())
			return $edicao[0]->projetos;

		return 0;
	}

	//Pega o ANO da edição atual em números romanos
	public static function getAnoEdicao()
	{

		$ano = Edicao::select(['ano'])
			->where('id', '=', Edicao::getEdicaoId())
			->get();

		if ($ano->count())
			return Edicao::numeroEdicao($ano[0]->ano);

		return false;
	}

	//Consulta se está dentro dos períodos
	public static function consultaPeriodo($tipo)
	{

		$nome_campos = false;

		switch ($tipo) {
			case 'Inscrição':
				$nome_campos = ['inscricao_abertura', 'inscricao_fechamento'];
				break;
			case 'Homologação':
				$nome_campos = ['homologacao_abertura', 'homologacao_fechamento'];
				break;
			case 'Avaliação':
				$nome_campos = ['avaliacao_abertura', 'avaliacao_fechamento'];
				break;
			case 'Credenciamento':
				$nome_campos = ['credenciamento_abertura', 'credenciamento_fechamento'];
				break;
			case 'Voluntário':
				$nome_campos = ['voluntario_abertura', 'voluntario_fechamento'];
				break;
			case 'Comissão':
				$nome_campos = ['comissao_abertura', 'comissao_fechamento'];
				break;
			case 'Feira':
				$nome_campos = ['feira_abertura', 'feira_fechamento'];
				break;
		}

		if ($nome_campos) {
			$edicao = Edicao::whereRaw("(NOW() AT TIME ZONE 'America/Sao_Paulo') >= " . $nome_campos[0])
				->whereRaw("(NOW() AT TIME ZONE 'America/Sao_Paulo') <= " . $nome_campos[1])
				->get();

			if ($edicao->count()) {
				return $edicao[0]->id;
			}
		}

		return false;
	}

	public static function numeroEdicao($n)
	{

		$numStr = '';

		//dezenas
		if ($n >= 10) {
			switch ((int)($n / 10)) {
				case 1:
					$numStr .= 'X';
					break;
				case 2:
					$numStr .= 'XX';
					break;
				case 3:
					$numStr .= 'XXX';
					break;
				case 4:
					$numStr .= 'XL';
					break;
				case 5:
					$numStr .= 'L';
					break;
				case 6:
					$numStr .= 'LX';
					break;
				case 7:
					$numStr .= 'LXX';
					break;
				case 8:
					$numStr .= 'LXXX';
					break;
				case 9:
					$numStr .= 'XC';
					break;
				case 10:
					$numStr .= 'C';
					break;
			}

			$n = $n % 10;
		}

		//unidades
		switch ($n) {
			case 1:
				$numStr .= 'I';
				break;
			case 2:
				$numStr .= 'II';
				break;
			case 3:
				$numStr .= 'III';
				break;
			case 4:
				$numStr .= 'IV';
				break;
			case 5:
				$numStr .= 'V';
				break;
			case 6:
				$numStr .= 'VI';
				break;
			case 7:
				$numStr .= 'VII';
				break;
			case 8:
				$numStr .= 'VIII';
				break;
			case 9:
				$numStr .= 'IX';
				break;
		}

		return $numStr;
	}

	public function edicoes()
	{
		return $this->belongsToMany('App\Edicao', 'edicao');
	}

	public function niveis()
	{
		return $this->belongsToMany('App\Nivel', 'nivel_edicao', 'edicao_id', 'nivel_id');
	}

	public function pessoas()
	{
		return $this->belongsToMany('App\Pessoa', 'comissao_edicao', 'pessoa_id', 'edicao_id');
	}

	public function areas()
	{
		return $this->belongsToMany('App\AreaConhecimento', 'area_edicao', 'edicao_id', 'area_id');
	}
}
