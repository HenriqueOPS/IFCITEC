<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\HomologacaoEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Endereco;
use App\Funcao;
use App\Pessoa;
use App\Edicao;
use App\Projeto;
use App\Avaliacao;
use App\Revisao;
use App\Jobs\MailComissaoAvaliadoraJob;
use App\Mensagem;
use App\Enums\EnumSituacaoProjeto;
use App\Enums\EnumFuncaoPessoa;

class ComissaoAvaliadoraController extends Controller
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

		if (
			Edicao::consultaPeriodo('Homologação') &&
			Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Homologador')
		) {

			$idOk = DB::table('revisao')
				->select('revisao.projeto_id')
				->where('pessoa_id', '=', Auth::user()->id)
				->where('revisado', '=', true)
				->get()
				->toArray();

			$idOk = array_column($idOk, 'projeto_id');

			$projetos = Projeto::select('projeto.id', 'projeto.titulo', 'projeto.situacao_id')
				->join('revisao', function ($query) {
					$query->on('projeto.id', '=', 'revisao.projeto_id');
					$query->where('revisao.pessoa_id', '=', Auth::user()->id);
				})
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->orderBy('revisao.revisado', 'asc')
				->get();

			return view('comissao.home', compact('idOk'))->withProjetos($projetos);
		} elseif (
			Edicao::consultaPeriodo('Avaliação') &&
			Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Avaliador')
		) {

			$idOk = DB::table('avaliacao')
				->select('avaliacao.projeto_id')
				->where('pessoa_id', '=', Auth::user()->id)
				->where('avaliado', '=', true)
				->get()
				->toArray();

			$idOk = array_column($idOk, 'projeto_id');

			$projetos = Projeto::select('projeto.id', 'projeto.titulo', 'projeto.situacao_id')
				->join('avaliacao', function ($query) {
					$query->on('projeto.id', '=', 'avaliacao.projeto_id');
					$query->where('avaliacao.pessoa_id', '=', Auth::user()->id);
				})
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->orderBy('avaliacao.avaliado', 'asc')
				->get();

			return view('comissao.home', compact('idOk'))->withProjetos($projetos);
		} elseif (
			Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Avaliador') ||
			Pessoa::find(Auth::id())->temFuncaoComissaoAvaliadora('Homologador')
		) {
			return view('inscricaoEnviada');
		} else {
			//@TODO: redirecionar de acordo com a função e o período
			return redirect()->route('comissaoAvaliadora');
		}
	}

	public function cadastrarComissao()
	{

		$temCadastro = DB::table('comissao_edicao')
			->where('edicao_id', Edicao::getEdicaoId())
			->where('pessoa_id', Auth::id())
			->count();

		$areas = DB::table('area_conhecimento')
			->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
			->select('area_conhecimento.id', 'area_conhecimento.area_conhecimento', 'area_conhecimento.nivel_id')
			->where('area_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('area_conhecimento.id', 'asc')
			->get()
			->toArray();

		$niveis = DB::table('nivel')
			->join('nivel_edicao', 'nivel.id', '=', 'nivel_edicao.nivel_id')
			->select('nivel.nivel', 'nivel.id', 'nivel_edicao.edicao_id')
			->where('nivel_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('nivel.id', 'asc')
			->get()
			->toArray();

		$projetosAreas = DB::table('area_conhecimento')
			->join('projeto', 'area_conhecimento.id', '=', 'projeto.area_id')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
			->select('area_conhecimento.area_conhecimento', 'area_conhecimento.id')
			->where('escola_funcao_pessoa_projeto.edicao_id', Edicao::getEdicaoId())
			->where('pessoa_id', Auth::user()->id)
			->whereIn(
				'escola_funcao_pessoa_projeto.funcao_id',
				[
					EnumFuncaoPessoa::getValue('Orientador'),
					EnumFuncaoPessoa::getValue('Coorientador'),
				]
			)
			->where('projeto.situacao_id', '!=', EnumSituacaoProjeto::getValue('NaoHomologado'))
			->orderBy('area_conhecimento.id', 'asc')
			->get()
			->keyBy('id')
			->toArray();

		$projetosAreas = array_keys($projetosAreas);

		foreach ($areas as $a) {
			if (!in_array($a->id, $projetosAreas)) {
				if (!isset($areasConhecimento)) {
					$areasConhecimento[] = $a;
				} else {
					$array = array_pluck($areasConhecimento, 'id');

					if (!in_array($a->id, $array))
						$areasConhecimento[] = $a;
				}
			}
		}
		$mensagens = Mensagem::where('nome', '=', 'Aviso(Comissão Avaliadora)')->get();
		if ($projetosAreas == null)
			$areasConhecimento = $areas;

		$dados = Pessoa::find(Auth::id());

		$data = null;

		if ($dados->endereco_id != null)
			$data = Endereco::find($dados->endereco_id);

		return view('comissao.cadastro', [
			'areas' => $areas,
			'niveis' => $niveis,
			'dados' => $dados,
			'data' => $data,
			'areasConhecimento' => $areasConhecimento,
			'temCadastro' => $temCadastro,
			'aviso'=>$mensagens[0]->conteudo
		]);
	}

	public function cadastraComissao(Request $req)
	{ 
		
		try {
            $data = $req->all();
            $val = Validator::make($data,[
                'cep' => 'required|',
                'endereco' => 'required|string',
                'bairro' => 'required|string',
                'municipio' => 'required|string',
                'uf' => 'required|string|max:2',
                'numero' => 'required|string',
                'titulacao' => 'required|string',
				'lattes' => 'required|active_url|max:190',
                'profissao' => 'required|string',
                'instituicao' => 'required|string',
                'area_id' => 'required|array',
                'area_id.*' => 'required|numeric',
                'funcao' => 'required|array',
            ]);
			if ($val->fails()) {
                return redirect()->back()->withErrors($val->errors())->withInput();
            }
			DB::beginTransaction();
			if (Pessoa::find(Auth::id())->endereco_id != null) { // altera o endereço do caboclo
				$idEndereco = DB::table('endereco')
					->where('id', '=', Pessoa::find(Auth::id())->endereco_id)
					->update([
						'cep' => $data['cep'],
						'endereco' => $data['endereco'],
						'bairro' => $data['bairro'],
						'municipio' => $data['municipio'],
						'uf' => $data['uf'],
						'numero' => $data['numero']
					]);
			} else { // cria um registro de endereço
	
				$idEndereco = Endereco::create([
					'cep' => $data['cep'],
					'endereco' => $data['endereco'],
					'bairro' => $data['bairro'],
					'municipio' => $data['municipio'],
					'uf' => $data['uf'],
					'numero' => $data['numero']
				]);
	
				$idEndereco = $idEndereco['original']['id'];
			}
	
			DB::table('pessoa')
				->where('id', '=', Auth::id())
				->update([
					'titulacao' => $data['titulacao'],
					'lattes' => $data['lattes'],
					'profissao' => $data['profissao'],
					'instituicao' => $data['instituicao'],
					'endereco_id' => $idEndereco,
				]);
	
			$comissaoEdicao = DB::table('comissao_edicao')
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->where('pessoa_id', '=', Auth::id())
				->get();
	
			if ($comissaoEdicao->count()) {
				$comissaoEdicaoId = $comissaoEdicao->first()->id;
			} else {
				$comissaoEdicaoId = DB::table('comissao_edicao')
					->insertGetId([
						'edicao_id' => Edicao::getEdicaoId(),
						'pessoa_id' => Auth::id()
					]);
			}
	
			// remove as áreas da comissão caso esteja tentando cadastrar dnv
			DB::table('areas_comissao')
				->where('comissao_edicao_id', '=', $comissaoEdicaoId)
				->delete();
	
			$areas = $data['area_id'];
			foreach ($areas as $areaId) {
				DB::table('areas_comissao')
					->insert([
						'area_id' => $areaId,
						'comissao_edicao_id' => $comissaoEdicaoId,
						'homologado' => null
					]);
			}
	
			// Avaliador
			if (in_array("1", $data['funcao'])) {
				$idFuncaoAvaliador = DB::table('funcao')
					->where('funcao', 'Avaliador')
					->get();
	
				$idFuncaoAvaliador = $idFuncaoAvaliador->first()->id;
	
				$isAvaliador = DB::table('funcao_pessoa')
					->where('edicao_id', '=', Edicao::getEdicaoId())
					->where('funcao_id', '=', $idFuncaoAvaliador)
					->where('pessoa_id', '=', Auth::id())
					->get();
	
				if (!$isAvaliador->count()) {
					DB::table('funcao_pessoa')
						->insert([
							'edicao_id' => Edicao::getEdicaoId(),
							'funcao_id' => $idFuncaoAvaliador,
							'pessoa_id' => Auth::id(),
							'homologado' => null
						]);
				}
			}
	
			// Homologador
			if (in_array("2", $data['funcao'])) {
	
				$idFuncaoHomologador = DB::table('funcao')
					->where('funcao', 'Homologador')
					->get();
	
				$idFuncaoHomologador = $idFuncaoHomologador->first()->id;
	
				$isHomologador = DB::table('funcao_pessoa')
					->where('edicao_id', '=', Edicao::getEdicaoId())
					->where('funcao_id', '=', $idFuncaoHomologador)
					->where('pessoa_id', '=', Auth::id())
					->get();
	
				if (!$isHomologador->count()) {
					DB::table('funcao_pessoa')
						->insert([
							'edicao_id' => Edicao::getEdicaoId(),
							'funcao_id' => $idFuncaoHomologador,
							'pessoa_id' => Auth::id(),
							'homologado' => null
						]);
				}
			}
	
			$emailJob = (new \App\Jobs\MailBaseJob(Auth::user()->email, 'Comissao Avaliadora', ['nome' => Auth::user()->nome])
			)->delay(\Carbon\Carbon::now()->addSeconds(3));
	
			dispatch($emailJob);
			DB::commit();
	
			return redirect()->route('autor');
			}
			catch (ValidationException $e) {
				// Redirecionar de volta com os erros de validação e os dados de entrada
				return redirect()->back()->withErrors($e->errors())->withInput();
			}catch (\Exception $e) {
				DB::rollback();
	
				// Lidar com a exceção de forma adequada
				return response()->json(['error' => 'Ocorreu um erro: ' . $e->getMessage()], 500);
			}
		}
		
	

	public function homologarComissao($id)
	{

		$comissaoEdicao = DB::table('comissao_edicao')->find($id);
		$pessoa = Pessoa::find($comissaoEdicao->pessoa_id);
		$funcaodesejada = DB::table('funcao_pessoa')
		->where('edicao_id',Edicao::getEdicaoId())
		->where('pessoa_id', $comissaoEdicao->pessoa_id)
		->get()
		->pluck('funcao_id')
		->toArray();
	
	
		$areasComissao = DB::table('areas_comissao')
			->select('area_id')
			->where('comissao_edicao_id', '=', $id)
			->get()
			->toArray();

		$idsAreas = array();
		foreach ($areasComissao as $a)
			array_push($idsAreas, $a->area_id);


		$areas = DB::table('area_conhecimento')
			->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
			->select('area_conhecimento.id', 'area_conhecimento.area_conhecimento', 'area_conhecimento.nivel_id')
			->where('area_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('area_conhecimento.id', 'asc')
			->get()
			->toArray();

		$nivel = DB::table('nivel')->join('nivel_edicao', 'nivel.id', '=', 'nivel_edicao.nivel_id')
			->select('nivel.nivel', 'nivel.id', 'nivel_edicao.edicao_id')
			->where('nivel_edicao.edicao_id', Edicao::getEdicaoId())
			->orderBy('nivel.id', 'asc')
			->get()
			->toArray();

		$projetosAreas = DB::table('area_conhecimento')
			->join('projeto', 'area_conhecimento.id', '=', 'projeto.area_id')
			->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
			->select('area_conhecimento.area_conhecimento', 'area_conhecimento.id')
			->where('escola_funcao_pessoa_projeto.edicao_id', Edicao::getEdicaoId())
			->where('pessoa_id', $comissaoEdicao->pessoa_id)
			->whereIn(
				'escola_funcao_pessoa_projeto.funcao_id',
				[
					EnumFuncaoPessoa::getValue('Orientador'),
					EnumFuncaoPessoa::getValue('Coorientador'),
				]
			)
			->where('projeto.situacao_id', '!=', EnumSituacaoProjeto::getValue('NaoHomologado'))
			->orderBy('area_conhecimento.id', 'asc')
			->get()
			->keyBy('id')
			->toArray();

		$projetosAreas = array_keys($projetosAreas);

		foreach ($areas as $a) {
			if (!in_array($a->id, $projetosAreas)) {
				if (!isset($areasConhecimento)) {
					$areasConhecimento[] = $a;
				} else {
					$array = array_pluck($areasConhecimento, 'id');
					if (!in_array($a->id, $array)) {
						$areasConhecimento[] = $a;
					}
				}
			}
		}

		if ($projetosAreas == null)
			$areasConhecimento = $areas;

			$comissaoEdicao->data_criacao = Carbon::parse($comissaoEdicao->data_criacao)->format('d/m/Y H:i:s');
		return view('admin.comissao.homologar', compact('id', 'pessoa', 'idsAreas', 'areas', 'nivel', 'areasConhecimento','comissaoEdicao','funcaodesejada'));
	}

	public function homologaComissao(Request $req)
	{

		$data = $req->all();
		$funcoesHomologadas = '';
		$funcoesNãoHomoladas = '';
		$pessoa = Pessoa::find($data['pessoa_id']);	


	
		if (!isset($data['homologador']) && $pessoa->temFuncao('Homologador', TRUE)) {
			// Set avaliador and homologador functions to false
			DB::table('funcao_pessoa')
				->where('pessoa_id', '=', $data['pessoa_id'])
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->whereIn('funcao_id', [
					EnumFuncaoPessoa::getValue('Homologador'),
				])
				->update([
					'homologado' => false
				]);
			$funcoesNãoHomoladas = 'Homologador';
		} 
		if (!isset($data['avaliador']) && $pessoa->temFuncao('Avaliador', TRUE)) {
			// Set avaliador and homologador functions to false
			DB::table('funcao_pessoa')
				->where('pessoa_id', '=', $data['pessoa_id'])
				->where('edicao_id', '=', Edicao::getEdicaoId())
				->whereIn('funcao_id', [
					EnumFuncaoPessoa::getValue('Avaliador'),
				])
				->update([
					'homologado' => false
				]);
			$funcoesNãoHomoladas = $funcoesNãoHomoladas . 'Avaliador';
		} 


		// seta homologado como false para função de avaliador/homologador


		$areasComissao = DB::table('areas_comissao')
			->select('area_id')
			->where('comissao_edicao_id', '=', $data['comissao_edicao_id'])
			->get()
			->toArray();

		$idsAreas = array();
		foreach ($areasComissao as $a)
			array_push($idsAreas, $a->area_id);

		// Existem áreas então HOMOLOGA
		if (isset($data['area_id'])) {

			// Cria novas areas
			$newAreas = array_diff($data['area_id'], $idsAreas);

			foreach ($newAreas as $area => $id) {
				DB::table('areas_comissao')
					->insert([
						'area_id' => $id,
						'comissao_edicao_id' => $data['comissao_edicao_id'],
						'homologado' => true
					]);
			}

			// Deleta campos que tinham agr não tem mais
			$oldAreas = array_diff($idsAreas, $data['area_id']);
			foreach ($oldAreas as $area => $id) {
				DB::table('areas_comissao')->where([
					'area_id' => $id,
					'comissao_edicao_id' => $data['comissao_edicao_id']
				])->delete();
			}

			// Homologa os campos já existentes
			DB::table('areas_comissao')
				->select('area_id')
				->where('comissao_edicao_id', '=', $data['comissao_edicao_id'])
				->whereIn('area_id', array_intersect($idsAreas, $data['area_id']))
				->update([
					'homologado' => true
				]);

			// Avaliador
			$funcoesHomologadas = '';

				if (isset($data['avaliador'])) {
					$avaliadorData = [
						'pessoa_id' => $data['pessoa_id'],
						'edicao_id' => Edicao::getEdicaoId(),
						'funcao_id' => EnumFuncaoPessoa::getValue('Avaliador'),
						'homologado' => true
					];

					$existingAvaliador = DB::table('funcao_pessoa')
						->where( 'pessoa_id',$data['pessoa_id'])
						->where('edicao_id', '=', Edicao::getEdicaoId())
						->where('funcao_id',EnumFuncaoPessoa::getValue('Avaliador'))
						->first();

					if ($existingAvaliador === null) {
						DB::table('funcao_pessoa')->insert($avaliadorData);
					}else{
						DB::table('funcao_pessoa')
						->where('pessoa_id', '=', $data['pessoa_id'])
						->where('edicao_id', '=', Edicao::getEdicaoId())
						->whereIn('funcao_id', [
							EnumFuncaoPessoa::getValue('Avaliador'),
						])
						->update([
							'homologado' => true
						]);
					}

					$funcoesHomologadas = 'Avaliador';
				}

				if (isset($data['homologador'])) {
					$homologadorData = [
						'pessoa_id' => $data['pessoa_id'],
						'edicao_id' => Edicao::getEdicaoId(),
						'funcao_id' => EnumFuncaoPessoa::getValue('Homologador'),
						'homologado' => true
					];

					$existingHomologador = DB::table('funcao_pessoa')
					->where( 'pessoa_id',$data['pessoa_id'])
					->where('edicao_id', '=', Edicao::getEdicaoId())
					->where('funcao_id',EnumFuncaoPessoa::getValue('Homologador'))
					->first();

					if ($existingHomologador === null) {
						DB::table('funcao_pessoa')->insert($homologadorData);
					}else{
						DB::table('funcao_pessoa')
						->where('pessoa_id', '=', $data['pessoa_id'])
						->where('edicao_id', '=', Edicao::getEdicaoId())
						->whereIn('funcao_id', [
							EnumFuncaoPessoa::getValue('Homologador'),
						])
						->update([
							'homologado' => true
						]);
					}

					$funcoesHomologadas .= ' Homologador';
				}
		} else { // Não existem áreas então NÃO HOMOLOGA

			// Deleta os campos das areas
			DB::table('areas_comissao')
				->where(['comissao_edicao_id' => $data['comissao_edicao_id']])
				->delete();

			// Avaliador
			DB::table('funcao_pessoa')
				->where([
					'pessoa_id' => $data['pessoa_id'],
					'edicao_id' => Edicao::getEdicaoId(),
					'funcao_id' => EnumFuncaoPessoa::getValue('Avaliador')
				])
				->update([
					'homologado' => false
				]);

			// Homologador
			DB::table('funcao_pessoa')
				->where([
					'pessoa_id' => $data['pessoa_id'],
					'edicao_id' => Edicao::getEdicaoId(),
					'funcao_id' => EnumFuncaoPessoa::getValue('Homologador')
				])
				->update([
					'homologado' => false
				]);
		}
		if($funcoesHomologadas == 'Avaliador Homologador'){
			$funcoesHomologadas = 'Avaliador/Homologador';
		}
		if($funcoesHomologadas != ''){
			$funcoesHomologadas = 'Você está Homologado no nosso sistema como ' . $funcoesHomologadas . '.';
		}
		#comentarios
		if($funcoesNãoHomoladas != ''){
			if($funcoesNãoHomoladas == 'HomologadorAvaliador'){
				$funcoesNãoHomoladas = 'Avaliador/Homologador';
			}
			$funcoesNãoHomoladas = 'Você não é um ' . $funcoesNãoHomoladas . ' no nosso sistema.';
		}
		$emailJob = (new \App\Jobs\MailBaseJob($pessoa->email, 'HomologacaoEmail', ['nome' =>$pessoa->nome,'funcoes' => $funcoesHomologadas,'naohomologadas' => $funcoesNãoHomoladas])
		)->delay(\Carbon\Carbon::now()->addSeconds(3));
		dispatch($emailJob);
		return redirect()->route('administrador.comissao');
	}

	public function excluiComissao($idC, $idF, $s)
	{
		if (password_verify($s, Auth::user()['attributes']['senha'])) {
			$pessoa = DB::table('comissao_edicao')
				->join('pessoa', 'comissao_edicao.pessoa_id', '=', 'pessoa.id')
				->select('pessoa.id')
				->where('comissao_edicao.id', $idC)
				->get();

			$revisoes = Revisao::select('id')
				->where('pessoa_id', $pessoa->first()->id)
				->get();

			$avaliacoes = Avaliacao::select('id')
				->where('pessoa_id', $pessoa->first()->id)
				->get();

			if ($revisoes->count() == 0 && $avaliacoes->count() == 0) {
				DB::table('areas_comissao')
					->where('comissao_edicao_id', $idC)
					->delete();

				DB::table('comissao_edicao')
					->where('id', $idC)
					->where('edicao_id', Edicao::getEdicaoId())
					->delete();

				$usuario = Pessoa::find($pessoa->first()->id);

				if ($usuario->temFuncao('Homologador', TRUE)) {
					DB::table('funcao_pessoa')
						->where('pessoa_id', $pessoa->first()->id)
						->where('funcao_id', EnumFuncaoPessoa::getValue('Homologador'))
						->where('edicao_id', Edicao::getEdicaoId())
						->delete();
				}

				if ($usuario->temFuncao('Avaliador', TRUE)) {
					DB::table('funcao_pessoa')
						->where('pessoa_id', $pessoa->first()->id)
						->where('funcao_id', EnumFuncaoPessoa::getValue('Avaliador'))
						->where('edicao_id', Edicao::getEdicaoId())
						->delete();
				}

				return 'true';
			} else if ($idF == EnumFuncaoPessoa::getValue('Avaliador')) {
				if ($revisoes->count() != 0 && $avaliacoes->count() == 0) {
					DB::table('funcao_pessoa')
						->where('pessoa_id', $pessoa->first()->id)
						->where('funcao_id', $idF)
						->where('edicao_id', Edicao::getEdicaoId())
						->delete();

					return 'true';
				}
			} else {
				return 'Não foi possível excluir usuário da comissão';
			}
		}

		return 'false';
	}
}