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
use App\Mensagem;

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
		$pessoa = Pessoa::find(Auth::id());
		if (Pessoa::find(Auth::id())->temFuncao('Voluntário') == true) {

			if (Pessoa::find(Auth::id())->temTarefa()) {
				$tarefa = DB::table('pessoa_tarefa')
					->select('tarefa.tarefa')
					->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
					->where('pessoa_tarefa.pessoa_id', '=', Auth::id())
					->get();
				

				return view('voluntario.tarefa', 
				['tarefa' => $tarefa]);
			} else {
				return view('voluntario.inscricaoEnviada');
			}
		} else {
			$tarefas = Tarefa::orderBy('tarefa')->get();
			$aviso = Mensagem::where('nome','=','Aviso(CadastroDeVoluntarios)')->get();
			$cursos = DB::table('cursos')->select('nome','nivel_id')->get();
			return view('voluntario.cadastro',compact('cursos'))->withTarefas($tarefas)->withAviso($aviso[0]->conteudo)->withPessoa($pessoa);
		}
	}

	public function cadastraVoluntario(Request $req)
	{
		$pessoa =Pessoa::find(Auth::id());
		$pessoa->telefone = $req->input('telefone');
		$pessoa->email = $req->input('email');
		$pessoa->nome = $req->input('nome');

		$req->input('ano');
		$voluntarioData = [
			'id' => $pessoa->id,      // Defina o ID do voluntário
			'ano' =>  $req->input('ano'),
			'curso' =>  $req->input('curso'),
			'turma' => $req->input('turma'),
			'edicao_id' =>  Edicao::getEdicaoId()
		];
		DB::table('voluntarios')->insert($voluntarioData);
		// Salva as alterações no registro da pessoa
		$pessoa->save();
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
					'homologado' => null
				]);

			$emailJob = (new \App\Jobs\MailBaseJob(Auth::user()->email, 'Voluntario', ['nome' => Auth::user()->nome]))
				->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);

			return view('voluntario.inscricaoEnviada');
		} else {
			return view('voluntario.temTrabalho');
		}
	}
	public function info($id){
		$voluntario = DB::table('voluntarios')->where('id', $id)->first();
		$pessoa = DB::table('pessoa')->where('id', $id)->first();
	
		// Juntar os objetos em um único objeto
		$info = (object) array_merge((array) $voluntario, (array) $pessoa);
	
		return response()->json($info);
	}
	public function homologar($id,Request $req){
		$update = $req->input('homologado');
		$voluntario = DB::table('funcao_pessoa')
		->where('pessoa_id',$id)
		->where('funcao_id',9)
		->where('edicao_id',Edicao::getEdicaoId())
		->update(['homologado' => $update]);
		$pessoa = Pessoa::where('id',$id)->first();
		$emailJob = (new \App\Jobs\MailBaseJob($pessoa->email, 'EmailVoluntarios', ['nome' => $pessoa->nome]))
				->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);
		return response()->json(['success' => 'Operação Realizada com sucesso']);
		
	}
}
