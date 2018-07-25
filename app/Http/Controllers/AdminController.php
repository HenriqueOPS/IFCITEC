<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Http\Requests\NivelRequest;
use App\Projeto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Funcao;
use App\Edicao;
use App\Escola;
use App\Endereco;
use App\Nivel;
use App\Pessoa;
use App\AreaConhecimento;

class AdminController extends Controller
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

		$edicoes = Edicao::all(['id', 'ano',
			'inscricao_abertura', 'inscricao_fechamento',
			'homologacao_abertura', 'homologacao_fechamento',
			'avaliacao_abertura', 'avaliacao_fechamento'])->sortByDesc('ano');

		$niveis = Nivel::all(['id', 'nivel', 'descricao']);

		$areas = AreaConhecimento::all(['id', 'area_conhecimento', 'descricao', 'nivel_id']);

		$escolas = Escola::all(['id', 'nome_completo', 'nome_curto', 'email', 'telefone']);

		$usuarios = Pessoa::all(['id', 'nome', 'email']);

		$projetos = DB::table('projeto')
			->select('titulo', 'id')
			->orderBy('created_at', 'asc')
			->where('edicao_id', Edicao::getEdicaoId())
			->get()
			->keyBy('id')
			->toArray();

		$autores = array();
		$orientadores = array();
		$coorientadores = array();

		//Participantes dos projetos
		if ($projetos) {
			$idAutor = Funcao::where('funcao', 'Autor')->first();
			$idOrientador = Funcao::where('funcao', 'Orientador')->first();
			$idCoorientador = Funcao::where('funcao', 'Coorientador')->first();

			$ids = array_keys($projetos);

			$autores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idAutor->id)
				->get()
				->toArray();

			$orientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)
				->where('funcao_id', $idOrientador->id)
				->get()
				->toArray();

			$coorientadores = DB::table('escola_funcao_pessoa_projeto')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->select('escola_funcao_pessoa_projeto.projeto_id', 'pessoa.id', 'pessoa.nome')
				->whereIn('projeto_id', $ids)->where('funcao_id', $idCoorientador->id)
				->get()
				->toArray();
		}

		$comissao = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('comissao_edicao', function ($join){
				$join->on('comissao_edicao.pessoa_id', '=', 'pessoa.id');
				$join->where('comissao_edicao.edicao_id', '=', Edicao::getEdicaoId());
			})
			->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId())
			->whereRaw('(funcao_pessoa.funcao_id = 3 or funcao_pessoa.funcao_id = 4)')
			->select('comissao_edicao.id','funcao_pessoa.homologado', 'funcao_pessoa.funcao_id',
					 'pessoa.nome', 'pessoa.instituicao', 'pessoa.titulacao')
			->orderBy('funcao_pessoa.homologado')
			->get()
			->toArray();

		return view('admin.home', collect(['edicoes' => $edicoes,
			'escolas' => $escolas,
			'niveis' => $niveis,
			'areas' => $areas,
			'projetos' => $projetos,
			'autores' => $autores,
			'orientadores' => $orientadores,
			'coorientadores' => $coorientadores,
			'comissao' => $comissao
		]))->withUsuarios($usuarios);

	}


	public function dadosNivel($id)
	{ //Ajax
		return Nivel::find($id);
	}

	public function cadastroNivel()
	{
		return view('admin.cadastroNivel');
	}


	public function cadastraNivel(NivelRequest $req)
	{

		$data = $req->all();

		Nivel::create([
			'nivel' => $data['nivel'],
			'descricao' => $data['descricao'],
			'max_ch' => $data['max_ch'],
			'min_ch' => $data['min_ch'],
			'palavras' => $data['palavras'],
		]);

		return redirect()->route('administrador');

	}

	public function editarNivel($id)
	{
		$dados = Nivel::find($id);
		return view('admin.editarNivel', array('dados' => $dados));

	}

	public function editaNivel(NivelRequest $req)
	{

		$data = $req->all();
		$id = $data['id_nivel'];

		Nivel::where('id', $id)
			->update(['nivel' => $data['nivel'],
				'max_ch' => $data['max_ch'],
				'min_ch' => $data['min_ch'],
				'descricao' => $data['descricao'],
				'palavras' => $data['palavras'],
			]);

		return redirect()->route('administrador');
	}

	public function excluiNivel($id, $s)
	{

		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			Nivel::find($id)->delete();

			return 'true';
		}

		return 'false';
	}

	public function dadosArea($id)
	{ //Ajax

		$dados = AreaConhecimento::find($id);
		$data = Nivel::find($dados->nivel_id);

		return compact('dados', 'data');
	}

	public function cadastroArea()
	{
		$niveis = DB::table('nivel')->select('id', 'nivel')->get();

		return view('admin.cadastroArea', array('niveis' => $niveis));
	}

	public function cadastraArea(AreaRequest $req)
	{

		$data = $req->all();

		AreaConhecimento::create([
			'nivel_id' => $data['nivel_id'],
			'area_conhecimento' => $data['area_conhecimento'],
			'descricao' => $data['descricao'],
		]);

		return redirect()->route('administrador');

	}

	public function editarArea($id)
	{
		$niveis = DB::table('nivel')->select('id', 'nivel')->get();
		$dados = AreaConhecimento::find($id);

		return view('admin.editarArea', array('niveis' => $niveis), compact('dados', 'n'));
	}

	public function editaArea(AreaRequest $req)
	{

		$data = $req->all();

		$id = $data['id_area'];

		AreaConhecimento::where('id', $id)
			->update(['nivel_id' => $data['nivel_id'],
				'area_conhecimento' => $data['area_conhecimento'],
				'descricao' => $data['descricao']
			]);

		return redirect()->route('administrador');
	}

	public function excluiArea($id, $s)
	{
		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			AreaConhecimento::find($id)->delete();
			return 'true';
		}

		return 'false';
	}

	public function dadosEscola($id)
	{ //Ajax

		$dados = Escola::find($id);

		if ($dados['endereco_id'])
			$data = Endereco::find($dados['endereco_id']);

		return compact('dados', 'data');
	}

	public function editarEscola($id)
	{

		$data = '';
		$dados = Escola::find($id);

		if ($dados['endereco_id'])
			$data = Endereco::find($dados['endereco_id']);

		return view('admin.editarEscola', compact('dados', 'data'));

	}

	public function editaEscola(Request $req)
	{

		$data = $req->all();

		$id_escola = $data['id_escola'];
		$id_endereco = $data['id_endereco'];

		if ($id_endereco != 0) {

			Endereco::where('id', $id_endereco)
				->update(['cep' => $data['cep'],
					'endereco' => $data['endereco'],
					'bairro' => $data['bairro'],
					'municipio' => $data['municipio'],
					'uf' => $data['uf'],
					'numero' => $data['numero']
				]);

		} else {

			$id_endereco = Endereco::create(['cep' => $data['cep'],
				'endereco' => $data['endereco'],
				'bairro' => $data['bairro'],
				'municipio' => $data['municipio'],
				'uf' => $data['uf'],
				'numero' => $data['numero']
			]);

			$id_endereco = $id_endereco['id'];

		}


		Escola::where('id', $id_escola)
			->update(['nome_completo' => $data['nome_completo'],
				'nome_curto' => $data['nome_curto'],
				'email' => $data['email'],
				'telefone' => $data['telefone'],
				'endereco_id' => $id_endereco
			]);

		return redirect()->route('administrador');
	}

	public function cadastroEscola()
	{
		return view('admin.cadastroEscola');
	}

	public function cadastraEscola(Request $req)
	{
		$data = $req->all();

		$idEndereco = Endereco::create([
			'cep' => $data['cep'],
			'endereco' => $data['endereco'],
			'bairro' => $data['bairro'],
			'municipio' => $data['municipio'],
			'uf' => $data['uf'],
			'numero' => $data['numero']
		]);

		Escola::create([
			'nome_completo' => $data['nome_completo'],
			'nome_curto' => $data['nome_curto'],
			'email' => $data['email'],
			'telefone' => $data['telefone'],
			'endereco_id' => $idEndereco['original']['id']
		]);

		return redirect()->route('administrador');

	}

	public function excluiEscola($id, $s)
	{

		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			Escola::find($id)->delete();


			return 'true';
		} else {
			return 'password-problem';
		}


	}

	public function editarFuncaoUsuario($id)
	{
		$usuario = Pessoa::find($id);
		$funcoes = Funcao::all();

		return view('admin.editarFuncaoUsuario')
			->withUsuario($usuario)
			->withFuncoes($funcoes);
	}

	public function editaFuncaoUsuario(Request $req, $id)
	{
		$data = $req->all();
		$funcoes = DB::table('funcao_pessoa')
			->select('funcao_id')
			->where('pessoa_id', $id)
			->get()
			->keyBy('funcao_id')
			->toArray();

		if (!empty($funcoes)) {
			$funcaoId = array_keys($funcoes);
			foreach ($funcoes as $funcao) {
				if (!isset($data['funcao']) || (!in_array($funcao->funcao_id, $data['funcao']))) {
					DB::table('funcao_pessoa')->where('funcao_id', $funcao->funcao_id)->where('pessoa_id', $id)->delete();
				}
			}

			if (isset($data['funcao'])) {
				foreach ($data['funcao'] as $funcao) {
					if (!in_array($funcao, $funcaoId)) {
						DB::table('funcao_pessoa')->insert([
							'funcao_id' => $funcao,
							'pessoa_id' => $id,
							'edicao_id' => Edicao::getEdicaoId(),
							'homologado' => TRUE
						]);
					}
				}
			}
		}
		else {
			foreach ($data['funcao'] as $funcao) {
				DB::table('funcao_pessoa')->insert([
					'funcao_id' => $funcao,
					'pessoa_id' => $id,
					'edicao_id' => Edicao::getEdicaoId(),
					'homologado' => TRUE
				]);
			}
		}

		$usuario = Pessoa::find($id);
		$funcoes = Funcao::all();
		return view('admin.editarFuncaoUsuario')
			->withUsuario($usuario)
			->withFuncoes($funcoes);
	}

	public function pesquisa(Request $req){
		$data = $req->all();
		//Teste
		$usuarios = Pessoa::where('nome','Rafaella')->get();
        return response()->json($usuarios);
	}

}
