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
use App\Situacao;
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
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Avaliador')->first()->id)
			->get();
			$filename = "Avaliadores.csv";
		} else if ($id == 2) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Homologador')->first()->id)
			->get();
			$filename = "Homologadores.csv";
		} else if ($id == 3) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Autor')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Orientador')->first()->id)
			->orWhere('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Coorientador')->first()->id)
			->get();
			$filename = "ParticipantesProjeto.csv";
		} else if ($id == 4) {
			$resultados = DB::table('funcao_pessoa')
			->join('pessoa','funcao_pessoa.pessoa_id','=','pessoa.id')
			->select('pessoa.email','pessoa.nome')
			->where('funcao_pessoa.edicao_id',Edicao::getEdicaoId())
			->where('funcao_pessoa.funcao_id', Funcao::select(['id'])->where('funcao', 'Voluntário')->first()->id)
			->get();
			$filename = "Voluntarios.csv";
		} else if ($id == 5) {
			$resultados = DB::table('projeto')
			->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
			->select('projeto.titulo', 'nivel.nivel', 'area_conhecimento.area_conhecimento')
			->where('projeto.edicao_id',Edicao::getEdicaoId())
			->get();
			$filename = "Projetos.csv";
		}
		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvProjetos()
	{
		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

	    $resultados = Projeto::select('projeto.id', 'titulo', 'situacao_id',
            'nivel.nivel', 'area_conhecimento.area_conhecimento', DB::raw('('.$subQuery.') as nota'))
	    	->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->orderBy('nivel','asc')
            ->orderBy('area_conhecimento','asc')
            ->orderBy('nota','desc')
            ->get();

		$filename = "ProjetosNotasHomologadores.csv";

		$handle = fopen($filename, 'w+');
		$nivel = utf8_decode('Nível');
		$area = utf8_decode('Área do Conhecimento');
		fputcsv($handle, array('Projeto',$nivel,$area,'Nota Final'), ';');

		foreach ($resultados as $row) {
			$titulo = utf8_decode($row->titulo);
			$nivel = utf8_decode($row->nivel);
			$area = utf8_decode($row->area_conhecimento);
			fputcsv($handle, array($titulo,$nivel,$area,$row->nota), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvAutoresConfirmaramPresenca()
	{
		$resultados = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.email')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('projeto.presenca', TRUE)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "AutoresConfirmaramPresenca.csv";

		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvAutoresHomologados()
	{
		$resultados = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.email')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		$filename = "AutoresHomologados.csv";

		$handle = fopen($filename, 'w+');
		fputcsv($handle, array('Nome','Email'), ';');

		foreach ($resultados as $row) {
			$nome = utf8_decode($row->nome);
			fputcsv($handle, array($nome,$row->email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function csvCertificados()
	{
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select( 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->where('edicao_id', Edicao::getEdicaoId())
						->orderBy('pessoa.nome')
						->get();

		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where('funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$comissaoAvaliadora = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where(function ($q){
                                        $q->where('funcao_id', Funcao::select(['id'])
                                            ->where('funcao', 'Avaliador')
                                            ->first()->id);
                                        $q->orWhere('funcao_id', Funcao::select(['id'])
                                            ->where('funcao', 'Homologador')
                                            ->first()->id);
                        })
						->orderBy('pessoa.nome')
						->get();

		$organizadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where('funcao_id', Funcao::where('funcao', 'Organizador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$administradores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.email')
						->where('edicao_id', Edicao::getEdicaoId())
						->where('funcao_id', Funcao::where('funcao', 'Administrador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$filename = "RelatorioPresenca.csv";

		$handle = fopen($filename, 'w+');

		fputcsv($handle, array('Nome','RG','CPF','Email'), ';');

		foreach ($voluntarios as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			fputcsv($handle, array($nome,$row->rg,$row->cpf,$email), ';');
		}

		$handle->createSheet();

		foreach ($administradores as $row) {
			$nome = utf8_decode($row->nome);
			$email = utf8_decode($row->email);
			fputcsv($handle, array($nome,$row->rg,$row->cpf,$email), ';');
		}

		fclose($handle);

		$headers = array(
			'Content-Type' => 'text/csv',
		);

		return Response::download($filename, $filename, $headers);
	}

	public function notaProjetosArea(){
		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

	    $projetos = Projeto::select('projeto.id', 'titulo', 'situacao_id',
            'nivel.nivel', 'area_conhecimento.area_conhecimento', DB::raw('('.$subQuery.') as nota'))
	    	->join('nivel','projeto.nivel_id','=','nivel.id')
			->join('area_conhecimento','projeto.area_id','=','area_conhecimento.id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->orderBy('nivel','asc')
            ->orderBy('area_conhecimento','asc')
            ->orderBy('nota','desc')
            ->get();

        return \PDF::loadView('relatorios.notaProjetosArea', array('projetos' => $projetos))->setPaper('A4', 'landscape')->download('nota_projetos_cadastrados.pdf');

	}

	public function notaProjetosNivel(){

		$niveis = Edicao::find(Edicao::getEdicaoId())->niveis;

		return \PDF::loadView('relatorios.notaProjetosNivel', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('nota_projetos_cadastrados.pdf');

	}

	public function projetosClassificados(){

        $areas = Edicao::find(Edicao::getEdicaoId())->areas;

        return \PDF::loadView('relatorios.projetosClassificados', array('areas' => $areas))->setPaper('A4', 'landscape')->download('projetos_classificados_area.pdf');
	}

	public function projetosClassificadosNivel(){

		$niveis = Edicao::find(Edicao::getEdicaoId())->niveis;

		return \PDF::loadView('relatorios.projetosClassificadosNivel', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('projetos_classificados_nivel.pdf');
	}

	public function projetosNaoHomologadosNivel(){

		$niveis = Edicao::find(Edicao::getEdicaoId())->niveis;

		return \PDF::loadView('relatorios.projetosNaoHomologadosNivel', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('projetos_nao_homologados_nivel.pdf');
	}

	public function projetosClassificadosSemNota(){

		$projetos = Projeto::select('projeto.titulo', 'projeto.situacao_id')
			->where('projeto.edicao_id','=',Edicao::getEdicaoId())
			->where('projeto.situacao_id','=', Situacao::where('situacao', 'Homologado')->get()->first()->id)
			->orderBy('projeto.titulo', 'asc')
			->get();

		return \PDF::loadView('relatorios.projetosClassificadosSemNota', array('projetos' => $projetos))->download('projetos_classificados.pdf');
	}


	public function niveis(){
		$niveis = Nivel::orderBy('nivel')->get();

		return \PDF::loadView('relatorios.niveis', array('niveis' => $niveis))->setPaper('A4', 'landscape')->download('niveis.pdf');
	}

	public function escolas(){
		$escolas = DB::table('escola')->join('endereco', 'escola.endereco_id', '=', 'endereco.id')
						->select('*')
						->orderBy('escola.nome_curto')
						->get();

		return \PDF::loadView('relatorios.escolas', array('escolas' => $escolas))->download('escolas.pdf');
	}

	public function autores(){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.autores', array('autores' => $autores, 'cont' => $cont))->download('autores.pdf');
	}

	public function orientadores(){
		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.orientadores', array('orientadores' => $orientadores, 'cont' => $cont))->download('orientadores.pdf');
	}

	public function coorientadores(){
		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$cont = 0;

		return \PDF::loadView('relatorios.coorientadores', array('coorientadores' => $coorientadores, 'cont' => $cont))->download('coorientadores.pdf');
	}

	public function voluntarios(){
		$voluntarios = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Voluntário')->first()->id)
						->orderBy('pessoa.nome')
						->get();

		$cont = 0;

		return \PDF::loadView('relatorios.voluntarios', array('voluntarios' => $voluntarios, 'cont' => $cont))->download('voluntarios.pdf');
	}

	public function homologadores(){
		$homologadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Homologador')->first()->id)
						->orderBy('pessoa.nome')
						->get();


		$cont = 0;

		return \PDF::loadView('relatorios.homologadores', array('homologadores' => $homologadores, 'cont' => $cont))->download('homologadores.pdf');
	}

	public function avaliadores(){
		$avaliadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('funcao_id', Funcao::where('funcao', 'Avaliador')->first()->id)
						->orderBy('pessoa.nome')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.avaliadores', array('avaliadores' => $avaliadores, 'cont' => $cont))->download('avaliadores.pdf');
	}

	public function autoresLanche(){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
			->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
			->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
			->where('projeto.presenca', TRUE)
			->where('escola.nome_curto', '!=' , 'IFRS Canoas')
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		$cont = 0;

		return \PDF::loadView('relatorios.autoresLanche', array('autores' => $autores, 'cont' => $cont))->download('autores_lanche.pdf');
	}

	public function autoresPosHomologacao(){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.autoresPosHomologacao', array('autores' => $autores, 'cont' => $cont))->download('autores_pos_homologacao.pdf');
	}

	public function camisaTamanho(){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.camisa')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		return \PDF::loadView('relatorios.camisaTamanho', array('autores' => $autores))->download('autores_tamanho_camisa.pdf');
	}

	public function camisaTamanhoAssinatura(){
		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('pessoa.nome', 'pessoa.camisa')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();

		return \PDF::loadView('relatorios.camisaTamanhoAssinatura', array('autores' => $autores))->setPaper('A4', 'landscape')->download('autores_tamanho_camisa_assinatura.pdf');
	}

	public function orientadoresPosHomologacao(){
		$orientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Orientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.orientadoresPosHomologacao', array('orientadores' => $orientadores,'cont' => $cont))->download('orientadores_pos_homologacao.pdf');
	}

	public function coorientadoresPosHomologacao(){
		$coorientadores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
						->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
						->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
						->select('funcao_pessoa.edicao_id', 'pessoa.nome','pessoa.rg', 'pessoa.cpf', 'pessoa.telefone')
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('projeto.presenca', TRUE)
						->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
						->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Coorientador')->first()->id)
						->orderBy('pessoa.nome')
						->distinct('pessoa.id')
						->get();
		$cont = 0;

		return \PDF::loadView('relatorios.coorientadoresPosHomologacao', array('coorientadores' => $coorientadores,'cont' => $cont))->download('coorientadores_pos_homologacao.pdf');
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

		return \PDF::loadView('relatorios.projetos', array('projetos' => $projetos,'autores' => $autores, 'orientadores' => $orientadores, 'coorientadores' => $coorientadores))->download('projetos.pdf');
	}

	public function areas(){
		$areas = AreaConhecimento::orderBy('area_conhecimento')->get();

		return \PDF::loadView('relatorios.areas', array('areas' => $areas))->setPaper('A4', 'landscape')->download('areas.pdf');
	}

	public function edicoes(){
		$edicoes = Edicao::orderBy('ano')->get();

		return \PDF::loadView('relatorios.edicoes', array('edicoes' => $edicoes))->download('edicoes.pdf');
	}

	public function funcoesUsuarios(){
		$usuarios = Pessoa::select('pessoa.id', 'pessoa.nome', 'pessoa.email')
				->get();

		return \PDF::loadView('relatorios.funcoesUsuarios', array('usuarios' => $usuarios))->download('funcoes.pdf');
	}

	public function escolaProjetos($id){
		$escola = Escola::find($id);

		$projetos = DB::table('escola_funcao_pessoa_projeto')
				->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
				->select('escola_funcao_pessoa_projeto.escola_id', 'projeto.id', 'projeto.titulo')
			->where('escola_id', $id)
			->where('escola_funcao_pessoa_projeto.edicao_id',Edicao::getEdicaoId())
			->distinct('projeto.id')
			->get()
			->toArray();
		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.escolaProjetos', array('escola' => $escola, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('escola_projetos.pdf');
	}

	public function nivelProjetos($id){
		$nivel = Nivel::find($id);

		$projetos = Projeto::where('nivel_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.nivelProjetos', array('nivel' => $nivel, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('nivelProjetos.pdf');
	}

	public function areaProjetos($id){
		$area = AreaConhecimento::find($id);

		$projetos = Projeto::where('area_id', $id)->where('edicao_id', Edicao::getEdicaoId())->get();

		$numeroProjetos = count($projetos);

		return \PDF::loadView('relatorios.areaProjetos', array('area' => $area, 'projetos' => $projetos, 'numeroProjetos' => $numeroProjetos))->download('areaProjetos.pdf');
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

		return \PDF::loadView('relatorios.voluntarioTarefa', array('voluntarios' => $voluntarios))->download('voluntarios_tarefas.pdf');
	}

	public function tarefaVoluntarios($id){
		$tarefa = Tarefa::find($id);

		return \PDF::loadView('relatorios.tarefaVoluntarios', array('tarefa' => $tarefa))->download('tarefaVoluntarios.pdf');
	}

	public function homologadoresArea(){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->where('area_edicao.edicao_id',Edicao::getEdicaoId())
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
		return \PDF::loadView('relatorios.homologadoresArea', array('areas' => $areas,'homologadores' => $homologadores, 'cont' => $cont))->download('homologadores_area.pdf');
	}

	public function avaliadoresArea(){
		$areas = DB::table('area_conhecimento')->join('nivel', 'area_conhecimento.nivel_id', '=', 'nivel.id')
				->join('area_edicao', 'area_conhecimento.id', '=', 'area_edicao.area_id')
				->select('area_conhecimento.area_conhecimento', 'nivel.nivel', 'area_conhecimento.id')
				->where('area_edicao.edicao_id',Edicao::getEdicaoId())
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
		return \PDF::loadView('relatorios.avaliadoresArea', array('areas' => $areas,'avaliadores' => $avaliadores, 'cont' => $cont))->download('avaliadores_area.pdf');
	}

	public function homologadoresProjeto(){
		$projetos = Projeto::select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->orderBy('projeto.titulo')
				->get();

		return \PDF::loadView('relatorios.homologadoresProjeto', array('projetos' => $projetos))->download('homologadores_projeto.pdf');
	}


	public function avaliadoresProjeto(){
		$projetos = Projeto::select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->orderBy('projeto.titulo')
				->get();

		return \PDF::loadView('relatorios.avaliadoresProjeto', array('projetos' => $projetos))->download('avaliadores_projeto.pdf');
	}

	public function projetosConfirmaramPresenca(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->where('projeto.presenca', TRUE)
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.projetosConfirmaramPresenca', array('projetos' => $projetos))->download('projetos_comparecerão.pdf');
	}

	public function classificacaoProjetos(){
		$areas = Edicao::find(Edicao::getEdicaoId())->areas;

        return \PDF::loadView('relatorios.classificacaoProjetos', array('areas' => $areas))->setPaper('A4', 'landscape')->download('classificacao_projetos.pdf');
	}

	public function premiacaoProjetos(){
		$areas = Edicao::find(Edicao::getEdicaoId())->areas;

        return \PDF::loadView('relatorios.premiacaoProjetos', array('areas' => $areas))->setPaper('A4', 'landscape')->download('premiacao_projetos.pdf');
	}

	public function classificacaoGeral(){
		$subQuery = DB::table('revisao')
            ->select(DB::raw('COALESCE(AVG(revisao.nota_final),0)'))
            ->where('revisao.projeto_id','=',DB::raw('projeto.id'))
            ->toSql();

		$projetos = Projeto::select(DB::raw('('.$subQuery.') as nota'),'projeto.nota_avaliacao', 'projeto.titulo', 'projeto.situacao_id')
            ->where('projeto.edicao_id','=',Edicao::getEdicaoId())
            ->where('projeto.situacao_id','=', Situacao::where('situacao', 'Avaliado')->get()->first()->id)
            ->where('projeto.nota_avaliacao','<>',NULL)
            ->orderBy('projeto.nota_avaliacao', 'desc')
            ->orderBy('nota', 'desc')
            ->orderBy('projeto.created_at', 'asc')
            ->get();

        return \PDF::loadView('relatorios.classificacaoGeral', array('projetos' => $projetos))->setPaper('A4', 'landscape')->download('classificacao_geral.pdf');
	}

	public function statusProjetos(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo', 'situacao.situacao')
				->join('situacao', 'projeto.situacao_id', '=', 'situacao.id')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->orderBy('situacao.situacao')
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.statusProjetos', array('projetos' => $projetos))->download('status_projetos.pdf');
	}

	public function projetosCompareceram(){
		$projetos = DB::table('projeto')
				->select('projeto.id', 'projeto.titulo')
				->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
				->join('pessoa', 'escola_funcao_pessoa_projeto.pessoa_id', '=', 'pessoa.id')
				->join('presenca', 'pessoa.id', '=', 'presenca.id')
				->where('projeto.edicao_id',Edicao::getEdicaoId())
				->orderBy('projeto.titulo')
				->get()
				->toArray();

		return \PDF::loadView('relatorios.projetosCompareceram', array('projetos' => $projetos))->download('projetos_compareceram.pdf');
	}

	public function gerarLocalizacaoProjetos(){
		$niveis = DB::table('nivel_edicao')
			->select(['nivel.id','nivel','min_ch','max_ch','palavras'])
			->where('edicao_id', '=',Edicao::getEdicaoId())
			->join('nivel','nivel_edicao.nivel_id','=','nivel.id')
			->get();
			
		return view('admin.gerarLocalizacaoProjetos')->withNiveis($niveis);
	}

	public function geraLocalizacaoProjetos(Request $req){
		$data = $req->all();
		$num = $data['button'];
		$ids = null;
		$cont = 0;
		foreach ($data['bloco'] as $key => $bloco) {
			$numeroSalas = ($data['ate'][$key] - $data['de'][$key]) + 1;
			$numeroProjetos = $data['num'][$key];

			for ($i = $data['de'][$key]; $i <= $data['ate'][$key]; $i++) {
			if($cont == 0){
					$projetos[$bloco][$i] = DB::table('projeto')
						->select('projeto.id', 'projeto.titulo', 'area_conhecimento.area_conhecimento', 'nivel.nivel', 'escola.nome_curto')
						->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
						->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
						->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
						->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
						->where('projeto.edicao_id',Edicao::getEdicaoId())
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('projeto.presenca', TRUE)
						->where('nivel.id', $data['nivel'][$key])
						->distinct('projeto.id')
						->orderBy('area_conhecimento.area_conhecimento')
						->orderBy('nivel.nivel')
						->orderBy('projeto.titulo')
						->limit($numeroProjetos)
						->get()
						->toArray();

				$id = DB::table('projeto')
					->select('projeto.id')
					->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
					->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
					->where('projeto.edicao_id',Edicao::getEdicaoId())
					->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
					->where('projeto.presenca', TRUE)
					->where('nivel.id', $data['nivel'][$key])
					->limit($numeroProjetos)
					->get()
					->keyBy('id')
					->toArray();
					$cont++;
					$ids = array_keys($id);
			}
			else{
				$projetos[$bloco][$i] = DB::table('projeto')
						->select('projeto.id', 'projeto.titulo', 'area_conhecimento.area_conhecimento', 'nivel.nivel', 'escola.nome_curto')
						->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
						->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
						->join('escola_funcao_pessoa_projeto', 'projeto.id', '=', 'escola_funcao_pessoa_projeto.projeto_id')
						->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
						->where('projeto.edicao_id',Edicao::getEdicaoId())
						->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
						->where('projeto.presenca', TRUE)
						->whereNotIn('projeto.id', $ids)
						->where('nivel.id', $data['nivel'][$key])
						->distinct('projeto.id')
						->orderBy('area_conhecimento.area_conhecimento')
						->orderBy('nivel.nivel')
						->orderBy('projeto.titulo')
						->limit($numeroProjetos)
						->get()
						->toArray();

						$id = DB::table('projeto')
							->select('projeto.id')
							->join('area_conhecimento', 'projeto.area_id', '=', 'area_conhecimento.id')
							->join('nivel', 'projeto.nivel_id', '=', 'nivel.id')
							->where('projeto.edicao_id',Edicao::getEdicaoId())
							->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
							->where('projeto.presenca', TRUE)
							->whereNotIn('projeto.id', $ids)
							->where('nivel.id', $data['nivel'][$key])
							->limit($numeroProjetos)
							->get()
							->keyBy('id')
							->toArray();
							$cont++;
						$ids = array_merge($ids,array_keys($id));
			}
			}
		}
		$cont = 1;
		if($num == 1){
			return \PDF::loadView('relatorios.geraLocalizacaoProjetos',array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_identificacao.pdf');
		}
		if ($num == 2) {
			return \PDF::loadView('relatorios.identificacaoProjetos',array('projetos' => $projetos, 'cont' => $cont))->setPaper('A4', 'landscape')->download('projetos_localizacao.pdf');
		}
	}

	public function gerarValeLanche(){
		return view('admin.gerarValeLanche');
	}

	public function valeLanche(Request $req){
		$data = $req->all();
		$dias = $data['dias'];

		$autores = DB::table('funcao_pessoa')->join('pessoa', 'funcao_pessoa.pessoa_id', '=', 'pessoa.id')
			->join('escola_funcao_pessoa_projeto', 'pessoa.id', '=', 'escola_funcao_pessoa_projeto.pessoa_id')
			->join('escola', 'escola_funcao_pessoa_projeto.escola_id', '=', 'escola.id')
			->join('projeto', 'escola_funcao_pessoa_projeto.projeto_id', '=', 'projeto.id')
			->select('funcao_pessoa.edicao_id', 'pessoa.nome', 'pessoa.rg', 'pessoa.cpf', 'pessoa.telefone', 'projeto.presenca')
			->where('projeto.situacao_id', Situacao::where('situacao', 'Homologado')->get()->first()->id)
			->where('funcao_pessoa.edicao_id', Edicao::getEdicaoId())
			->where('projeto.presenca', TRUE)
			->where('escola.nome_curto', '!=' , 'IFRS Canoas')
			->where('funcao_pessoa.funcao_id', Funcao::where('funcao', 'Autor')->first()->id)
			->orderBy('pessoa.nome')
			->distinct('pessoa.id')
			->get();

		$cont = $autores->count() * $dias;
		
		return view('relatorios.valeLanche', array('cont' => $cont));
	}

	public function projetosConfirmaramPresencaArea(){
		$areas = Edicao::find(Edicao::getEdicaoId())->areas;

		
		return \PDF::loadView('relatorios.projetosConfirmaramPresencaArea', array('areas' => $areas))->download('projetos_presenca_nivel.pdf');
	}

}
