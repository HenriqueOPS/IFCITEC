<?php

namespace App\Http\Controllers;

use App\Edicao;
use App\Projeto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	public function dashboardPage() {
		return view('admin.dashboard');
	}

	public function dashboard() {

		$response = [];

		$response['projetos']['avaliados'] = Projeto::where('edicao_id', '=', Edicao::getEdicaoId())
			->where('situacao_id', '=', 5)
			->count();

		$response['projetos']['naoAvaliados'] = Projeto::where('edicao_id', '=', Edicao::getEdicaoId())
			->where('situacao_id', '=', 4)
			->count();

		// total de projetos (avaliados + não avaliados)
		$response['projetos']['numProjetos'] = $response['projetos']['avaliados'] + $response['projetos']['naoAvaliados'];

		$subQuery = DB::table('avaliacao')
			->select(DB::raw('count(*)'))
			->where('avaliacao.projeto_id', '=', DB::raw('projeto.id'))
			->where('avaliacao.avaliado', '=', DB::raw('true'))
			->toSql();

		// projetos com apenas uma avalição até o momento
		$response['projetos']['umaAvalicao'] = Projeto::select('projeto.id')
			->where('projeto.edicao_id', '=', Edicao::getEdicaoId())
			->where(DB::raw(1) , '=', DB::raw('('.$subQuery.')'))
			->where('situacao_id', '=', 4)
			->count();

		$response['avaliadores']['numAvaliadores'] = DB::table('funcao_pessoa')
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_id', '=', 3)
			->count();

		$response['avaliadores']['presentes'] = DB::table('funcao_pessoa')
			->join('presenca', 'funcao_pessoa.pessoa_id', '=', 'presenca.id_pessoa')
			->where('presenca.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
			->where('funcao_pessoa.funcao_id', '=', 3)
			->count();

		$response['avaliadores']['naoPresentes'] = $response['avaliadores']['numAvaliadores'] - $response['avaliadores']['presentes'];

		return response()->json($response);
	}
}
