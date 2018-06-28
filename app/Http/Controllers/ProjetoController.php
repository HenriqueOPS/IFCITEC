<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PeriodosController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjetoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Jobs\MailAutorJob;
use App\Jobs\MailOrientadorJob;
use App\Jobs\MailCoorientadorJob;
//
use App\Pessoa;
use App\Nivel;
use App\AreaConhecimento;
use App\Funcao;
use App\Escola;
use App\Edicao;
use App\Projeto;
use App\PalavraChave;
use App\Revisao;
use App\Avaliacao;

class ProjetoController extends Controller
{

	/**
	 * Instantiate a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
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
	public function create(PeriodosController $p)
	{
		$niveis = Nivel::has('edicoes', '=', $p->periodoInscricao())->get();
		$areas = AreaConhecimento::has('edicoes', '=', $p->periodoInscricao())->get();

		$funcoes = Funcao::getByCategory('integrante');

		$escolas = Escola::all();
		$pessoas = Pessoa::all();

		return view('projeto.create')
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
	public function store(PeriodosController $p, ProjetoRequest $request)
	{
		$projeto = new Projeto();
		$projeto->fill($request->toArray());
		$projeto->titulo = strtoupper($request->titulo);
		//
		$areaConhecimento = AreaConhecimento::find($request->area_conhecimento);
		$nivel = Nivel::find($request->nivel);
		$edicao = Edicao::find($p->periodoInscricao());
		$projeto->edicao()->associate($edicao);
		$projeto->areaConhecimento()->associate($areaConhecimento);
		$projeto->nivel()->associate($nivel);
		//
		$projeto->save();
		//--Inicio Attachment de Palavras Chaves. Tabela: palavra_projeto
		$palavrasChaves = explode(",", $request->palavras_chaves);
		foreach ($palavrasChaves as $palavra) {
			$projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $palavra]));
		}

		//--Inicio Attachment de Participante.
		//Tabela: escola_funcao_pessoa_projeto
		//Insert via DB pois o Laravel não está preparado para um tabela de 4 relacionamentos

		foreach ($request['autor'] as $a) {
			if ($a != null) {
				$autor = Pessoa::find($a);
				if ($autor->temFuncao('Autor') == false) {
					DB::table('funcao_pessoa')->insert(
						['edicao_id' => $p->periodoInscricao(),
							'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
							'pessoa_id' => $a,
							'homologado' => FALSE
						]);
				}
				DB::table('escola_funcao_pessoa_projeto')->insert(
					['escola_id' => $request->escola,
						'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
						'pessoa_id' => $a,
						'projeto_id' => $projeto->id,
						'edicao_id' => $p->periodoInscricao(),
					]
				);

				$email = Pessoa::find($a)->email;
				$nome = Pessoa::find($a)->nome;
				$titulo = $projeto->titulo;
				$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(60));
				dispatch($emailJob);


			}
		}

		$orientador = Pessoa::find($request['orientador']);
		if ($orientador->temFuncao('Orientador') == false) {
			DB::table('funcao_pessoa')->insert(
				['edicao_id' => $p->periodoInscricao(),
					'funcao_id' => Funcao::where('funcao', 'Orientador')->first()->id,
					'pessoa_id' => $request['orientador'],
					'homologado' => FALSE
				]);
		}
		DB::table('escola_funcao_pessoa_projeto')->insert(
			['escola_id' => $request->escola,
				'funcao_id' => Funcao::where('funcao', 'Orientador')->first()->id,
				'pessoa_id' => $request['orientador'],
				'projeto_id' => $projeto->id,
				'edicao_id' => $p->periodoInscricao(),
			]
		);
		$email = Pessoa::find($request['orientador'])->email;
		$nome = Pessoa::find($request['orientador'])->nome;
		$titulo = $projeto->titulo;
		$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(60));
		dispatch($emailJob);

		foreach ($request['coorientador'] as $c) {
			if ($c != null) {
				$coorientador = Pessoa::find($c);
				if ($coorientador->temFuncao('Coorientador') == false) {
					DB::table('funcao_pessoa')->insert(
						['edicao_id' => $p->periodoInscricao(),
							'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
							'pessoa_id' => $c,
							'homologado' => FALSE
						]);
				}
				DB::table('escola_funcao_pessoa_projeto')->insert(
					['escola_id' => $request->escola,
						'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
						'pessoa_id' => $c,
						'projeto_id' => $projeto->id,
						'edicao_id' => $p->periodoInscricao(),
					]
				);
				$email = Pessoa::find($c)->email;
				$nome = Pessoa::find($c)->nome;
				$titulo = $projeto->titulo;
				$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(60));
				dispatch($emailJob);
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
		return view('projeto.show')->withProjeto($projeto);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function editarProjeto(PeriodosController $p, $id)
	{
		$pessoas = Pessoa::all();
		$projetoP = Projeto::find($id);
		$nivelP = Nivel::find($projetoP->nivel_id);
		$areaP = AreaConhecimento::find($projetoP->area_id);
		$idPalavras = DB::table('palavra_projeto')->select('palavra_id')
			->where('projeto_id', $id)->get();
		foreach ($idPalavras as $i) {
			$palavrasP[] = PalavraChave::find($i->palavra_id);
		}
		$escolaP = DB::table('escola_funcao_pessoa_projeto')->select('escola_id')
			->where('projeto_id', $id)->get();

		$autor = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->get()
			->toArray();

		$orientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
			->get()
			->toArray();

		$coorientador = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
			->get()
			->toArray();

		$niveis = Nivel::has('edicoes', '=', $p->periodoInscricao())->get();
		$areas = AreaConhecimento::has('edicoes', '=', $p->periodoInscricao())->get();


		$funcoes = Funcao::getByCategory('integrante');
		$escolas = Escola::all();

		return view('projeto.edit', compact('niveis', 'areas', 'funcoes', 'escolas', 'projetoP', 'nivelP', 'areaP', 'escolaP', 'palavrasP', 'autor', 'orientador', 'coorientador', 'pessoas'));
	}

	public function editaProjeto(PeriodosController $p, ProjetoRequest $req)
	{
		$id = $req->all()['id_projeto'];
		Projeto::where('id', $id)->update(['titulo' => $req->all()['titulo'],
			'resumo' => $req->all()['resumo'],
			'area_id' => $req->all()['area_conhecimento'],
			'nivel_id' => $req->all()['nivel'],


		]);

		DB::table('escola_funcao_pessoa_projeto')->where('projeto_id', $id)->update(['escola_id' => $req->all()['escola'],
		]);

		$projeto = Projeto::find($id);
		$palavrasChave = explode(",", $req->all()['palavras_chaves']);
		$palavrasBanco = DB::table('palavra_chave')
			->join('palavra_projeto', 'palavra_chave.id', '=', 'palavra_projeto.palavra_id')
			->select('palavra')
			->where('projeto_id', $id)
			->get()
			->keyBy('palavra')
			->toArray();
		$palavrasb = array_keys($palavrasBanco);
		for ($i = 0; $i < count($palavrasChave); $i++) {
			$palavrasChave[$i] = trim($palavrasChave[$i]);
		}

		foreach ($palavrasChave as $pc) {
			if (in_array($pc, $palavrasb) == false) {
				$projeto->palavrasChaves()->attach(PalavraChave::create(['palavra' => $pc]));
			}
		}

		foreach ($palavrasBanco as $pcbanco) {
			if (!in_array($pcbanco->palavra, $palavrasChave)) {
				$idPalavraChave = DB::table('palavra_chave')->join('palavra_projeto', 'palavra_chave.id', '=', 'palavra_projeto.palavra_id')->where('projeto_id', $id)->where('palavra', $pcbanco->palavra)->get();
				DB::table('palavra_projeto')->where('projeto_id', $id)->where('palavra_id', $idPalavraChave->first()->id)->delete();
			}
		}
		$autores = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('edicao_id', $p->periodoInscricao())
			->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->get()
			->keyBy('pessoa_id')
			->toArray();

		$oProjeto = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('edicao_id', $p->periodoInscricao())
			->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
			->get();

		$coorientadores = DB::table('escola_funcao_pessoa_projeto')->select('pessoa_id')
			->where('projeto_id', $id)
			->where('edicao_id', $p->periodoInscricao())
			->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
			->get()
			->keyBy('pessoa_id')
			->toArray();

		$aProjeto = array_keys($autores);
		$cProjeto = array_keys($coorientadores);
		foreach ($req->all()['autor'] as $a) {

		}
		foreach ($aProjeto as $ap) {
			if (in_array($ap, $_POST['autor']) == false) {
				DB::table('escola_funcao_pessoa_projeto')
					->where('projeto_id', $id)
					->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
					->where('pessoa_id', $ap)
					->where('edicao_id', $p->periodoInscricao())
					->delete();
				if (Pessoa::find($ap)->naoTemFuncao(Funcao::where('funcao', 'Autor')->first()->id, $id, $ap) == true) {
					DB::table('funcao_pessoa')
						->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('pessoa_id', $ap)
						->where('edicao_id', $p->periodoInscricao())
						->delete();
				}
			}
		}
		if ($oProjeto->first()->pessoa_id != $_POST['orientador']) {
			DB::table('escola_funcao_pessoa_projeto')
				->where('projeto_id', $id)
				->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
				->where('pessoa_id', $oProjeto->first()->pessoa_id)
				->where('edicao_id', $p->periodoInscricao())
				->delete();
			if (Pessoa::find($oProjeto->first()->pessoa_id)->naoTemFuncao(Funcao::where('funcao', 'Orientador')->first()->id, $id, $oProjeto->first()->pessoa_id) == true) {
				DB::table('funcao_pessoa')
					->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
					->where('pessoa_id', $oProjeto->first()->pessoa_id)
					->where('edicao_id', $p->periodoInscricao())
					->delete();
			}
		}
		if ($cProjeto != null) {
			foreach ($cProjeto as $cp) {
				if (in_array($cp, $_POST['coorientador']) == false) {
					DB::table('escola_funcao_pessoa_projeto')
						->where('projeto_id', $id)
						->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->where('pessoa_id', $cp)
						->where('edicao_id', $p->periodoInscricao())
						->delete();
					if (Pessoa::find($ap)->naoTemFuncao(Funcao::where('funcao', 'Autor')->first()->id, $id, $ap) == true) {
						DB::table('funcao_pessoa')
							->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
							->where('pessoa_id', $cp)
							->where('edicao_id', $p->periodoInscricao())
							->delete();
					}
				}
			}
		}
		foreach ($req->all()['autor'] as $a) {
			if ($a != null) {
				if (is_array($aProjeto) == true) {
					if (in_array($a, $aProjeto) == false) {
						if (Pessoa::find($a)->temFuncao('Autor') == false) {
							DB::table('funcao_pessoa')->insert(
								['edicao_id' => $p->periodoInscricao(),
									'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
									'pessoa_id' => $a,
									'homologado' => FALSE
								]);
						}
						DB::table('escola_funcao_pessoa_projeto')->insert(
							['escola_id' => $req->all()['escola'],
								'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
								'pessoa_id' => $a,
								'projeto_id' => $projeto->id,
								'edicao_id' => $p->periodoInscricao(),
							]
						);

						$email = Pessoa::find($a)->email;
						$nome = Pessoa::find($a)->nome;
						$titulo = $projeto->titulo;
						$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(3));
						dispatch($emailJob);
					}
				} else {
					if ($a != $aProjeto->first()->pessoa_id) {
						if (Pessoa::find($a)->temFuncao('Autor') == false) {
							DB::table('funcao_pessoa')->insert(
								['edicao_id' => $p->periodoInscricao(),
									'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
									'pessoa_id' => $a,
									'homologado' => FALSE
								]);
						}
						DB::table('escola_funcao_pessoa_projeto')->insert(
							['escola_id' => $req->all()['escola'],
								'funcao_id' => Funcao::where('funcao', 'Autor')->first()->id,
								'pessoa_id' => $a,
								'projeto_id' => $projeto->id,
								'edicao_id' => $p->periodoInscricao(),
							]
						);

						$email = Pessoa::find($a)->email;
						$nome = Pessoa::find($a)->nome;
						$titulo = $projeto->titulo;
						$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(3));
						dispatch($emailJob);
					}
				}
			}
		}
		$orientador = Pessoa::where('id', $oProjeto->first()->pessoa_id)->first();
		if ($req->all()['orientador'] != $orientador->id) {
			if (Pessoa::find($req->all()['orientador'])->temFuncao('Orientador') == false) {
				DB::table('funcao_pessoa')->insert(
					['edicao_id' => $p->periodoInscricao(),
						'funcao_id' => Funcao::where('funcao', 'Orientador')->first()->id,
						'pessoa_id' => $orientador->first()->id,
						'homologado' => FALSE
					]);
			}
			DB::table('escola_funcao_pessoa_projeto')->insert(
				['escola_id' => $req->all()['escola'],
					'funcao_id' => Funcao::where('funcao', 'Orientador')->first()->id,
					'pessoa_id' => $orientador->first()->id,
					'projeto_id' => $projeto->id,
					'edicao_id' => $p->periodoInscricao(),
				]
			);
			$email = Pessoa::find($req->all()['orientador'])->email;
			$nome = Pessoa::find($req->all()['orientador'])->nome;
			$titulo = $projeto->titulo;
			$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(3));
			dispatch($emailJob);
		}
		foreach ($req->all()['coorientador'] as $c) {
			if ($c != null) {
				if (is_array($cProjeto) == true) {
					if (in_array($c, $cProjeto) == false) {
						if (Pessoa::find($c)->temFuncao('Coorientador') == false) {
							DB::table('funcao_pessoa')->insert(
								['edicao_id' => $p->periodoInscricao(),
									'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
									'pessoa_id' => $c,
									'homologado' => FALSE
								]);
						}
						DB::table('escola_funcao_pessoa_projeto')->insert(
							['escola_id' => $req->all()['escola'],
								'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
								'pessoa_id' => $c,
								'projeto_id' => $projeto->id,
								'edicao_id' => $p->periodoInscricao(),
							]
						);
						$email = Pessoa::find($c)->email;
						$nome = Pessoa::find($c)->nome;
						$titulo = $projeto->titulo;
						$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(3));
						dispatch($emailJob);
					}
				} else {
					if (count($cProjeto) == 0 || $c != $cProjeto->first()->pessoa_id) {
						if (Pessoa::find($c)->temFuncao('Coorientador') == false) {
							DB::table('funcao_pessoa')->insert(
								['edicao_id' => $p->periodoInscricao(),
									'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
									'pessoa_id' => $c,
									'homologado' => FALSE
								]);
						}
						DB::table('escola_funcao_pessoa_projeto')->insert(
							['escola_id' => $req->all()['escola'],
								'funcao_id' => Funcao::where('funcao', 'Coorientador')->first()->id,
								'pessoa_id' => $c,
								'projeto_id' => $projeto->id,
								'edicao_id' => $p->periodoInscricao(),
							]
						);
						$email = Pessoa::find($c)->email;
						$nome = Pessoa::find($c)->nome;
						$titulo = $projeto->titulo;
						$emailJob = (new MailAutorJob($email, $nome, $titulo))->delay(\Carbon\Carbon::now()->addSeconds(3));
						dispatch($emailJob);
					}
				}
			}
		}
		return redirect()->route('projeto.show', ['projeto' => $projeto->id]);
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
			return response()->json(['error' => "A pessoa não está inscrita no sistema!"], 200);
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

	//   public function integrantes(){
	//     return view('projeto.integrantes');
	// }
}
