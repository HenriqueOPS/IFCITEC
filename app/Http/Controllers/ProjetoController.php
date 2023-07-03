<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\ProjetoRequest;

// Mail Jobs
use App\Jobs\MailAutorJob;
use App\Jobs\MailOrientadorJob;
use App\Jobs\MailCoorientadorJob;
use App\Jobs\MailProjetoHomologadoJob;
use App\Jobs\MailProjetoNaoHomologadoJob;
use App\Jobs\MailVinculaProjetoJob;
use App\Jobs\MailVinculaAvaliadorJob;

//
use App\Pessoa;
use App\Funcao;
use App\Nivel;
use App\AreaConhecimento;
use App\Escola;
use App\Edicao;
use App\Projeto;
use App\PalavraChave;
use App\Revisao;
use App\Avaliacao;
use App\Mensagem;

use App\Enums\EnumSituacaoProjeto;
use App\Enums\EnumFuncaoPessoa;

class ProjetoController extends Controller
{

	/**
	 * Instantiate a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('confirmaPresenca');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{

		//Não está no período de Inscrição
		if (!Edicao::consultaPeriodo('Inscrição'))
			return redirect()->route('home');

		/*
		Não sei pq mas parou de funcionar
		$niveis = Edicao::find(Edicao::getEdicaoId())->niveis()->get();
		$areas = Edicao::find(Edicao::getEdicaoId())->areas()->get();
		*/

		$aviso = Mensagem::where('nome', '=', 'Aviso(NovoProjetoPrimeiro)')->get();
		$aviso2 = Mensagem::where('nome', '=', 'Aviso(NovoProjetoSegundo)')->get();
		$niveis = DB::table('nivel_edicao')
			->select(['nivel.id', 'nivel', 'min_ch', 'max_ch', 'palavras'])
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->join('nivel', 'nivel_edicao.nivel_id', '=', 'nivel.id')
			->get();

		$areas = Edicao::find(Edicao::getEdicaoId())->areas()->get();

		$funcoes = Funcao::getByCategory('integrante');

		$escolas = Escola::all(['id', 'nome_curto']);
		$pessoas = Pessoa::all(['id', 'nome', 'email', 'oculto'])->filter(function ($item) {
			return $item->oculto == false;
		});

