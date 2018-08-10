<?php

namespace App\Http\Controllers;

use App\AreaConhecimento;
use App\Nivel;
use App\Edicao;
use App\Escola;
use App\Projeto;
use App\Pessoa;
use App\Funcao;
use App\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RelatorioController extends Controller
{
	public function csv($id)
	{
		if ($id == 1) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email')
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
			->get();
			$filename = "Avaliadores.csv";
		} else if ($id == 2) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email')
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
			->get();
			$filename = "Homologadores.csv";
		} else if ($id == 3) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email')
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Autor')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id)
			->get();
			$filename = "ParticipantesProjeto.csv";
		} else if ($id == 4) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email')
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Voluntário')->first()->id)
			->get();
			$filename = "Voluntarios.csv";
		}
		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Email'));

		foreach ($resultados as $row) {
			fputcsv($handle, array($row->email));
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function niveis(){
		$niveis = Nivel::orderBy('nivel')->get();

		return \PDF::loadView('relatorios.niveis', array('niveis' => $niveis))->stream('niveis.pdf');
	}

	public function escolas(){
		$escolas = Escola::orderBy('nome_curto')->get();
		return \PDF::loadView('relatorios.escolas', array('escolas' => $escolas))->stream('escolas.pdf');
	}

	public function usuarios(){
		$edicoes = Edicao::orderBy('ano')->get();

		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->get();

		$homologadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Homologador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$avaliadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome')
						->where('funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		return \PDF::loadView('relatorios.usuarios', array('autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores, 'voluntarios' => $voluntarios, 'homologadores' => $homologadores, 'avaliadores' => $avaliadores, 'edicoes' => $edicoes))->stream('usuarios.pdf');
	}

	public function projetos(){
		$projetos = DB::table('projeto')->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
			->select('projeto.titulo', 'projeto.id', 'escola_funcao_pessoa_projeto.escola_id')
			->orderBy('titulo')
			->where('projeto.edicao_id', Edicao::getEdicaoId())
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
		
		return \PDF::loadView('relatorios.projetos', array('projetos' => $projetos,'autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores))->stream('escolas.pdf');
	}

	public function areas(){
		$areas = AreaConhecimento::orderBy('area_conhecimento')->get();

		return \PDF::loadView('relatorios.areas', array('areas' => $areas))->stream('areas.pdf');
	}

	public function edicoes(){
		$edicoes = Edicao::orderBy('ano')->get();
		
		return \PDF::loadView('relatorios.edicoes', array('edicoes' => $edicoes))->stream('edicoes.pdf');
	}

	public function funcoesUsuarios(){
		$usuarios = Pessoa::all();
		$funcoes = Funcao::all();
		
		return \PDF::loadView('relatorios.funcoesUsuarios', array('usuarios' => $usuarios,'funcoes' => $funcoes))->stream('funcoes.pdf');
	}

	public function escolaProjetos($id){
		$escola = Escola::find($id);
		//dd($escola->nome_curto);
		$projetos = DB::table('escola_funcao_pessoa_projeto')
				->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
				->select('escola_funcao_pessoa_projeto.escola_id', 'projeto.id', 'projeto.titulo')
			->where('escola_id', $id)
			->where('escola_funcao_pessoa_projeto.edicao_id',Edicao::getEdicaoId())
			->distinct('projeto.id')
			->get()
			->toArray();
		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.escolaProjetos', array('escola' => $escola, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->stream('areas.pdf');
	}

	public function nivelProjetos($id){
		$nivel = Nivel::find($id);
	
		$projetos = Projeto::where('nivel_id', $id)->get();
		
		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.nivelProjetos', array('nivel' => $nivel, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->stream('nivelProjetos.pdf');
	}

	public function areaProjetos($id){
		$area = AreaConhecimento::find($id);
	
		$projetos = Projeto::where('area_id', $id)->get();
		
		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.areaProjetos', array('area' => $area, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->stream('areaProjetos.pdf');
	}

	public function voluntarioTarefa(){
		$voluntarios = DB::table('funcao_pessoa')
				->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
				->join('funcao', 'funcao_pessoa.funcao_id', '=', 'funcao.id')
				->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->where('funcao.funcao','Voluntário')
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->get()
				->toArray();
	
		return \PDF::loadView('relatorios.voluntarioTarefa', array('voluntarios' => $voluntarios))->stream('areaProjetos.pdf');
	}

	public function tarefaVoluntarios($id){
		$tarefa = Tarefa::find($id);

		return \PDF::loadView('relatorios.tarefaVoluntarios', array('tarefa' => $tarefa))->stream('tarefaVoluntarios.pdf');
	}

	public function homologadoresArea(){
		$areas = AreaConhecimento::all();
		$homologadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->get()
				->toArray();
		
		return \PDF::loadView('relatorios.homologadoresArea', array('areas' => $areas,'homologadores' => $homologadores))->stream('homologadores_area.pdf');
	}

	public function avaliadoresArea(){
		$areas = AreaConhecimento::all();
		$avaliadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->get()
				->toArray();
		
		return \PDF::loadView('relatorios.avaliadoresArea', array('areas' => $areas,'avaliadores' => $avaliadores))->stream('avaliadores_area.pdf');
	}

	public function homologadoresProjeto(){
		$projetos = Projeto::all();
		$homologadores = Pessoa::all();
		
		foreach ($homologadores as $homologador) {
			if ($homologador->temFuncao('Homologador')) {
				$homologadores[] = $homologador;
			}
		}
		return \PDF::loadView('relatorios.homologadoresProjeto', array('projetos' => $projetos,'homologadores' => $homologadores))->stream('homologadores_projeto.pdf');
	}

	public function avaliadoresProjeto(){
		$projetos = Projeto::all();
		$avaliadores = Pessoa::all();
		
		foreach ($avaliadores as $avaliador) {
			if ($avaliador->temFuncao('Avaliador')) {
				$avaliadores[] = $avaliador;
			}
		}
		return \PDF::loadView('relatorios.avaliadoresProjeto', array('projetos' => $projetos,'avaliadores' => $avaliadores))->stream('avaliadores_projeto.pdf');
	}

}