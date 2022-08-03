<?php

namespace App\Http\Controllers;

use App\Pessoa;
use App\Situacao;
use App\Funcao;
use App\Edicao;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use QRCode;

class CrachaController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function generateQrCode($id){
		return QRCode::text($id)
				->setMargin(1)
				->svg();
	}

	public function generateCrachas($edicao){
		return Response::view('impressao.crachas', compact('edicao'));
	}

	public function generateCrachasAutores($edicao) {
		$pessoas = DB::table('funcao_pessoa')
			->select('pessoa.nome', 'pessoa.id')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
		$funcao = 'Autor';
		return Response::view('impressao.cracha_verde', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasAutoresResumo($edicao) {
		$pessoas = DB::table('funcao_pessoa')
			->select('pessoa.nome', 'pessoa.id')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		$funcao = 'Autor';
		return Response::view('impressao.cracha_verde_resumo', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasComissaoAvaliadora($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id')
			->where('funcao_pessoa.edicao_id', '=',$edicao)
			->where('funcao_pessoa.homologado', '=', true)
			->where('funcao_pessoa.funcao_id', '=', Funcao::where('funcao', 'Avaliador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
		$funcao = 'Comissão Avaliadora';
		return view('impressao.cracha_vermelho', compact('pessoas', 'funcao', 'edicao'));
	}
	
	public function generateCrachasComissaoAvaliadoraResumo($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id')
			->where('funcao_pessoa.edicao_id', '=',$edicao)
			->where('funcao_pessoa.homologado', '=', true)
			->where('funcao_pessoa.funcao_id', '=', Funcao::where('funcao', 'Avaliador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		$funcao = 'Comissão Avaliadora';
		return view('impressao.cracha_vermelho_resumo', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasComissaoOrganizadora($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('funcao_pessoa.funcao_id', Funcao::select(['id'])
					->where('funcao', 'Administrador')
					->first()->id);
				$q->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])
					->where('funcao', 'Organizador')
					->first()->id);
			})
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
		$funcao = 'Comissão Organizadora';
		return view('impressao.cracha_vermelho', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasComissaoOrganizadoraResumo($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('funcao_pessoa.funcao_id', Funcao::select(['id'])
					->where('funcao', 'Administrador')
					->first()->id);
				$q->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])
					->where('funcao', 'Organizador')
					->first()->id);
			})
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		$funcao = 'Comissão Organizadora';
		return view('impressao.cracha_vermelho_resumo', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasOrientadores($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			
		$funcao = 'Orientador';
		return view('impressao.cracha_verde', compact('pessoas','funcao', 'edicao'));
	}

	public function generateCrachasOrientadoresResumo($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		$funcao = 'Orientador';
		return view('impressao.cracha_verde_resumo', compact('pessoas','funcao', 'edicao'));
	}

	public function generateCrachasCoorientadores($edicao) {
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		$funcao = 'Coorientador';
		return view('impressao.cracha_verde', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasCoorientadoresResumo($edicao) {
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('pessoa.nome', 'pessoa.id')
			->where(function ($q){
				$q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
				$q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Avaliado')->get()->first()->id);
			})
			->where('funcao_pessoa.edicao_id', '=', $edicao)
			->where('projeto.edicao_id', '=', $edicao)
			->where('projeto.presenca', '=', true)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		$funcao = 'Coorientador';
		return view('impressao.cracha_verde_resumo', compact('pessoas', 'funcao', 'edicao'));
	}

	public function generateCrachasVoluntarios($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id', 'tarefa.tarefa')
			->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
			->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
			->where('funcao_pessoa.edicao_id', $edicao)
			->where('pessoa_tarefa.edicao_id', $edicao)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		return view('impressao.cracha_azul', compact('pessoas', 'edicao'));
	}
	public function generateCrachasVoluntariosResumo($edicao){
		$pessoas = DB::table('funcao_pessoa')
			->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->select('pessoa.nome', 'pessoa.id', 'tarefa.tarefa')
			->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
			->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
			->where('funcao_pessoa.edicao_id', $edicao)
			->where('pessoa_tarefa.edicao_id', $edicao)
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();
			foreach ($pessoas as $pessoa) {
				$pessoa->nome = explode(' ',$pessoa->nome, 2)[0];
			}
		return view('impressao.cracha_azul_resumo', compact('pessoas', 'edicao'));
	}


}
