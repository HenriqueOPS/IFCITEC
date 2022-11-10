<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Jobs\MailVoluntarioJob;

use App\Edicao;
use App\Pessoa;
use App\Funcao;
use App\Tarefa;

use App\Enums\EnumFuncaoPessoa;

class VoluntarioController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		if (Pessoa::find(Auth::id())->temFuncao('Voluntário') == true) {

			if (Pessoa::find(Auth::id())->temTarefa()) {
				$tarefa = DB::table('pessoa_tarefa')
					->select('tarefa.tarefa')
					->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
					->where('pessoa_tarefa.pessoa_id', '=', Auth::id())
					->get();

				return view('voluntario.tarefa', ['tarefa' => $tarefa]);
			} else {
				return view('voluntario.inscricaoEnviada');
			}
		} else {
			$tarefas = Tarefa::orderBy('tarefa')->get();

			return view('voluntario.cadastro')->withTarefas($tarefas);
		}
	}

	public function cadastraVoluntario(Request $req)
	{

		if (!Auth::user()->temTrabalho()) {
			$funcaoVoluntarioId = EnumFuncaoPessoa::getValue('Voluntario');

			$voluntario = DB::table('funcao_pessoa')
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('funcao_id', '=', $funcaoVoluntarioId)
				->where('pessoa_id', '=', Auth::id())
				->where('homologado', '=', false)
				->get();

			// verifica se já tá inscrito como voluntário
			if ($voluntario->count())
				return view('voluntario.inscricaoEnviada');

			DB::table('funcao_pessoa')
				->insert([
					'edicao_id' => Edicao::getEdicaoId(),
					'funcao_id' => $funcaoVoluntarioId,
					'pessoa_id' => Auth::id(),
					'homologado' => false
				]);

			$emailJob = (new \App\Jobs\MailBaseJob(Auth::user()->email, 'Voluntario', ['nome' => Auth::user()->nome]))
				->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);

			return view('voluntario.inscricaoEnviada');
		} else {
			return view('voluntario.temTrabalho');
		}
	}
}