		return view('projeto.create',[
			'aviso'=>$aviso[0]->conteudo,
			'aviso2'=>$aviso2[0]->conteudo,
		])
			->withNiveis($niveis)
			->withAreas($areas)
			->withFuncoes($funcoes)
			->withEscolas($escolas)
			->withPessoas($pessoas);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProjetoRequest $request)
	{
		$projeto = new Projeto();
		$projeto->fill($request->toArray());
		$projeto->titulo = strtoupper($request->titulo);
		$projeto->situacao_id = EnumSituacaoProjeto::getValue('Cadastrado');
		//
		$areaConhecimento = AreaConhecimento::find($request->area_conhecimento);
		$nivel = Nivel::find($request->nivel);
		$edicao = Edicao::find(Edicao::getEdicaoId());

		$projeto->edicao()->associate($edicao);
		$projeto->areaConhecimento()->associate($areaConhecimento);
		$projeto->nivel()->associate($nivel);
		//
		$projeto->save();
		//--Inicio Attachment de Palavras Chaves. Tabela: palavra_projeto
		$palavrasChaves = $request->palavras_chaves;
$palavrasChaves = explode(",", $palavrasChaves);
foreach ($palavrasChaves as $palavra) {
    $projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $palavra]));
}

		//--Inicio Attachment de Participante.
		//Tabela: escola_funcao_pessoa_projeto
		//Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos

		//Autores
		foreach ($request['autor'] as $key => $idAutor) {

			if ($idAutor) {

				$dataAutor = Pessoa::select(['id', 'nome', 'email'])->find($idAutor);
				if (!$dataAutor->temFuncao('Autor')) {
					DB::table('funcao_pessoa')
						->insert([
							'edicao_id' => Edicao::getEdicaoId(),
							'funcao_id' => EnumFuncaoPessoa::getValue('Autor'),
							'pessoa_id' => $idAutor,
							'homologado' => false
						]);
				}

				DB::table('escola_funcao_pessoa_projeto')
					->insert([
						'escola_id' => $request->escola,
						'funcao_id' => EnumFuncaoPessoa::getValue('Autor'),
						'pessoa_id' => $idAutor,
						'projeto_id' => $projeto->id,
						'edicao_id' => Edicao::getEdicaoId(),
						'concluinte' => $request->autorConcluinte[$key]
					]);

				dispatch(
					new \App\Jobs\MailBaseJob(
						$dataAutor->email,
						'Projeto Criado Autor',
						[
							'nome' => $dataAutor->nome,
							'titulo' => $projeto->titulo
						]
					)
				);
			}
		}

		// Orientador
		$dataOrientador = Pessoa::select(['id', 'nome', 'email'])->find($request['orientador']);
		if (!$dataOrientador->temFuncao('Orientador')) {
			DB::table('funcao_pessoa')
				->insert([
					'edicao_id' => Edicao::getEdicaoId(),
					'funcao_id' => EnumFuncaoPessoa::getValue('Orientador'),
					'pessoa_id' => $request['orientador'],
					'homologado' => false
				]);
		}

		DB::table('escola_funcao_pessoa_projeto')
			->insert([
				'escola_id' => $request->escola,
				'funcao_id' => EnumFuncaoPessoa::getValue('Orientador'),
				'pessoa_id' => $request['orientador'],
				'projeto_id' => $projeto->id,
				'edicao_id' => Edicao::getEdicaoId()
			]);

		dispatch(
			new \App\Jobs\MailBaseJob(
				$dataOrientador->email,
				'Projeto Criado Orientador',
				[
					'nome' => $dataOrientador->nome,
					'titulo' => $projeto->titulo
				]
			)
		);

		// Coorientadores
		foreach ($request['coorientador'] as $idCoorientador) {

			if ($idCoorientador) {

				$dataCoorientador = Pessoa::select(['id', 'nome', 'email'])->find($idCoorientador);
				if (!$dataCoorientador->temFuncao('Coorientador')) {
					DB::table('funcao_pessoa')
						->insert([
							'edicao_id' => Edicao::getEdicaoId(),
							'funcao_id' => EnumFuncaoPessoa::getValue('Coorientador'),
							'pessoa_id' => $idCoorientador,
							'homologado' => false
						]);
				}

				DB::table('escola_funcao_pessoa_projeto')
					->insert([
						'escola_id' => $request->escola,
						'funcao_id' => EnumFuncaoPessoa::getValue('Coorientador'),
						'pessoa_id' => $idCoorientador,
						'projeto_id' => $projeto->id,
						'edicao_id' => Edicao::getEdicaoId(),
					]);

				dispatch(
					new \App\Jobs\MailBaseJob(
						$dataCoorientador->email,
						'Projeto Criado Coorientador',
						[
							'nome' => $dataCoorientador->nome,
							'titulo' => $projeto->titulo
						]
					)
				);
			}
		}

		return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
		$projeto = Projeto::find($id);
		if (!($projeto instanceof Projeto)) {
			abort(404);
		}

		$ehHomologador = DB::table('revisao')
			->where('projeto_id', '=', $projeto->id)
			->where('pessoa_id', '=', Auth::user()->id)
			->get()->count();

		$ehAvaliador = DB::table('avaliacao')
			->where('projeto_id', '=', $projeto->id)
			->where('pessoa_id', '=', Auth::user()->id)
			->get()->count();

		//Busca pelas observações dos Homologadores
		$obsHomologadores = DB::table('revisao')
			->select('observacao', 'nota_final')
			->where('projeto_id', '=', $projeto->id)
			->where('revisado', '=', true)
			->get();

		//Busca pelas observações dos Avaliadores
		$obsAvaliadores = DB::table('avaliacao')
			->select('observacao', 'nota_final')
			->where('projeto_id', '=', $projeto->id)
			->where('avaliado', '=', true)
			->get();

		return view('projeto.show', compact('ehHomologador', 'ehAvaliador', 'obsHomologadores', 'obsAvaliadores'))
			->withProjeto($projeto);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function editarProjeto($id)
	{

		// TODO: usar transactions aqui

		$pessoas = Pessoa::all();
		$projetoP = Projeto::find($id);
		$nivelP = Nivel::find($projetoP->nivel_id);
		$areaP = AreaConhecimento::find($projetoP->area_id);

		$idPalavras = DB::table('palavra_projeto')
			->select('palavra_id')
			->where('projeto_id', $id)
			->get();

		foreach ($idPalavras as $i)
			$palavrasP[] = PalavraChave::find($i->palavra_id);

		$escolaP = DB::table('escola_funcao_pessoa_projeto')
			->select('escola_id')
			->where('projeto_id', $id)
			->get();

		$autor = DB::table('escola_funcao_pessoa_projeto')
			->select('pessoa_id', 'concluinte')
			->where('projeto_id', $id)
			->where('funcao_id', EnumFuncaoPessoa::getValue('Autor'))
			->get()
			->toArray();

		$orientador = DB::table('escola_funcao_pessoa_projeto')
			->select('pessoa_id')
			->where('projeto_id', $id)
			->where('funcao_id', EnumFuncaoPessoa::getValue('Orientador'))
			->get()
			->toArray();

		$coorientador = DB::table('escola_funcao_pessoa_projeto')
			->select('pessoa_id')
			->where('projeto_id', $id)
			->where('funcao_id', EnumFuncaoPessoa::getValue('Coorientador'))
			->get()
			->toArray();

		$niveis = DB::table('nivel_edicao')
			->select(['nivel.id', 'nivel', 'min_ch', 'max_ch', 'palavras'])
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->join('nivel', 'nivel_edicao.nivel_id', '=', 'nivel.id')
			->get();

		$areas = Edicao::find(Edicao::getEdicaoId())->areas()->get();

		$funcoes = Funcao::getByCategory('integrante');
		$escolas = Escola::all();

		// Valida se pode editar o projeto
		$idPessoasProjeto = array();

		if ($orientador)
			array_push($idPessoasProjeto, $orientador[0]->pessoa_id);

		foreach ($autor as $a => $id)
			array_push($idPessoasProjeto, $id->pessoa_id);

		foreach ($coorientador as $c => $id)
			array_push($idPessoasProjeto, $id->pessoa_id);

		if (in_array(Auth::user()->id, $idPessoasProjeto) || Auth::user()->temFuncao('Organizador') || Auth::user()->temFuncao('Administrador'))
			return view('projeto.edit', compact('niveis', 'areas', 'funcoes', 'escolas', 'projetoP', 'nivelP', 'areaP', 'escolaP', 'palavrasP', 'autor', 'orientador', 'coorientador', 'pessoas'));

		return redirect()->route('home');
	}

	public function editaProjeto(ProjetoRequest $req)
	{
		$id = $req->all()['id_projeto'];

		// Valida se pode editar o projeto
		$integrantesIds = Projeto::find($id)->pessoas->toArray();
		$integrantesIds = array_column($integrantesIds, 'id');

		if (in_array(Auth::user()->id, $integrantesIds) || Auth::user()->temFuncao('Organizador') || Auth::user()->temFuncao('Administrador')) {

			// altera o projeto em si
			Projeto::where('id', '=', $id)
				->update([
					'titulo' => strtoupper($req->all()['titulo']),
					'resumo' => $req->all()['resumo'],
					'area_id' => $req->all()['area_conhecimento'],
					'nivel_id' => $req->all()['nivel']
				]);

			// quebra as palavras-chave que vieram do formulário
			$palavrasChave = explode(",", $req->all()['palavras_chaves']);

			// deleta as palavras-chave do projeto
			DB::table('palavra_projeto')
				->where('projeto_id', $id)
				->delete();

			// recria as palavras chave
			foreach ($palavrasChave as $palavra)
				Projeto::find($id)->palavrasChaves()->attach(PalavraChave::create(['palavra' => $palavra]));

			$projeto = Projeto::find($id);

			// deleta todos os vinculos de pessoa ao projeto
			DB::table('escola_funcao_pessoa_projeto')
				->where('projeto_id', '=', $id)
				->delete();

			// Cria os vinculos de Autores ao projeto
			foreach ($req->all()['autor'] as $key => $idAutor) {

				if ($idAutor) {
					$dataAutor = Pessoa::select(['id', 'nome', 'email'])->find($idAutor);

					if (!$dataAutor->temFuncao('Autor')) {
						DB::table('funcao_pessoa')
							->insert([
								'edicao_id' => Edicao::getEdicaoId(),
								'funcao_id' => EnumFuncaoPessoa::getValue('Autor'),
								'pessoa_id' => $idAutor,
								'homologado' => false
							]);
					}

					DB::table('escola_funcao_pessoa_projeto')
						->insert([
							'escola_id' => $req->all()['escola'],
							'funcao_id' => EnumFuncaoPessoa::getValue('Autor'),
							'pessoa_id' => $idAutor,
							'projeto_id' => $id,
							'edicao_id' => Edicao::getEdicaoId(),
							'concluinte' => $req->autorConcluinte[$key]
						]);

					dispatch(
						new \App\Jobs\MailBaseJob(
							$dataAutor->email,
							'Projeto Criado Autor',
							[
								'nome' => $dataAutor->nome,
								'titulo' => $projeto->titulo
							]
						)
					);
				}
			}

			// Cria o vinculo de Orientador ao projeto
			$dataOrientador = Pessoa::select(['id', 'nome', 'email'])->find($req->all()['orientador']);

			if (!$dataOrientador->temFuncao('Orientador')) {
				DB::table('funcao_pessoa')
					->insert([
						'edicao_id' => Edicao::getEdicaoId(),
						'funcao_id' => EnumFuncaoPessoa::getValue('Orientador'),
						'pessoa_id' => $req->all()['orientador'],
						'homologado' => false
					]);
			}

			DB::table('escola_funcao_pessoa_projeto')
				->insert([
					'escola_id' => $req->all()['escola'],
					'funcao_id' => EnumFuncaoPessoa::getValue('Orientador'),
					'pessoa_id' => $req->all()['orientador'],
					'projeto_id' => $id,
					'edicao_id' => Edicao::getEdicaoId()
				]);

			dispatch(
				new \App\Jobs\MailBaseJob(
					$dataOrientador->email,
					'Projeto Criado Orientador',
					[
						'nome' => $dataOrientador->nome,
						'titulo' => $projeto->titulo
					]
				)
			);

			// Cria o vinculo dos Coorientadores ao projeto
			foreach ($req->all()['coorientador'] as $idCoorientador) {
				if ($idCoorientador) {
					$dataCoorientador = Pessoa::select(['id', 'nome', 'email'])->find($idCoorientador);
					if (!$dataCoorientador->temFuncao('Coorientador')) {
						DB::table('funcao_pessoa')
							->insert([
								'edicao_id' => Edicao::getEdicaoId(),
								'funcao_id' => EnumFuncaoPessoa::getValue('Coorientador'),
								'pessoa_id' => $idCoorientador,
								'homologado' => false
							]);
					}

					DB::table('escola_funcao_pessoa_projeto')
						->insert([
							'escola_id' => $req->all()['escola'],
							'funcao_id' => EnumFuncaoPessoa::getValue('Coorientador'),
							'pessoa_id' => $idCoorientador,
							'projeto_id' => $id,
							'edicao_id' => Edicao::getEdicaoId(),
						]);

					dispatch(
						new \App\Jobs\MailBaseJob(
							$dataCoorientador->email,
							'Projeto Criado Coorientador',
							[
								'nome' => $dataCoorientador->nome,
								'titulo' => $projeto->titulo
							]
						)
					);
				}
			}

			return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
		}

		return redirect()->route('home');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	public function searchPessoaByEmail($email)
	{
		$pessoa = Pessoa::findByEmail($email);
		if (!($pessoa instanceof Pessoa)) {
			return response()->json([
				'error' => "A pessoa não está inscrita no sistema!"
			], 200);
		}

		return compact('pessoa');
	}

	public function relatorio($id)
	{

		if ($id == 1) {
			$resultados = DB::table('public.geral_projetos')->select('*')->get();
			$filename = "GeralProjetos.csv";
		} else if ($id == 2) {
			$resultados = DB::table('public.geralprojetosnotgrouped')->select('*')->get();
			$filename = "GeralProjetosNAOAgrupados.csv";
		} else {
			$resultados = DB::table('public.relatorioavaliadores')->select('*')->get();
			$filename = "Avaliadores.csv";
			$handle = fopen($filename, 'w+');
			fputcsv($handle, array('ID', 'Nome', 'Email', 'Titulacao', 'Lattes', 'Profissao', 'Instituicao', 'CPF', 'Revisor', 'Avaliador'));

			foreach ($resultados as $row) {
				fputcsv($handle, array($row->id, $row->nome, $row->email, $row->titulacao, $row->lattes, $row->profissao, $row->instituicao, $row->cpf, $row->revisor, $row->avaliador));
			}

			fclose($handle);

			$headers = array(
				'Content-Type' => 'text/csv',
			);

			return Response::download($filename, $filename, $headers);
		}
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('ID', 'Titulo', 'Area Conhecimento', 'Nível', 'Nomes', 'Email', 'Escola', 'Situacao'));

		foreach ($resultados as $row) {
			fputcsv($handle, array($row->id, $row->titulo, $row->area_conhecimento, $row->nivel, $row->nomes, $row->email, $row->nome_curto, $row->situacao));
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function setSituacao($id, $situacao)
	{
		$projeto = Projeto::find($id);
		if (!($projeto instanceof Projeto)) {
			return redirect('home');
		}

		foreach ($projeto->revisoes as $revisao) {
			$revisao->situacao_id = $situacao;
			$revisao->save();
		}

		return redirect('home');
	}


	public function showFormVinculaHomologador($id)
	{
		$projeto = Projeto::find($id);
		if (!($projeto instanceof Projeto)) {
			abort(404);
		}

		$numProjetos = DB::raw('SELECT count(*)
			FROM revisao
			JOIN projeto ON projeto.id = revisao.projeto_id
			WHERE pessoa_id = pessoa.id AND projeto.edicao_id = comissao_edicao.edicao_id');

		$revisores = DB::table('areas_comissao')
			->select('pessoa.id', 'pessoa.nome', 'pessoa.instituicao', 'pessoa.titulacao', DB::raw('(' . $numProjetos . ') as num_projetos'))
			//busca pelo registro na comissao avaliadora
			->join('comissao_edicao', function ($join) {
				$join->on('comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id');
				$join->where('comissao_edicao.edicao_id', '=', Edicao::getEdicaoId());
			})
			//busca pela pessoa
			->join('pessoa', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
			//busca pela função homologador (id => 4) HARD CODED e foda-se
			->join('funcao_pessoa', function ($join) {
				$join->on('pessoa.id', '=', 'funcao_pessoa.pessoa_id');
				$join->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId());
				$join->where('funcao_pessoa.funcao_id', '=', 4);
				$join->where('funcao_pessoa.homologado', '=', true);
			})
			->where('area_id', '=', $projeto->area_id)
			->where('areas_comissao.homologado', '=', true)
			->orderBy('pessoa.nome')
			->get();

		$revisoresProjeto = DB::table('revisao')->where('projeto_id', '=', $id)->get();

		$revisoresValue = "";
		$idRevisores = array();
		foreach ($revisoresProjeto as $revisor) {
			$revisoresValue .= ',' . $revisor->pessoa_id;
			array_push($idRevisores, $revisor->pessoa_id);
		}
		$revisoresValue = ltrim($revisoresValue, ',');

		return view(
			'comissao.homologador.vincula',
			[
				'revisoresValue' => $revisoresValue,
				'idRevisores' => $idRevisores,
				'revisores' => $revisores,
				'projeto' => $projeto
			]
		);
	}

	public function vinculaHomologador(Request $request)
	{

		DB::table('revisao')
			->where('projeto_id', '=', $request->projeto_id)
			->where('revisado', '=', false)
			->delete();

		Projeto::find($request->projeto_id)
			->update([
				'situacao_id' => EnumSituacaoProjeto::getValue('Cadastrado')
			]);

		$idAnterior = DB::table('revisao')
			->select('revisao.pessoa_id')
			->where('projeto_id', '=', $request->projeto_id)
			->get()
			->toArray();

		$idAnterior = array_column($idAnterior, 'pessoa_id');

		$revisores = explode(',', $request->revisores_id);
		if ($revisores[0] != '') {
			foreach ($revisores as $revisor) {
				if (!in_array($revisor, $idAnterior)) {
					$revisao = new Revisao();
					$revisao->projeto_id = $request->projeto_id;
					$revisao->pessoa_id = $revisor;
					$revisao->nota_final = 0;
					$revisao->revisado = false;
					$revisao->save();

					//dados projeto
					$projeto = Projeto::find($request->projeto_id);

					//homologador
					$pessoa = Pessoa::find($revisao->pessoa_id);

					dispatch(
						new \App\Jobs\MailBaseJob(
							$pessoa->email,
							'Projeto Vincula Homologador',
							[
								'nome' => $pessoa->nome,
								'titulo' => $projeto->titulo
							]
						)
					);
				}
			}

			Projeto::find($request->projeto_id)
				->update([
					'situacao_id' => EnumSituacaoProjeto::getValue('NaoHomologado')
				]);
		}

		return redirect(route('administrador.projetos'));
	}


	public function showFormVinculaAvaliador($id)
	{
		$projeto = Projeto::find($id);
		if (!($projeto instanceof Projeto)) {
			abort(404);
		}

		$numProjetos = DB::raw('SELECT count(*)
                                FROM avaliacao
                                INNER JOIN projeto ON projeto.id = avaliacao.projeto_id
                                WHERE pessoa_id = pessoa.id AND projeto.edicao_id = comissao_edicao.edicao_id');

		$avaliadores = DB::table('areas_comissao')
			->select('pessoa.id', 'pessoa.nome', 'pessoa.instituicao', 'pessoa.titulacao', DB::raw('(' . $numProjetos . ') as num_projetos'))
			//busca pelo registro na comissao avaliadora
			->join('comissao_edicao', function ($join) {
				$join->on('comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id');
				$join->where('comissao_edicao.edicao_id', '=', Edicao::getEdicaoId());
			})
			//busca pela pessoa
			->join('pessoa', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
			//busca pela função avaliador (id => 3) HARD CODED e foda-se
			->join('funcao_pessoa', function ($join) {
				$join->on('pessoa.id', '=', 'funcao_pessoa.pessoa_id');
				$join->where('funcao_pessoa.edicao_id', '=', Edicao::getEdicaoId());
				$join->where('funcao_pessoa.funcao_id', '=', 3);
				$join->where('funcao_pessoa.homologado', '=', true);
			})
			->where('area_id', '=', $projeto->area_id)
			->where('areas_comissao.homologado', '=', true)
			->orderBy('pessoa.nome')
			->get();

		$avaliadoresDoProjeto = DB::table('avaliacao')
			->select('pessoa_id')
			->where('projeto_id', '=', $id)
			->get();

		$avaliadoresValue = "";
		$idAvaliadores = array();
		foreach ($avaliadoresDoProjeto as $avaliador) {
			$avaliadoresValue .= ',' . $avaliador->pessoa_id;
			array_push($idAvaliadores, $avaliador->pessoa_id);
		}
		$avaliadoresValue = ltrim($avaliadoresValue, ',');

		return view('comissao.avaliador.vincula')
			->with([
				'avaliadores' => $avaliadores,
				'avaliadoresValue' => $avaliadoresValue,
				'idAvaliadores' => $idAvaliadores,
				'projeto' => $projeto,
			]);
	}

	public function vinculaAvaliador(Request $request)
	{
		DB::table('avaliacao')
			->where('projeto_id', '=', $request->projeto_id)
			->where('avaliado', '=', false)
			->delete();

		Projeto::find($request->projeto_id)
			->update(['situacao_id' => 3]); //Homologado

		$ids = DB::table('avaliacao')
			->select('pessoa_id')
			->where('projeto_id', '=', $request->projeto_id)
			->get()
			->toArray();

		$ids = array_column($ids, 'pessoa_id');

		$avaliadores = explode(',', $request->avaliadores_id);
		if ($avaliadores[0] != '') {
			foreach ($avaliadores as $avaliador) {

				if (!in_array($avaliador, $ids)) {
					$avaliacao = new Avaliacao();
					$avaliacao->pessoa_id = $avaliador;
					$avaliacao->projeto_id = $request->projeto_id;
					$avaliacao->nota_final = 0;
					$avaliacao->observacao = '';
					$avaliacao->avaliado = false;
					$avaliacao->save();

					//dados projeto
					$projeto = Projeto::find($request->projeto_id);

					//avaliador
					$pessoa = Pessoa::find($avaliacao->pessoa_id);

					dispatch(
						new \App\Jobs\MailBaseJob(
							$pessoa->email,
							'Projeto Vincula Avaliador',
							[
								'nome' => $pessoa->nome,
								'titulo' => $projeto->titulo
							]
						)
					);
				}
			}

			Projeto::find($request->projeto_id)
				->update([
					'situacao_id' => EnumSituacaoProjeto::getValue('NaoAvaliado')
				]);
		}

		return redirect(route('administrador.projetos'));
	}

	public function statusProjeto($id)
	{

		$projeto = Projeto::find($id);

		$response = [
			'titulo' => $projeto->titulo,
			'nivel' => $projeto->nivel->nivel,
			'area' => $projeto->areaConhecimento->area_conhecimento,
			'situacao' => $projeto->getStatus(),
			'homologacao' => array(),
			'avaliacao' => array(),
		];

		//Busca o nome dos Homologadores
		if ($response['situacao'] != "Cadastrado") {
			$response['homologacao'] = DB::table('revisao')
				->select('pessoa.nome', 'revisao.nota_final', 'revisao.revisado')
				->join('pessoa', 'revisao.pessoa_id', '=', 'pessoa.id')
				->where('projeto_id', $id)
				->get()
				->toArray();
		}

		//Busca o nome dos Avaliadores
		if (
			$response['situacao'] == "Não Avaliado" ||
			$response['situacao'] == "Avaliado" ||
			$response['situacao'] == "Não Compareceu"
		) {

			$response['avaliacao'] = DB::table('avaliacao')
				->select('pessoa.nome', 'avaliacao.nota_final', 'avaliacao.avaliado')
				->join('pessoa', 'avaliacao.pessoa_id', '=', 'pessoa.id')
				->where('projeto_id', $id)
				->get()
				->toArray();
		}

		return response()->json($response, 200);
	}

	public function homologarProjetos()
	{

		//subquery para pegar a média da homologação
		$subQuery = DB::table('revisao')
			->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
			->where('revisao.projeto_id', '=', DB::raw('projeto.id'))
			->toSql();

		//busca os projetos Não Homologados
		$projetos = Projeto::select(
			'projeto.id',
			'titulo',
			'situacao_id',
			'nivel_id',
			'area_id',
			DB::raw('(' . $subQuery . ') as nota')
		)
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->where('situacao_id', '=', EnumSituacaoProjeto::getValue('NaoHomologado'))
			->orderBy('nota', 'desc')
			->get();

		//busca os projetos já Homologados
		$projetosHomologados = Projeto::select(
			'projeto.id',
			'titulo',
			'situacao_id',
			'nivel_id',
			'area_id',
			DB::raw('(' . $subQuery . ') as nota')
		)
			->where('edicao_id', '=', Edicao::getEdicaoId())
			->where('situacao_id', '=', EnumSituacaoProjeto::getValue('Homologado'))
			->orderBy('nota', 'desc')
			->get();

		$IDhomologados = '';

		if ($projetosHomologados->count()) {
			$IDhomologados = Projeto::select('id')
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('situacao_id', '=', EnumSituacaoProjeto::getValue('Homologado'))
				->get()->toArray();

			$IDhomologados = array_column($IDhomologados, 'id');
			$IDhomologados = implode(',', $IDhomologados);
		}


		return view('comissao.homologarProjetos')
			->with([
				'projetos' => $projetos,
				'projetosHomologados' => $projetosHomologados,
				'IDhomologados' => $IDhomologados
			]);
	}

	public function homologaProjetos(Request $req)
	{

		if ($req->all()['projetos_id'] != '') {

			// Quebra a string e pega o id dos projetos
			$IDprojetos = explode(',', $req->all()['projetos_id']);

			// Busca o ID de todos os projetos homologados antes
			$homologadosAntes = Projeto::select('id')
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('situacao_id', '=', EnumSituacaoProjeto::getValue('Homologado'))
				->get()
				->toArray();

			$homologadosAntes = array_column($homologadosAntes, 'id');

			// Faz a diferença entre o conjunto dos projetos homologados agora com os homologados antes
			$IDprojetosHomologados = array_diff($IDprojetos, $homologadosAntes);


			// Busca o ID de todos os projetos não homologados antes
			$naoHomologadosAntes = Projeto::select('id')
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('situacao_id', '=', EnumSituacaoProjeto::getValue('NaoHomologado'))
				->get()
				->toArray();

			$naoHomologadosAntes = array_column($naoHomologadosAntes, 'id');

			// Faz a diferença entre o conjunto dos projetos não homologados antes com os homologados agora
			$IDprojetosNaoHomologados = array_diff($naoHomologadosAntes, $IDprojetos);
			// Faz a diferença entre o conjunto dos projetos homologados antes com os homologados agora
			$IDprojetosNaoHomologadosAux = array_diff($homologadosAntes, $IDprojetos);

			$IDprojetosNaoHomologados = array_merge($IDprojetosNaoHomologados, $IDprojetosNaoHomologadosAux);


			// Muda o status dos projetos selecionados para Homologado
			Projeto::whereIn('id', $IDprojetosHomologados)
				->update([
					'situacao_id' => EnumSituacaoProjeto::getValue('Homologado')
				]);

			// Muda o status dos projetos selecionados para Não Homologado
			if (count($IDprojetosNaoHomologados) > 0) {
				Projeto::whereIn('id', $IDprojetosNaoHomologados)
					->update([
						'situacao_id' => EnumSituacaoProjeto::getValue('NaoHomologado')
					]);
			}

			// Dispara os emails dos projetos homologados
			// É IMPORTANTE estar com a queue em "database" e não em "sync"
			foreach ($IDprojetosHomologados as $IDprojeto) {

				$projeto = Projeto::select('id', 'titulo')
					->where('id', $IDprojeto)
					->get();

				if ($projeto->count()) {

					foreach ($projeto[0]->pessoas as $pessoa) {
						dispatch(
							new \App\Jobs\MailBaseJob(
								$pessoa->email,
								'Projeto Homologado',
								[
									'nome' => $pessoa->nome,
									'titulo' => $projeto[0]->titulo,
									'idProj' => $projeto[0]->id
								]
							)
						);
					}
				}
			}

			// primeira homologação de trabalhos
			if (count($homologadosAntes) == 0) {
				// Dispara os emails dos projetos não homologado
				foreach ($IDprojetosNaoHomologados as $IDprojeto) {

					$projeto = Projeto::select('id', 'titulo')
						->where('id', $IDprojeto)
						->get();

					if ($projeto->count()) {

						foreach ($projeto[0]->pessoas as $pessoa) {
							dispatch(
								new \App\Jobs\MailBaseJob(
									$pessoa->email,
									'Projeto Nao Homologado',
									[
										'nome' => $pessoa->nome,
										'titulo' => $projeto[0]->titulo
									]
								)
							);
						}
					}
				}
			}
		}

		return redirect(route('administrador.projetos'));
	}

	public function confirmaPresenca($id)
	{
		$p = Projeto::where('id', $id)
			->where('situacao_id', '!=', EnumSituacaoProjeto::getValue('NaoHomologado'))
			->update(['presenca' => true]);

		return response()->view('confirmaPresenca', ['p' => $p]);
	}

	public function dadosNivel($id)
	{ //Ajax
		return Nivel::find($id);
	}

	public function projetoNaoCompareceu($id, $s)
	{ //Ajax
		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			Projeto::where('id', $id)->update([
				'situacao_id' => EnumSituacaoProjeto::getValue('NaoCompareceu')
			]);

			return 'true';
		}

		return 'false';
	}

	public function projetoCompareceuAvaliado($id, $s)
	{ //Ajax
		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			Projeto::where('id', $id)
				->update([
					'situacao_id' => EnumSituacaoProjeto::getValue('Avaliado')
				]);

			return 'true';
		}

		return 'false';
	}

	public function projetoCompareceuNaoAvaliado($id, $s)
	{ //Ajax
		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			Projeto::where('id', $id)
				->update([
					'situacao_id' => EnumSituacaoProjeto::getValue('NaoAvaliado')
				]);

			return 'true';
		}

		return 'false';
	}
}
