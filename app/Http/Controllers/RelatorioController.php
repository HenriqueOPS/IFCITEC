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

class RelatorioController extends Controller
{
	public function niveis(){
		$niveis = Nivel::orderBy('nivel')->get();

		return \PDF::loadView('relatorios.niveis', array('niveis' => $niveis))->stream('niveis.pdf');
	}

	public function escolas(){
		$escolas = Escola::orderBy('nome_curto')->get();
		return \PDF::loadView('relatorios.escolas', array('escolas' => $escolas))->stream('escolas.pdf');
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

}