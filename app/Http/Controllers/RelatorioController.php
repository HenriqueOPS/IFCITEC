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
		} else if ($id == 5) {
			$resultados = DB::table('projeto')
			->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
			->select('projeto.titulo', 'nivel.nivel', 'area_conhecimento.area_conhecimento')
			->get();
			$filename = "Projetos.csv";
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

		return \PDF::loadView('relatorios.niveis', array('niveis' => $niveis))->setPaper('A4', 'landscape')->stream('niveis.pdf');
	}

	public function escolas(){
		$escolas = DB::table('escola')->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
						->select('*')
						->orderBy('escola.nome_curto')
						->get();

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
						->orderBy('pessoa.nome')
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
		$cont = 0;

		return \PDF::loadView('relatorios.usuarios', array('autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores, 'voluntarios' => $voluntarios, 'homologadores' => $homologadores, 'avaliadores' => $avaliadores, 'edicoes' => $edicoes, 'cont' => $cont))->stream('usuarios.pdf');
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

		return \PDF::loadView('relatorios.areas', array('areas' => $areas))->setPaper('A4', 'landscape')->stream('areas.pdf');
	}

	public function edicoes(){
		$edicoes = Edicao::orderBy('ano')->get();
		
		return \PDF::loadView('relatorios.edicoes', array('edicoes' => $edicoes))->stream('edicoes.pdf');
	}

	public function funcoesUsuarios(){
		$usuarios = DB::table('pessoa')
				->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->get()
				->toArray();

		$funcoesUsuarios = DB::table('funcao_pessoa')
				->select('funcao_pessoa.pessoa_id', 'funcao_pessoa.funcao_id')
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->get()
				->toArray();

		$funcoes = DB::table('funcao')
				->join('funcao_pessoa', 'funcao.id', '=', 'funcao_pessoa.funcao_id')
				->select('funcao.id', 'funcao.funcao', 'funcao_pessoa.pessoa_id')
				->get()
				->toArray();
		
		return \PDF::loadView('relatorios.funcoesUsuarios', array('usuarios' => $usuarios,'funcoes' => $funcoes, 'funcoesUsuarios' => $funcoesUsuarios))->stream('funcoes.pdf');
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
				->orderBy('pessoa.nome')
				->get()
				->toArray();
	
		return \PDF::loadView('relatorios.voluntarioTarefa', array('voluntarios' => $voluntarios))->stream('areaProjetos.pdf');
	}

	public function tarefaVoluntarios($id){
		$tarefa = Tarefa::find($id);

		return \PDF::loadView('relatorios.tarefaVoluntarios', array('tarefa' => $tarefa))->stream('tarefaVoluntarios.pdf');
	}

	public function homologadoresArea(){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->orderBy('nivel.nivel')
				->get()
				->toArray();

		$homologadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->orderBy('pessoa.nome')
				->get()
				->toArray();
		$cont = 0;
		return \PDF::loadView('relatorios.homologadoresArea', array('areas' => $areas,'homologadores' => $homologadores, 'cont' => $cont))->stream('homologadores_area.pdf');
	}

	public function avaliadoresArea(){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->orderBy('nivel.nivel')
				->get()
				->toArray();

		$avaliadores = DB::table('pessoa')->join('comissao_edicao', 'pessoa.id', '=', 'comissao_edicao.pessoa_id')
				->join('funcao_pessoa', 'pessoa.id', '=', 'funcao_pessoa.pessoa_id')
				->join('areas_comissao', 'comissao_edicao.id', '=', 'areas_comissao.comissao_edicao_id')
				->select('pessoa.nome', 'areas_comissao.area_id')
				->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->orderBy('pessoa.nome')
				->get()
				->toArray();
		
		$cont = 0;
		return \PDF::loadView('relatorios.avaliadoresArea', array('areas' => $areas,'avaliadores' => $avaliadores, 'cont' => $cont))->stream('avaliadores_area.pdf');
	}

	public function homologadoresProjeto(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->orderBy('projeto.titulo')
				->get()
				->toArray();
		$homologadores = DB::table('funcao_pessoa')
				->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
				->join('funcao', 'funcao_pessoa.funcao_id', '=', 'funcao.id')
				->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->where('funcao.funcao','Homologador')
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->orderBy('pessoa.nome')
				->get()
				->toArray();

		$revisoes = DB::table('pessoa') 
				->join('revisao', 'pessoa.id', '=', 'revisao.pessoa_id')
				->join('projeto', 'revisao.projeto_id', '=', 'projeto.id')
				->get()
				->toArray();
		return \PDF::loadView('relatorios.homologadoresProjeto', array('projetos' => $projetos,'homologadores' => $homologadores, 'revisoes' => $revisoes))->stream('homologadores_projeto.pdf');
	}


	public function avaliadoresProjeto(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->where(function ($q){
                    $q->where('projeto.situacao_id', Situacao::select(['id'])->where('situacao', 'Não Avaliado')->first()->id);
                    $q->orWhere('projeto.situacao_id', Situacao::select(['id'])->where('situacao', 'Avaliado')->first()->id);
                })
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		$avaliadores = DB::table('funcao_pessoa')
				->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
				->join('funcao', 'funcao_pessoa.funcao_id', '=', 'funcao.id')
				->select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->where('funcao.funcao','Avaliador')
				->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
				->orderBy('pessoa.nome')
				->get()
				->toArray();

		$avaliacoes = DB::table('pessoa') 
				->join('avaliacao', 'pessoa.id', '=', 'avaliacao.pessoa_id')
				->join('projeto', 'avaliacao.projeto_id', '=', 'projeto.id')
				->get()
				->toArray();
		
		return \PDF::loadView('relatorios.avaliadoresProjeto', array('projetos' => $projetos,'avaliadores' => $avaliadores, 'avaliacoes' => $avaliacoes))->stream('avaliadores_projeto.pdf');
	}

	public function projetosConfirmaramPresenca(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->where('projeto.presenca', TRUE)
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.projetosConfirmaramPresenca', array('projetos' => $projetos))->stream('projetos_comparecerão.pdf');
	}

}