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

class CrachaController extends Controller
{

	public function generateQrCode($id){
		return QRCode::text($id)
				->setMargin(1)
				->svg();
	}

	public function generateCrachas(){
		
		return Response::view('impressao.crachas');
	}

	public function generateCrachasAutores($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$funcao = 'Autor';
		return Response::view('impressao.cracha_verde', compact('pessoas', 'funcao'));
	}

	public function generateCrachasComissaoAvaliadora($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.id')
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$funcao = 'Comissão Avaliadora';	
		return view('impressao.cracha_vermelho', compact('pessoas', 'funcao'));
	}

	public function generateCrachasComissaoOrganizadora(){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
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
		return view('impressao.cracha_vermelho', compact('pessoas', 'funcao'));
	}

	public function generateCrachasOrientadores($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
                        ->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$funcao = 'Orientador';
		return view('impressao.cracha_verde', compact('pessoas','funcao'));
	}

	public function generateCrachasCoorientadores($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.id')
                        ->where(function ($q){
                            $q->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id);
                            $q->orWhere('projeto.situacao_id', Situacao::where('situacao', 'Não Avaliado')->get()->first()->id);
                        })
                        ->where('funcao_pessoa.edicao_id', $edicao)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$funcao = 'Coorientador';
		return view('impressao.cracha_verde', compact('pessoas', 'funcao'));
	}

	public function generateCrachasVoluntarios($edicao){
		$pessoas = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.id', 'tarefa.tarefa')
						->join('pessoa_tarefa', 'pessoa.id', '=', 'pessoa_tarefa.pessoa_id')
						->join('tarefa', 'pessoa_tarefa.tarefa_id', '=', 'tarefa.id')
						->where('funcao_pessoa.edicao_id', $edicao)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
						
		return view('impressao.cracha_azul', compact('pessoas'));
	}

}
